<?php
//****** CM学生賞応募者定義ファイル ******

require_once("CMsPrizeEntry.php");


//CM学生賞応募者登録クラス
class ActionEditProfile extends CMsPrizeEntry {
	var $isPublic = false;//不特定多数ユーザからアクセスされる場合TRUE
	var $enabledModeType = array('edit');//使用可能なモードの種類
	var $PriMailTitle = '応募者情報を編集しました';
	
	//ページ遷移定義
	var $pages = array(
			'input' => 'index.php',
			'confirm' => 'confirm.php',
			'execute' => 'submit.php',
			'end' => 'thanks.php',
			);

/* ■■ イベント ■■ */

/**
 * 初期化実行前イベント
 *
 * @access public
 */
	function onBeforeCreate() {
		
		foreach($this->staff_template as $key => $val){
			$this->staff_template[$key]['allowInput'] = false;
		}

		parent::onBeforeCreate();
		
		//テンプレート設定
		$this->template['valid_status']['allowInput'] = false;//有効ステータス
		
		$this->template['school_id']['required'] = false;//会員校ID
		$this->template['school_id']['allowInput'] = false;//会員校ID入力
		
		$this->template['recruit_type']['allowInput'] = false;//応募種別入力
		
		$this->template['name_sei']['required'] = false;//代表者姓
		$this->template['name_sei']['allowInput'] = false;//代表者姓
		$this->template['name_mei']['required'] = false;//代表者名
		$this->template['name_mei']['allowInput'] = false;//代表者名
		
		$this->template['email']['required'] = false;//代表者メールアドレス
		$this->template['email']['allowInput'] = false;//代表者メールアドレス
		$this->template['email']['hasConfirmField'] = false;//代表者メールアドレス確認
		
		$this->template['instructor_name_sei']['required'] = false;//担当教官姓
		$this->template['instructor_name_sei']['allowInput'] = false;//担当教官姓
		$this->template['instructor_name_mei']['required'] = false;//担当教官名
		$this->template['instructor_name_mei']['allowInput'] = false;//担当教官名
		
		
		$this->template['title']['allowInput'] = false;//作品タイトル
		$this->template['theme']['allowInput'] = false;//作品テーマ
		$this->template['intention']['allowInput'] = false;//企画意図・狙い
		
		
		$this->template['receipt_dvd']['allowInput'] = false;//DVD受付年月日
		$this->template['note']['allowInput'] = false;//備考
		
		$this->template['editstatus'] = array(
				'caption' => '編集状況',
				'allowInput' => false,
				'allowOutput' => false,
		);
		
		$this->template['regist_url'] = array(
				'caption' => '承認用URL',
				'allowInput' => false,
				'allowOutput' => false,
		);
	}
	
/**
 * DBからのデータセット後イベント
 *
 * @access public
 */
	function onAfterDataSetFromDB() {
		parent::onAfterDataSetFromDB();
		
		if($this->getOldValue('kana_sei') || $this->getOldValue('kana_mei') || $this->getOldValue('instructor_kana_sei') || $this->getOldValue('instructor_kana_mei')){
			if($this->getOldValue('instructor_key')){//担当教官承認が未であれば
				$this->set('editstatus', 1);
				
				$this->setAttr('kana_sei','allowInput', false);//代表者姓フリガナ
				$this->setAttr('kana_mei','allowInput', false);//代表者名フリガナ
				$this->setAttr('instructor_kana_sei','allowInput', false);//担当教官姓フリガナ
				$this->setAttr('instructor_kana_mei','allowInput', false);//担当教官名フリガナ
				
				$this->setAttr('college', 'allowInput', false);//学部・学科・学年
				$this->setAttr('tel', 'splitInput', false);//代表者電話番号分割入力
				$this->setAttr('tel', 'allowInput', false);//代表者電話番号
					
				$this->setAttr('instructor_tel', 'splitInput', false);//担当教官電話番号分割入力
				$this->setAttr('instructor_tel', 'allowInput', false);//担当教官電話番号
				
			} else {
				$this->set('editstatus', 2);//編集完全不可
			}
		} else {
			$this->set('editstatus', 0);
			##入力必須を設定
			$this->setAttr('kana_sei','required', true);//代表者姓フリガナ
			$this->setAttr('kana_mei','required', true);//代表者名フリガナ
			$this->setAttr('instructor_kana_sei','required', true);//担当教官姓フリガナ
			$this->setAttr('instructor_kana_mei','required', true);//担当教官名フリガナ
			
			$this->setAttr('college', 'required', true);//学部・学科・学年
			$this->setAttr('tel', 'required', true);//代表者電話番号
			$this->setAttr('instructor_tel', 'required', true);//担当教官電話番号
		
		}
		
		if(!$this->getOldValue('instructor_key')){//担当教官承認済みであれば						
				$this->setAttr('instructor_email', 'required', false);//担当教官メールアドレス
				$this->setAttr('instructor_email', 'allowInput', false);//担当教官メールアドレス
				$this->setAttr('instructor_email', 'hasConfirmField', false);//担当教官メールアドレス確認
				$this->setAttr('instructor_email_confirm', 'required', false);//担当教官メールアドレス確認
		}		
		
	}

	
/**
 * 各レコードのバリデート後イベント
 *
 * @param FormRecord $record 対象のFormRecordオブジェクト
 * @access public
 */
	function onAfterValidate($record) {
		parent::onAfterValidate($record);
		
		if ($this->hasError('kana_sei') || $this->hasError('kana_mei')){
			$this->setError('kana_sei', '代表者の姓と名、');
			$this->setError('kana_mei', 'フリガナ両方をカタカナで入力してください。');
		}
		
		if ($this->hasError('instructor_kana_sei') || $this->hasError('instructor_kana_mei')){
			$this->setError('instructor_kana_sei', '担当教官の姓と名、');
			$this->setError('instructor_kana_mei', 'フリガナ両方をカタカナで入力してください。');
		}

		
	}
/**
 * DB処理後
 *
 * @param FormRecord $record 対象のFormRecordオブジェクト
 * @access public
 */
	function onAfterDBExecute($record) {
		parent::onAfterDBExecute($record);
		

		
		//###【担当教官へメール送信】
		if(!$this->get('instructor_key')){//担当教官が承認済み
			$MailCC = array($this->get('instructor_email') => $this->get('instructor_name_full'));
			
		} else if($this->get('instructor_email') != $this->getOldValue('instructor_email')){//担当教官のメールアドレス変更
			$MailCC = array();
			
		///承認依頼メールタイトルを生成
		$SendMailTitle = _MAIL_TITLE_HEAD.'【'.getJustEntryPrizeTitle($this->get('prize_id')).'|'.App::custom('recruit_type', $this->get('recruit_type')).'】'.$this->SecMailTitle.'〔'.$this->get('name_sei').' '.$this->get('name_mei').'〕様';
			
		///担当教官承認用URLを生成
			$this->set('regist_url',App::config('URL.root_ssl').'act/regist/?regi='.$this->get('instructor_key'));
		
			$this->sendMail(array($this->get('instructor_email') => $this->get('instructor_name_full')), array(App::custom('admin_mail_adress') => App::custom('admin_secretariat_name')), App::custom('admin_mail_adress'), $SendMailTitle, 'retry_mail.dat',array(), NULL, App::custom('admin_mail_adress'));
		}
		
		// ///編集完了メールタイトルを生成
		// $SendMailTitle = _MAIL_TITLE_HEAD.'【'.getJustEntryPrizeTitle($this->get('prize_id')).'|'.App::custom('recruit_type', $this->get('recruit_type')).'】'.$this->PriMailTitle.'〔'.$this->get('name_sei').' '.$this->get('name_mei').'〕様';
		
		// ///###【申し込み者へメール送信】//CC：担当教官（承認済みであれば）//BCC：AC担当者
		// 	$this->sendMail(array($this->get('email') => $this->get('name_full')), array(App::custom('admin_mail_adress') => App::custom('admin_secretariat_name')), App::custom('admin_mail_adress'), $SendMailTitle, 'reply_mail.dat',array(), $MailCC, App::custom('admin_mail_adress'));
		
		$this->DB->commit();
	}
		
}


?>