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
            height:40px;
            width:100%;
            bottom:0;
            background-color: #222222;
            z-index:1060;
        }

        audio{
            display:none;
        }

        #control-buttons{
            display: inline-block;
            position:relative;
            bottom:2px;
            left:100px;
            height:100%;
            width:150px;
        }

        #control-buttons input{
            display: inline-block;
            margin:3px 10px 6px 10px;
            height:23px;
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
            display: inline-block;
            position:relative;
            left:130px;
            bottom:13px;
            height:10px;
            width:950px;
        }
        #play-info{
            display:inline-block;
            position:relative;
            height:9px;
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
            width: 9px;
            height: 9px;
            background: black;
            border: 2px solid #ff8243;
            -moz-border-radius: 50px;
            -webkit-border-radius: 50px;
            border-radius: 50px;
        }

        #played{
            position:relative;
            height:100%;
            width:0;
            background-color: #ff8243;
        }

        #played-time, #duration-time{
            display:inline-block;
            margin:0 10px 0 10px;
            font-size:0.9rem;
            color:white;
        }

        #album-mini{
            position:relative;
            display:inline-block;
            height:38px;
            width:38px;
            left:115px;
            background-image:url('<?php echo URL?>i/1.jpg');
            background-repeat: no-repeat;
            background-size:cover;
        }

        #play-options{
            display:inline-block;
            position:relative;
            float:right;
            right:50px;
            height:100%;
            width:200px;
        }
        #play-options img{
            display:inline-block;
            position: relative;
            height:28px;
            margin:5px;
        }

    </style>
    <script>

        var audio = document.createElement('audio');
        var duration;
        var progressrate;
        var PLAYBARWIDTH = 800; //800px + error range
        var playinterval;
        var barbutton;
        var currentMousePos = { x: -1, y: -1 };

        $(function(){
            audio.setAttribute('src', "<?php echo URL?>audio/6.mp3");
            //Event Listener will be executed when the audio loads
            audio.addEventListener("loadeddata", function() {
                duration = audio.duration;
                barbutton = $("#play-bar-button");
                displayTime(document.getElementById("duration-time"),duration);
                //calculate px that will progress per sec
                progressrate = Math.round((PLAYBARWIDTH / (duration*10)) * 1000) / 1000;
            });


            $("#play-bar-button").draggable({
                axis : "x",
                containment:"parent",
                drag: function() {
                    setPlaybutton();
                }
            });

            function setPlaybutton(){
                var left = parseInt(barbutton.css("left"));
                setPlayedBarAndButton(left);
                var currentTime = left / (progressrate * 10);
                audio.currentTime = parseInt(currentTime);
                displayTime(document.getElementById("played-time"), currentTime);
                displayTime(document.getElementById("duration-time"), duration - currentTime);
            }

            // Set the range of mousedown
            // prevent clicking out of the play bar
            $("#play-info").mousedown(function(event){
                event.type = "mousedown.draggable"; //set event type
                currentMousePos.x = event.pageX;

                var offset = $("#play-bar").offset();

                if(currentMousePos.x <= offset.left - 1){
                    currentMousePos.x -= offset.left + 2;
                }else{
                    currentMousePos.x -= offset.left + 4;
                }
                if(currentMousePos.x >= -1 && currentMousePos.x <= 801){
                    //console.log(currentMousePos.x);
                    $("#play-bar-button").css("left",currentMousePos.x).trigger(event); //execute drag event
                    setPlaybutton();
                }
            })
        });

        function displayTime(target, second){
            var min = ~~(second / 60); // shorthand of Math.float
            var sec = ~~(second % 60);
            if(sec < 10) target.innerHTML = min + ":0" + sec;
            else target.innerHTML = min + ":" + sec;
        }

        function musicPlay(){
            if(isPlaying(audio)){
                audio.pause();
                $("#play").attr("src","<?php echo URL?>img/play.png");
                clearInterval(playinterval);
            }else{
                audio.play();
                playinterval = setInterval(function(){  playBarButtonProgress();  },100);
                $("#play").attr("src","<?php echo URL?>img/pause.png");
            }
        }

        function isPlaying(audelem) { return !audelem.paused; }

        function playBarButtonProgress(){
            var left = parseFloat(barbutton.css("left"));
            left += progressrate;
            setPlayedBarAndButton();
            if(left >= (PLAYBARWIDTH - 2 )){
                audio.pause();
                audio.currentTime = 0;
                $("#play").attr("src","<?php echo URL?>img/play.png");
                //$("#play-bar-button").css("left","  0px");
                setPlayedBarAndButton(0);
                clearInterval(playinterval);
                displayTime(document.getElementById("played-time"), 0);
                displayTime(document.getElementById("duration-time"), duration);
                return;
            }
            displayTime(document.getElementById("played-time"), audio.currentTime);
            displayTime(document.getElementById("duration-time"), duration - audio.currentTime);
        }

        function setPlayedBarAndButton(left = null){
            var tmp;
            if(left == null){
                tmp = ~~ (audio.currentTime * 10);
                tmp =  tmp * progressrate;
            }else{
                tmp = left;
            }
            barbutton.css("left",tmp + "px");
            $("#played").css("width",tmp+5 + "px");
        }

    </script>
</head>



<div id="mini-music-player"><!--
    <audio id="test">
        <source src="audio/1.mp3" type="audio/mpeg">
    </audio>-->
    <div id="play-info-all">
        <div id="control-buttons">
            <input type="image"src="<?php echo URL?>img/backwards.png" onclick="musicForwards()">
            <input id="play" type="image" src="<?php echo URL?>img/play.png" onclick="musicPlay()">
            <input type="image" src="<?php echo URL?>img/forwards.png" onclick="musicBackwards()">
        </div>

        <div id="album-mini"></div>

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

        <div id="play-options">
            <img src="<?php echo URL?>img/repeat_one.png">
            <img src="<?php echo URL?>img/shuffle.png">
            <img src="<?php echo URL?>img/arrow-up.png">
        </div>
    </div>

</div>