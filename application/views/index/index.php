<html>
<head>
    <title>Wintle</title>

    <style>

        .main-board{
            height:1000px;
            width:85%;
            background-color: ghostwhite;
            margin:auto;
        }

        .main-board .user-board{
            display:inline-block;
            position:relative;
            height:100%;
            width:25%;
            background-color: rgba(0,0,0,0.3);
        }

        .main-board .music-board{
            display:inline-block;
            position:relative;
            float:right;
            height:100%;
            width:75%;
            background-color: #2b2e31;
        }

        .sb{
            position:relative;
            background-color: #3d4043;
            width:100%;
            height:120px;
            margin-top:30px;
        }

        .label{
            position:relative;
            float:left;
            background-color: #6d95e0;
            width:20px;
            height:100%;

        }

        .body{
            margin-top : 30px;
        }
        #bg{
            position:absolute;
            height:100%;
            width:100%;
            background-color: rgba(189,189,189,0.5);
        }

    </style>
</head>
<body class="body">
<!--<iframe style="position:absolute" width="100%" height="100%" src="https://www.youtube.com/embed/hG2ekffXMhs?list=RDhG2ekffXMhs&showinfo=0&autoplay=1&loop=1&controls=0&disablekb=0" frameborder="0" allowfullscreen></iframe>
-->
<div id="bg">
<div class="main-board">
    <div class="user-board">
        <div class="sb userinfo">
            <div class="label"></div>
        </div>

        <div class="sb follower">
            <div class="label"></div>
        </div>

        <div class="sb playlist">
            <div class="label"></div>
        </div>

        <div class="sb library">
            <div class="label"></div>
        </div>

        <div class="sb myproject">
            <div class="label"></div>
        </div>
    </div>
    <div class="music-board">

    </div>
</div>
</div>