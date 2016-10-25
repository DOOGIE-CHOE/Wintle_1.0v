<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/11/2016
 * Time: 4:29 PM
 */

if(Session::isSessionSet("profile_id")){
    $id = Session::get("profile_id");
}
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
                background-repeat: no-repeat;
                -webkit-background-size:;
                background-size:cover;
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

            #profilephoto #photo{
                width: 187px;
                height: 187px;
                border-radius: 50%;
                background-repeat: no-repeat;
                background-position: center center;
                background-size: auto;
            }

            #username, #user-hashtag{
                position:relative;
                height:100px;
                width:972px;
                z-index:20;
                float:right;
            }
            #username #user-name{
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

            #contents{
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
            #edit-profile-photo {
                position: absolute;
                display:none;
                bottom:0;
                height: 60px;
                width: 187px;
                overflow: hidden;
            }
            #edit-profile-photo:before {
                content: '';
                position: absolute;
                height: 187px;
                width: 187px;
                border-radius: 50%;
                bottom: 0;
                background: rgba(0,0,0,0.5);
            }

            #edit-profile-photo p{
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
            $.get("<?php echo URL?>common/getUsernameByEmail/<?php echo $id?>", function(o){
                var value = jQuery.parseJSON(o);
                if(value == null){
                    //display default image
                }else{
                    $("#username").append("<div id='user-name'>"+value+"</div>");
                }
            });
            $.get("<?php echo URL?>common/getProfilePhoto/cover/<?php echo $id?>", function(o){
                var value = jQuery.parseJSON(o);
                var photo = $("#cover-photo");
                if(value.cover_photo_path == null){
                    //display default image
                }else{
                    // photo.append("<img src = '"+value.profile_photo_path+"' style='width: 187px; height: 187px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;'>");
                    photo.css('background-image', 'url(<?php echo URL?>' + value.cover_photo_path + ')');
                }
            });
            $.get("<?php echo URL?>common/getProfilePhoto/profile/<?php echo $id?>",function(o){
                var value = jQuery.parseJSON(o);
                var photo = $("#profilephoto");
                if (value.profile_photo_path != null) {
                    //display default image
                    // photo.append("<img src = '"+value.profile_photo_path+"' style='width: 187px; height: 187px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;'>");
                    $("#photo").css("background-image", 'url(<?php echo URL?>' + value.profile_photo_path + ')').css("background-size","cover");
                }
            });

            $(function(){

                $("#profilephoto").mouseover(function(){
                    $("#edit-profile-photo").fadeIn(200);
                }).mouseleave(function(){
                    $("#edit-profile-photo").fadeOut(0);
                });

                $("#cover-photo").mouseover(function(){
                    $("#cover-photo p").fadeIn(200);
                }).mouseleave(function(){
                    $("#cover-photo p").fadeOut(0);
                });


                $("#edit-profile-photo").click(function(){
                    $("#profile-photo-input").trigger("click");
                });

                $("#edit-cover-photo").click(function(){
                    $("#cover-photo-input").trigger("click");
                });

                $('#profile-photo-input').on('change',function(){
                    $('#upload-profile-form').ajaxForm({
                        success:function(e) {
                            var data = $.parseJSON(e);
                            if(data[0] == false){
                                errorDisplay(data[1]);
                                return false;
                            }else{
                                $.pagehandler.loadContent('<?php echo URL?>profile',"all");
                            }
                        }
                    }).submit();
                });

                $("#cover-photo-input").on('change',function(){
                    $('#upload-cover-form').ajaxForm({
                        success:function(e) {
                            var data = $.parseJSON(e);
                            if(data[0] == false){
                                errorDisplay(data[1]);
                                return false;
                            }else{
                                $.pagehandler.loadContent('<?php echo URL?>profile',"all");
                            }
                        }
                    }).submit();
                });

                $("#HashTags").tagit({
                    //evert for after putting tags
                    afterTagAdded: function(evt, ui) {
                        var tags = $("#HashTags").tagit("assignedTags");
                        //check whether the first charactor is #
                        if(tags[tags.length-1].charAt(0) != '#'){

                            //put # charactor at first then replace it with without-sharp tag
                            var tagswithsharp = '#'+tags[tags.length-1];
                            $("#HashTags").tagit("removeTagByLabel",tags[tags.length-1]);
                            $("#HashTags").tagit("createTag",tagswithsharp);
                        }
                    }
                });

            });


        </script>

    </head>

    <body id="body">
    <div class="main-board">
        <div class="user-board">
            <script>
            </script>
            <div id="user-info">
                <form id="upload-profile-form" action="<?php echo URL?>profile/uploadProfilePhoto/profile" method="POST" enctype="multipart/form-data" >
                    <div id="profile">
                        <div id="profilephoto">
                            <?php if(Session::get("loggedIn") == true && Session::get("user_email") == Session::get("profile_id")){ ?>
                                <div id='edit-profile-photo'><p>EDIT</p></div>
                                <input type='file' id='profile-photo-input' name="image" style="display: none;">
                            <?php }?>
                            <div id='photo' style='background-color:#222222;'>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="username">
                </div>
                <div id="user-hashtag"><div id="hashtag"><input name="HashTags" id="HashTags" required placeholder="Add hashtags"></div></div>
            </div>
            <form id="upload-cover-form" action="<?php echo URL?>profile/uploadProfilePhoto/cover" method="POST" enctype="multipart/form-data" >
                <div id="cover-photo">
                    <?php if(Session::get("loggedIn") == true && Session::get("user_email") == Session::get("profile_id")){ ?>
                        <div id="edit-cover-photo"><p>EDIT</p></div>
                        <input type='file' id='cover-photo-input' name="image" style="display: none;">
                    <?php }?>
                </div>
            </form>

            <div id="contents-set">
                <div id="category">
                    <div style="margin-left:50px;">Home</div>
                    <div  onclick="$.pagehandler.loadContent('<?php echo URL?>profile/projects','contents');" >PlayLists</div>
                    <div>Projects</div>
                    <div>Friends</div>
                    <div>Following</div>
                    <div>Followers</div>
                    <div>Incomes</div>
                </div>
                <div id="contents">

                </div>
            </div>

        </div>
    </div>


    </body>



</div>


