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

        #mini-music-player {
            position: fixed;
            height: 60px;
            width: 100%;
            bottom: 0;
            background-color: rgba(0,0,0,0.8);
            z-index: 1060;
        }

        audio {
            display: none;
        }

        #control-buttons {
            display: inline-block;
            position: relative;
            height: 100%;
            width: 138px;
        }

        #button-box {
            position: absolute;
            top: 50%;
            height: 32px;
            margin-top: -16px;
        }

        #control-buttons input {
            display: inline-block;
            margin: 3px 10px 6px 10px;
            height: 21px;
        }

        #play-info-all {
            position: relative;
            height: 60px;
            width: 1200px;
            margin: auto;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        #play-info-time {
            display: inline-block;
            position: relative;
            margin-left: 20px;
            height: 59px;
            width: 800px;
        }

        #creator-info {
            position: relative;
            height: 40px;
            width: 100%;
        }

        #creator-info #content-hash {
            position: absolute;
            height: 20px;
            width: 100%;
            color: white;
        }

        #creator-info #content-info {
            top: 20px;
            position: absolute;
            height: 20px;
            width: 100%;
        }

        #play-info {
            position: absolute;
            height: 9px;
            width: 800px;
            bottom: 9px;
        }

        #play-bar {
            position: relative;
            margin: auto;
            top: 4px;
            height: 2px;
            width: 100%;
            background: whitesmoke;
        }

        #play-bar-button {
            display:none;
            position: absolute;
            top: 0;
            width: 9px;
            height: 9px;
            background: black;
            border: 2px solid #EE3B24;
            -moz-border-radius: 50px;
            -webkit-border-radius: 50px;
            border-radius: 50px;
        }

        #played {
            position: relative;
            height: 100%;
            width: 0;
            background-color: #EE3B24;
        }

        #content-name {
            position: relative;
            display: inline-block;
            color: white;
            float: left;
            height: 100%;
            width: auto;
        }

        #playtime {
            position: relative;
            display: inline-block;
            float: right;
            height: 100%;
            width: auto;
        }

        #played-time, #duration-time {
            display: inline-block;
            margin: 0 10px 0 10px;
            font-size: 0.9rem;
            color:white;
        }

        #played-time{
            color: #EE3B24;
        }

        #album-mini {
            position: relative;
            display: inline-block;
            height: 60px;
            width: 60px;
            margin-left: 20px;
        }

        #album-photo {
            height: 60px;
            width: 60px;
            background-image: url('<?php echo URL?>img/vinyl.png');
            background-repeat: no-repeat;
            background-size: cover;
        }

        #play-options {
            display: inline-block;
            position: relative;
            margin-left: 20px;
            height: 100%;
            width: 122px;
        }

        #play-options #button-box {
            position: absolute;
            top: 50%;
            height: 38px;
            margin-top: -19px;
        }

        #play-options input {
            display: inline-block;
            position: relative;
            height: 24px;
            margin: 6px;
        }

    </style>
    <script>

        var audio = document.createElement('audio');
        var duration;
        var progressrate;
        var PLAYBARWIDTH = 800; //800px + error range
        var playinterval;
        var barbutton;
        var currentMousePos = {x: -1, y: -1};
        var audioElement = [];
        var longestAudio;
        var playFlag = false;

        $(function () {


            $("#play-bar-button").draggable({
                axis: "x",
                containment: "parent",
                drag: function () {
                    setPlaybutton();
                }
            });



            // Set the range of mousedown
            // prevent clicking out of the play bar
            $("#play-info").mousedown(function (event) {
                event.type = "mousedown.draggable"; //set event type
                currentMousePos.x = event.pageX;

                var offset = $("#play-bar").offset();

                if (currentMousePos.x <= offset.left - 1) {
                    currentMousePos.x -= offset.left + 2;
                } else {
                    currentMousePos.x -= offset.left + 4;
                }
                if (currentMousePos.x >= -1 && currentMousePos.x <= 801) {
                    //console.log(currentMousePos.x);
                    $("#play-bar-button").css("left", currentMousePos.x).trigger(event); //execute drag event
                    setPlaybutton();
                }
            });

            $("#play-info").mouseover(function(){
                $("#play-bar-button").css("display","block");
                setButtonPosition();
            }).mouseout(function(){
                $("#play-bar-button").css("display","none");
            });
        });

        function resetAllAudio(){
            for(var i =0; i< audioElement.length; i++){
                audioElement[i].pause();
            }
            clearInterval(playinterval);
            audioElement = [];
            longestAudio = null;
        }

        function playAudioFiles(component, content_name, hashs, event = null){
            loadAudio(component, event);
            setPlaybarInfos(content_name,hashs);
        }

        function setPlaybarInfos(content_name, hashs, album_photo = null){
            document.getElementById("content-hash").innerHTML = hashs;
            document.getElementById("content-name").innerHTML = content_name;
        }

        function loadAudio(component, event = null){
            resetAllAudio();
            var count = 0;
            var maxDuraion = 0;
            console.log(component);
            for(var i = 0; i< component.length; i++){
                var audio = document.createElement('audio');
                audio.setAttribute('src', component[i]);
                audio.load();
                audio.onloadeddata = function(){
                    if(this.duration > maxDuraion){
                        maxDuraion = this.duration;
                        longestAudio = this;
                    }
                    audioElement.push(this);
                    count++;
                    if(count >= component.length){
                        preSetAudio(maxDuraion);

                        if(event == null){
                            musicPlay();
                        }else{
                            document.dispatchEvent(readyAudioEvent);
                        }
                    }
                };
            }
        }

        function preSetAudio(duration){
            barbutton = $("#play-bar-button");
            displayTime(document.getElementById("duration-time"), duration);
            //calculate px that will progress per sec
            progressrate = Math.round((PLAYBARWIDTH / (duration * 10)) * 1000) / 1000;
            //Trigger playing music event******************
            //musicPlay();
        }

        function setPlaybutton() {
            var left = parseInt(barbutton.css("left"));
            setPlayedBarAndButton(left);
            var currentTime = left / (progressrate * 10);
            for(var i =0; i< audioElement.length; i++){
                audioElement[i].currentTime = parseInt(currentTime);
                if(!isPlaying(audioElement[i])) {
                    if(playFlag){
                        if(audioElement[i].duration > audioElement[i].currentTime){
                            audioElement[i].play();
                        }
                    }
                }
            }
            displayTime(document.getElementById("played-time"), currentTime);
        }

        function displayTime(target, second) {
            var min = ~~(second / 60);
            var sec = ~~(second % 60);
            if (sec < 10) target.innerHTML = min + ":0" + sec;
            else target.innerHTML = min + ":" + sec;
        }

        function musicPlay() {
            if (isPlaying(longestAudio)) {
                playFlag = false;
                for(var i =0; i< audioElement.length; i++){
                    audioElement[i].pause();
                }
                $("#play").attr("src", "<?php echo URL?>img/play.png");
                clearInterval(playinterval);
            } else {
                playFlag = true;
                for(var i =0; i< audioElement.length; i++){
                    audioElement[i].play();
                }
                playinterval = setInterval(function () {
                    playBarButtonProgress();
                }, 100);
                $("#play").attr("src", "<?php echo URL?>img/pause.png");
            }
        }

        function isPlaying(audelem) {
            return !audelem.paused;
        }

        function playBarButtonProgress() {
            var left = parseFloat(barbutton.css("left"));
            left += progressrate;
            setPlayedBarAndButton();
            if (left >= (PLAYBARWIDTH - 2 )) {
                for(var i =0; i< audioElement.length; i++){
                    audioElement[i].pause();
                    audioElement[i].currentTime = 0;
                }
                $("#play").attr("src", "<?php echo URL?>img/play.png");
                //$("#play-bar-button").css("left","  0px");
                setPlayedBarAndButton(0);
                clearInterval(playinterval);
                displayTime(document.getElementById("played-time"), 0);
                return;
            }
            displayTime(document.getElementById("played-time"), longestAudio.currentTime);
        }

        function setPlayedBarAndButton(left = null) {
            var tmp;
            if (left == null) {
                tmp = ~~(longestAudio.currentTime * 10);
                tmp = tmp * progressrate;
            } else {
                tmp = left;
            }
            barbutton.css("left", tmp + "px");
            $("#played").css("width", tmp + 5 + "px");
        }

        function setButtonPosition(left = null){
            var tmp;
            if (left == null) {
                tmp = ~~(longestAudio.currentTime * 10);
                tmp = tmp * progressrate;
            } else {
                tmp = left;
            }
            barbutton.css("left", tmp + "px");
        }

    </script>
</head>


<div id="mini-music-player"><!--
    <audio id="test">
        <source src="audio/1.mp3" type="audio/mpeg">
    </audio>-->
    <div id="play-info-all">
        <div id="control-buttons">
            <div id="button-box">
                <input type="image" src="<?php echo URL ?>img/backwards.png" onclick="musicForwards()">
                <input id="play" type="image" src="<?php echo URL ?>img/play.png" onclick="musicPlay()">
                <input type="image" src="<?php echo URL ?>img/forwards.png" onclick="musicBackwards()">
            </div>
        </div>


        <div id="album-mini">
            <div id="album-photo"></div>
        </div>

        <div id="play-info-time">
            <div id="creator-info">
                <div id="content-hash"></div>
                <div id="content-info">
                    <div id="content-name">
                    </div>
                    <div id="playtime">
                        <div id="played-time">0:00</div>
                        <div id="duration-time">0:00</div>
                    </div>
                </div>
            </div>
            <div id="play-info">
                <div id="play-bar">
                    <div id="played"></div>
                </div>
                <div id="play-bar-button"></div>
            </div>
        </div>
        <div id="play-options">
            <div id="button-box">
                <input type="image" src="<?php echo URL ?>img/repeat_one.png" onclick="musicForwards()">
                <input id="play" type="image" src="<?php echo URL ?>img/shuffle.png" onclick="musicPlay()">
                <input type="image" src="<?php echo URL ?>img/arrow-up.png" onclick="musicBackwards()">
            </div>
        </div>
    </div>

</div>