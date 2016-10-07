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

        #control-buttons{
            position:relative;
            top:5px;
            left:70px;
        }

        #control-buttons input{
            display: inline-block;
            margin-left:10px;
            height:40px;
        }

        #play-info-all{
            position:relative;
            height:50px;
            width: 1500px;
            margin:auto;
            top:0;
            left:0;
            right:0;
            bottom:0;
        }

        #play-info-time{
            position:absolute;
            margin:auto;
            top:0;
            left:0;
            right:0;
            bottom:0;
            height:10px;
            width:1000px;
        }
        #play-info{
            display:inline-block;
            position:relative;
            height:10px;
            width:800px;
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

        #played-time, #duration-time{
            display:inline-block;
            margin:0 10px 0 10px;
        }

    </style>
    <script>


        var audio = document.createElement('audio');

        $(function(){
            audio.setAttribute('src', "audio/3.mp3");


            audio.addEventListener("loadeddata", function() {
                var duration = Math.floor(audio.duration);
                var min = ~~(duration/60); // ~~ is shorthand of Math.Floor
                var sec = duration%60;
                var durationdisplay = document.getElementById("duration-time");
                durationdisplay.innerHTML = min + ":" + sec;
            });

            $("#play-bar-button").draggable({
                axis : "x",
                containment:"parent",
                drag: function() {
                    $("#played").css("width",(parseInt($("#play-bar-button").css("left")) + 5)+"px");
                }
            });
         //   console.log(toFixed(audio.duration,2));
           // $("#duration-time").innerHTML=toFixed(audio.duration,2);


        });

        function musicPlay(){
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
/*

        function toFixed(value, precision) {
            var precision = precision || 0,
                power = Math.pow(10, precision),
                absValue = Math.abs(Math.round(value * power)),
                result = (value < 0 ? '-' : '') + String(Math.floor(absValue / power));

            if (precision > 0) {
                var fraction = String(absValue % power),
                    padding = new Array(Math.max(precision - fraction.length, 0) + 1).join('0');
                result += '.' + padding + fraction;
            }
            return result;
        }
*/

    </script>
</head>



<div id="mini-music-player"><!--
    <audio id="test">
        <source src="audio/1.mp3" type="audio/mpeg">
    </audio>-->
    <div id="play-info-all">
        <div id="control-buttons">
            <input type="image" src="img/backwards.png" onclick="musicForwards()">
            <input id="play" type="image" src="img/play.png" onclick="musicPlay()">
            <input type="image" src="img/forwards.png" onclick="musicBackwards()">
        </div>

        <div id="play-info-time">
            <div id="played-time">0:00</div>
            <div id="play-info">
                <div id="play-bar">
                    <div id="played"></div>
                </div>
                <div id="play-bar-button"></div>
            </div>
            <div id="duration-time">0:00</div>
        </div>
    </div>

</div>