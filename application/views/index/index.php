<div id="all">
    <head>

        <style>
            html body{
                overflow-x:hidden;
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
                width:75%;
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
                background-image: url("img/bg/bg1.jpg");
                background-size: cover;
            }

            #to-albumart{
                position:fixed;
                right:0;
                top:37px;
                height:100%;
                width:7%;
                background-color: rgba(189,189,189,0.7);
                z-index:1;
            }

            .line-arrow {
                position: absolute;
                overflow: hidden;
                display: inline-block;
                font-size: 10px; /*set the size for arrow*/
                width: 4em;
                height: 4em;
                top:45%;
            }

            .line-arrow.left {
                border-top: 3px solid black;
                border-left: 3px solid black;
                transform: rotate(-45deg) skew(0deg);
                margin-right:15px;
            }


            .line-arrow.right {
                border-top: 3px solid black;
                border-right: 3px solid black;
                transform: rotate(54deg) skew(20deg);
                right: 50px;
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
        </style>

        <script>

            $(function(){
                $(".cell").mouseover(function(){
                    if( $(this).find("#test-button").length == 0){
                        $(this).html("<img id='test-button' src='img/play_grey.png'>");
                        $(this).find("#test-button").fadeIn(300);
                    }
                }).mouseleave(function(){
                    if( $(this).find("#test-button").length > 0) {
                        $(this).find("#test-button").fadeOut(200);
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

    <div class="main-board">
        <div class="user-board">

            <div class="sb userinfo">
                <div class="label" style="background-color: #6d95e0"></div>
                <?php
                if(Session::get("loggedIn") != true){
                    echo "Please Log In";
                }else{
                    ?>
                    <script>
                        $.get("index/getProfilePhoto", function(o){
                            var value = jQuery.parseJSON(o);
                            var photo = $("#profilephoto");
                            if(value.profile_photo_path == null){
                                if(photo.find("img").length == 0)
                                    photo.append("<img src = 'profileimages/default.png' style='height:90px;'>");
                            }else{
                                //display image as a circular image
                                if(photo.find("img").length == 0)
                                    photo.append("<img src = '"+value.profile_photo_path+"' style='width: 90px; height: 90px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;'>");
                            }
                        });
                    </script>
                <?php } ?>

                <div id="profilephoto" onclick="$.pagehandler.loadContent('mypage');"></div>
                <div id="shortcut">
                    <div id="shortcut-username">
                        <?php echo "<div id='username'>".Session::get('user_name')."</div>"?>
                        <img id="setting" src="img/setting.svg">
                    </div>
                    <div id="shortcut-info">
                        <div id="shortcut-info-icon">
                            <img src="img/like.svg">
                            <img src="img/social.svg">
                            <img src="img/file.svg">
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
        </div>
        <div class="music-board"></div>
    </div>
    <div id="to-albumart">
        <!-- <?php /*echo "<a href='" .URL."albumartall'>";*/?><div class="line-arrow right"></div></a>-->
        <div class="line-arrow right" onclick="$.pagehandler.loadContent('http://localhost/albumartall');"></div>
    </div>
    <script type="text/javascript">
        var temp = "<div class='cell' style='width:{width}px; height: {height}px; background-image: url(i/{index}.jpg); background-size:cover; background-repeat:no-repeat; margin:0' onclick='a({index})'></div>";
        var w = 1, h = 1,html = '', limitItem = 47;
        var cellinfo = [];
        for (var i = 1; i < limitItem; i++) {
            //w = 200 +  200 * Math.random() << 0;
            h = w = (Math.floor(Math.random() * 2) + 1) * 140;
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