<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 11/30/2016
 * Time: 7:43 PM
 */
?>


<div id="all">
    <head>

        <style>
            html body{
                overflow-x:hidden;
                color:black;
            }

            .main-board{
                height:1000px;
                width:1222px;
                background-color: ghostwhite;
                margin:auto;
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

            #bg{
                position:fixed;
                height:100%;
                width:100%;
                background-repeat: no-repeat;
                background-image: url("<?php echo URL?>img/bg/bg1.png");
                background-size: cover;
            }

            #shortcut-info-icon img{
                position:relative;
                display: inline-block;
                margin:13px 26px 11px 9px;
                height:19px;
            }

            #shortcut-info-number div{
                position:absolute;
            }

        </style>

        <script>
            $(function(){
                $("#username").blur(function(){

                });
            });


        </script>

    </head>
    <body>
    <div id="bg"></div>

    <div class="main-board">
        <div class="music-board">
            <br><br><br>
            <input type="text" id="username">
            <input type="button" id="find" value="find"> <br><br><br><br>
            <input type="text" id="msg" name="msg">
            <input type="button" id="bt" value="send">

        </div>
    </div>
    </body>

</div>



