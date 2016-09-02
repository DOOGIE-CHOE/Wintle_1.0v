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

        #flat{
            position:relative;
            padding:0;
            margin:0;
            background-color: rgb(230,233,235);
            border-style:solid;
            border-width: 1px;
            height:50rem;
            width:3000px;
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

        .options{
            position:absolute;
            float:left;
            height:1000px;
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
            background-color: #BA55D3;
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

        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', 'audio/song1.mp3');

        function bar(){
            if(document.getElementById("button").value == "start") {
                document.getElementById("button").value = "stop";
                interval = setInterval(function(){  barProgress(_increase);  },100);
            }else{
                document.getElementById("button").value = "start";
                audioElement.pause();
                clearInterval(interval);
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
            $("#bar").css("left", "0");
            document.getElementById("button").value = "start";
            clearInterval(interval);
        }


        /*
         function barProcess(increase) {
         _increase = parseInt(increase) + RemToPx;
         $("#bar").css("left", _increase / 10 + "px");

         timer+=0.1;
         timer = timer.toFixed(1);
         timer = parseFloat(timer);
         AudioHandler();
         timeout = setTimeout("barProcess('" + _increase + "')", 100);
         }
         */


        function test(){
            /*
             var p = $("#draggable-5");
             var position = p.position();
             var d = $("#flat");
             var dposition = d.offset();

             var left = position.left - dposition.left;


             $("#left").text("left : "+ position.left);
             $("#left-div").text("top : "+ position.top);*/
        }

        function collision($div1, $div2) {
            var x1 = $div1.offset().left;
            var y1 = $div1.offset().top;
            var h1 = $div1.outerHeight(true);
            var w1 = $div1.outerWidth(true);
            var b1 = y1 + h1;
            var r1 = x1 + w1;
            var x2 = $div2.offset().left;
            var y2 = $div2.offset().top;
            var h2 = $div2.outerHeight(true);
            var w2 = $div2.outerWidth(true);
            var b2 = y2 + h2;
            var r2 = x2 + w2;

            if (b1 < y2 || y1 > b2 || r1 < x2 || x1 > r2) return false;
            return true;
        }

        function calculateLeftToPx(id){
            var tmp = $(id).css("left");
            tmp = tmp.substring(0, tmp.length-2);
            tmp = parseFloat(tmp)/16;
            tmp = tmp.toFixed(1);
            return tmp;
        }

        function drawWavefroms(_sequence, _path, _width){
            $("#flat").append("<div id='tile'><div id='draggable-"+_sequence+"' class='raw-audio' style='background-image:url("+_path+"); width:"+_width+";'></div></div>");
            $("#draggable-"+_sequence).draggable ({
                axis : "x"
            });

        }

        $(document).ready(function(){
            $('#audio').on('change',function(){
                $('#upload-audio').ajaxForm({
                    beforeSubmit:function(e){
                        $('.cssload-overlay').css("visibility","visible");
                    },
                    success:function(e){
                        $('.cssload-overlay').css("visibility","hidden");
                        var data = $.parseJSON(e);
                        if(data[1] == true){/*error alert here*/}
                        var count = data[0].length;

                        var test =0;
                        while($("#draggable-"+test).length != 0){
                            test++;
                        }
                        for(var i =0; i<count; i++){
                            drawWavefroms(i+test ,data[0][i].fullpath, data[0][i].width);
                        }
                    },
                    error:function(e){
                    }

                }).submit();
            });

            // it works like a threading function
            //setInterval("AudioHandler()",50);


            /*
             // EVENT LISTENER FOR AUDIO
             audioElement.addEventListener("load", function() {
             audioElement.play();
             }, true);
             */

            //Collision style music player
            /*          window.setInterval(function() {
             if(collision($('#bar'), $('#draggable-1'))){
             audioElement.play();
             }
             }, 10);*/

            /*
             $('.play').click(function() {
             audioElement.play();
             });

             $('.pause').click(function() {
             audioElement.pause();
             });*/

            });

    </script>
</head>
<body>
<div id="logo">
    <img src="logo.png">
</div>

<div class="options"></div>

<!--
<div id="seconds">
    <a style="margin-left:2rem">1</a>
    <a style="margin-left:1rem">2</a>
    <a style="margin-left:5rem">2:00</a>
    <a style="margin-left:5rem">2:30</a>
    <a style="margin-left:5rem">3:00</a>
    <a style="margin-left:5rem">3:30</a>
    <a style="margin-left:5rem">4:00</a>
</div>-->
</br>
<div class="cssload-overlay">
    <div class="cssload-container" >
        <div class="cssload-whirlpool"></div>
    </div>
</div>

<form name="upload-audio" id="upload-audio" method="post" enctype="multipart/form-data" action="uploadaudio.php" >
    <div id="buttons">
        <div id="buttons-align">
            <input type="file" value="upload" name="audio[]" id="audio" multiple>

            <input type="button" value="start" id="button" onclick="bar()">
            <input type="button" value="reset" id="reset" onclick="resetBarProgress()">
        </div>
    </div>
</form>

<div id="flat">
    <div id="bar">
    </div>
</div>
<div>
    <p id="left"></p>
    <p id="left-div"></p>
</div>

</body>
</html>