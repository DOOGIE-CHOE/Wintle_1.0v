<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/11/2016
 * Time: 4:29 PM
 */

//현재 보고있는 프로필의 정보를 가지고 오기 위한 소스
if(Session::isSessionSet("profile_id")){
    $profile_id = Session::get("profile_id");
}
$user_id = Session::get("user_id");


?>


<div id="all">

    <head>
        <style>
            .profile_head{
                top: 55px;
                position: relative;
                z-index: 0;
                display: block;

                /* 16:9 비율 */
                width:100%;
                padding-top: 35%;

            }
            .usercover_bg{
                width: 100%;
                height: 100%;
                top:0;
                left:0;
                right:0;
                position: absolute;
                background-color: black;
                opacity: 0.3;
                z-index: 0;
            }
            .cover-resize-wrapper:before{
                content: "";
                display: block;
                padding-top: 100%;
            }
            .cover-resize-wrapper{
                width: 100%;
                height: 100%;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                position: absolute;
                overflow: hidden;
            }
            #cover_photo{
                width: 100%;
                height:auto;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                position: absolute;
                background-repeat: no-repeat;
                background-size: cover;
            }
            #profile_info{
                max-width: 650px;
                /*height: 180px;*/
                text-align: center;
                z-index: 1;
                margin: 0 auto;
                bottom: 0;
                left: 0;
                right: 0;
            }
            #profile_text{
                font-size: 1.6em;
                text-align:center;
                line-height: 55px;
                margin-bottom: -65px;
            }
            #hash_tag{
                height:20%;
            }
            #photo{
                width:150px;
                height:150px;
                border-radius:50%;
                background-repeat:no-repeat;
                background-position:center center;
                background-size: cover;
                margin:0 auto;
            }
            #edit-profile-photo {
                position: absolute;
                display:none;
                top:100px;
                left:0;
                right:0;
                height: 50px;
                width: 150px;
                margin: 0 auto;
                overflow: hidden;
            }
            #edit-profile-photo:before {
                content: '';
                position: absolute;
                height: 150px;
                width: 150px;
                border-radius: 50%;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                left:0;
            }
            #edit-profile-photo p{
                position:relative;
                text-align : center;
                vertical-align:middle;
                line-height:50px;
                font-size: 23px;
                cursor:pointer;
                z-index: 20;
                /*disable cursor dragging*/
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
                color:whitesmoke;
            }

            #nav{
                list-style: none;
                margin: 0 auto;
                padding: 0;
                text-align: center;
                position: relative;
                background: white;
                top: 55px;
                height: 50px;
                box-shadow: 0 1px 4px rgba(0,0,0,0.3);
                border-radius:0 0 3px 3px;
            }

            /*#nav li{*/
                /*display:inline;*/
                /*overflow: hidden;*/
                /*z-index:1;*/
            /*}*/
            #nav a{
                display:inline-block;
                padding:0 !important;
                padding-top:15px !important;
                color: black;
                cursor:pointer;
                text-decoration: none;
            }
            #nav font{
                font-size:1.2em;
            }
            #username div{
                font-size:1.4em;
            }
            .triangle{
                visibility:hidden;
                position:absolute;
                border-bottom: 15px solid #f5f5f5;
                border-right: 10px solid transparent;
                border-left: 10px solid transparent;
            }
            #profile_text{
                height:100%;
                line-height: 50px;
            }
            #cover_upload_button{
                left: 10px;
                top: 10px;
                position:absolute;
                z-index:2;
            }
            .profile_followCheck{
                cursor: pointer;
            }
            .profile_followCheck:before{
                content:'following';
                font-weight:500;
                background:#fc6100;
                border-radius:5%;
                padding:2px;
                margin:2px 0;
                text-align: center;
                display:block;
                color:#000 !important
            }

            .profile_unfollowCheck {
                cursor: pointer;
            }
            .profile_unfollowCheck:before {
                content:'follow';
                font-weight:500;
                background:#999;
                border-radius:5%;
                padding:2px;
                margin:2px 0;
                text-align: center;
                display:block;
                color:#000 !important
            }

            .profile-grid{
                width:95%;
                margin:0 auto 0 auto !important;
                padding:0 !important
            }
            .profile-grid-item{
                width: 100%;
                float: left;
                height: auto !important;
                margin: 0px auto;
                padding: 0;
                background: white;
                box-shadow: 0 1px 4px rgba(0,0,0,0.3);
                border-radius: 3px 3px 0 0;
            }
            .profile-top{
                z-index: 1;
                top: -80px;
                position: relative;
            }
            #profile_photo{
                z-index: 1;
                width: 25%;
                margin: 0 auto;
            }

            /*@media(max-width:1920px){  }*/
            @media(max-width:1600px){  }
            @media(max-width:1440px){ #profile_text {  line-height: 45px; } }
            @media(max-width:1280px){ #profile_text {  line-height: 42px; } }
            @media(max-width:1024px){ #profile_text {  line-height: 40px; } }
            @media (max-width: 960px) { #profile_text {  line-height: 38px; } }
            @media (max-width: 840px) {
                #photo { width:140px;  height:140px;  }
                #nav{ display: table; width: 100%; }
                #nav font{ font-size:1.2em }
                .cover-resize-wrapper{  max-width:650px; width:95%; margin:0 auto 0 auto !important; top:20% }
                .usercover_bg{ max-width:650px; width:95%; margin:0 auto 0 auto !important; top:20% }
                #profile_text {  line-height: 35px; font-size:1.2em; margin-bottom: -55px;}
                .profile-top{ top: -65px; }
                .profile_head{ margin-top: -5%; }
            }
            @media (min-width: 840px) {
                #profile_info { position:absolute; }
                #edit-profile-photo{ }
            }
            @media (max-width: 767px) {
                #photo { width:130px;  height:130px;  }
                #edit-profile-photo{ width:140px; height:45px; }
                #edit-profile-photo:before { width:140px;  height:140px; }
                #profile_text {  line-height: 32px;  margin-bottom: -25px;}
                #nav{ display: table; width: 100%; }
                #nav font{ font-size:1.2em }
                .profile-top{ top: -35px; }
            }

            @media(max-width:600px){
                #photo { width:120px;  height:120px;  }
                #edit-profile-photo { width:130px; height:40px; }
                #edit-profile-photo p { line-height: 40px; font-size: 21px; }
                #edit-profile-photo:before { width:130px;  height:130px; }
                #profile_text { }
                #nav{ display: table; width: 100%; }
                #nav font{ font-size:1.2em }
                .profile-top{ top: -35px; }
            }
            @media (max-width: 540px) {
                #photo{  width:110px;  height:110px;  }
                #edit-profile-photo{ width:120px; height:45px; }
                #edit-profile-photo p{ line-height: 45px; font-size: 19px;}
                #edit-profile-photo:before { width:120px;  height:120px;  }
                /*#profile_text { font-size:1.1em; margin-bottom: -50px; }*/
                #nav font{ font-size:1.1em }
                /*.profile-top{ top: -60px; }*/
            }
            @media (max-width: 480px) {
                #photo{  width:100px;  height:100px;  }
                #edit-profile-photo{ width:110px; height:40px;}
                #edit-profile-photo p{ line-height: 40px; font-size: 17px;}
                #edit-profile-photo:before { width:110px;  height:110px;  }
                #profile_text { font-size:1.0em; }
                #nav font{ font-size:1.0em }
                .profile-top{ top: -30px; }
            }
            @media (max-width: 400px) {
                #photo{  width:90px;  height:90px;  }
                #edit-profile-photo{ width:100px; height:35px; }
                #edit-profile-photo p{ line-height: 35px; font-size: 15px;}
                #edit-profile-photo:before { width:100px;  height:100px;  }
                #profile_text { line-height: 30px; font-size:0.9em; margin-bottom: -25px;}
                #nav font{ font-size:0.9em }
            }
            @media (max-width: 320px) {
                #photo{  width:80px;  height:80px;  }
                #edit-profile-photo{ width:80px; height:30px; }
                #edit-profile-photo p{ line-height: 30px; font-size: 13px;}
                #edit-profile-photo:before {  width:80px;  height:80px;  }
                #profile_text { line-height: 25px; font-size:0.8em; margin-bottom: -20px;}
                .profile-top{ top: -25px; }
            }
        </style>
        <script>
            $.get("<?php echo URL?>common/getUsernameById/<?php echo $profile_id?>", function(o){
                var value = jQuery.parseJSON(o);
                if(value == null){
                    //display default image
                }else{
                    $("#username").append("<div>"+value+"</div>");
                }
            });
            $.get("<?php echo URL?>common/getProfilePhoto/cover/<?php echo $profile_id?>", function(o){
                $("#save-position-photo").hide();
                var value = jQuery.parseJSON(o);
                if(value.cover_photo_path == null){
                    //display default image
                }else{
                    $("#cover_photo").attr("src", "<?php echo URL?>"+ value.cover_photo_path);
                }
            }).done(function(){
                $.get("<?php echo URL?>profile/getCoverPhotoPosition/<?php echo $profile_id?>",function(o){

                    var result = jQuery.parseJSON(o);

                    var cover_photo_img = $("#cover_photo");

                    var imgHeight = cover_photo_img.height();

                    var headerHeight = $("#header-gnb").height();

                    var userCoverHeight = $(".profile_head").height();


                    var viewHeight = userCoverHeight - headerHeight; //화면에 보이는 높이

                    //페이지 호출 할때 보이는 부분보다 이미지가 작을때 이미지 높이 정의
                    //커버 이미지 높이 전체 뷰 높이로 지정.
                    if(imgHeight < viewHeight){
                        cover_photo_img.css({'height' : viewHeight, 'top' : '55px'});
                    } else {
                        cover_photo_img.css("top",result+"%");

                    }
                });
            });

            //프로필 사진 가져옴
            $.get("<?php echo URL?>common/getProfilePhoto/profile/<?php echo $profile_id?>",function(o){
                var value = jQuery.parseJSON(o);
                if (value.profile_photo_path != null) {
                    //display default image
                    // photo.append("<img src = '"+value.profile_photo_path+"' style='width: 187px; height: 187px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;'>");
                    $("#photo").css("background-image", 'url(<?php echo URL?>' + value.profile_photo_path + ')');
                    //$("#photo").attr('src', "<?php echo URL?>" + value.profile_photo_path);
                } else {
                    $("#photo").css("background-image", 'url(<?php echo URL?>' + 'img/defaultprofile.png)');
                }
            });

            //팔로우인지 체크
            $.get("<?php echo URL?>profile/getUserFollow/<?php echo $profile_id?>",function(o){
                var value = jQuery.parseJSON(o);
                var following = "following";
                var follow = "follow";
                var fCheck;
                //팔로우 하면 followCheck 언팔로우면 unfollowCheck
                if(value == following){
                    fCheck = "profile_followCheck";
                } else {
                    fCheck = "profile_unfollowCheck";
                }

                $('#follow_button').addClass(fCheck);

                /*if (value == following) {
                    //팔로우
                    $("#follow div").css("background-image", 'url(?php echo URL?>' + 'icon/profile/001-signs.svg)');
                    $("#follow font").text(value);
                } else if(value == follow) {
                    //언팔로우
                    $("#follow div").css("background-image", 'url(?php echo URL?>' + 'icon/profile/following.svg)');
                    $("#follow font").text(value);
                } else {
                    //비회원
                    $("#follow div").css("background-image", 'url(?php echo URL?>' + 'icon/profile/following.svg)');
                    $("#follow font").text(follow);
                }*/
            });

            //팔로워 숫자를 가져옴
            $.get("<?php echo URL?>common/getFollowNumber/<?php echo $profile_id?>",function(o){
                var value = jQuery.parseJSON(o);
                //$('#follow_number font').text(value['follow_num']);
            });

            //contents의 like 갯수를 가져옴
            $.get("<?php echo URL?>profile/getUserLike/<?php echo $profile_id?>",function(o){
                var value = jQuery.parseJSON(o);
                $('#like_number').text(value['like_number']);
            });

            //contents의 갯수를 가져옴
            $.get("<?php echo URL?>profile/getContentsNumber/<?php echo $profile_id?>",function(o){
                var value = jQuery.parseJSON(o);
                $('#contents_number').text(value['content_number']);
            });

            //remixing 갯수를 가져옴 (remixing 받은 횟수)
            $.get("<?php echo URL?>profile/getRemixingNumber/<?php echo $profile_id?>",function(o){
                var value = jQuery.parseJSON(o);
                $('#remixing_number').text(value['remixing_number']);
            });

            $(function() {


                //선택된 메뉴가 없을때 home메뉴로 고정한다.
                var menu_id = get_menu();
                if (menu_id != null) {
                    //followers나 following 메뉴 일때 menu_id를 follow로 지정
                    if (menu_id == "followers" || menu_id == "following") {
                        menu_id = "follow";
                    }
                    $('li').removeClass('active');
                    $('#' + menu_id).addClass('active');
                }
                else {
                    $('#home').addClass('active');
                }
                /////////////////////////////////////////

                //페이지 크기 조절할때 함수 실행
                $("#profile_photo").mouseover(function () {
                    $("#edit-profile-photo").fadeIn(200);
                }).mouseleave(function () {
                    $("#edit-profile-photo").fadeOut(0);
                });
                $("#edit-profile-photo").click(function () {
                    $("#profile-photo-input").trigger("click");
                });
                $("#edit-cover-photo").click(function () {
                    $("#cover-photo-input").trigger("click");
                });
                $('#profile-photo-input').on('change', function () {
                    $('#upload-profile-form').ajaxForm({
                        success: function (e) {
                            var data = $.parseJSON(e);
                            if (data[0] == false) {
                                errorDisplay(data[1]);
                                return false;
                            } else {
                                $.pagehandler.loadContent('<?php echo URL?>profile', "all");
                            }
                        }
                    }).submit();
                });
                $("#cover-photo-input").on('change', function () {
                    $('#upload-cover-form').ajaxForm({
                        success: function (e) {
                            var data = $.parseJSON(e);
                            if (data[0] == false) {
                                errorDisplay(data[1]);
                                return false;
                            } else {
                                $.pagehandler.loadContent('<?php echo URL?>profile', "all");
                            }
                        }
                    }).submit();
                });

//                $("#HashTags").tagit({
//                    //evert for after putting tags
//                    afterTagAdded: function(evt, ui) {
//                        var tags = $("#HashTags").tagit("assignedTags");
//                        //check whether the first charactor is #
//                        if(tags[tags.length-1].charAt(0) != '#'){
//                            //put # charactor at first then replace it with without-sharp tag
//                            var tagswithsharp = '#'+tags[tags.length-1];
//                            $("#HashTags").tagit("removeTagByLabel",tags[tags.length-1]);
//                            $("#HashTags").tagit("createTag",tagswithsharp);
//                        }
//                    }
//                });

                $('.profile_li').click(function () {
                    //작업일 2017-04-03, 2017-04-19
                    //class명이 동일할 경우가 있어 프로필에서 유일하게 사용하는 class명으로 지정
                    //선택된 메뉴에 css를 적용하기 위함
                    $('.profile_li').removeClass('active');  //li에에 active class 제거
                    $(this).addClass('active');     //클릭한 li에 class추가

                    // 작업일 2017-04-04
                    // li를 클릭하여 메뉴를 선택하기 위함
                    var menu_id = $(this).attr('id');    //클릭했던 li태그 ID를 가져와서 담는다.
                    $.pagehandler.loadContent('<?php echo URL . Session::get('profile_url')?>/' + menu_id, "contents"); //Url을 담는다.
                });

                /*
                 메뉴 마우스 오버 기능
                 $('li').mouseover(function(){
                 $('li').removeClass('active');
                 $(this).addClass('active');
                 });*/


                /*
                 작업일 : 2017-04-05
                 자기소개 펼치기기 위한 소스

                 */

                /* 2017-04-12 권동하 */
                $('#follow_button').click(function () {
                    //팔로우하게되면 1을 반환하고 text는 following 변환
                    var following = 1;

                    //팔로우 취소하게되면 2를 반환 text는 follow 변환
                    var follow = 2;

                    //비회원인데 follw버튼을 클릭 하면 회원가입 메세지 반환
                    var guest = -1;

                    $.get("<?php echo URL?>profile/setUserFollow/" + <?php echo $profile_id ?> , function (o) {
                        var data = $.parseJSON(o);

                        //followCheck 와 unfollowCheck의 css :before를 이용하여 텍스트 치환
                        if (data[0] == following) {
                            $('#follow_button').addClass("profile_followCheck");
                            $('#follow_button').removeClass("profile_unfollowCheck");
                        } else if (data[0] == follow) {
                            $('#follow_button').addClass("profile_unfollowCheck");
                            $('#follow_button').removeClass("profile_followCheck");
                        } else if (data[0] == guest){
                            errorDisplay("Please, Sign up");
                        }
                    });
                });

                /* 프로필 이미지를 profile_head에 가운데 오도록하기 위함 */
//                var profile_head_height = $('.profile_head').height();
//                var profile_height = (2 / 3) * profile_head_height;
//                var photo_size =  (2 / 7) * profile_head_height;
//
//                $('#edit-profile-photo').css({'width': photo_size, 'top' : (4 / 7) * photo_size});
//                $('#profile_info').css('bottom', profile_height);
//
//                if(70 <= photo_size) {
//                    $('#photo').css({'width': photo_size, 'height': photo_size});
//                    $('#profile_text').css({'left':'35%'});
//                } else {
//                    $('#photo').css({'width': '70px', 'height': '70px'});
//                    $('#profile_text').css({'left':'80px'});
//                }
                if( $(window).width() <= 820 ){
                    //console.log($('.cover-resize-wrapper').width());
                    //$('.cover-resize-wrapper').height();

                    console.log($('.cover-resize-wrapper').offset().top);
                    console.log($('#profile_info .profile-grid-item').offset().top);

                    var cover_size = (35/100) * $('.cover-resize-wrapper').width();
                    $('.cover-resize-wrapper').height(cover_size);
                    $('.usercover_bg').height(cover_size);
                } else {
                    $('.cover-resize-wrapper').css('height', '');
                    $('.usercover_bg').css('height', '');
                }

                $(window).bind('resize',function () {
                    //820은 프로필 카드가 cover사진 밑으로 내려가는 시점을 말한다.
                    if( $(window).width() <= 820 ){
                        //console.log($('.cover-resize-wrapper').width());
                        //$('.cover-resize-wrapper').height();

//                        console.log($('.cover-resize-wrapper').offset().top);
//                        console.log($('#profile_info .profile-grid-item').offset().top);

                        //비율을 맞추기 위해 가로 비율에 35퍼센트 만큼 높이 값을 준다.
                        var cover_size = (35/100) * $('.cover-resize-wrapper').width();
                        $('.cover-resize-wrapper').height(cover_size);
                        $('.usercover_bg').height(cover_size);
                    } else {
                        $('.cover-resize-wrapper').css('height', '');
                        $('.usercover_bg').css('height', '');
                    }

//                    var profile_head_height = $('.profile_head').height();
//                    var profile_height = (2 / 3) * profile_head_height;
//                    var tmp = (2 / 7);
//                    var photo_size = tmp * profile_head_height;
//
//                    $('#edit-profile-photo').css({'width': photo_size, 'top' : (4 / 7) * photo_size});
//                    $('#profile_info').css('bottom', profile_height);
//
//                    if(70 <= photo_size) {
//                        $('#photo').css({'width': photo_size, 'height': photo_size});
//                        $('#profile_text').css({'left':'35%'});
//                    } else {
//                        $('#photo').css({'width': '70px', 'height': '70px'});
//                        $('#profile_text').css({'left':'80px'});
//                    }
//


                });

                $('#nav a').mouseover(function(){
                    var menu_id = $(this).attr('id');
                    $('#'+menu_id+' .triangle').css('visibility','visible');
                });

                $('#nav a').mouseout(function(){
                    var menu_id = $(this).attr('id');
                    $('#'+menu_id+' .triangle').css('visibility','hidden');
                });

                $('#nav a').click(function(){
                    var menu_id = $(this).attr('id');
                    $('#'+menu_id+' .triangle').css('visibility','visible');
                });
            });

            function repositionCover() {
                $('#upload-cover-photo').hide();    //업로드 버튼
                $('#edit-position-photo').hide();   //위치수정 버튼
                $('#save-position-photo').show();   //저장 버튼

                //cover img에 드래그 기능 및 커서 css추가
                $('#cover_photo')
                    .css('cursor', 'Pointer')
                    .css('z-index', '1')
                    .draggable({
                        scroll: false,
                        axis: "y",
                        cursor: "Pointer",
                        drag: function (event, ui) {
                            //드래그 중 일때 실행
                            var y1 = $('.cover-resize-wrapper').height();
                            var y2 = $('.cover-resize-wrapper').find('img').height();
                            var ratio = (ui.position.top * -1) / y2 * 100;

                            //커버 사진이 커버 화면 밖으로 지정되는 상황 블록
                            if (ui.position.top >= 0) {
                                ui.position.top = 0;
                            }
                            else if (ui.position.top <= (y1-y2)) {
                                ui.position.top = y1-y2+5;
                            }
                        },
                        stop: function(event, ui) {
                            //드래그가 멈추었을 때 실행
                            //input value 에 top 값 저장
                            var ratio = ((ui.position.top) /$('.cover-resize-wrapper').height()) * 100;
                            console.log(ratio);
                            $('input.cover-position').val(ratio);
                        }
                    });
            }

            function saveReposition() {
                if ($('input.cover-position').length == 1) {
                    //저장하였던 top 값을 가져온다
                    var posY = $('input.cover-position').val();

                    $('#cover-position-form').attr("Action", "<?php echo URL?>profile/userCoverPhotoPosition/<?php echo $profile_id?>/" + posY);
                    console.log($('#cover-position-form').attr('Action'));
                    $("form#cover-position-form").ajaxForm({
                         success: function(e){
                             var data = $.parseJSON(e);
                             if(data[0] == false){

                             } else {
                                 $('#upload-cover-photo').show();   //업로드 버튼
                                 $('#edit-position-photo').show();  //위치수정 버튼
                                 $('#save-position-photo').hide();  //저장 버튼
                                 $('input.cover-position').val(0);  //input값 초기화
                                 //cover img 드래그 기능 및 커서 해제
                                 $('#cover_photo').css('top', posY+'%').draggable('destroy').css({'cursor':'default', 'z-index':''});
                             }
                         }
                     }).submit();
                }
            }

                /* 2017-04-19 권동하 */
                //이미지 위치 수정

            // 메뉴 태그 가져오는 함수
            function get_menu(){
                var url = document.location.href;
                var menu = url.split('/');
                if(typeof menu[4] != 'undefined')
                    menu = menu[4].replace("#", "");
                else
                    menu = null;
                return menu;
            }
        </script>
    </head>

    <body id="body" class="body_bg02 popup-background bg_deepgray">

    <!--  화면 하단 이용 약관 및 개인정보처리방침 페이지 링크 -->
    <div class="row info-bottom-board">
        <div class="col-md-2 col-lg-2 pull-right">
            <span onclick="$.pagehandler.loadContent('<?php echo URL?>info/terms','all')">Terms</span>
            <span onclick="$.pagehandler.loadContent('<?php echo URL?>info/privacy','all')">Privacy</span>
        </div>
    </div>

        <!--메뉴-->
        <div class="profile_head ">

            <!-- 프러필 커버 사진 -->
            <div class="cover-resize-wrapper">
                <?php if($profile_id == $user_id){ ?>
                    <div id="cover_upload_button" style="width:50%">
                        <button id='edit-position-photo' class="btn bg_orange btn-xs" onclick="repositionCover()" style="float:left;margin-right: 3%;">Edit</button>
                        <button id='save-position-photo' class="btn bg_orange btn-xs" onclick="saveReposition()" style="float:left;margin-right: 3%;">Save</button>
                        <form id="cover-position-form" method="post">
                            <input class="cover-position" name="pos" value="0" type="hidden">
                        </form>
                        <form id="upload-cover-form" action="<?php echo URL ?>profile/uploadProfilePhoto/cover" method="POST" enctype="multipart/form-data" >
                            <button type="button"  id='edit-cover-photo' class="btn bg_orange btn-xs" style="float: left;">upload</button>
                            <input type='file'  name="image" id='cover-photo-input' style="display: none;">
                        </form>
                    </div>

                <?php }?>
                <img id="cover_photo" draggable='false'>
            </div>
            <!-- 프로필 DIV -->
            <div id="profile_info" class="profile-grid">
                <div class="profile-grid-item" style="">
                    <div class="profile-top" style="">
<!--                        <div style=" position: absolute; top: 85px; right: 5px;">-->
<!--                            <img src="--><?php //echo URL ?><!--/icon/profile/WI_settings.svg">-->
<!--                        </div>-->
                        <div id="profile_photo" class="" style="width:50%">
                            <form id="upload-profile-form" action="<?php echo URL?>profile/uploadProfilePhoto/profile" method="POST" enctype="multipart/form-data" >
                                <div id="photo" class=""></div>
                                <?php if(Session::get("loggedIn") == true && Session::get("user_id") == Session::get("profile_id")){ ?>
                                    <div id="edit-profile-photo"><p>Edit</p></div>
                                    <input type='file' id='profile-photo-input' name="image" style="display: none;">
                                <?php } ?>
                            </form>
                        </div>
                        <div id="profile_text" class="" style="">
                            <div class="row">
                                <div id="username" style="" class=""></div>
                            </div>
<!--                            <div class="row">-->
<!--                                <!-- 해시테크 -->
<!--                                <div id="hash_tag" class="col-md-12 col-sm-12">-->
<!--                                    <p>#해시태그 #피아노 #바이올린</p>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="row">
                                <?php if(Session::get("loggedIn") == false || Session::get("user_id") != Session::get("profile_id")){ ?>
<!--                                <div id="follow_button" class="col-xs-6 col-sm-6 col-md-6 col-lg-6"></div>-->
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="display:none">
                                    <button>message</button>
                                </div>
                                <?php } else { ?>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display:none">
                                    <button>message</button>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <!-- like contants follow -->
                                <div  class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><span data-langNum="1204">스타 </span><span id="like_number"></span></div>
                                <div  class="col-xs-4 col-sm-4 col-md-4 col-lg-4" ><span data-langNum="1222">콘텐츠 </span><span id="contents_number"></span></div>
                                <div  class="col-xs-4 col-sm-4 col-md-4 col-lg-4" ><span data-langNum="1223">리믹싱 </span><span id="remixing_number"></span></div>
                                <!--<div id="follow_number" class="col-md-5 col-sm-5">follow(<font></font>)</div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 검은 색 바탕 투명도 50% -->
            <div class="usercover_bg"></div>
        </div>
        <nav style="max-width: 650px; margin: 0 auto;" class="navbar profile-grid">
            <ul id="nav" class="nav row">
                <!-- Home -->
                <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="float:none; display:inline-block">
                    <a id="home" onclick="$.pagehandler.loadContent('<?php echo URL.Session::get('profile_url')."/home"?>','contents');">
                        <!--<img src="<?php /*echo URL*/?>icon/profile/home.svg">-->
                        <span data-langNum="1224">Home</span>
<!--                        <div style="width: 25%;height: 15px;margin: 0 auto;">-->
<!--                            <div class="triangle"></div>-->
<!--                        </div>-->
                    </a>
                </li>
                <!-- About -->
<!--                <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">-->
                    <!-- <a id="about" onclick="$.pagehandler.loadContent('<?php /*echo URL.Session::get('profile_url')."/about" */?>','contents');">-->
<!--                        -->
<!--                        <font>About</font>-->
<!--                        <div style="width: 25%;height: 15px;margin: 0 auto;">-->
<!--                            <div class="triangle"></div>-->
<!--                        </div>-->
<!--                    </a>-->
<!--                </li>-->
                <!-- Box -->
<!--                <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">-->
<!--                     <a id="box" onclick="$.pagehandler.loadContent('<?php /*echo URL.Session::get('profile_url')."/box"?> */?>','contents');"> -->

<!--                        <font>Box</font>-->
<!--                        <div style="width: 25%;height: 15px;margin: 0 auto;">-->
<!--                            <div class="triangle"></div>-->
<!--                        </div>-->
<!--                    </a>-->
<!--                </li>-->
                <!-- Follow -->
<!--                <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">-->
                <!--                     <a id="box" onclick="$.pagehandler.loadContent('<?php /*echo URL.Session::get('profile_url')."/follow"?> */?>','contents');"> -->

                <!--                        <font>Follow</font>-->
<!--                        <div style="width: 25%;height: 15px;margin: 0 auto;">-->
<!--                            <div class="triangle"></div>-->
<!--                        </div>-->
<!--                    </a>-->
<!--                </li>-->
            </ul>
        </nav>
        <!-- 삼각형 -->