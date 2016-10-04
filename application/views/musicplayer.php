<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/3/2016
 * Time: 4:11 PM
 */

?>
<head>
    <style>

        #mini-music-player{
            position:fixed;
            height:50px;
            width:100%;
            bottom:0;
            background-color: #1FB5BF;
            z-index:10;
        }

        audio{
            display:none;
        }

        #control-buttons input{
            position:relative;
            margin-left:10px;
            height:40px;
            left:15%;
            top:5px;
        }
    </style>
    <script>

        function musicPlay(){
            var audio = document.createElement('audio');
            audio.setAttribute('src', "audio/1.mp3");
            audio.load();
            audio.play();
        }

    </script>
</head>



<div id="mini-music-player"><!--
    <audio id="test">
        <source src="audio/1.mp3" type="audio/mpeg">
    </audio>-->
    <div id="control-buttons">
        <input type="image" src="img/backwards.png" onclick="musicForwards()">
        <input type="image" src="img/play.png" onclick="musicPlay()">
        <input type="image" src="img/forwards.png" onclick="musicBackwards()">
    </div>
</div>