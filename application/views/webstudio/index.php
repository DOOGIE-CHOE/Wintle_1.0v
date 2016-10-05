<?php
?>

<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>WebStudio - Wintle</title>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

    <!-- draggable import --><!--
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>-->
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <!------------jquery import ----------->
    <script src="<?php echo URL?>public/js/jquery/jquery.form.js" type="text/javascript"></script>

    <link href="<?php echo URL?>public/css/loadingSpinner.css" rel="stylesheet">


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
            background-image: url("http://wintle.co.kr/public/img/tile.png");
            background-size:16px;
            background-repeat: repeat-x;
            width:100%;
            height:125px;
            z-index: 10;
        }

        #bar{
            position:absolute;
            top:0;
            left:0;
            z-index: 80;
            border-style:solid;
            border-width: 1px;
            height:100%;
            width:0;
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

        #line{
            position:absolute;
            top:0;
            left:-8px;
            z-index: 80;
            height:100%;
            cursor:e-resize;
        }

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
        .co-op{
            position:fixed;
            float: right;
            top:115px;
            right:15px;
            z-index:10;
            height:50px;
            width:50px;
        }

        .co-op img{
            height:50px;
            width:50px;
        }

    </style>
    <script>
        const REMTOPX = 16;
        const OPTIONWIDTH = 300;
        const ARROWBOXHALFWIDTH = 8;
        var isBarProgressing = false;
        var timer = 0;
        var interval;
        var playlist =[];
        var audioElement = [];

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

        function getRandomColor() {
            var colorList = ["#BA55D3","royalblue","#EE6AA7","#FF4040","#7FFFD4","#9AFF9A","#EEEE00","#FFA500","#FF6347", "#828282"];
            /*
             * "#BA55D3"   light purple
             * "royalblue" royalblue
             * "#EE6AA7"   hot pink
             * "#FF4040"   brown1
             * "#7FFFD4"   aquamarine1
             * "#9AFF9A"   palegreen1
             * "#EEEE00"   yello1
             * "#FFA500"   orange1
             * "#FF6347"   tomato1
             * "#828282"   grey51
             * */
            var min = 0;
            var max = colorList.length-1;
            return colorList[Math.floor(Math.random() * (max - min + 1)) + min];
        }

        function drawWavefroms(_sequence, _path, _width){
            playlist.push("#draggable-"+_sequence);
            $("#flat").append("<div id='tile'><div id='draggable-"+_sequence+"' class='raw-audio' style='background-image:url("+_path+"); width:"+_width+"; background-color: "+getRandomColor()+"; '></div></div>");
            $("#draggable-"+_sequence).draggable ({
                axis : "x",
                containment:"parent"
            });
        }

        function setAudio(_path){
            var audio = document.createElement('audio');
            audio.setAttribute('src', _path);
            audio.load();
            audioElement.push(audio); //call by reference//
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

            var line = $("#line");


            line.draggable ({
                axis : "x",
                cursorAt:{left:8},
                containment:[294]
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
                time += 0.5; //line's left is initialized -0.5
                timer = time;
                for(var i =0; i<audioElement.length; i++){
                    // Compare block position, bar position by left
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


            $('#audio').on('change',function(){
                $('#upload-audio').ajaxForm({
                    beforeSubmit:function(e){
                        //loading gif on
                        $('.cssload-overlay').css("visibility","visible");
                    },
                    success:function(e){
                        //loading gif off
                        $('.cssload-overlay').css("visibility","hidden");
                        var data = $.parseJSON(e);
                        if(data[1] != false){
                            errorDisplay(data[1]);}
                        var dataLength = data[0].length;
                        var count =0;
                        while($("#draggable-"+count).length != 0){
                            count++;
                        }
                        for(var i =0; i<dataLength; i++){
                            drawWavefroms(i+count ,data[0][i].imgpath, data[0][i].width);
                            setAudio(data[0][i].audiopath);
                        }
                    },
                    error:function(e){

                    }

                }).submit();
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
        <a href="<?php echo URL?>webstudio" style="font-weight: bold; text-decoration: underline">Web Studio</a>
        <a>&nbsp</a>
        <a href="<?php echo URL?>webstudio/sample">Sample page</a>
    </div>
</div>
<div class="option-space">
</div>
<div class="co-op"><img src="<?php echo URL?>img/groups.png"></div>

</br>
<div class="cssload-overlay">
    <div class="cssload-container" >
        <div class="cssload-whirlpool"></div>
    </div>
</div>
<div id="mp">
    <div id="flat">
        <div id="time"></div>
        <div id="line">
            <div id="arrow">
            </div>
            <div id="bar"></div>
        </div>
    </div>
</div>

<form name="upload-audio" id="upload-audio" method="post" enctype="multipart/form-data" action="<?php echo URL?>webstudio/uploadaudio">
    <div id="buttons">
        <div id="buttons-align">
            <input type="file" value="upload" name="audio" id="audio">
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

