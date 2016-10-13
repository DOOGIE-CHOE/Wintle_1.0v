<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/11/2016
 * Time: 4:29 PM
 */

?>

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
                float:right;
                height:100%;
                width:1222px;
                background-color: #2b2e31;
            }

            #body{
                margin-top:37px;
            }

            #cover-photo{
                position:relative;
                width:100%;
                height:210px;
                background: black;
            }

            #cover-photo p{
                position:absolute;
                display: none;
                right:15px;
                top:15px;
                font-size:20px;
                z-index:11;
                font-weight:bold;
                cursor:pointer;
                /*disable cursor dragging*/
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            #user-info{
                position:absolute;
                height:200px;
                width:100%;
                top:117px;
                z-index: 10;
            }
            #profile{
                position:absolute;
                height:200px;
                width:250px;
            }

            #profilephoto{
                position:relative;
                z-index: 10;
                top:5px;
                left:50px;
            }

            #username, #user-hashtag{
                position:relative;
                height:100px;
                width:972px;
                z-index:20;
                float:right;
            }
            #username #name{
                position:absolute;
                font-size: 50px;
                bottom:10px;
                left:10px;
            }

            #user-hashtag #hashtag{
                position:absolute;
                top:10px;
                left:10px;
                font-size: 30px;
            }

            #contents-set{
                position:relative;
                top:170px;
                width:100%;
                height:auto;
            }

            #category{
                position:relative;
                width:100%;
                height:50px;
            }
            #category div{
                position: relative;
                display: inline-block;
                font-size: 20px;
                margin:15px;
            }

            #content{
                position:relative;
                width:100%;
                height:1000px;
                background-color: whitesmoke;
            }
            /*
                        #edit-profile{
                            position:absolute;
                            bottom:0;
                            height:50px;
                            width:187px;
                            background: black;
                            z-index: 11;
                        }*/
            #edit-profile {
                position: absolute;
                display:none;
                bottom:0;
                height: 60px;
                width: 187px;
                overflow: hidden;
            }
            #edit-profile:before {
                content: '';
                position: absolute;
                height: 187px;
                width: 187px;
                border-radius: 50%;
                bottom: 0;
                background: rgba(0,0,0,0.5);
            }

            #edit-profile p{
                position:relative;
                text-align : center;
                vertical-align:middle;
                line-height:50px;
                font-size: 23px;
                font-weight: bold;
                cursor:pointer;
                z-index: 20;

                /*disable cursor dragging*/
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

        </style>
        <script>
            $(function(){
                $("#profilephoto").mouseover(function(){
                    $("#edit-profile").fadeIn(200);
                }).mouseleave(function(){
                    $("#edit-profile").fadeOut(0);
                });

                $("#cover-photo").mouseover(function(){
                    $("#cover-photo p").fadeIn(200);
                }).mouseleave(function(){
                    $("#cover-photo p").fadeOut(0);
                });


                $("#edit-profile").click(function(){
                    $("#image-input").trigger("click");
                });

                $('#image-input').on('change',function(){
                    $('#upload-profile-form').ajaxForm({
                        success:function(e) {
                            var data = $.parseJSON(e);
                            if(data[0] == false){
                                errorDisplay(data[1]);
                                return false;
                            }else{
                                $.pagehandler.loadContent('mypage');
                            }
                        }
                    }).submit();
                });


            });
        </script>

    </head>

    <body id="body">
    <div class="main-board">
        <div class="user-board">
            <?php
            if(Session::get("loggedIn") != true){
                echo "Please Log In";
            }else{
                ?>
                <script>
                    $.get("common/getProfilePhoto", function(o){
                        var value = jQuery.parseJSON(o);
                        var photo = $("#profilephoto");
                        if(value.profile_photo_path == null){
                            //display default image
                            if(photo.find("img").length == 0)
                                photo.append("<img src = 'profileimages/default.png'>");
                        }else{
                            //display image as a circular image
                            if(photo.find("img").length == 0)
                            // photo.append("<img src = '"+value.profile_photo_path+"' style='width: 187px; height: 187px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;'>");
                                photo.append("<div style='background-image: url("+value.profile_photo_path+");width: 187px; height: 187px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;'><div>");
                        }
                    });
                </script>
            <?php } ?>
            <div id="user-info">
                <form id="upload-profile-form" action="common/uploadProfilePhoto" method="POST" enctype="multipart/form-data" >
                    <div id="profile">
                        <div id="profilephoto">
                            <div id='edit-profile'><p>EDIT</p></div>
                            <input type='file' id='image-input' name="image" style="display: none;">
                        </div>
                    </div>
                </form>
                <div id="username"><?php echo "<div id='name'>".Session::get('user_name')."</div>"?></div>
                <div id="user-hashtag"><div id="hashtag">#test, #test2, #test3</div></div>
            </div>

            <div id="cover-photo">
                <p>EDIT</p>
            </div>

            <div id="contents-set">
                <div id="category">
                    <div style="margin-left:50px;">Home</div>
                    <div>PlayLists</div>
                    <div>Projects</div>
                    <div>Friends</div>
                    <div>Following</div>
                    <div>Followers</div>
                    <div>Incomes</div>
                </div>
                <div id="content">

                </div>
            </div>

        </div>
    </div>


    </body>



</div>


