<?php

$top_fst_text = "Log In";
$top_snd_text = "Sign Up";
$top_fst_link = "#popup1";
$top_snd_link = "#popup1";


if(Session::isSessionSet("loggedIn")){
    $top_fst_text = "";
    $top_snd_text = "Log Out";
    $top_fst_link = "";
    $top_snd_link = "logout/callLogOut";
}

?>
<html>
<head>
    <!------------jquery import ----------->
    <script src="<?php echo URL?>public/js/jquery/jquery-3.1.0.js" type="text/javascript" charset="utf-8"></script>

    <!-- draggable import -->
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


    <!-- css Plug In -->
    <link href="css/css_reset.css" rel="stylesheet" />

    <!-- css custom -->
    <link media="screen" href="css/style/pc.css" rel="stylesheet" />

    <link rel="stylesheet" href="css/style.css">

    <!-- Tile Display -->
    <script type="text/javascript" src="js/tiledisplay/freewall.js"></script>

    <!-- page handler-->
    <script type="text/javascript" src="js/ajax-page-call.js"></script>
</head>
<header style="height: 37px;">
    <div id="header-gnb">
        <div class="HeaderImg1">  <!-- HeaderImg[i] {0 : 홈 버튼, 1 : 로고, 2 : 메뉴 버튼} -->
            <img src="img/pavicon/logo_white_scaled.png" style="height:37px"  onclick="$.pagehandler.loadContent('index');">
        </div>
        <div class="MemberShipBtn1" style="top:10px">  <!-- MemberShipBtn[n] {0 : 입장 전, 1 : 입장 후 (로그인 X)} -->
            <a href="<?php echo $top_fst_link?>" id="top_login"><?php echo $top_fst_text?></a>
            <a href="<?php echo $top_snd_link?>" id="top_login"><?php echo $top_snd_text?></a>
        </div>
        <div style="position:absolute; right:25px; height:37px;">
            <a href="webstudio"><img src="img/beta.png" style="height:37px"></a>
        </div>
    </div>
</header>