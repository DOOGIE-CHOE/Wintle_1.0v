<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/16/2016
 * Time: 11:48 AM
 */?>
<div id="all">

    <script type="text/javascript" src="js/jquery/jquery.canvasjs.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $(".like_graph").CanvasJSChart({
                backgroundColor: "transparent",
                title: {
                    text: "TITLE",
                    fontSize: 12
                },
                legend : {
                    fontColor: "white",
                    verticalAlign: "center",  // "top" , "bottom"
                    horizontalAlign: "right"  // "center" , "right"
                },
                dataPointMaxWidth: 35,
                height: 260,
                data: [
                    {
                        type: "column", //try changing to column, area
                        name: "View Count",
                        showInLegend: "true",
                        color: "#ff8242 ",
                        dataPoints: [
                            { y: 450, label: "New Age" },
                            { y: 414, label:  "Rock"},
                            { y: 520 , label:  "Jazz"},
                            { y: 460 , label:  "Blues"},
                            { y: 450 , label:  "R&B"},
                            { y: 500 , label:  "POP"},
                            { y: 480 , label:  "Soul"},
                            { y: 480 , label:  "Ballad"}
                        ]
                    },
                    {
                        type: "line", //try changing to column, area
                        name: "Likes",
                        showInLegend: "true",
                        color: "#5cb4cb",
                        dataPoints: [
                            { y: 100, label: "New Age" },
                            { y: 414, label:  "Rock"},
                            { y: 300 , label:  "Jazz"},
                            { y: 460 , label:  "Blues"},
                            { y: 250 , label:  "R&B"},
                            { y: 500 , label:  "POP"},
                            { y: 480 , label:  "Soul"},
                            { y: 480 , label:  "Ballad"}
                        ]
                    }
                ]
            });
        });
    </script>


    </head>

    <body class="body_bg02">
    <div id="sub-header">
        <div id="container">
            <div id="subclass">
                <div><p style="border-bottom: 3px solid #ff8243; padding-bottom: 2px;"onclick="$.pagehandler.loadContent('<?php echo URL?>index','all');">All</p></div>
                <div><p onclick="$.pagehandler.loadContent('<?php echo URL?>topchart','all');">Seed</p></div>
                <div><p onclick="$.pagehandler.loadContent('<?php echo URL?>recommend','all');">Recommended</p></div>
            </div>

            <div id="sort">
                <!--<img src="<?php /*echo URL*/?>img/search.png" style="height:18px; right:0; margin-right:10px;">-->
                <img src="<?php echo URL?>img/filter.png" style="height:18px; right:0; margin-right:10px;">
            </div>
        </div>
    </div>
    <div id="wrapper" >
        <div class="container bg_black06">
            <div class="mgt_20">
                <!--like-->
                <div class="rowAR">
                    <div class="like_title f_white" style=" background:url('<?php echo URL?>image/like_titlebar.png') no-repeat; padding:10px; text-align:center; width:267px; margin:20px auto; font-size:1.5em; font-weight:300 ">You may like</div>
                    <div class="like_graphAR bg_black06">
                        <div class="like_graph"><!--그래프 들어가는곳<img src="/wintle/image/gr.png"> --></div>
                    </div>
                </div>

                <div class="rowAR">

                    <!--음악분류별 목록-->
                    <h3 class="f_white f300"><font class="glyphicon glyphicon-stop"></font> K-POP</h3>

                    <!--앨범그룹1-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>Jazz</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p1.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p2.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p3.jpg" alt="" /></div>
                    </div>

                    <!--앨범그룹2-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>신남</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p4.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p5.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p1.jpg" alt="" /></div>
                    </div>

                    <!--앨범그룹3-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>Rock</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p1.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p2.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p3.jpg" alt="" /></div>
                    </div>

                    <!--앨범그룹4-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>Ballad</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p5.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p3.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p1.jpg" alt="" /></div>
                    </div>

                    <!--앨범그룹5-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>New Age</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p4.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p5.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p1.jpg" alt="" /></div>
                    </div>

                    <!--앨범그룹6-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>달달한</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p1.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p2.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p3.jpg" alt="" /></div>
                    </div>

                    <!--앨범그룹7-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>슬플때</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p3.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p4.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p1.jpg" alt="" /></div>
                    </div>

                    <!--앨범그룹8-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>Blues</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p1.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p3.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p4.jpg" alt="" /></div>
                    </div>

                    <!--앨범그룹9-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>사랑스런</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p4.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p3.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p1.jpg" alt="" /></div>
                    </div>

                    <!--앨범그룹10-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>R&B</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p1.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p2.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p3.jpg" alt="" /></div>
                    </div>

                    <!--앨범그룹11-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>잠자기전</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p1.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p2.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p3.jpg" alt="" /></div>
                    </div>

                    <!--앨범그룹12-->
                    <div class="like-grid">
                        <div class="albumT">
                            <div class="albumT_ar"><p><span>Soul</span></p></div>
                        </div>
                        <div class="albumP1"><img src="image/album_p1.jpg" alt="" /></div>
                        <div class="albumP2"><img src="image/album_p2.jpg" alt="" /></div>
                        <div class="albumP3"><img src="image/album_p3.jpg" alt="" /></div>
                    </div>
                </div>
            </div>
        </div><!--container-->
    </div><!--#wrapper-->
    </body>

</div>