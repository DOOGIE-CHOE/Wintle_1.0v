<?php
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>jQuery UI Droppable - Default functionality</title>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <!-- draggable import -->
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <link href="loadingSpinner.css" rel="stylesheet">

    <script type="text/javascript" src="jquery.form.js"></script>

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
            background-image: url("tile.png");
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


    </style>
    <script>
        var timer = 0;
        var RemToPx = 16;
        var _increase = 0;
        var interval;
        var playlist =[];
        var audioElement = [];

        function bar(){
            if(document.getElementById("button").value == "start") {
                document.getElementById("button").value = "stop";
                interval = setInterval(function(){  barProgress(_increase);  },100);
                playAllAudio();
            }else{
                document.getElementById("button").value = "start";
                stopAllAudio();
                clearInterval(interval);
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

        function barProgress(increase) {
            _increase = parseInt(increase) + RemToPx;
            timer += 0.1;
            timer = timer.toFixed(1);
            timer = parseFloat(timer);
            $("#bar").css("left", _increase / 10 + "px");
        }

        function resetBarProgress() {
            _increase = 0;
            timer = 0;
            $("#bar").css("left", "0");
            document.getElementById("button").value = "start";
            clearInterval(interval);
            resetAllAudio();
        }

        function calculateLeftToPx(id){
            var tmp = $(id).css("left");
            tmp = tmp.substring(0, tmp.length-2);
            tmp = parseFloat(tmp)/16;
            tmp = tmp.toFixed(1);
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
                axis : "x"
            });
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
                    if(timer == calculateLeftToPx(playlist[i])){
                        audioElement[i].play();
                    }
                }
            }
        }

        function test(){
            var a = $("#draggable-0").css("left");
            var b = $("#draggable-1").css("left");
            var c = $("#draggable-2").css("left");
            var d = $("#draggable-3").css("left");
            var e = $("#draggable-4").css("left");
            alert(a+b+c+d+e);
        }

        $(document).ready(function(){
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
                        if(data[1] == true){/*error alert here*/}
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
    <img src="logo.png">
</div>

<div class="option-space">

</div>

</br>
<div class="cssload-overlay">
    <div class="cssload-container" >
        <div class="cssload-whirlpool"></div>
    </div>
</div>
<div id="mp">
    <div id="flat">
        <div id='tile'><div id='draggable-0' class='raw-audio' style='background-image:url("waves/guitar.png"); width :3738.88px; left:40px; background-color: royalblue; '></div></div>
        <div id='tile'><div id='draggable-1' class='raw-audio' style='background-image:url("waves/drum.png"); width : 3685.76px; left:34px; background-color: #BA55D3; '></div></div>
        <div id='tile'><div id='draggable-2' class='raw-audio' style='background-image:url("waves/piano.png"); width :3734.88px; left:14px; background-color: #7FFFD4; '></div></div>
        <div id='tile'><div id='draggable-3' class='raw-audio' style='background-image:url("waves/string.png"); width : 3094.88px; left 670px; background-color:  #EE6AA7;'></div></div>
        <div id='tile'><div id='draggable-4' class='raw-audio' style='background-image:url("waves/vocal.png"); width : 3423.2px; left:313px; background-color: #9AFF9A; '></div></div>
        <div id="bar">
        </div>
    </div>
</div>

<form name="upload-audio" id="upload-audio" method="post" enctype="multipart/form-data" action="uploadaudio.php" >
    <div id="buttons">
        <div id="buttons-align">
            <input type="file" value="upload" name="audio[]" id="audio" multiple>
            <input type="button" value="test" onclick="test()">
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

