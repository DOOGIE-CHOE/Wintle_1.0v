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

            .main-board .list-board{
                display:inline-block;
                position:relative;
                height:100%;
                width: 300px;
                background-color: rgba(0,0,0,0.3);
            }

            .main-board .user-board{
                display:inline-block;
                position:relative;
                float:right;
                height:100%;
                width:922px;
                background-color: #2b2e31;
            }

            #body{
                margin-top:37px;
            }

            #cover-photo{
                position:relative;
                width:100%;
                height:210px;
            }
            #user-info{
                position:relative;
                background: dimgrey;
                width:100%;
                height:100%;
            }

            #profilephoto{
                position:absolute;
                z-index: 10;
                top:117px;
                left:60px;
            }
        </style>

    </head>

    <?echo "this is my page"?>
    <body id="body">
    <div class="main-board">
        <div class="list-board">
        </div>
        <div class="user-board">
            <?php
            if(Session::get("loggedIn") != true){
                echo "Please Log In";
            }else{
                ?>
                <script>
                    $.get("index/getProfilePhoto", function(o){
                        var value = jQuery.parseJSON(o);
                        if(value.profile_photo_path == null){
                            $("#profilephoto").append("<img src = 'profileimages/default.png' style='height:187px;'>");
                        }else{
                            $("#profilephoto").append("<img src = '"+value.profile_photo_path+"' style='height:187px;'>");
                        }
                    });
                </script>
            <?php } ?>
            <div id="profilephoto"></div>
            <div id="cover-photo">
                <?php echo "<div id='username'>".Session::get('user_name')."</div>"?>
            </div>
            <div id="user-info"></div>
        </div>
    </div>
    </body>



</div>


