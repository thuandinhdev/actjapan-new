<?php
require_once("../../../common/frame/template.php");


//セッション開始
Session::start();

//権限オブジェクト生成
$Auth = new CmsAuth('members');

//権限が無い場合はログインページへ
$Auth->checkCurrentPage($Auth->per('default'), App::custom('URL.members_login'));

//DB接続
$DB = new DBO_MySQL();

###現在応募受付中のCM学生賞があるかチェック
$prize_id = getJustEntryPrize();

//CM学生賞名を取得//取れなかったら停止
$PageTitle = getJustEntryPrizeTitle($prize_id, true);

//フォーム定義クラス読み込み
require_once("ActionEditProduct.php");
$FORM = new ActionEditProduct($DB, $Auth->id);
$FORM->load(array('id'=>$Auth->id));


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/kasou.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>
<?php IO::outputTag($PageTitle); ?>
:ACジャパン</title>
<!-- InstanceEndEditable -->
<link href="../../../common/css/style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../../../common/js/jquery.js"></script>
<script type="text/javascript" src="../../../common/js/jquery.cookie.js"></script>
<script type="text/javascript" src="../../../common/js/jquery.textresizer.min.js"></script>
<script type="text/javascript" src="../../../common/js/base.js"></script>
<script type="text/javascript" src="../../../common/js/video_function2.js"></script>

<!-- Video API -->
<script type="text/javascript" src="../../../common/js/api/html5media.min.js"></script>
<!--[if lt IE 9]><script src="../../common/js/api/html5shiv.js"></script><![endif]-->


<style type="text/css">
#gnav_campaign > a {
	background-position: 0 bottom;
}
</style>
<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript">
$(function(){
<?php for ($i=1; $i<=$FORM->staffPersons;$i++){
	if($i % 5 == 0) {
	$staffdiv++;
		if($FORM->get('staff_count') < $i){
		$tableNum = 'stafftable'.$staffdiv;
?>
	$('#<?php IO::outputTag($tableNum); ?>').css('display', 'none');
<?php
		}
	}
} ?>

});

function inputTableOpen(tN){
	var tableNum = "stafftable"+tN;

	if ($('#'+tableNum).is(':visible') == false) {
		$('#'+tableNum).show('normal');
	}
}

</script>
<style type="text/css">
#gnav_campaign > a {
	background-position: 0 bottom;
}
table.inner th.sNum {
	width: 20px;
}
.input th {
	vertical-align: middle;
}
.notinputbg {
	background-color: #FFCCCC;
}
</style>
<?php App::outputFrameworkScript(); ?>
<script type="text/javascript" src="../../../common/js/jquery.textresizer.min.js"></script>
<script type="text/javascript">
$(function(){
	getIntentionLength();
	
    $('#intention').bind('keyup',function(){
		getIntentionLength();
    });
	
	$("#btnSubmit").click(function() {
		var titleC = $('#title').val().length;
		var themeC = $('#theme').val().length;
		var intentionC = $('#intention').val().length;		
		if(titleC<=0 || themeC<=0 || intentionC<=0){
			alert("作品タイトル、作品テーマ、企画意図は、\n作品応募期日までに必ず入力してください。\n未入力のままですと審査の対象外となります。");
		}	
		$('#input_form').submit();
    });
});

function getIntentionLength(){
	var intentionLength = $('#intention').val().length;
	$('#intentionCount').html(intentionLength);
	if(intentionLength > 150){
		$('#inputAlert').css("display", "block");
		$("#btnSubmit").prop("disabled", true);
	} else {
		$('#inputAlert').css("display", "none");
		$("#btnSubmit").prop("disabled", false);
	}
}

</script>
<!-- InstanceEndEditable -->
<!-- InstanceParam name="breadclam" type="boolean" value="true" -->
<!-- InstanceParam name="gnav" type="text" value="campaign" -->
<!-- InstanceParam name="lnav" type="text" value="cm" -->

</head>
<body>
<div id="site_header">
  <div id="innner">
    
    <div id="header_right">
        <div id="site-search">
          <form class="gsc-search-box" method="get" action="../../../result.html">
            <input type="text" name="q" id="keywords" value="" placeholder="サイト内検索">
            <input type="submit" id="search-btn" value="検索">
          </form>
        </div>
      <div id= "chg-font-size"  class="cf">
        <div id="font-size"><img src="../../../common/images/font-size.gif" width="58" height="12" alt=""/></div>
        <ul id="chg_size">
          <li id="btn_s"><a href="javascript:;">標準</a></li>
          <li id="btn_b"><a href="javascript:;">大</a></li>
        </ul>
      </div>
        <div id="logo">
      <h1><a href="../../../index.html"><img src="../../../common/images/logo_header.png" width="146" height="45" alt="公益社団法人ACジャパン"/></a></h1>
      </div>
      <a href="../../../about_ac/english/about_ac.html" id="link_english" target="_blank">english</a> <a href="../../../contact.html" id="link_contact">お問い合わせ</a>
      <ul id="gnav">
        <li id="gnav_about_ac"><a href="../../../about_ac/index.html">ACジャパンの活動</a>
          <ul class="submenu">
            <li><a href="../../../about_ac/greeting.html">理事長ごあいさつ</a></li>
            <li><a href="../../../about_ac/index.html">ACジャパンとは</a></li>
            <li><a href="../../../about_ac/philosophy.html">ACジャパンの歴史</a></li>
            <li><a href="../../../about_ac/action.html">ACジャパンの活動のしくみ</a></li>
            <li><a href="../../../about_ac/mebae.html">ACマスコットめばえちゃん</a></li>
          </ul>
        </li>
        <li id="gnav_outline"><a href="../../../outline/index.html">団体概要</a>
          <ul class="submenu">
            <li><a href="../../../outline/index.html">団体概要</a></li>
            <li><a href="../../../outline/contract.html">定款</a></li>
            <li><a href="../../../outline/history.html">沿革</a></li>
            <li><a href="../../../outline/organi.html">組織図</a></li>
            <li><a href="../../../outline/board.html">役員一覧</a></li>
            <li><a href="../../../outline/business.html">公開資料</a></li>
            <li><a href="../../../outline/hojin.html">公益社団法人の該当性</a></li>
            <li><a href="../../../outline/p_policy.html">特定個人情報の基本方針</a></li>
            <li><a href="../../../outline/link.html">関係団体リンク</a></li>
          </ul>
        </li>
        <li id="gnav_campaign"><a href="../../../campaign/index.html">広告キャンペーン</a>
          <ul class="submenu" id="cp">
            <li class="odd"><a href="../../../campaign/index.html">広告キャンペーン概要</a></li>
            <li><a href="../../../campaign/flow.html">キャンペーン実施の流れ</a></li>
            <li class="odd"><a href="../../../campaign/rule.html">支援キャンペーン実施諸規則</a></li>
            <li class="trouble"><a href="../../../campaign/production.html">プレゼンテーション<br />参加広告会社</a></li>
            <li class="odd"><a href="../../../campaign/self_theme.html">全国キャンペーンテーマ</a></li>
            <li><a href="../../../campaign/self_all/index.html">全国キャンペーン</a></li>
            <li class="odd"><a href="">広報キャンペーン</a></li>
            <li><a href="../../../campaign/self_area/index.html">地域キャンペーン</a></li>
            <li class="odd"><a href="../../../campaign/support/index.html">支援キャンペーン</a></li>
            <li class="trouble"><a href="../../../campaign/nhk/index.html">ＡＣジャパン・NHK<br />共同キャンペーン</a></li>
            <li class="odd"><a href="../../../campaign/cm/index.html">ＡＣジャパン広告学生賞</a></li>
            <li><a href="">臨時キャンペーン</a></li>
            <li class="trouble"><a href="../../../campaign/search.php">ＡＣジャパン<br />広告作品アーカイブ</a></li>
            <li><a href="../../../campaign/view/index.html">広告賞受賞作品一覧</a></li>
            <li><a href="../../../campaign/rental.html">広告作品の貸出について</a></li>
            <li><a href="../../../campaign/secondary_use.html">広告作品の二次使用について</a></li>
          </ul>
        </li>
        <li id="gnav_join"><a href="../../../join/index.html">入会のご案内</a>
          <ul class="submenu">
            <li><a href="../../../join/index.html">入会のご案内</a></li>
            <li><a href="../../../join/contact.html">資料請求</a></li>
          </ul>
        </li>
        <li id="gnav_member"><a href="../../../member/index.html">会員一覧</a>
          <ul class="submenu">
            <li><a href="../../../member/index.html">正会員リスト</a></li>
            <li><a href="../../../member/support_list.html">個人会員リスト</a></li>
          </ul>
        </li>
		<li id="gnav_comment"><a href="../../../request/index.html">ご意見・ご要望</a>
          <!--<ul class="submenu">
            <li><a href="../comment/index.html">正会員リスト</a></li>
            <li><a href="../comment/support_list.html">個人会員リスト</a></li>
          </ul>-->
        </li>
      </ul>
    </div>
  </div>
  <div id="header_line"></div>
</div>
<div id="container"> 
  <div id="wapper" class="cf">
    <div id="contents_area" class="cf">
      <div id="g_title"><!-- InstanceBeginEditable name="g_title" -->
        <h1>
          <?php IO::outputTag($PageTitle); ?>
        </h1>
        <!-- InstanceEndEditable --></div>
      <div id="maincontent" class="cf">
        <div id="maincontent-innner" class="cf"> <!-- InstanceBeginEditable name="maincontent-innnre" -->
        <div><a href="../preview.php">&lt;&nbsp;登録情報確認画面に戻る</a></div>
        <h2 style="margin-bottom: 10px;">作品情報の入力</h2>
        <p>応募する作品の内容を入力し、ページ最下部の【確認】をクリックしてください。</p>
        <form id="input_form" name="input_form" method="post" action="confirm.php">
          <?php $FORM->outputErrorAlert(); ?>
          <input type="hidden" id="prize_id" name="prize_id" value="<?php IO::outputTag($prize_id); ?>" />
          <?php $FORM->outputToken(); ?>
          <table class="input">
          <tr>
            <th>作品タイトル<span class="required">【必須】</span></th>
            <td><div class="form_block">
                <input type="text" id="title" name="title" maxlength="255" size="40" value="<?php $FORM->outputTag('title'); ?>"<?php if(!$FORM->get('title')){ ?> class="notinputbg"<?php } ?> />
              </div>
              <?php $FORM->outputError('title'); ?></td>
          </tr>
          <tr>
            <th>作品テーマ<span class="required">【必須】</span><br />
              <span class="required">（10文字程度）</span></th>
            <td><div class="form_block">
                <input type="text" id="theme" name="theme" maxlength="20" size="20" value="<?php $FORM->outputTag('theme'); ?>"<?php if(!$FORM->get('theme')){ ?> class="notinputbg"<?php } ?> />
              </div>
              <p>環境保全、いじめ、マナーなど、作品テーマを一言で入力してください。</p>
              <?php $FORM->outputError('theme'); ?></td>
          </tr>
          <tr>
            <th>企画意図・狙い<br/><span class="required">【必須】</span><br />
              <span class="required">（150文字以内）</span> </th>
            <td>
            <span id="intentionCount">0</span>文字入力<span id="inputAlert" class="required" style="float:right;font-weight:bold;">※150文字以上は送信できません。</span>
            <div class="form_block">
                <textarea id="intention" name="intention" rows="5" style="width:85%;"<?php if(!$FORM->get('intention')){ ?> class="notinputbg"<?php } ?>>
<?php $FORM->output('intention'); ?>
</textarea>
              </div>
              <p>この作品で訴えたいこと、なぜこのテーマを選んだかなど、制作の意図を150文字以内で入力してください。</p>
              <?php $FORM->outputError('intention'); ?></td>
          </tr>
          <tr>
            <th>スタッフ<span class="required">【必須】</span>
              <?php //print "<br />".$FORM->get('staff_count')."<br />"; ?></th>
            <td><p class="attn">代表者を含めた全スタッフを入力してください。<br />                
                ※漢字表記に誤りがないよう、事前に確認の上、入力してください。<br />
                フリガナも必ず入力してください。</p>
              <table class="inner table-staff">
                <?php for ($i=1; $i<=$FORM->staffPersons;$i++){
			$staff_id = 'staff_id'.sprintf("%02d", $i);//スタッフID
			$staff_delete = 'staff_delete'.sprintf("%02d", $i);//スタッフレコード削除
			$staff_name_sei = 'staff_name_sei'.sprintf("%02d", $i);//姓
			$staff_name_mei = 'staff_name_mei'.sprintf("%02d", $i);//名
			$staff_kana_sei = 'staff_kana_sei'.sprintf("%02d", $i);//セイ
			$staff_kana_mei = 'staff_kana_mei'.sprintf("%02d", $i);//メイ
              ?>
                <tr>
                  <th class="sNum"><?php IO::output($i); ?>
                    ：
                    <?php if ($i==1){ ?>
                    <br/>
                    <span class="required">（代表者）</span>
                    <?php } ?>
                    <input type="hidden" id="<?php IO::output($staff_id); ?>" name="<?php IO::output($staff_id); ?>" value="<?php $FORM->outputTag($staff_id); ?>" />
                    <?php if($FORM->get($staff_id) && $i > 1){ ?>
                    <ul class="check_sequence staff_delete01_input_area">
                      <?php foreach ($FORM->getLabel($staff_delete) as $key => $val) { ?>
                      <li>
                        <label for="<?php IO::output($staff_delete); ?>_<?php print($key); ?>">
                          <input type="checkbox" id="<?php IO::output($staff_delete); ?>_<?php print($key); ?>" name="<?php IO::output($staff_delete); ?>[]" value="<?php print($key); ?>" <?php $FORM->checked($staff_delete, $key); ?> />
                          <?php IO::output($val); ?>
                        </label>
                      </li>
                      <?php } ?>
                    </ul>
                    <?php } ?>
                  </th>
                  <th class="sStr"> 姓
                    <div class="form_block">
                      <input type="text" id="<?php IO::output($staff_name_sei); ?>" name="<?php IO::output($staff_name_sei); ?>" maxlength="255" size="6" value="<?php $FORM->outputTag($staff_name_sei); ?>" />
                    </div>
                    <?php $FORM->outputError($staff_name_sei); ?></th>
                  <th class="sStr"> 名
                    <div class="form_block">
                      <input type="text" id="<?php IO::output($staff_name_mei); ?>" name="<?php IO::output($staff_name_mei); ?>" maxlength="255" size="6" value="<?php $FORM->outputTag($staff_name_mei); ?>" />
                    </div>
                    <?php $FORM->outputError($staff_name_mei); ?></th>
                  <th class="sStr"> 姓（フリガナ）
                    <div class="form_block">
                      <input type="text" id="<?php IO::output($staff_kana_sei); ?>" name="<?php IO::output($staff_kana_sei); ?>" maxlength="255" size="6" value="<?php $FORM->outputTag($staff_kana_sei); ?>" />
                    </div>
                    <?php $FORM->outputError($staff_kana_sei); ?></th>
                  <th class="sStr"> 名（フリガナ）
                    <div class="form_block">
                      <input type="text" id="<?php IO::output($staff_kana_mei); ?>" name="<?php IO::output($staff_kana_mei); ?>" maxlength="255" size="6" value="<?php $FORM->outputTag($staff_kana_mei); ?>" />
                    </div>
                    <?php $FORM->outputError($staff_kana_mei); ?></th>
                </tr>
                <?php if($i % 5 == 0){ ?>
                <?php $stafftable++; ?>
              </table>
              <?php if($i<$FORM->staffPersons){ ?>
              <div><a href="javascript:inputTableOpen('<?php IO::outputTag($stafftable); ?>');">▼スタッフを追加（5名ずつ）</a></div>
              <?php if($stafftable > 1){ ?>
          </div>
          <?php } ?>
          <div id="stafftable<?php IO::outputTag($stafftable); ?>">
          <table class="inner table-staff">
            <?php } ?>
            <?php } ?>
            <?php } ?>
              </td>
            
              </tr>
            
            <tr>
              <td colspan="2" class="buttonArea"><input type="button" value="確認" id="btnSubmit" /></td>
            </tr>
          </table>
        </form>
        <h3><a href="../logout.php">ログアウト</a></h3>
        <!-- InstanceEndEditable --> </div>
      </div>
      <div class="rightmenu">    
        <ul class="localnavi">
          <li class="item "><a href="../../../campaign/index.html">広告キャンペーン概要</a></li>
         <li class=""><a href="../../../campaign/flow.html">キャンペーン実施の流れ</a></li>
          <li class=""><a href="../../../campaign/rule.html">支援キャンペーン実施諸規則</a></li>
           <li class=""><a href="../../../campaign/production.html">プレゼンテーション参加広告会社</a></li> 
          <li class=""><a href="../../../campaign/self_theme.html">全国キャンペーンテーマ</a></li>
          <li class=""><a href="../../../campaign/self_all/index.html">全国キャンペーン</a></li>
          <li class=""><a>広報キャンペーン</a></li>
          <li class=""><a href="../../../campaign/self_area/index.html">地域キャンペーン</a></li>
          <li class=""><a href="../../../campaign/support/index.html">支援キャンペーン</a></li>
          <li class=""><a href="../../../campaign/nhk/index.html">ＡＣジャパン・NHK<br /><span style="padding-left:30px">共同キャンペーン</span></a></li>
          <li class=" active"><a href="../../../campaign/cm/index.html">ＡＣジャパン広告学生賞</a> 
            <!--<ul class="sub">
      <li>ACジャパンの公共広告　</li>
      <li>テーマ選定</li>
      <li>支援キャンペーン</li>
      <li>掲載媒体・実績</li>
      <li>CM学生賞の実施</li>
      </ul>--> 
          </li>
          <li class=""><a>臨時キャンペーン</a></li>
          <li class=""><a href="../../../campaign/search.php">ＡＣジャパン<br /><span style="padding-left:30px">広告作品アーカイブ</span></a></li>
          <li class=""><a href="../../../campaign/view/index.html">広告賞受賞作品一覧</a></li>
          <li class=""><a href="../../../campaign/rental.html">広告作品の貸出について</a></li>
          <li class=""><a href="../../../campaign/secondary_use.html">広告作品の二次使用について</a></li>
        </ul>
            </div>
    </div>
  </div>
   </div>
<div id="footer" class="cf">
  <div id="footerinnner">
    <div id="footer-top">
      <ul id="footerlink">
        <li class="footernav"><a href="../../../about.html">本サイトについて</a></li>
        <li class="footernav"><a href="../../../privacy.html">プライバシーポリシー</a></li>
        <li class="footernav"><a href="../../../sitemap.html">サイトマップ</a></li>
        <li class="footernav"><a href="../../../about.html#environ">推奨環境について</a></li>
      </ul>
      <div id="pagetop"><a href="#logo"><img src="../../../common/images/pageup.gif" width="220" height="32" alt="page up"/></a></div>
    </div>
    <p id="copyright">Copyright&copy;2014 Advertising Council Japan. All Rights Reserved.</p>
  </div>
</div>
<!-- InstanceBeginEditable name="Page Js" -->
<!-- Page JavaScript-->
<!-- InstanceEndEditable --> 
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51402180-1', 'ad-c.or.jp');
  ga('send', 'pageview');

</script>
</body>
<!-- InstanceEnd --></html>
