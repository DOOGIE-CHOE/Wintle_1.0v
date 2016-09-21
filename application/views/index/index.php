<html>
<head>
    <title>Wintle</title>

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
            position:fixed;
            height:100%;
            width:100%;
            background-repeat: no-repeat;
            background-image: url("img/bg/bg1.jpg");
            background-size: cover;
        }
        #to-albumart{
            position:fixed;
            right:0;
            top:50px;
            height:100%;
            width:7%;
            background-color: rgba(189,189,189,0.7);
            z-index:1;
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
            transform: rotate(-45deg) skew(0deg);
            margin-right:15px;
        }


        .line-arrow.right {
            border-top: 3px solid black;
            border-right: 3px solid black;
            transform: rotate(54deg) skew(20deg);
            right: 50px;
        }


    </style>
</head>
<body class="body">
<!--<iframe style="position:absolute" width="100%" height="100%" src="https://www.youtube.com/embed/hG2ekffXMhs?list=RDhG2ekffXMhs&showinfo=0&autoplay=1&loop=1&controls=0&disablekb=0" frameborder="0" allowfullscreen></iframe>
-->
<div id="bg"></div>

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
        <div class="music-board"></div>
    </div>
    <div id="to-albumart">
    <?php echo "<a href='" .URL."albumartall'";?><div class="line-arrow right"></div></a>
    </div>

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