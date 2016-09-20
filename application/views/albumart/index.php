<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/20/2016
 * Time: 1:58 PM
 */


?>

<head>
    <style>
        html body{
            overflow-x:hidden;
        }

        .main-board{
            height:1000px;
            width:85%;
            background-color: ghostwhite;
            margin:auto;
        }

        .main-board .music-board{
            display:inline-block;
            position:relative;
            float:left;
            height:100%;
            width:75%;
            background-color: #2b2e31;
        }

        #bg{
            position:absolute;
            height:100%;
            width:100%;
            background-color: rgba(189,189,189,0.5);
        }

        .body{
            margin-top : 30px;
        }


        .line-arrow {
            position: absolute;
            overflow: hidden;
            display: inline-block;
            font-size: 10px; /*set the size for arrow*/
            width: 4em;
            height: 4em;
            top:45%;
        }

        .line-arrow.left {
            border-top: 3px solid black;
            border-left: 3px solid black;
            transform: rotate(-54deg) skew(-20deg);
            left:50px;
        }

    </style>
</head>

<body class="body">
<div id="bg">
    <div class="main-board">
        <div class="music-board"></div>
    </div>
    <div id="to-albums">
        <?php echo "<a href='" .URL."index'";?>  <div class="line-arrow left"></div> </a>
    </div>
</div>
</body>

