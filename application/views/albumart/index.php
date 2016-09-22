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
            position:fixed;
            height:100%;
            width:100%;
            background-repeat: no-repeat;
            background-image: url("img/bg/bg2.jpg");
            background-size: cover;
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


<script type="text/javascript">
    var temp = "<div class='cell' style='width:{width}px; height: {height}px; background-image: url(i/{index}.jpg); background-size:cover; background-repeat:no-repeat; margin:0' onclick='a({index})'></div>";
    var w = 1, h = 1,html = '', limitItem = 49;
    var cellinfo = [];
    for (var i = 0; i < limitItem; ++i) {
        //w = 200 +  200 * Math.random() << 0;
        h = w = (Math.floor(Math.random() * 2) + 1) * 150;
        //html += temp.replace(/\{height\}/g, 200).replace(/\{width\}/g, w).replace("{index}", i + 1);
        html += temp.replace(/\{height\}/g, h).replace(/\{width\}/g, w).replace("{index}", i + 1);
        //     cellinfo.push(temp.replace(/\{height\}/g, h).replace(/\{width\}/g, w).replace("{index}", i + 1));
    }
    $(".music-board").html(html);

    var wall = new Freewall(".music-board");
    wall.reset({
        selector: '.cell',
        animate: true,
        cellW: 150,
        cellH: 150,
        onResize: function() {
            wall.fitWidth();
        }
    });
    wall.fitWidth();
    // for scroll bar appear;
    $(window).trigger("resize");

    function a(id){
        errorDisplay(id.index);
    }
</script>
