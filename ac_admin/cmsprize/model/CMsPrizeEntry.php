<?php
//****** 広告学生賞応募者定義ファイル ******

require_once("CMsPrizeStaff.php");

//広告学生賞応募者登録クラス
class CMsPrizeEntry extends ActionForm {

	var $table = _TABLE_CMSPRIZE_ENTRY;//テーブル名
	var $PriMailTitle = '';
	var $SecMailTitle = '';
	//スタッフ配列
	var $staffPersons = 30;//スタッフ最大人数
	var $staffs = array();//スタッフ配列
	var $required_staff = false;//スタッフ入力必須

	//レコードテンプレート
	var $template = array(
		'id' => array(
				'caption' => 'ID',
				'isKey' => true,
				'fieldType' => FIELD_TYPE_AUTONUMBER,
				'sessionParam' => 'id',
		),
		'valid_status' => array(
				'caption' => '有効ステータス',
				'fieldType' => FIELD_TYPE_INT,
				'formType' => FORM_TYPE_RADIO,
		),
		'prize_id' => array(
				'caption' => '学生賞ID',
				'fieldType' => FIELD_TYPE_INT,
				'required' => true,
				'sessionParam' => 'prize_id',
				'param' => 'prize_id',
		),
		'prize_num' => array(
				'caption' => '開催回数',
				'allowInput' => false,
				'allowOutput' => false,
		),
		'school_id' => array(
				'caption' => '会員校ID',
				'fieldType' => FIELD_TYPE_INT,
				'required' => true,
				'sessionParam' => 'school_id',
				'param' => 'school_id',
		),
		'recruit_type' => array(
				'caption' => '応募部門',
				'formType' => FORM_TYPE_RADIO,
				'sessionParam' => 'recruit_type',
				'param' => 'recruit_type',
		),
		'school_name' => array(
				'caption' => '学校名',
				'allowInput' => false,
				'allowOutput' => false,
		),
####応募者情報
		'user_id' => array(
				'caption' => '作品ID',
				'max' => 255,
				'allowInput' => false,
		),
		'user_pass' => array(
				'caption' => 'パスワード',
				'allowInput' => false,
		),
		'name_sei' => array(
				'caption' => '代表者姓',
				'required' => true,
				'max' => 255,
		),
		'name_mei' => array(
				'caption' => '代表者名',
				'required' => true,
				'max' => 255,
		),
		'name_full' => array(
				'caption' => '代表者フルネーム',
				'allowInput' => false,
				'allowOutput' => false,
		),
		'kana_sei' => array(
				'caption' => '代表者姓フリガナ',
				'max' => 255,
				'convert' => "C",
				'format' => array('^[ 　ァ-ヶー]+$' => "カタカナを入力してください。"),
		),
		'kana_mei' => array(
				'caption' => '代表者名フリガナ',
				'max' => 255,
				'convert' => "C",
				'format' => array('^[ 　ァ-ヶー]+$' => "カタカナを入力してください。"),
		),
		'email' => array(
				'caption' => '代表者メールアドレス',
				'formatType' => FORMAT_TYPE_EMAIL,
				'required' => true,
				'hasConfirmField' => true,
		),
		'member_key' => array(
				'caption' => '代表者承認フレーズ',
				'max' => 255,
				'allowInput' => false,
				'allowOutput' => false,	
		),
		'college' => array(
				'caption' => '学部・学科・学年',
				'max' => 255,
		),
		'tel' => array(
				'caption' => '代表者電話番号',
				'formatType' => FORMAT_TYPE_TEL,
				'splitInput' => true,
				'convert' => "a",
		),
		'instructor_name_sei' => array(
				'caption' => '担当教官姓',
				'required' => true,
				'max' => 255,
		),
		'instructor_name_mei' => array(
				'caption' => '担当教官名',
				'required' => true,
				'max' => 255,
		),
		'instructor_name_full' => array(
				'caption' => '担当教官フルネーム',
				'allowInput' => false,
				'allowOutput' => false,
		),
		'instructor_kana_sei' => array(
				'caption' => '担当教官姓フリガナ',
				'max' => 255,
				'convert' => "C",
				'format' => array('^[ 　ァ-ヶー]+$' => "カタカナを入力してください。"),
		),
		'instructor_kana_mei' => array(
				'caption' => '担当教官名フリガナ',
				'max' => 255,
				'convert' => "C",
				'format' => array('^[ 　ァ-ヶー]+$' => "カタカナを入力してください。"),
		),
		'instructor_email' => array(
				'caption' => '担当教官メールアドレス',
				'formatType' => FORMAT_TYPE_EMAIL,
				'required' => true,
				'hasConfirmField' => true,
		),
		'instructor_key' => array(
				'caption' => '担当教官承認フレーズ',
				'max' => 255,
				'allowInput' => false,
				'allowOutput' => false,
		),
		'instructor_tel' => array(
				'caption' => '担当教官電話番号',
				'formatType' => FORMAT_TYPE_TEL,
				'splitInput' => true,
				'convert' => "a",
		),
###作品情報
		'title' => array(
				'caption' => '作品タイトル',
				'max' => 255,
		),
		'theme' => array(
				'caption' => '作品テーマ',
				'max' => 20,
		),
		'intention' => array(
				'caption' => '企画意図・狙い',
				'max' => 150,
		),
		'staff_count' => array(
				'caption' => '登録スタッフ数',
				'allowInput' => false,
				'allowOutput' => false,
		),
		'receipt_dvd' => array(
				'caption' => 'DVD受付年月日',
				'fieldType' => FIELD_TYPE_DATE,
				'formatType' => FORMAT_TYPE_DATE,
		),
		'note' => array(
				'caption' => '備考',
				'max' => 3000,
				'formType' => FORM_TYPE_TEXTAREA,
		),
		'regist_date' => array(
				'caption' => '代表者本登録完了日',
				'allowInput' => false,
				'allowOutput' => false,
		),
####更新記録
		'update_member_id' => array(
				'caption' => '最終更新者ID',
				'fieldType' => FIELD_TYPE_UPDATE_ID,
		),
		'last_update' => array(
				'caption' => '最終更新日時',
				'fieldType' => FIELD_TYPE_DATETIME,//★定数ではないので注意★
				'allowInput' => false,
		),
		'create_member_id' => array(
				'caption' => '作成者ID',
				'fieldType' => FIELD_TYPE_CREATE_ID,
		),
		'created_date' => array(
				'caption' => '作成日時',
				'fieldType' => FIELD_TYPE_CREATED_DATE,
		),
####メール送信日時
		'send_date' => array(
				'caption' => '送信日時',
				'allowInput' => false,
				'allowOutput' => false,
		),
		'mail_signature' => array(
				'caption' => 'メール署名',
				'allowInput' => false,
				'allowOutput' => false,
		),
		'agree_upload_terms' => array(
			'caption' => 'アップロード規約に同意する',
			'fieldType' => FIELD_TYPE_INT,
		),
	);

	
###スタッフテンプレート
var $staff_template = array(
		'staff_id' => array(
				'caption' => 'スタッフテーブルID',
				'allowOutput' => false,
		),
		'staff_delete' => array(
				'caption' => 'スタッフレコード削除',
				'formType' => FORM_TYPE_CHECKBOX,
				'allowOutput' => false,
		),
		'staff_name_sei' => array(
				'caption' => '姓：スタッフ',
				'max' => 255,
				'allowOutput' => false,
		),
		'staff_name_mei' => array(
				'caption' => '名：スタッフ',
				'max' => 255,
				'allowOutput' => false,
		),
		'staff_kana_sei' => array(
				'caption' => 'セイ：スタッフ',
				'max' => 255,
				'allowOutput' => false,
				'convert' => "C",
				'format' => array('^[ 　ァ-ヶー]+$' => "カタカナを入力してください。"),
		),
		'staff_kana_mei' => array(
				'caption' => 'メイ：スタッフ',
				'max' => 255,
				'allowOutput' => false,
				'convert' => "C",
				'format' => array('^[ 　ァ-ヶー]+$' => "カタカナを入力してください。"),
		),
	);

/* ■■ イベント ■■ */

/**
 * モードをセット
 *
 * @param str $mode モード
 * @access public
 */
	function setMode($mode) {
		parent::setMode($mode);
		
		foreach ($this->staffs as $key => $staffs) {
			$this->staffs[$key]->setMode($this->mode);
		}
	}

/**
 * 初期化実行前イベント
 *
 * @access public
 */
	function onBeforeCreate() {
		for ($i=1; $i<=$this->staffPersons;$i++){//スタッフテンプレート追加
			foreach($this->staff_template as $key => $val){
				$val['caption'] .= sprintf("%02d", $i);
				$this->template[$key .sprintf("%02d", $i)] = $val;
			}
		}
	}


/**
 * ラベル定義イベント
 * ラベル定義を行うイベント
 *
 * @access public
 */
	function onDefineLabel() {
		$this->setLabel('valid_status', App::custom('valid_status'));//有効状態
		$this->setLabel('recruit_type', App::custom('recruit_type'));//応募部門
		for ($i=1; $i<=$this->staffPersons;$i++){//スタッフレコード削除
			$staff_delete = 'staff_delete'.sprintf("%02d", $i);
			$this->setLabel($staff_delete, array('1' => '削除'));
		}
	}

/**
 * DBからのデータセット後イベント
 *
 * @access public
 */
	function onAfterDataSetFromDB() {
		
		//登録済みスタッフデータを取得
		$this->staffs = $this->getStaffs();
		$this->set('staff_count', count($this->staffs));
		if(count($this->staffs)){
			//スタッフテンプレートに値を代入
			$i=0;
			foreach($this->staffs as $key){

				$i++;
				$staff_id = 'staff_id'.sprintf("%02d", $i);//スタッフID
				$staff_name_sei = 'staff_name_sei'.sprintf("%02d", $i);//姓
				$staff_name_mei = 'staff_name_mei'.sprintf("%02d", $i);//名
				$staff_kana_sei = 'staff_kana_sei'.sprintf("%02d", $i);//セイ
				$staff_kana_mei = 'staff_kana_mei'.sprintf("%02d", $i);//メイ
				
					$this->set($staff_id, $key->get('id'));
					$this->set($staff_name_sei, $key->get('staff_name_sei'));
					$this->set($staff_name_mei, $key->get('staff_name_mei'));
					$this->set($staff_kana_sei, $key->get('staff_kana_sei'));
					$this->set($staff_kana_mei, $key->get('staff_kana_mei'));

			}
		}
	}
	
/**
 * セッションからデータ取得後イベント
 *
 * @access public
 */
	function onAfterSessionLoad() {
		//登録済みスタッフデータを取得
		$this->staffs = $this->getStaffs();
	}
	
	
/**
 * 各レコードのバリデート後イベント
 *
 * @param FormRecord $record 対象のFormRecordオブジェクト
 * @access public
 */
	function onAfterValidate($record) {

		$staff_count = 0;
		$staff_err = 0;
		
		for ($i=1; $i<=$this->staffPersons;$i++){//スタッフ入力チェック
			$staff_name_sei = 'staff_name_sei'.sprintf("%02d", $i);//姓
			$staff_name_mei = 'staff_name_mei'.sprintf("%02d", $i);//名
			$staff_kana_sei = 'staff_kana_sei'.sprintf("%02d", $i);//セイ
			$staff_kana_mei = 'staff_kana_mei'.sprintf("%02d", $i);//メイ
			if($this->get($staff_name_sei) || $this->get($staff_name_mei) || $this->get($staff_kana_sei) || $this->get($staff_kana_mei) || ($i == 1 && $this->required_staff)){
				if(!$this->get($staff_name_sei) || !$this->get($staff_name_mei) || !$this->get($staff_kana_sei) || !$this->get($staff_kana_mei)){
					$this->setError($staff_name_sei, "スタッフは、姓と");
					$this->setError($staff_name_mei, "名と、それぞれの");
					$this->setError($staff_kana_sei, "フリガナ全てを");
					$this->setError($staff_kana_mei, "入力してください。");
					$staff_err++;
				}
				$staff_count = $i;
			}
		}
		
		if(!$staff_err && $this->get('staff_count') < $staff_count) {
			$this->set('staff_count', $staff_count);
		} else if(!$staff_err && !$staff_count){
			$this->set('staff_count', $staff_count);
		}

	}
	
/**
 * DB処理前
 *
 * @param FormRecord $record 対象のFormRecordオブジェクト
 * @access public
 */
	function onBeforeDBExecute($record) {
		
		//送信日時を現在時刻に設定
		$this->set('send_date', date('Y年n月j日 H:i:s'));
		
		//開催回数を取得
		if(!$this->get('prize_num')){
			$this->set('prize_num', getPrizeNum($this->get('prize_id')));
		}
		//会員校名を取得
		if(!$this->get('school_name')){
			$list = getSchoolNumName($this->get('school_id'));
			$this->set('school_name', $list['school_name']);	
		}
		//代表者名を取得
		if(!$this->get('name_full')){
			$this->set('name_full', $this->get('name_sei').' '.$this->get('name_mei').' 様');	
		}
		//担当教官名を取得
		if(!$this->get('instructor_name_full')){
			$this->set('instructor_name_full', $this->get('instructor_name_sei').' '.$this->get('instructor_name_mei').' 様');	
		}
		//メール署名を取得
		if(!$this->get('mail_signature')){
			$this->set('mail_signature', _MAIL_SIGNATURE);	
		}
		
		//最終更新日時を現在時刻に設定
		$this->set('last_update', date('Y-m-d H:i:s'));
	}
	
/**
 * DB処理後
 *
 * @param FormRecord $record 対象のFormRecordオブジェクト
 * @access public
 */
	function onAfterDBExecute($record) {		
		//削除であればidを空に
		if($this->mode == 'delete'){
			//IDを空に
			$this->set('id', '');
		} else {
		
			//スタッフテーブル更新::入力された値をチェックしてセット
			for ($i=1; $i<=$this->staffPersons;$i++){
				$setRow = array();
				$staff_id = 'staff_id'.sprintf("%02d", $i);//スタッフID
				$staff_delete = 'staff_delete'.sprintf("%02d", $i);//スタッフレコード削除
				$staff_name_sei = 'staff_name_sei'.sprintf("%02d", $i);//姓
				$staff_name_mei = 'staff_name_mei'.sprintf("%02d", $i);//名
				$staff_kana_sei = 'staff_kana_sei'.sprintf("%02d", $i);//セイ
				$staff_kana_mei = 'staff_kana_mei'.sprintf("%02d", $i);//メイ
				
				if($this->get($staff_name_sei) && $this->get($staff_name_mei) && $this->get($staff_kana_sei) && $this->get($staff_kana_mei)){
					$setRow['staff_name_sei'] = $this->get($staff_name_sei);
					$setRow['staff_name_mei'] = $this->get($staff_name_mei);
					$setRow['staff_kana_sei'] = $this->get($staff_kana_sei);
					$setRow['staff_kana_mei'] = $this->get($staff_kana_mei);
				}
			
				if(!$this->get($staff_id) && count($setRow)){//IDが空で名前が入力されていれば新規
						$id = Util::createToken();
						$this->staffs[$id] = new CMsPrizeStaff($this->DB, $this->member_id);
						$this->staffs[$id]->setMode('new');
						$this->staffs[$id]->defineRecord();
						$this->staffs[$id]->set('entry_id', $this->get('id'));
						$this->staffs[$id]->set('staff_name_sei', $setRow['staff_name_sei']);
						$this->staffs[$id]->set('staff_name_mei', $setRow['staff_name_mei']);
						$this->staffs[$id]->set('staff_kana_sei', $setRow['staff_kana_sei']);
						$this->staffs[$id]->set('staff_kana_mei', $setRow['staff_kana_mei']);
						
				} else if($this->get($staff_id)){
				
					if($this->get($staff_delete)){//削除
						$this->staffs[$this->get($staff_id)]->setMode('delete');
					} else {//更新
						$this->staffs[$this->get($staff_id)]->set('staff_name_sei', $setRow['staff_name_sei']);
						$this->staffs[$this->get($staff_id)]->set('staff_name_mei', $setRow['staff_name_mei']);
						$this->staffs[$this->get($staff_id)]->set('staff_kana_sei', $setRow['staff_kana_sei']);
						$this->staffs[$this->get($staff_id)]->set('staff_kana_mei', $setRow['staff_kana_mei']);
					}
				}
			}
		}
		//スタッフテーブル更新
		foreach ($this->staffs as $key => $staff) {
			$this->staffs[$key]->set('entry_id', $this->get('id'));
			$this->staffs[$key]->dbExecute();
		}
		
	}
	

/**
 * スタッフ情報取得
 * 自身にセットされた［スタッフ情報］を返却
 * @return staffs[t_cmsprize_staff.id] = 
 * @access public
 */
 
	function getStaffs() {	
		$list = array();
		if($this->get('id')){
			//スタッフ情報フィールドを追加
			$SO = new SQLSearch($this->DB, _TABLE_CMSPRIZE_STAFF);
			$SO->setNumSearch(_TABLE_CMSPRIZE_STAFF.'.entry_id', $this->get('id'));//この応募ID
			$SO->setOrder(array('id'));
			
			$SO->setAlias(_TABLE_CMSPRIZE_STAFF.'.id', 'staff_id');
			$SO->setAlias(_TABLE_CMSPRIZE_STAFF.'.update_member_id', 'staff_update_member_id');
			$SO->setAlias(_TABLE_CMSPRIZE_STAFF.'.last_update', 'staff_last_update');
			$SO->setAlias(_TABLE_CMSPRIZE_STAFF.'.create_member_id', 'staff_create_member_id');
			$SO->setAlias(_TABLE_CMSPRIZE_STAFF.'.created_date', 'staff_created_date');
			
			$SO->search();
			
			while ($row = $SO->fetch()) {	
				$list[$row['staff_id']] = new CMsPrizeStaff($this->DB, $this->member_id);
				$row['id'] = $row['staff_id'];
				$row['update_member_id'] = $row['staff_update_member_id'];
				$row['last_update'] = $row['staff_last_update'];
				$row['create_member_id'] = $row['staff_create_member_id'];
				$row['created_date'] = $row['staff_created_date'];
				$list[$row['staff_id']]->setRecord($row, true);
				$list[$row['staff_id']]->setMode($this->mode);
			}
		}
		return $list;
	}

	function updateAgreeUploadTerms(){
		$sql = "UPDATE "._TABLE_CMSPRIZE_ENTRY." SET ";
		$sql .= " agree_upload_terms = 1";
		$sql .= " WHERE 1";
		$sql .= " AND id = ". $this->member_id;
		$res = $this->DB->query($sql);
		$this->DB->commit();
	}
}

?>