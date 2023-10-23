<?php
require_once("../../common/frame/template.php");

//SSLじゃない場合はリダイレクト
if (!$_SERVER["HTTPS"]) IO::forceRedirect('https://'.App::config('host').$_SERVER["PHP_SELF"]);


//デバッグから除外
//if (class_exists('Debug')) Debug::invalid();

//セッションスタート
Session::start();

//権限オブジェクト生成
$Auth = new CmsAuth('members');

//権限が無い場合はログインページへ
$Auth->checkCurrentPage($Auth->per('default'), App::custom('URL.members_login'));

//var_dump($Auth);

//DB接続
$DB = new DBO_MySQL();

###現在応募受付中の広告学生賞があるかチェック
$prize_id = getJustEntryPrize();

//広告学生賞名を取得//取れなかったら停止
$PageTitle = getJustEntryPrizeTitle($prize_id, true);

//フォーム定義クラス読み込み
require_once("CMsPrizeEntry.php");
$FORM = new CMsPrizeEntry($DB, $Auth->id);
$FORM->setRecordDB(array('id'=>$Auth->id));


###//応募者情報//を登録済みかチェック
$EditDoneMember = false;
//代表者および、担当教官のフリガナが入力されていたら
if($FORM->get('kana_sei') || $FORM->get('kana_mei') || $FORM->get('instructor_kana_sei') || $FORM->get('instructor_kana_mei')){
	
	if($FORM->get('instructor_key')){//担当教官承認が未であれば
		$EditDoneMember = 1;//未承認なので担当教官メールアドレスのみ編集可
	} else {
		$EditDoneMember = 2;//編集不可
	}
}
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
<link href="../../common/css/style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../../common/js/jquery.js"></script>
<script type="text/javascript" src="../../common/js/jquery.cookie.js"></script>
<script type="text/javascript" src="../../common/js/jquery.textresizer.min.js"></script>
<script type="text/javascript" src="../../common/js/base.js"></script>
<script type="text/javascript" src="../../common/js/video_function2.js"></script>

<!-- Video API -->
<script type="text/javascript" src="../../common/js/api/html5media.min.js"></script>
<!--[if lt IE 9]><script src="../../common/js/api/html5shiv.js"></script><![endif]-->


<style type="text/css">
#gnav_campaign > a {
	background-position: 0 bottom;
}
</style>
<!-- InstanceBeginEditable name="head" -->
<?php App::outputFrameworkScript(); ?>
<script type="text/javascript">
$(function(){
	<?php if($EditDoneMember != 2){ ?>
	$("#EditProfile").click(function(){
		$('#profile_form').submit();
	});
	<?php } ?>
	<?php if($EditDoneMember){ ?>
	$("#EditProduct").click(function(){
		$('#product_form').submit();
	});
	<?php } ?>
	
	$("#showProfile").click(function(){
		$('#showProfile').empty();
		if($('#otherProfile').css('display') == 'none'){
			$('#otherProfile').show("fast");
			$('#showProfile').text('閉じる▲')
		} else {
			$('#otherProfile').hide("fast");
			$('#showProfile').text('すべての内容を確認する▼')
		}
    });
});
</script>
<style type="text/css">
.leftth {
	text-align: left !important;
	padding-left: 1em;
}
table .inner, table .inner th {
	border: hidden;
}
.notinputlabel {
	color: #FF0000;
	font-weight: bold;
}
.notinputbg {
	background-color: #FFCCCC;
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
          <form class="gsc-search-box" method="get" action="../../result.html">
            <input type="text" name="q" id="keywords" value="" placeholder="サイト内検索">
            <input type="submit" id="search-btn" value="検索">
          </form>
        </div>
      <div id= "chg-font-size"  class="cf">
        <div id="font-size"><img src="../../common/images/font-size.gif" width="58" height="12" alt=""/></div>
        <ul id="chg_size">
          <li id="btn_s"><a href="javascript:;">標準</a></li>
          <li id="btn_b"><a href="javascript:;">大</a></li>
        </ul>
      </div>
        <div id="logo">
      <h1><a href="../../index.html"><img src="../../common/images/logo_header.png" width="146" height="45" alt="公益社団法人ACジャパン"/></a></h1>
      </div>
      <a href="../../about_ac/english/about_ac.html" id="link_english" target="_blank">english</a> <a href="../../contact.html" id="link_contact">お問い合わせ</a>
      <ul id="gnav">
        <li id="gnav_about_ac"><a href="../../about_ac/index.html">ACジャパンの活動</a>
          <ul class="submenu">
            <li><a href="../../about_ac/greeting.html">理事長ごあいさつ</a></li>
            <li><a href="../../about_ac/index.html">ACジャパンとは</a></li>
            <li><a href="../../about_ac/philosophy.html">ACジャパンの歴史</a></li>
            <li><a href="../../about_ac/action.html">ACジャパンの活動のしくみ</a></li>
            <li><a href="../../about_ac/mebae.html">ACマスコットめばえちゃん</a></li>
          </ul>
        </li>
        <li id="gnav_outline"><a href="../../outline/index.html">団体概要</a>
          <ul class="submenu">
            <li><a href="../../outline/index.html">団体概要</a></li>
            <li><a href="../../outline/contract.html">定款</a></li>
            <li><a href="../../outline/history.html">沿革</a></li>
            <li><a href="../../outline/organi.html">組織図</a></li>
            <li><a href="../../outline/board.html">役員一覧</a></li>
            <li><a href="../../outline/business.html">公開資料</a></li>
            <li><a href="../../outline/hojin.html">公益社団法人の該当性</a></li>
            <li><a href="../../outline/p_policy.html">特定個人情報の基本方針</a></li>
            <li><a href="../../outline/link.html">関係団体リンク</a></li>
          </ul>
        </li>
        <li id="gnav_campaign"><a href="../../campaign/index.html">広告キャンペーン</a>
          <ul class="submenu" id="cp">
            <li class="odd"><a href="../../campaign/index.html">広告キャンペーン概要</a></li>
            <li><a href="../../campaign/flow.html">キャンペーン実施の流れ</a></li>
            <li class="odd"><a href="../../campaign/rule.html">支援キャンペーン実施諸規則</a></li>
            <li class="trouble"><a href="../../campaign/production.html">プレゼンテーション<br />参加広告会社</a></li>
            <li class="odd"><a href="../../campaign/self_theme.html">全国キャンペーンテーマ</a></li>
            <li><a href="../../campaign/self_all/index.html">全国キャンペーン</a></li>
            <li class="odd"><a href="">広報キャンペーン</a></li>
            <li><a href="../../campaign/self_area/index.html">地域キャンペーン</a></li>
            <li class="odd"><a href="../../campaign/support/index.html">支援キャンペーン</a></li>
            <li class="trouble"><a href="../../campaign/nhk/index.html">ＡＣジャパン・NHK<br />共同キャンペーン</a></li>
            <li class="odd"><a href="../../campaign/cm/index.html">ＡＣジャパン広告学生賞</a></li>
            <li><a href="">臨時キャンペーン</a></li>
            <li class="trouble"><a href="../../campaign/search.php">ＡＣジャパン<br />広告作品アーカイブ</a></li>
            <li><a href="../../campaign/view/index.html">広告賞受賞作品一覧</a></li>
            <li><a href="../../campaign/rental.html">広告作品の貸出について</a></li>
            <li><a href="../../campaign/secondary_use.html">広告作品の二次使用について</a></li>
          </ul>
        </li>
        <li id="gnav_join"><a href="../../join/index.html">入会のご案内</a>
          <ul class="submenu">
            <li><a href="../../join/index.html">入会のご案内</a></li>
            <li><a href="../../join/contact.html">資料請求</a></li>
          </ul>
        </li>
        <li id="gnav_member"><a href="../../member/index.html">会員一覧</a>
          <ul class="submenu">
            <li><a href="../../member/index.html">正会員リスト</a></li>
            <li><a href="../../member/support_list.html">個人会員リスト</a></li>
          </ul>
        </li>
		<li id="gnav_comment"><a href="../../request/index.html">ご意見・ご要望</a>
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
          <h2 style="margin-bottom: 10px;">登録情報確認画面</h2>
          <div class="input_h3">応募者情報</div>
          <?php if(!$EditDoneMember){ ?>
          <p class="attn">作品情報を登録する前に必ず応募者情報の入力を完了してください。</p>
          <?php } ?>
          <table class="input">
            <tr>
              <th>会員校</th>
              <td><div class="form_block">
                  <?php $SchoolNumNameArray = getSchoolNumName($FORM->get('school_id')); ?>
                  【
                  <?php IO::output($SchoolNumNameArray['school_number']); ?>
                  】&nbsp;
                  <?php IO::output($SchoolNumNameArray['school_name']); ?>
                </div></td>
            </tr>
            <tr>
              <th>作品ID</th>
              <td><div class="form_block">
                  <?php $FORM->output('user_id'); ?>
                </div></td>
            </tr>
            <tr>
              <th>代表者名</th>
              <td><div class="form_block">
                  <?php $FORM->output('name_sei'); ?>
                  &nbsp;
                  <?php $FORM->output('name_mei'); ?>
                </div></td>
            </tr>
            <tr>
              <th>応募部門</th>
              <td><div class="form_block">
                  <?php $FORM->outputText('recruit_type'); ?>
                </div></td>
            </tr>
            <?php if($EditDoneMember == 2){ ?>
          </table>
          <p style="text-align:right;"><a href="javascript:;" id="showProfile">すべての内容を確認する▼</a></p>
          <table class="input" id="otherProfile" style="display:none;">
            <?php } ?>
            <tr>
              <th<?php if(!$FORM->get('kana_sei') || !$FORM->get('kana_mei')){ ?> class="notinputlabel"<?php } ?>>代表者名フリガナ</th>
              <td<?php if(!$FORM->get('kana_sei') || !$FORM->get('kana_mei')){ ?> class="notinputbg"<?php } ?>><div class="form_block">
                  <?php $FORM->output('kana_sei'); ?>
                  &nbsp;
                  <?php $FORM->output('kana_mei'); ?>
                </div></td>
            </tr>
            <tr>
              <th>代表者メールアドレス</th>
              <td><div class="form_block">
                  <?php $FORM->output('email'); ?>
                </div></td>
            </tr>
            <tr>
              <th<?php if(!$FORM->get('college')){ ?> class="notinputlabel"<?php } ?>>学部・学科・学年</th>
              <td<?php if(!$FORM->get('college')){ ?> class="notinputbg"<?php } ?>><div class="form_block">
                  <?php $FORM->output('college'); ?>
                </div></td>
            </tr>
            <tr>
              <th<?php if(!$FORM->get('tel')){ ?> class="notinputlabel"<?php } ?>>代表者電話番号</th>
              <td<?php if(!$FORM->get('tel')){ ?> class="notinputbg"<?php } ?>><div class="form_block">
                  <?php $FORM->output('tel'); ?>
                </div></td>
            </tr>
            <tr>
              <th>担当教官名
                &nbsp; <?php print getRegistStatus($FORM->get('instructor_key')); ?></th>
              <td><div class="form_block">
                  <?php $FORM->output('instructor_name_sei'); ?>
                  &nbsp;
                  <?php $FORM->output('instructor_name_mei'); ?>
                </div></td>
            </tr>
            <tr>
              <th<?php if(!$FORM->get('instructor_kana_sei') || !$FORM->get('instructor_kana_mei')){ ?> class="notinputlabel"<?php } ?>>担当教官名フリガナ</th>
              <td<?php if(!$FORM->get('instructor_kana_sei') || !$FORM->get('instructor_kana_mei')){ ?> class="notinputbg"<?php } ?>><div class="form_block">
                  <?php $FORM->output('instructor_kana_sei'); ?>
                  &nbsp;
                  <?php $FORM->output('instructor_kana_mei'); ?>
                </div></td>
            </tr>
            <tr>
              <th>担当教官メールアドレス</th>
              <td><div class="form_block">
                  <?php $FORM->output('instructor_email'); ?>
                </div></td>
            </tr>
            <tr>
              <th<?php if(!$FORM->get('instructor_tel')){ ?> class="notinputlabel"<?php } ?>>担当教官電話番号</th>
              <td<?php if(!$FORM->get('instructor_tel')){ ?> class="notinputbg"<?php } ?>><div class="form_block">
                  <?php $FORM->output('instructor_tel'); ?>
                </div></td>
            </tr>
            <tr>
              <td colspan="2" class="buttonArea"><?php if($EditDoneMember != 2){ ?>
                <form id="profile_form" name="profile_form" method="get" action="profile/">
                  <input type="hidden" id="id"  name="id" value="<?php $FORM->outputTag('id'); ?>" />
                  <input type="hidden" id="mode"  name="mode" value="edit" />
                  <input type="button" id="EditProfile" name="EditProfile" value="応募者情報を編集" />
                </form>
                <?php } else { //編集不可であれば　?>
                <span class="attn">一度登録した応募者情報は編集できません。</span>
                <?php } ?></td>
            </tr>
          </table>
          <div class="input_h3">ACジャパンのCIダウンロード</div>
          <table class="input">
          <?php if($FORM->get('recruit_type')=='T'){ //テレビCM部門?>
            <tr>
              <th class="leftth">作品の最後には、必ずACのCIを表示してください。データは以下からダウンロードできます。</th>
            </tr>
            <tr>
              <td><a href="cidata/tdata.zip"><img src="img/ac_logo.png" width="168" height="133" alt="ACジャパンCI"/><br />
                ■ACジャパンCIデータ（zip形式圧縮ファイル）</a></td>
            </tr>
            <?php } else ?>
            <?php if($FORM->get('recruit_type')=='N'){ //新聞広告部門?>
            <tr>
              <th class="leftth">制作の際は必ず規定の制作用フォーマットを使用してください。<br />
原寸データと説明書は以下からダウンロードできます。</th>
            </tr>
            <tr>
              <td><a href="cidata/ndata.zip"><img src="img/ac_logo.png" width="168" height="133" alt="ACジャパンCI"/><br />
                ■ACジャパンCIデータ（zip形式圧縮ファイル）</a></td>
            </tr>
            <?php } ?>
          </table>
          <div class="input_h3">作品情報</div>
          <?php if(!$EditDoneMember){ ?>
          <p class="attn">応募者情報の入力が完了するまでは作品情報は登録できません。</p>
          <?php } ?>
          <table class="input">
            <tr>
              <th>作品タイトル</th>
              <td><div class="form_block">
                  <?php $FORM->output('title'); ?>
                </div></td>
            </tr>
            <tr>
              <th>作品テーマ</th>
              <td><div class="form_block">
                  <?php $FORM->output('theme', true); ?>
                </div></td>
            </tr>
            <tr>
              <th>企画意図・狙い</th>
              <td><div class="form_block">
                  <?php $FORM->output('intention', true); ?>
                </div></td>
            </tr>
            <tr>
              <th>スタッフ</th>
              <td><table class="inner">
                  <?php for ($i=1; $i<=$FORM->staffPersons;$i++){
			$staff_name_sei = 'staff_name_sei'.sprintf("%02d", $i);//姓
			$staff_name_mei = 'staff_name_mei'.sprintf("%02d", $i);//名
			$staff_kana_sei = 'staff_kana_sei'.sprintf("%02d", $i);//セイ
			$staff_kana_mei = 'staff_kana_mei'.sprintf("%02d", $i);//メイ
              ?>
                  <?php if($FORM->get($staff_name_sei) || $FORM->get($staff_name_mei) || $FORM->get($staff_kana_sei) || $FORM->get($staff_kana_mei)){ ?>
                  <tr>
                    <th><?php IO::output($i); ?>
                      ：</th>
                    <th> <div class="form_block">
                        <?php $FORM->output($staff_name_sei); ?>
                        <?php $FORM->output($staff_name_mei); ?>
                        （
                        <?php $FORM->outputTag($staff_kana_sei); ?>
                        <?php $FORM->output($staff_kana_mei); ?>
                        ） </div>
                    </th>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                </table></td>
            </tr>
            <?php if($EditDoneMember){ ?>
            <tr>
              <td colspan="2" class="buttonArea"><form id="product_form" name="product_form" method="get" action="product/">
                  <input type="hidden" id="id"  name="id" value="<?php $FORM->outputTag('id'); ?>" />
                  <input type="hidden" id="mode"  name="mode" value="edit" />
                  <input type="button" id="EditProduct" name="EditProduct" value="作品情報を編集" />
                </form></td>
            </tr>
            <?php } ?>
          </table>    
          <?php if($FORM->get('agree_upload_terms')){ ?>     
          <table class="input">
            <tbody>
              <tr><th class="leftth">作品情報登録が完了し、作品データのアップロードが可能になりました。</th></tr>              
              <tr>
                <td>
                <div class="upload_form">
                  <p>
                    <strong
                      >作品アップロードアクセス先（クリックで別ウィンドウが開きます）</strong
                    >
                  </p>
                  <p>
                    <a href="https://a5.adstream.com/uploader?type=assets&isS3=true" target="_blank">https://a5.adstream.com/uploader?type=assets&isS3=true</a>
                  </p>
                  <ul class="account">
                    <li>
                      <span class="txt">ログインID:</span
                      ><span class="value">ac-prize@adbank.me</span>
                    </li>
                    <li>
                      <span class="txt">パスワード:</span
                      ><span class="value">Acs226554ccx​</span>
                    </li>
                  </ul>
                  <div class="name-file">
                    <span class="label">応募作品ファイル名</span>
                    <div class="file-code">
                      <div class="copy-code">
                        <span class="name-code" id="copyText"><?php $FORM->output('user_id'); ?>_<?php print(preg_replace('/\s+/', '', $FORM->get('name_sei').$FORM->get('name_mei'))); ?></span>
                        <button id="copyButton" onclick="withCopy();">
                          Copy
                        </button>
                      </div>
                      <span class="note"
                        >※応募作品データのファイル名は上記を使用してください。
                        <br />上記以外のファイル名は無効・失格となる場合があります。
                      </span>
                    </div>
                  </div>
                </div>
                </td>
              </tr>
            </tbody>
          </table> 
          <?php } ?>
          <h3><a href="logout.php">ログアウト</a></h3>
          <!-- InstanceEndEditable --> </div>
      </div>
      <div class="rightmenu">    
        <ul class="localnavi">
          <li class="item "><a href="../../campaign/index.html">広告キャンペーン概要</a></li>
         <li class=""><a href="../../campaign/flow.html">キャンペーン実施の流れ</a></li>
          <li class=""><a href="../../campaign/rule.html">支援キャンペーン実施諸規則</a></li>
           <li class=""><a href="../../campaign/production.html">プレゼンテーション参加広告会社</a></li> 
          <li class=""><a href="../../campaign/self_theme.html">全国キャンペーンテーマ</a></li>
          <li class=""><a href="../../campaign/self_all/index.html">全国キャンペーン</a></li>
          <li class=""><a>広報キャンペーン</a></li>
          <li class=""><a href="../../campaign/self_area/index.html">地域キャンペーン</a></li>
          <li class=""><a href="../../campaign/support/index.html">支援キャンペーン</a></li>
          <li class=""><a href="../../campaign/nhk/index.html">ＡＣジャパン・NHK<br /><span style="padding-left:30px">共同キャンペーン</span></a></li>
          <li class=" active"><a href="../../campaign/cm/index.html">ＡＣジャパン広告学生賞</a> 
            <!--<ul class="sub">
      <li>ACジャパンの公共広告　</li>
      <li>テーマ選定</li>
      <li>支援キャンペーン</li>
      <li>掲載媒体・実績</li>
      <li>CM学生賞の実施</li>
      </ul>--> 
          </li>
          <li class=""><a>臨時キャンペーン</a></li>
          <li class=""><a href="../../campaign/search.php">ＡＣジャパン<br /><span style="padding-left:30px">広告作品アーカイブ</span></a></li>
          <li class=""><a href="../../campaign/view/index.html">広告賞受賞作品一覧</a></li>
          <li class=""><a href="../../campaign/rental.html">広告作品の貸出について</a></li>
          <li class=""><a href="../../campaign/secondary_use.html">広告作品の二次使用について</a></li>
        </ul>
            </div>
    </div>
  </div>
   </div>
<div id="footer" class="cf">
  <div id="footerinnner">
    <div id="footer-top">
      <ul id="footerlink">
        <li class="footernav"><a href="../../about.html">本サイトについて</a></li>
        <li class="footernav"><a href="../../privacy.html">プライバシーポリシー</a></li>
        <li class="footernav"><a href="../../sitemap.html">サイトマップ</a></li>
        <li class="footernav"><a href="../../about.html#environ">推奨環境について</a></li>
      </ul>
      <div id="pagetop"><a href="#logo"><img src="../../common/images/pageup.gif" width="220" height="32" alt="page up"/></a></div>
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
