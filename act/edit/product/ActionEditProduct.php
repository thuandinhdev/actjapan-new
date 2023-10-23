<?php
//****** CM学生賞応募作品定義ファイル ******

require_once("CMsPrizeEntry.php");


//CM学生賞応募作品登録クラス
class ActionEditProduct extends CMsPrizeEntry {
	var $isPublic = false;//不特定多数ユーザからアクセスされる場合TRUE
	var $enabledModeType = array('edit');//使用可能なモードの種類
	var $PriMailTitle = '作品情報を編集しました';
	
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
		parent::onBeforeCreate();
		
		$this->template['edit_url'] = array(
			'caption' => '編集用URL',
			'allowInput' => false,
			'allowOutput' => false,
		);
		
		//テンプレート設定
		$this->template['valid_status']['allowInput'] = false;//有効ステータス
		
		$this->template['school_id']['required'] = false;//会員校ID
		$this->template['school_id']['allowInput'] = false;//会員校ID
		
		$this->template['recruit_type']['allowInput'] = false;//応募種別入力
		
		$this->template['name_sei']['required'] = false;//代表者姓
		$this->template['name_sei']['allowInput'] = false;//代表者姓
		$this->template['name_mei']['required'] = false;//代表者名
		$this->template['name_mei']['allowInput'] = false;//代表者名
		$this->template['kana_sei']['allowInput'] = false;//代表者姓カナ
		$this->template['kana_mei']['allowInput'] = false;//代表者名カナ

		$this->template['college']['allowInput'] = false;//学部・学科・学年
		$this->template['tel']['splitInput'] = false;//電話番号分割入力
		$this->template['tel']['allowInput'] = false;//代表者電話番号
		
		$this->template['email']['required'] = false;//代表者メールアドレス
		$this->template['email']['allowInput'] = false;//代表者メールアドレス
		$this->template['email']['hasConfirmField'] = false;//代表者メールアドレス確認

		$this->template['instructor_name_sei']['required'] = false;//担当教官姓
		$this->template['instructor_name_sei']['allowInput'] = false;//担当教官姓
		$this->template['instructor_name_mei']['required'] = false;//担当教官名
		$this->template['instructor_name_mei']['allowInput'] = false;//担当教官名
		$this->template['instructor_kana_sei']['allowInput'] = false;//担当教官姓カナ
		$this->template['instructor_kana_mei']['allowInput'] = false;//担当教官名カナ

		$this->template['instructor_email']['required'] = false;//担当メールアドレス
		$this->template['instructor_email']['allowInput'] = false;//担当メールアドレス
		$this->template['instructor_email']['hasConfirmField'] = false;//担当教官メールアドレス確認
		$this->template['instructor_tel']['splitInput'] = false;//担当教官電話番号分割入力
		$this->template['instructor_tel']['allowInput'] = false;//担当教官代表者電話番号
		
		$this->template['receipt_dvd']['allowInput'] = false;//DVD受付年月日
		$this->template['note']['allowInput'] = false;//備考

		$this->template['title']['required'] = true;//作品タイトル
		$this->template['theme']['required'] = true;//作品テーマ
		$this->template['intention']['required'] = true;//企画意図・狙い
		$this->template['agree_upload_terms']['allowInput'] = false;//アップロード規約に同意する
		$this->required_staff = true;//スタッフ入力必須
		
	}
	
	
/**
 * DB処理後
 *
 * @param FormRecord $record 対象のFormRecordオブジェクト
 * @access public
 */
	function onAfterDBExecute($record) {
		parent::onAfterDBExecute($record);
		
		
		// ///編集完了メールタイトルを生成
		// $SendMailTitle = _MAIL_TITLE_HEAD.'【'.getJustEntryPrizeTitle($this->get('prize_id')).'|'.App::custom('recruit_type', $this->get('recruit_type')).'】'.$this->PriMailTitle.'〔'.$this->get('name_sei').' '.$this->get('name_mei').'〕様';
		
		// //###【担当教官へメール送信】
		// if(!$this->get('instructor_key')){//担当教官が承認済み
		// 	$MailCC = array($this->get('instructor_email') => $this->get('instructor_name_full'));
		// } else {
		// 	$MailCC = array();
		// }
		
		// ///###【申し込み者へメール送信】//CC：担当教官（承認済みであれば）//BCC：AC担当者
		// ///編集URLを生成
		// $this->set('edit_url',App::config('URL.root_ssl').'act/edit/');
		
		// 	$this->sendMail(array($this->get('email') => $this->get('name_full')), array(App::custom('admin_mail_adress') => App::custom('admin_secretariat_name')), App::custom('admin_mail_adress'), $SendMailTitle, 'reply_mail.dat',array(), $MailCC, App::custom('admin_mail_adress'));
		
		$this->DB->commit();
	}
}


?>