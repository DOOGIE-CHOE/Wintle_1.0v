<?php
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WebStudio - Wintle</title>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

    <!-- draggable import -->
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <!------------jquery import ----------->
    <script src="<?php echo URL?>js/jquery/jquery.form.js" type="text/javascript"></script>

    <link href="<?php echo URL?>css/loadingSpinner.css" rel="stylesheet">

    <style>
        body, html{
            margin:0;
            padding:0;
        }

        #logo img{
            position:relative;
            float:left;
            height:55px;
            margin-left:50px;
            margin-top:7px;
        }
        #mp{
            padding-bottom: 10%;
        }

        #flat{
            position:relative;
            padding: 0;
            margin:0;
            background-color: rgb(230,233,235);
            width:5000px;
            left: 301px;
            top:53px;
        }


        #tile{
            position:relative;
            background-image: url("<?php echo URL?>img/tile.png");
            background-size:16px;
            background-repeat: repeat-x;
            width:100%;
            height:125px;
            z-index: 10;
        }
        #line{
            position:absolute;
            top:0;
            left:-8px;
            z-index: 80;
            height:100%;
            cursor:e-resize;
        }

        /*#arrow{
            position:relative;
            margin:auto;
            right:0;
            left:0;
            top:0;
            z-index: 81;
        }

        #arrow #arrow-box{
            width:16px;
            height:14px;
            background: #2C3E50;
        }

        #arrow #arrow-down{
            width: 0;
            height:0;
            border-left: 9px solid transparent;
            border-right: 9px solid transparent;
            border-top: 12px solid #2C3E50;
        }*/

        #arrow {
            width: 16px;
            height: 14px;
            background-color: black;
            position: relative;
        }
        #arrow:after {
            content: '';
            position: absolute;
            top: 14px;
            left: 0;
            width: 0;
            height: 0;
            border: 8px solid transparent;
            border-top: 8px solid black;
        }
        #arrow:before {
            content: '';
            position: absolute;
            top: 14px;
            left: 0;
            width: 0;
            height: 0;
            border: 9px solid transparent;
            border-top: 8px solid black;
        }

        #bar{
            position:relative;
            border-style:solid;
            border-width: 1px;
            height:100%;
            width:0;
            right:0;
            left:0;
            margin:auto;
            background: black;
        }

        .option-space{
            position:absolute;
            float:left;
            height:100%;
            width:300px;
            top:70px;
            background:rgb(232,235,237);
        }

        #buttons{
            z-index: 90;
            position:fixed;
            bottom:0;
            width:100%;
            height:100px;
            background: whitesmoke;
        }

        #buttons #buttons-align{
            vertical-align:center;
            text-align: center;
            line-height: 100px;
        }

        .raw-audio {
            position: relative;
            background-repeat:no-repeat;
            background-position:center;
            height:100px;
            margin-top: 5px;
            margin-bottom: 9px;
            opacity: 0.9;
            z-index: 10;
            left:100px;
            border-radius: 8px;
        }

        #time{
            position:relative;
            height:25px;
            width:3000px;
            background-color: #1FB5BF;
        }


        #page-option{
            position:absolute;
            top:30px;
            left:320px;
        }
        #page-option a{
            display:inline-block;
            font-size: 20px;
        }
        a:link {
            color: black;
            text-decoration: none;
        }
        a:visited{
            color:black;
            text-decoration: none;
        }



    </style>
    <script>
        var timer = 0;
        var interval;
        var playlist =["#draggable-0","#draggable-1","#draggable-2","#draggable-3","#draggable-4"];
        var audioElement = [];
        const REMTOPX = 16;
        const OPTIONWIDTH = 300;
        const ARROWBOXHALFWIDTH = 8;
        var isBarProgressing = false;

        function bar(){
            if(document.getElementById("button").value == "start") {
                document.getElementById("button").value = "stop";
                interval = setInterval(function(){  barProgress();  },100);
                playAllAudio();
            }else{
                document.getElementById("button").value = "start";
                stopAllAudio();
                clearInterval(interval);
                isBarProgressing = false;
            }
        }

        function playAllAudio(){
            for(var i = 0; i<audioElement.length; i++){
                if(audioElement[i].currentTime != 0)
                    audioElement[i].play();
            }
        }

        function stopAllAudio(){
            for(var i = 0; i<audioElement.length; i++){
                audioElement[i].pause();
            }
        }

        function resetAllAudio(){
            for(var i = 0; i<audioElement.length; i++){
                audioElement[i].pause();
                audioElement[i].currentTime = 0;
            }
        }

        function barProgress() {
            isBarProgressing = true;
            timer += 0.1;
            timer = timer.toFixed(1);
            timer = parseFloat(timer);
            var line = $("#line");
            var tmp = line.css("left").substring(0, line.css("left").length - 2);
            tmp = parseFloat(tmp) + REMTOPX/10;
            line.css("left", tmp + "px");
        }

        function resetBarProgress() {
            timer = 0;
            $("#line").css("left", -ARROWBOXHALFWIDTH+"px");
            document.getElementById("button").value = "start";
            clearInterval(interval);
            isBarProgressing = false;
            resetAllAudio();
        }


        function calculateLeftToTime(id){
            var tmp = $(id).css("left");
            tmp = tmp.substring(0, tmp.length-2);
            tmp = tmp/REMTOPX;
            tmp = tmp.toFixed(1);
            tmp = parseFloat(tmp);
            return tmp;
        }

        function setAudio(_path){
            var audio = document.createElement('audio');
            audio.setAttribute('src', _path);
            audio.load();
            audioElement.push(audio);
            //audioElement[audioElement.length-1].load();
        }

        function audioHandler(){
            if(playlist.length == 0){
            }else{
                for(var i=0;i<playlist.length;i++){
                    if(timer >= calculateLeftToTime(playlist[i]) && isBarProgressing){
                        audioElement[i].play();
                    }
                }
            }
        }

        $(document).ready(function(){
            setAudio("audio/comeback_guitar.m4a");
            setAudio("audio/comeback_drum.m4a");
            setAudio("audio/comeback_piano.m4a");
            setAudio("audio/comeback_string.m4a");
            setAudio("audio/comeback_vocal.m4a");

            $("#draggable-0").draggable ({
                axis : "x"
            });
            $("#draggable-1").draggable ({
                axis : "x"
            });
            $("#draggable-2").draggable ({
                axis : "x"
            });
            $("#draggable-3").draggable ({
                axis : "x"
            });
            $("#draggable-4").draggable ({
                axis : "x"
            });


            var line = $("#line");

            line.draggable ({
                axis : "x",
                cursorAt:{left:8},
                containment:[294]
            });

            line.mouseover(function(){

            });

            line.mousedown(function (){
                clearInterval(interval);
                isBarProgressing = false;
            });

            line.mouseup(function(event){
                line.css("left",event.pageX - OPTIONWIDTH - ARROWBOXHALFWIDTH+"px");
                if(document.getElementById("button").value == "stop") {
                    interval = setInterval(function(){  barProgress(); },100);
                }

                var time = calculateLeftToTime("#line");
                time += 0.5;
                timer = time;
                for(var i =0; i<audioElement.length; i++){
                    var tmp = calculateLeftToTime(playlist[i]);
                    if(time > tmp && audioElement[i].currentTime < time - tmp){
                        audioElement[i].currentTime = time - tmp;
                    }else if(time > tmp && audioElement[i].currentTime > time - tmp){
                        audioElement[i].currentTime = time - tmp;
                    }else if(time < tmp && audioElement[i].currentTime > 0 ){
                        audioElement[i].currentTime = 0;
                        audioElement[i].pause();
                    }
                }
            });
            // it works like a threading function
            setInterval("audioHandler()",50);
        });

    </script>
</head>
<body>
<div id="logo">
    <img src="<?php echo URL?>img/pavicon/logo.png">
    <div id="page-option">
        <a href="<?php echo URL?>webstudio">Web Studio</a>
        <a>&nbsp</a>
        <a href="<?php echo URL?>webstudio/sample" style="font-weight: bold; text-decoration: underline">Sample page</a>
    </div>
</div>
<div class="option-space">
</div>

<div class="option-space"></div>

</br>
<div class="cssload-overlay">
    <div class="cssload-container" >
        <div class="cssload-whirlpool"></div>
    </div>
</div>
<div id="mp">
    <div id="flat">
        <div id="time"></div>
        <div id='tile'><div id="draggable-0" class='raw-audio' style='background-image:url("waves/guitar.png"); width :3738.88px; left:39px; background-color: royalblue; '></div></div>
        <div id='tile'><div id='draggable-1' class='raw-audio' style='background-image:url("waves/drum.png"); width : 3685.76px; left:33px; background-color: #BA55D3; '></div></div>
        <div id='tile'><div id='draggable-2' class='raw-audio' style='background-image:url("waves/piano.png"); width :3734.88px; left:14px; background-color: #7FFFD4; '></div></div>
        <div id='tile'><div id='draggable-3' class='raw-audio' style='background-image:url("waves/string.png"); width : 3094.88px; left:670px; background-color:#EE6AA7;'></div></div>
        <div id='tile'><div id='draggable-4' class='raw-audio' style='background-image:url("waves/vocal.png"); width : 3423.2px; left:315px; background-color: #9AFF9A; '></div></div>

        <div id="line">
            <div id="arrow">
            </div>
            <div id="bar"></div>
        </div>
    </div>
</div>

<form name="upload-audio" id="upload-audio" method="post" enctype="multipart/form-data" action="uploadaudio.php" >
    <div id="buttons">
        <div id="buttons-align">
           <!-- <input type="file" value="upload" name="audio[]" id="audio" multiple>-->
            <input type="button" value="start" id="button" onclick="bar()">
            <input type="button" value="reset" id="reset" onclick="resetBarProgress()">
        </div>
    </div>
</form>
<div>
    <p id="left"></p>
    <p id="left-div"></p>
</div>

</body>
</html>

