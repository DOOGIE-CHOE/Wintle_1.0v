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

        #play-info-all{
            position:absolute;
            height:10px;
            width:50%;
            margin:auto;
            top:0;
            left:0;
            right:0;
            bottom:0;
        }

        #play-info{
            position:relative;
            height:10px;
            width:80%;
            margin:auto;
            top:0;
            left:0;
            right:0;
            bottom:0;
        }

        #play-bar{
            position:relative;
            margin:auto;
            top:4px;
            height:2px;
            width:100%;
            background: whitesmoke;
        }

        #play-bar-button{
            position:absolute;
            top:0;
            width: 10px;
            height: 10px;
            background: black;
            -moz-border-radius: 50px;
            -webkit-border-radius: 50px;
            border-radius: 50px;
        }

        #played{
            position:relative;
            height:100%;
            width:0;
            background-color: blue;
        }

    </style>
    <script>


        var audio = document.createElement('audio');

        $(function(){
            audio.setAttribute('src', "audio/1.mp3");
            $("#play-bar-button").draggable({
                axis : "x",
                containment:"parent",
                drag: function() {
                    $("#played").css("width",(parseInt($("#play-bar-button").css("left")) + 5)+"px");
                }
            });
        });

        function musicPlay(){
            console.log(audio.currentTime);
            if(isPlaying(audio)){
                audio.pause();
                $("#play").attr("src","img/play.png");

            }else{
                audio.play();
                $("#play").attr("src","img/pause.png");
            }
        }

        $("#play-bar-button").change(function(){
            alert(1);

        });

        function isPlaying(audelem) { return !audelem.paused; }
    </script>
</head>



<div id="mini-music-player"><!--
    <audio id="test">
        <source src="audio/1.mp3" type="audio/mpeg">
    </audio>-->
    <div id="control-buttons">
        <input type="image" src="img/backwards.png" onclick="musicForwards()">
        <input id="play" type="image" src="img/play.png" onclick="musicPlay()">
        <input type="image" src="img/forwards.png" onclick="musicBackwards()">
    </div>

    <div id="play-info-all">
        <div id="played-time">0:00</div>
        <div id="play-info">
            <div id="play-bar">
                <div id="played"></div>
            </div>
            <div id="play-bar-button"></div>
        </div>
    </div>

</div>