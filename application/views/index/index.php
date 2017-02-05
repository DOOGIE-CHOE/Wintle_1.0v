<div id="all">
    <script>
        $(function () {
            var wall = new Freewall(".grid");
            wall.reset({
                selector: '.grid-item',
                animate: true,
                cellW: 300,
                cellH: 'auto',
                gutterX: 20,
                gutterY: 20
            });
            //put this instead of on load function;

            wall.fitZone(setwidthgrid(), 'auto');
            $(window).resize(function () {
                wall.fitZone(setwidthgrid(), 'auto');
            });


            //catch the event to click dynamically appended div
            $(".popup-background").on("click", "div.dynamic-popup", function (e) {
                //when the mymodal is hidden (after toggled)
                $('#myModal').on('hidden.bs.modal', function (e) {
                    //remove appended popup
                    $(".dynamic-popup").empty();
                });
//                 var container = $("#mymodal");
//                 var block = $(".modal-dialog");
//                  clicking outside of popup
//                 if ((!container.is(e.target) && container.has(e.target).length === 0) && (!block.is(e.target) && block.has(e.target).length === 0) )
//                 {
//                    $(".pop").empty();
//                 }
            });

            $("#search").blur(function () {
                if (!this.value) { //if it's empty
                    console.log(3);
                } else {
                    $.get("<?php echo URL?>viewlist/loadContentsByHash?hashtags=" + $("#search").val(), function (o) {
                        var value = jQuery.parseJSON(o);
                        if (value.error != null) {
                            errorDisplay(value.error);
                        } else {
                            console.log(value);
                        }
                    });
                }
            }).keypress(function (e) {
                if (e.which === 32)
                    return false;
            });
        });


        function setwidthgrid() {
            $(".grid").width("95%");
            var $grid = $(".grid").css("width");
            var tmp = parseInt($grid);
            var w = parseInt(tmp / 310);
            var width = (w * 310);
            $(".grid").css("width", width + "px");
            //   return width;
        }


        function profileload(){

        }
        //put this instead of on load function;
        $.get("<?php echo URL?>viewlist/loadNewContents/<?php echo 0?>", function (o) {
            var value = jQuery.parseJSON(o);
            console.log(value);
            if (value == null) {
                //display default image
            } else {
                for (var i = 0; i < value.length; i++) {
                    if (!(value[i].content_type_name == "image" || value[i].content_type_name == "lyrics")) {

                    } else {
                        if (value[i].profile_photo_path == null) {
                            value[i].profile_photo_path = 'img/defaultprofile.png';
                        }

                        var html = "<div class='grid-item'>" +
                            "<div class='user' onclick=\"$.pagehandler.loadContent('<?php echo URL?>"+value[i].profile_url+"','all');\" >" +
                            "<div class='userphoto'>" +
                            "<img src='<?php echo URL?>"+value[i].profile_photo_path+"' class='img-circle'>" +
                            "</div>" +
                            "<div class='musictext'>" +
                            "<ul>" +
                            "<li><span class='music_name'>"+value[i].user_name+"</span></li>" +
                            "</ul></div></div>";
                        if (value[i].content_type_name == "image") {
                            html += "<div class='albumP'><img src='" + value[i].content_path + "' alt=''/></div>";
                            <!--앨범사진-->

                            // ** path **
                            // to replace \ to /
                            //value[i].content_path = value[i].content_path.replace(/\\/g,'/');
                        } else if (value[i].content_type_name == "lyrics") {
                            html += "<div class='albumT'>" + value[i].content_path + "</div>";
                            <!--lyrics-->
                        } else {
                        }
                        html +=
                            "<div class='userinfo'>" +
                            "<div class='musictext'><ul>"+
                            //"<li><span class='music_title'>" + value[i].content_title + "</span></li>" +
                            "<li><span class='music_name'>" + value[i].comments + "</span></li>" +
                            "<li class='music_tag'>";
                        if (value[i].hashtags != null) {
                            var hsh = value[i].hashtags.split(",");
                        }

                        for (var j = 0; j < hsh.length; j++) {
                            html += "<span class='label f_dwhite'>" + "\#" + hsh[j] + "</span>";
                        }



                        html +=
                            "</li></ul></div></div>" + <!--userinfo-->

                            "<div class='btm_info'>"+
                            "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                        "<a href='#'><img src='<?php echo URL?>icon/Details_Content/share.svg' class='w20px'/></a></span>"+
                            "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                        "<a href='#'><img src='<?php echo URL?>icon/Details_Content/Comment.svg' class='w20px'/></a></span>"+
                            "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                        "<a href='#'><img src='<?php echo URL?>icon/Details_Content/like.svg' class='w20px'/></a></span>"+
                            "</div>";
                        $(".grid").append(html);
                    }
                }
            }
        }).done(function () {
            var count = 0;
            var arrange = setInterval(function () {
                $(window).trigger('resize'); // resize grid-item
                count++;
                if (count >= 10) {
                    clearInterval(arrange);
                }
            }, 300);
        });

        function appendPopUp() {
            var html =
                "	<div class='modal fade ' id='myModal' role='dialog'>	" +
                "	<div class='modal_close' data-dismiss='modal'><a href='#' >&times;</a></div>	" +
                "		" +
                "	<div class='modal-dialog'>	" +
                "	<div class='modal-content'>	" +
                "	<div class='view_header bg_dblue'>	" +
                "	<a href='#' title='상세보기' ><div class='de_view'><span class='glyphicon glyphicon-menu-right'></span></div></a>	" +
                "	<div class='album_p'><img src='image/album_p1.jpg' class='w100'></div>	" +
                "	<div class='album_con'>	" +
                "	<ul>	" +
                "	<li class='li_size01' >	" +
                "	<div class='musictext w40 f_left'>	" +
                "	<ul>	" +
                "	<li><span class='music_name f_2'>Andrew</span></li>	" +
                "	<li class='music_tag'>	" +
                "	<span class='label label-primary'>#한줄만</span>	" +
                "	<span class='label label-primary'>#Classic</span>	" +
                "	<span class='label label-primary'>#jazz</span>	" +
                "	</li>	" +
                "	</ul>	" +
                "	</div>	" +
                "	<div class='w60 f_left pdt_15'>	" +
                "	<div class='w70px center f_white f_08 f_left'>	" +
                "	<a href='#' class='dpb'><img src='icon/Details_Content/like_fill.svg' class='w25px'  /></a>	" +
                "	<font class='clear f_brown mgt_2'>like 200</font>	" +
                "	</div>	" +
                "	<div class='w90px center f_white f_08 f_left'>	" +
                "	<a href='#' class='dpb'><img src='icon/Details_Content/Comment.svg' class='w25px' style='filter:invert()' /></a>	" +
                "	<font class='clear f_brown mgt_2'>l &nbsp;&nbsp;comment 200</font>	" +
                "	</div>	" +
                "	<div class='w70px center f_white f_08 f_left'>	" +
                "	<a href='#' class='dpb'><img src='icon/Details_Content/share.svg' class='w25px' style='filter:invert()'  /></a>	" +
                "	<font class='clear f_brown mgt_2'>l &nbsp;&nbsp;share 200</font>	" +
                "	</div>	" +
                "	</div>	" +
                "	</li>	" +
                "	<li class='li_size02'>	" +
                "	<div class='ofh f_08'>	" +
                "	Look at the stars,	" +
                "	Look how they shine for you,	" +
                "	And everything you do,	" +
                "	Yeah they were all yellow,	" +
                "		" +
                "	I came along	" +
                "	I wrote a song for you	" +
                "	And all the things you do	" +
                "	And it was called yellow	" +
                "		" +
                "	So then I took my turn	" +
                "	Oh all the things I've done	" +
                "	And it was all yellow  Look at the stars,	" +
                "	Look how they shine for you,	" +
                "	And everything you do,	" +
                "	Yeah they were all yellow,	" +
                "		" +
                "	I came along	" +
                "	I wrote a song for you	" +
                "	And all the things you do	" +
                "	And it was called yellow	" +
                "		" +
                "	So then I took my turn	" +
                "	Oh all the things I've done	" +
                "	And it was all yellow  Look at the stars,	" +
                "	Look how they shine for you,	" +
                "	And everything you do,	" +
                "	Yeah they were all yellow,	" +
                "		" +
                "	I came along	" +
                "	I wrote a song for you	" +
                "	And all the things you do	" +
                "	And it was called yellow	" +
                "		" +
                "	So then I took my turn	" +
                "	Oh all the things I've done	" +
                "	And it was all yellow	" +
                "	</div>	" +
                "	</li>	" +
                "	</ul>	" +
                "	</div>	" +
                "	</div>	" +
                "	<div class='view_body'>	" +
                "	<ul class='media-list'>	" +
                "	<li class='media'>	" +
                "	<div class='wrt_mem'><img class='img-circle' src='image/album_p6.jpg' style='width:55px; height:55px;'></div>	" +
                "	<div class='wrt_day'><span>2016/10/10</span><span><a href='#'>Comment</a> / <a href='#'>Edit</a></span></div>	" +
                "	<div class='wrt_con'>	" +
                "	<span class='name'>kahee</span>	" +
                "	<span class='dpb mgt_8 pdl_15'>첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다</span>	" +
                "	</div>	" +
                "	</li>	" +
                "	<li class='media'>	" +
                "	<div class='wrt_mem'><img class='img-circle' src='image/album_p3.jpg' style='width:55px; height:55px;'></div>	" +
                "	<div class='wrt_day'><span>2016/10/10</span><span><a href='#'>Comment</a> / <a href='#'>Edit</a></span></div>	" +
                "	<div class='wrt_con'>	" +
                "	<span class='name'>kahee</span>	" +
                "	<span class='dpb mgt_5 pdl_20'>첫번째글 내용이 보여집니다</span>	" +
                "	</div>	" +
                "	</li>	" +
                "	<li class='media comment'>	" +
                "	<div class='wrt_mem'><img class='img-circle' src='image/album_p6.jpg' style='width:55px; height:55px;'></div>	" +
                "	<div class='wrt_day'><span>2016/10/10</span><span><a href='#'>Edit</a></span></div>	" +
                "	<div class='wrt_con'>	" +
                "	<span class='name'>kahee</span>	" +
                "	<span class='dpb mgt_5 pdl_20'>첫번째글 내용이 보여집니다</span>	" +
                "	</div>	" +
                "	</li>	" +
                "	<li class='media comment'>	" +
                "	<div class='wrt_mem'><img class='img-circle' src='image/album_p3.jpg' style='width:55px; height:55px;'></div>	" +
                "	<div class='wrt_day'><span>2016/10/10</span><span><a href='#'>Edit</a></span></div>	" +
                "	<div class='wrt_con'>	" +
                "	<span class='name'>kahee</span>	" +
                "	<span class='dpb mgt_5 pdl_20'>첫번째글 내용이 보여집니다</span>	" +
                "	</div>	" +
                "	</li>	" +
                "	<li class='media comment'>	" +
                "	<div class='wrt_mem'><img class='img-circle' src='image/album_p3.jpg' style='width:55px; height:55px;'></div>	" +
                "	<div class='wrt_day'><span>2016/10/10</span><span><a href='#'>Edit</a></span></div>	" +
                "	<div class='wrt_con'>	" +
                "	<span class='name'>kahee</span>	" +
                "	<span class='dpb mgt_5 pdl_20'>첫번째글 내용이 보여집니다</span>	" +
                "	</div>	" +
                "	</li>	" +
                "	<li class='media comment'>	" +
                "	<div class='wrt_mem'><img class='img-circle' src='image/album_p3.jpg' style='width:55px; height:55px;'></div>	" +
                "	<div class='wrt_day'><span>2016/10/10</span><span><a href='#'>Edit</a></span></div>	" +
                "	<div class='wrt_con'>	" +
                "	<span class='name'>kahee</span>	" +
                "	<span class='dpb mgt_5 pdl_20'>첫번째글 내용이 보여집니다</span>	" +
                "	</div>	" +
                "	</li>	" +
                "	<li class='media comment'>	" +
                "	<div class='wrt_mem'><img class='img-circle' src='image/album_p3.jpg' style='width:55px; height:55px;'></div>	" +
                "	<div class='wrt_day'><span>2016/10/10</span><span><a href='#'>Edit</a></span></div>	" +
                "	<div class='wrt_con'>	" +
                "	<span class='name'>kahee</span>	" +
                "	<span class='dpb mgt_5 pdl_20'>첫번째글 내용이 보여집니다</span>	" +
                "	</div>	" +
                "	</li>	" +
                "	</ul>	" +
                "	</div>	" +
                "	<div class='view_footer bg_dblue'>	" +
                "	<img class='img-circle mem' src='icon/Music_pop_up/user_man.svg' style='width:55px; height:55px;'>	" +
                "	<img class='wrt' src='icon/Music_pop_up/Comment.svg' style='width:30px; height:30px; filter:invert()'>	" +
                "	<input class='wrt_input w70 mgl_60' type='text'  id='usr' placeholder='write...'>	" +
                "	</div>	" +
                "	</div>	" +
                "	</div>	" +
                "	</div>	";
            $(".dynamic-popup").append(html);


            var counter = 0;
            var myInterval = setInterval(function () {
                ++counter;
                console.log(counter);
                if (counter == 10) {
                    clearInterval(myInterval);
                }
            }, 1000);
        }
    </script>
    <body class="body_bg02 popup-background, bg_black">


    <!--    <div id="sub-header">-->
    <!--        <div id="container">-->
    <!--            <!--<div id="subclass">-->
    <!--                <div><p style="border-bottom: 3px solid #ff8243; padding-bottom: 2px;" onclick="$.pagehandler.loadContent('-->
    <?php ///*echo URL*/?><!--index','all');">All</p></div>-->
    <!--                <div><p onclick="$.pagehandler.loadContent('-->
    <?php ///*echo URL*/?><!--topchart','all');">Seed</p></div>-->
    <!--                <div><p onclick="$.pagehandler.loadContent('-->
    <?php ///*echo URL*/?><!--recommend','all');">Recommended</p></div>-->
    <!--            </div>-->
    <!---->
    <!--            <div style="width:100px;display:inline-block;">-->
    <!--                <input type="text" id="search">-->
    <!--            </div>-->
    <!--            <div id="sort">-->
    <!--                <!--<img src="-->
    <?php ///*echo URL*/?><!--img/search.png" style="height:18px; right:0; margin-right:10px;">-->
    <!--                <img src="-->
    <?php //echo URL?><!--img/filter.png" style="height:18px; right:0; margin-right:10px;">-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->


    <div id="wrapper">
        <div class="container bg_black">

            <!--앨범전체 AREA-->
            <div class="grid" data-layout-mode="masonry">
                <!--앨범-->
                <div class="grid-item">

                    <div class="user">
                        <div class="userphoto">
                            <!--                            <div class="badge bg_orange">3</div>-->
                            <img src="image/p2.jpg" class="img-circle">
                        </div>
                        <div class="musictext">
                            <ul>
                                <li><span class="music_name">Andrew</span></li>
                            </ul>
                        </div>
                    </div>


                    <div class="albumP"><a href="#" onclick="appendPopUp()" data-toggle="modal"
                                           data-target="#myModal"><img src="image/sample111.jpg" alt=""/></a>
                    </div>
                    <div class="userinfo">
                        <div class="musictext">
                            <ul>
                                <li><span class="music_title">그냥 그런 노래...<br> 재밌긴 하당 한번 확인해 보세용 !</span></li>
                                <li class="music_tag">
                                    <span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span><span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span><span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span><span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span><span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span><span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span><span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span><span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span>
                                </li>
                            </ul>
                        </div>
                    </div><!--//userinfo-->
                    <div class="btm_info" style="background: ugba(0,0,0,0)">
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/share.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/Comment.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/like.svg" class="w20px"/></a></span>
                    </div>
                </div>
                <!--앨범-->
                <div class="grid-item" style="background-color:rgba(255,255,255,0.1)">

                    <div class="user">
                        <div class="userphoto">
                            <!--                            <div class="badge bg_orange">3</div>-->
                            <img src="image/p2.jpg" class="img-circle">
                        </div>
                        <div class="musictext">
                            <ul>
                                <li><span class="music_name">Andrew</span></li>
                            </ul>
                        </div>
                    </div>


                    <div class="albumP"><a href="#" onclick="appendPopUp()" data-toggle="modal"
                                           data-target="#myModal"><img src="image/album_p7.jpg" alt=""/></a>
                    </div>
                    <div class="userinfo">
                        <div class="musictext">
                            <ul>
                                <li><span class="music_title">그냥 그저그런 노래 ..</span></li>
                                <li class="music_tag">
                                    <span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span>
                                </li>
                            </ul>
                        </div>
                    </div><!--//userinfo-->
                    <div class="btm_info" style="background: ugba(0,0,0,0)">
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/share.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/Comment.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/like.svg" class="w20px"/></a></span>
                    </div>
                </div>

                <!--앨범-->
                <div class="grid-item">

                    <div class="user">
                        <div class="userphoto">
                            <!--                            <div class="badge bg_orange">3</div>-->
                            <img src="image/p2.jpg" class="img-circle">
                        </div>
                        <div class="musictext">
                            <ul>
                                <li><span class="music_name">Andrew</span></li>
                            </ul>
                        </div>
                    </div>


                    <div class="albumP"><a href="#" onclick="appendPopUp()" data-toggle="modal"
                                           data-target="#myModal"><img src="image/album_p1.jpg" alt=""/></a>
                    </div>
                    <div class="userinfo">
                        <div class="musictext">
                            <ul>
                                <li><span class="music_title">그냥 그저그런 노래 ..</span></li>
                                <li class="music_tag">
                                    <span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span>
                                </li>
                            </ul>
                        </div>
                    </div><!--//userinfo-->
                    <div class="btm_info" style="background: ugba(0,0,0,0)">
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/share.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/Comment.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/like.svg" class="w20px"/></a></span>
                    </div>
                </div>

                <!--앨범-->
                <div class="grid-item" style="background-color:rgba(255,255,255,0.1)">

                    <div class="user">
                        <div class="userphoto">
                            <!--                            <div class="badge bg_orange">3</div>-->
                            <img src="image/p2.jpg" class="img-circle">
                        </div>
                        <div class="musictext">
                            <ul>
                                <li><span class="music_name">Andrew</span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="albumT">
                        사랑해 아직도<br>
                        왜너를 잊지 못 하니<br><br>
                        오랜 기억 속에 너를 생각하며<br>
                        달려온 시간들 속에<br><br>
                        필름처럼 지나온 너의 목소리가 들려와<br>
                        I want you Only you<br><br>
                        사랑해 아직도<br>
                        왜너를 잊지 못 하니<br><br>
                        오랜 기억 속에 너를 생각하며<br>
                        달려온 시간들 속에<br><br>
                        필름처럼 지나온 너의 목소리가 들려와<br>
                        I want you Only you<br><br>
                        지금도 늦기 않았나?<br>
                        다시 네게 다가가려해<br><br>
                        변한 나의 모습이지만<br>
                        받아주겠니 I love you<br>
                        사랑해 아직도<br>
                        왜너를 잊지 못 하니<br><br>
                        오랜 기억 속에 너를 생각하며<br>
                        달려온 시간들 속에<br><br>
                        필름처럼 지나온 너의 목소리가 들려와<br>
                        I want you Only you<br><br>
                        사랑해 아직도<br>
                        왜너를 잊지 못 하니<br><br>
                        오랜 기억 속에 너를 생각하며<br>
                        달려온 시간들 속에<br><br>
                        필름처럼 지나온 너의 목소리가 들려와<br>
                        I want you Only you<br><br>
                        지금도 늦기 않았나?<br>
                        다시 네게 다가가려해<br><br>
                        변한 나의 모습이지만<br>
                        받아주겠니 I love you<br>


                    </div>
                    <div class="userinfo">
                        <div class="musictext">
                            <ul>
                                <li><span class="music_title">그냥 그저그런 노래 ..</span></li>
                                <li class="music_tag">
                                    <span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span>
                                </li>
                            </ul>
                        </div>
                    </div><!--//userinfo-->
                    <div class="btm_info" style="background: ugba(0,0,0,0)">
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/share.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/Comment.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/like.svg" class="w20px"/></a></span>
                    </div>
                </div>

                <!--앨범-->
                <div class="grid-item" style="background-color:rgba(255,255,255,0.1)">

                    <div class="user">
                        <div class="userphoto">
                            <!--                            <div class="badge bg_orange">3</div>-->
                            <img src="image/p2.jpg" class="img-circle">
                        </div>
                        <div class="musictext">
                            <ul>
                                <li><span class="music_name">Andrew</span></li>
                            </ul>
                        </div>
                    </div>


                    <div class="albumP"><a href="#" onclick="appendPopUp()" data-toggle="modal"
                                           data-target="#myModal"><img src="image/album_p6.jpg" alt=""/></a>
                    </div>
                    <div class="userinfo">
                        <div class="musictext">
                            <ul>
                                <li><span class="music_title">그냥 그저그런 노래 ..</span></li>
                                <li class="music_tag">
                                    <span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span>
                                </li>
                            </ul>
                        </div>
                    </div><!--//userinfo-->
                    <div class="btm_info" style="background: ugba(0,0,0,0)">
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/share.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/Comment.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/like.svg" class="w20px"/></a></span>
                    </div>
                </div>

                <!--앨범-->
                <div class="grid-item" style="background-color:rgba(255,255,255,0.1)">

                    <div class="user">
                        <div class="userphoto">
                            <!--                            <div class="badge bg_orange">3</div>-->
                            <img src="image/p2.jpg" class="img-circle">
                        </div>
                        <div class="musictext">
                            <ul>
                                <li><span class="music_name">Andrew</span></li>
                            </ul>
                        </div>
                    </div>


                    <div class="albumT">
                        사랑해 아직도<br>
                        왜너를 잊지 못 하니<br><br>
                        오랜 기억 속에 너를 생각하며<br>
                        달려온 시간들 속에<br><br>
                        필름처럼 지나온 너의 목소리가 들려와<br>
                        I want you Only you<br><br>
                        사랑해 아직도<br>
                        왜너를 잊지 못 하니<br><br>
                        오랜 기억 속에 너를 생각하며<br>
                        달려온 시간들 속에<br><br>
                        필름처럼 지나온 너의 목소리가 들려와<br>
                        I want you Only you<br><br>
                        지금도 늦기 않았나?<br>
                        다시 네게 다가가려해<br><br>
                        변한 나의 모습이지만<br>
                        받아주겠니 I love you<br>
                        받아주겠니 I love you<br>
                        받아주겠니 I love you<br>
                        받아주겠니 I love you<br>
                        받아주겠니 I love you<br>

                    </div>

                    <div class="userinfo">
                        <div class="musictext">
                            <ul>
                                <li><span class="music_title">그냥 그저그런 노래 ..</span></li>
                                <li class="music_tag">
                                    <span class="label f_dwhite">#달콤한</span>
                                    <span class="label f_dwhite">#Classic</span>
                                    <span class="label f_dwhite">#jazz</span>
                                    <span class="label f_dwhite">#jazz</span>
                                </li>
                            </ul>
                        </div>
                    </div><!--//userinfo-->
                    <div class="btm_info" style="background: ugba(0,0,0,0)">
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/share.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/Comment.svg" class="w20px"/></a></span>
                        <span style="position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;"><a
                                    href="#"><img src="icon/Details_Content/like.svg" class="w20px"/></a></span>
                    </div>
                </div>


                <!-- Modal 앨범상세보기 호출 -->
                <div class="dynamic-popup">

                </div>
            </div><!--grid-->
        </div><!--container-->
    </div><!--#wrapper-->
    </body>
</div>