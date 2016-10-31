<?php

$id = Session::get("user_email");
?>
<div id="all">
    <head>

        <style>
            html body{
                overflow-x:hidden;
            }
            .tap{
                position:relative;
                height:100%;
                background: black;
            }

            #list{
                position:relative;
                left:270px;
                width:1222px;
            }
            #list p{
                display:inline-block;
                font-size:24px;
                margin:20px;
            }
            #sort{
                display: inline-block;
                position:absolute;
                right:20px;
            }

            #sort p{
                display:inline-block;
                font-size:15px;
                margin:20px;
            }
            .main-board{
                height:100%;
                width:1222px;
                background-color: ghostwhite;
                margin:auto;
            }

            .main-board .user-board{
                display:inline-block;
                position:relative;
                height:100%;
                width: 300px;
                background-color: rgba(0,0,0,0.3);
            }

            .main-board .music-board{
                display:inline-block;
                position:relative;
                float:right;
                height:100%;
                /*  width:75%;*/
                width:100%;
                background-color: #2b2e31;
            }

            .sb{
                position:relative;
                background-color: #222222;
                width:100%;
                height:90px;
                margin-top:22px;
                margin-bottom:22px;
            }

            .sub{
                background-color: #444444;
                width:95%;
                float:right;
                margin:0 0 15px 0;
            }

            .label{
                display: inline-block;
                position:relative;
                float:left;
                background-color: rgb(65,126,141);
                width:15px;
                height:100%;
            }

            #body{
                margin-top : 37px;
            }
            #bg{
                position:fixed;
                height:100%;
                width:100%;
                background-repeat: no-repeat;
                background-image: url("<?php echo URL?>img/bg/bg1.jpg");
                background-size: cover;
            }

            #label-info{
                margin-left:20px;
                color: rgb(65,126,141);
            }
            #shortcut{
                display: inline-block;
                position:absolute;
                height:100%;
                width:65%;
                right:0;
            }

            #shortcut-username{
                position:relative;
                height:50%;
                width:100%;
            }

            #username{
                position:absolute;
                margin:auto;
                font-size: 22px;
                left:7px;
                top:15px;
            }

            #shortcut-info{
                position:relative;
                height:50%;
                width:100%;
            }

            #shortcut-info-icon{
                position:absolute;
                height:100%;
                width:100%;
            }
            #shortcut-info-icon img{
                position:relative;
                display: inline-block;
                margin:13px 26px 11px 9px;
                height:19px;
            }

            #shortcut-info-number{
                position:absolute;
                height:100%;
                width:100%;
            }
            #shortcut-info-number div{
                position:absolute;
            }

            #number-likes{
                margin:16px 15px 15px 37px;
            }
            #number-followers{
                margin:16px 15px 15px 97px;
            }
            #number-projects{
                margin:16px 15px 15px 157px;
            }

            #profilephoto{
                display: inline-block;
                margin-left: 3px;
            }

            #setting{
                position:relative;
                top:5px;
                right:5px;
                height:20px;
                float:right;
            }


            #test-button{
                display:none;
                position:absolute;
                left:0;
                right:0;
                top:0;
                bottom:0;
                margin:auto;
                height:50%;
                width:50%;
            }
            #test-button:hover{
                display: block;
            }

            #albummenu{
                display:none;
                position:absolute;
                width:70px;
                height:100%;
                background-color: black;
                opacity:1;
                right:-70px;
                z-index:10;
            }

        </style>

        <script>

            $(function(){
                /*$(".cell").mouseover(function(){
                 if( $(this).find("#test-button").length == 0){
                 $(this).html("<img id='test-button' src='img/play_grey.png'>");
                 $(this).find("#test-button").fadeIn(300);
                 }
                 }).mouseleave(function(){
                 if( $(this).find("#test-button").length > 0) {
                 $(this).find("#test-button").fadeOut(200);
                 $(this).html("");
                 }
                 });*/

                $(".cell").mouseover(function(){
                    if( $(this).find("#albummenu").length == 0) {
                        $(this).html("<div id='albummenu'><div>");
                        $(this).find("#albummenu").show("slide", {direction: "left"}, 200);
                    }
                }).mouseleave(function(){
                    if( $(this).find("#albummenu").length > 0) {
                        $(this).find("#albummenu").hide("slide", {direction: "right"}, 200);
                        $(this).html("");
                    }
                });
            });


        </script>
    </head>
    <body id="body">
    <!--<iframe style="position:absolute" width="100%" height="100%" src="https://www.youtube.com/embed/hG2ekffXMhs?list=RDhG2ekffXMhs&showinfo=0&autoplay=1&loop=1&controls=0&disablekb=0" frameborder="0" allowfullscreen></iframe>
    -->
    <div id="bg"></div>
    <div class="tap">
        <div id="list">
            <p>Top Chart</p>
            <p>New</p>
            <p>Recommended</p>
            <div id="sort">
                <p>장르선택</p>
                <p>인기순</p>
                <p>최신순</p>
            </div>
        </div>

        <div class="main-board"><!--
        <div class="user-board">

            <div class="sb userinfo">
                <div class="label" style="background-color: #6d95e0"></div>
                <?php
            /*                if(Session::get("loggedIn") != true){
                                echo "Please Log In";
                            }else{
                                */?>
                    <script>
                        $.get("<?php /*echo URL*/?>common/getProfilePhoto/profile/<?php /*echo $id*/?>", function(o){
                            var value = jQuery.parseJSON(o);
                            var photo = $("#profilephoto");
                            if(value.profile_photo_path == null){
                                //display default image
                                if(photo.find("#photo").length == 0)
                                //    photo.append("<img style='width: 220px; height: 220px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;' src = '<?php /*echo URL*/?>profileimages/default.png'>");
                                    photo.append("<div id='photo' style='background-image: url(<?php /*echo URL*/?>profileimages/default.png);width: 90px; height: 90px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: auto;'><div>");

                            }else{
                                //display image as a circular image
                                if(photo.find("#photo").length == 0)
                                // photo.append("<img src = '"+value.profile_photo_path+"' style='width: 187px; height: 187px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;'>");
                                    photo.append("<div id='photo' style='background-image: url(<?php /*echo URL*/?>"+value.profile_photo_path+");width: 90px; height: 90px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;'><div>");
                            }
                        });
                    </script>
                <?php /*} */?>

                <div id="profilephoto" onclick="$.pagehandler.loadContent('<?php /*echo URL.Session::get("my_profile")*/?>','all');"></div>
                <div id="shortcut">
                    <div id="shortcut-username">
                        <?php /*echo "<div id='username'>".Session::get('user_name')."</div>"*/?>
                        <img id="setting" src="<?php /*echo URL*/?>img/setting.svg">
                    </div>
                    <div id="shortcut-info">
                        <div id="shortcut-info-icon">
                            <img src="<?php /*echo URL*/?>img/like.svg">
                            <img src="<?php /*echo URL*/?>img/social.svg">
                            <img src="<?php /*echo URL*/?>img/file.svg">
                        </div>
                        <div id="shortcut-info-number">
                            <div id="number-likes">---</div>
                            <div id="number-followers">---</div>
                            <div id="number-projects">---</div>
                        </div>
                    </div>
                </div>
            </div>


            <h3 style="margin:0;">My Info</h3>
            <div class="sb sub follower">
                <div class="label"></div>
                <h4 id="label-info">Follower</h4>
            </div>

            <div class="sb sub playlist">
                <div class="label"></div>
                <h4 id="label-info">Playlist</h4>
            </div>

            <div class="sb sub library">
                <div class="label"></div>
                <h4 id="label-info">Library</h4>
            </div>

            <div class="sb sub myproject">
                <div class="label"></div>
                <h4 id="label-info">MyProject</h4>
            </div>
        </div>-->
            <div class="music-board"></div>
        </div>
    </div>
    <script type="text/javascript">
        var temp = "<div class='cell' style='width:{width}px; height: {height}px; background-image: url(<?php echo URL?>i/{index}.jpg); background-size:cover; background-repeat:no-repeat; margin:0' onclick='a({index})'></div>";
        var w = 1, h = 1,html = '', limitItem = 47;
        var cellinfo = [];
        for (var i = 1; i < limitItem; i++) {
            //w = 200 +  200 * Math.random() << 0;
            h = w = (Math.floor(Math.random() * 1) + 2) * 140;
            //html += temp.replace(/\{height\}/g, 200).replace(/\{width\}/g, w).replace("{index}", i + 1);
            html += temp.replace(/\{height\}/g, h).replace(/\{width\}/g, w).replace("{index}", i );
            //     cellinfo.push(temp.replace(/\{height\}/g, h).replace(/\{width\}/g, w).replace("{index}", i + 1));
        }
        $(".music-board").html(html);

        var wall = new Freewall(".music-board");
        wall.reset({
            selector: '.cell',
            animate: true,
            cellW: 140,
            cellH: 140,
            onResize: function() {
                wall.fitWidth();
            }
        });
        wall.fitWidth();
        // for scroll bar appear;
        $(window).trigger("resize");

        function a(id){
            errorDisplay(id.index);
        }
    </script>

    </body>

</div>