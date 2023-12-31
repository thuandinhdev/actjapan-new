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

$param = ActionForm::getSessionParam();

###CM学生賞IDを取得
$prize_id = $param['prize_id'];

//CM学生賞名を取得//取れなかったら停止
$PageTitle = getJustEntryPrizeTitle($prize_id, true);

require_once("CMsPrizeEntry.php");
$FORM = new CMsPrizeEntry($DB, $Auth->id);
$FORM->setRecordDB(array('id'=>$Auth->id));

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
<?php App::outputFrameworkScript(); ?>
<script type="text/javascript" src="../../../common/js/jquery.textresizer.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#btnSubmit").click(function(){
		$('#input_form').submit();
	});
});

function checkAgreeFlie(){
	if($('#agree_pdf_mp4').is(":checked") && $('#agree_excel').is(":checked")){
		$("#btnSubmit").prop("disabled", false);
	} else {
		$("#btnSubmit").prop("disabled", true);
	}
}
$( document ).ready(function() {
  checkAgreeFlie();
});

</script>
<style type="text/css">
.attn {
	color: #990000;
	font-weight: bold;
}
.check_form {
  border: 1px solid #5691c0;
  padding: 12px;
}
.align-center {
  text-align: center;
  margin-top: 10px;
}
</style>
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
      <div id="g_title"><!-- InstanceBeginEditable name="g_title" --><h1><?php IO::outputTag($PageTitle); ?></h1><!-- InstanceEndEditable --></div>
      <div id="maincontent" class="cf">
        <div id="maincontent-innner" class="cf"> <!-- InstanceBeginEditable name="maincontent-innnre" -->
       <h2 style="margin-bottom: 10px;">作品情報登録の完了</h2>
        <p>作品情報の登録を完了しました。<br />
        作品情報は応募期間中何度でも編集が可能です。</p>
        <div class="action-link">
          <a href="../preview.php">&lt;&nbsp;登録情報確認画面に戻る</a>
          <h3><a href="../logout.php">ログアウト</a></h3>
        </div>
        <form id="input_form" name="input_form" method="post" action="../info_upload.php" class="check_form">
          <input type="hidden" id="prize_id" name="prize_id" value="<?php IO::outputTag($prize_id); ?>" />
          <p>※必ず作品情報の内容を確定させてからチェックを入れてください。</p>
          <ul class="check_sequence">
            <li>
              <label for="">
                <input type="checkbox" id="agree_pdf_mp4" onchange="checkAgreeFlie()" <?php if($FORM->get('agree_upload_terms')){ ?> checked <?php }?>/>
                応募作品データは新聞の場合は<strong class="red">10MB</strong>以下の<strong class="red">PDF</strong>、CMの場合は<strong class="red">50MB</strong>以下の<strong class="red">MP4</strong>ですか？
              </label>
            </li>
            <li>
              <label for="">
                <input type="checkbox" id="agree_excel" onchange="checkAgreeFlie()" <?php if($FORM->get('agree_upload_terms')){ ?> checked <?php }?>/>
                EXCELのアップロード用「応募作品リスト」は準備できていますか？​
              </label>
            </li>
          </ul>
          <p class="align-center">
            <input type="button" id="btnSubmit" class="thanks_btnsubmit" value="登録を完了しアップロードへ進む"/>
          </p>
        </form>
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
