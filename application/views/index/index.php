<div id="all">
    <script>
        var offset = 0;
        var flag = true;   //job flag

        $(function () {
            if (flag) {
                flag = false;
                loadNewContent();
            }
            $(window).scroll(function () {
                // do whatever you need here.
                if ($(window).scrollTop() > $('.grid').height() - 1050 && flag == true) {
                    flag = false;    // wait until the job is done
                    loadNewContent(); // call loading card function

                }

            });
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

        function loadNewContent() {
            //put this instead of on load function;
            $.get("<?php echo URL?>viewlist/loadNewContents/" + offset + "/20", function (o) {
                offset += 20;
                var value = jQuery.parseJSON(o);
                console.log(value);
                if (value == null) {
                    //display default image
                } else {
                    for (var i = 0; i < value.length; i++) {
                        if (!(value[i].content_type_name == "image" || value[i].content_type_name == "lyrics" || value[i].content_type_name == "audio")) {
                            //if the content is not inmage or lyrics or audio
                        } else {
                            if (value[i].profile_photo_path == null) {
                                value[i].profile_photo_path = 'img/defaultprofile.png';
                            }

                            var html = "<div class='grid-item'>" +
                                "<div class='user' onclick=\"$.pagehandler.loadContent('<?php echo URL?>" + value[i].profile_url + "','all');\" >" +
                                "<div class='userphoto'>" +
                                "<img src='<?php echo URL?>" + value[i].profile_photo_path + "' class='img-circle'>" +
                                "</div>" +
                                "<div class='musictext'>" +
                                "<ul>" +
                                "<li><span class='music_name'>" + value[i].user_name + "</span></li>" +
                                "</ul></div></div>";
                            if (value[i].content_type_name == "image") {
                                html += "<div class='albumP'><img src='" + value[i].content_path + "' alt=''/></div>";
                                <!--앨범사진-->

                                // ** path **
                                // to replace \ to /
                                //value[i].content_path = value[i].content_path.replace(/\\/g,'/');
                            } else if (value[i].content_type_name == "audio") {
                                var path = value[i].content_path;
                                path = path.split("\/");
                                var imagename = path[3].split('.');
                                var content_path = "<?php echo URL?>" + "wave/" + path[1] + "/" + path[2] + "/" + imagename[0] + ".png";
                                html += "<div class='albumA'><img src='" + content_path + "' alt=''/></div>";
                            }
                            else if (value[i].content_type_name == "lyrics") {
                                html += "<div class='albumT'>" + value[i].content_path.replace(/\n/g, '<br />') + "</div>";
                                <!--lyrics-->
                            } else {
                            }
                            html +=
                                "<div class='userinfo'>" +
                                "<div class='musictext'><ul>" +
                                "<li><span class='music_title'>" + value[i].content_title + "</span></li>" +
                                "<li><span class='music_name'>" + value[i].comments + "</span></li>" +
                                "<li class='music_tag'>";
                            if (value[i].hashtags != null) {
                                var hsh = value[i].hashtags.split(",");
                            }

                            for (var j = 0; j < hsh.length; j++) {
                                html += "<span class='label f_dwhite'>" + hsh[j] + "</span>";
                            }


                            html +=
                                "</li></ul></div></div>" + <!--userinfo-->

                                "<div class='btm_info'>" +
                                "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                                "<a href='#'><img src='<?php echo URL?>icon/Details_Content/share.svg' class='w20px'/></a></span>" +
                                "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                                "<a href='#'><img src='<?php echo URL?>icon/Details_Content/Comment.svg' class='w20px'/></a></span>" +
                                "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                                "<a href='#'><img src='<?php echo URL?>icon/Details_Content/like.svg' class='w20px'/></a></span>" +
                                "</div>";
                            $(".grid-main").append(html);
                        }
                    }
                }
            }).done(function () {
                var count = 0;
                var arrange = setInterval(function () {
                    $(window).trigger('resize'); // resize grid-item
                    count++;
                    if (count >= 5) {
                        clearInterval(arrange);
                        flag = true; // the job is done
                    }
                }, 300);

            });
        }


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
            <div class="grid grid-main" data-layout-mode="masonry">
                <!--앨범-->

                <div class="grid-item">
                    <div class="albumP"><a href="#" data-toggle="modal" data-target="#playDetail"><img
                                    src="../image/p2.jpg" alt=""/></a></div>
                </div>


                <div class="modal" id="playDetail" role="dialog">

                    <div class="view_header_fix" style=" text-align:center">
                        <div class="modal_close" data-dismiss="modal"><a href="#">&times;</a></div>
                        <div class="view_header_fix_top">
                            <ul>
                                <li class="bg_grayDark ofh ">
                                    <span class="icon">
                                        <a href="#">
                                            <img src="../icon/Details_Content/like.svg"
                                                                         style="filter:invert()"/>
                                        </a> <a href="#">
                                            <img
                                                    src="../icon/Music_pop_up/list.svg" style="filter:invert()"/>
                                        </a> <a href="#">
                                            <img src="../icon/Details_Content/share.svg"
                                                              style="filter:invert()"/>
                                        </a>
                                    </span>
                                    <span class="btn">
                                               <button type="button" class="f_white btn btn-danger btn-sm">add your talent to the music</button>
                                    </span>
                                </li>
                            </ul>
                        </div><!--view_header_fix_top-->
                    </div><!--view_header_fix-->


                    <!--1앨범상세 header-->
                    <div class="view_bodyAR">
                        <div class="modal-content">

                            <!--2앨범관련 커뮤니티area-->
                            <div class="view_body_fix" style="padding-top:100px;">

                                <!--앨범사진외 -->
                                <ul class="userinfo">
                                    <li> <span class="user">
              <div class="userP"><img src="../image/p1.jpg" class="img-circle"></div>
              <div class="userN">Andrew</div>
              <div class="userT">눈물과 비</div>
              </span> <span class="icon"> <a href="#"><img src="../icon/Details_Content/like.svg"
                                                           style="filter:invert()"/></a> <a href="#"><img
                                                        src="../icon/Music_pop_up/list.svg"
                                                        style="filter:invert()"/></a> <a href="#"><img
                                                        src="../icon/Details_Content/share.svg"
                                                        style="filter:invert()"/></a> </span></li>
                                    <li><span><img src="../image/album_p2.jpg" class="albumIMG"/></span> <span><font
                                                    class="f_right f_gray mgt_10">2017/01/01(20:00)</font></span></li>
                                </ul>

                                <!--media-->
                                <ul class="media-list">
                                    <p class="comment_title"><img src="../icon/Music_pop_up/Comment.svg"> Comment <font
                                                class="f_075">9</font><span><a href="#">More</a></span></p>
                                    <li class="media">
                                        <div class="wrt_mem"><img class="img-circle" src="../image/album_p6.jpg"
                                                                  style="width:55px; height:55px;"></div>
                                        <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Comment</a> / <a
                                                        href="#">Edit</a></span></div>
                                        <div class="wrt_con"><span class="name">kahee</span> <span
                                                    class="dpb mgt_8 pdl_15">첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다</span>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="wrt_mem"><img class="img-circle" src="../image/album_p3.jpg"
                                                                  style="width:55px; height:55px;"></div>
                                        <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Comment</a> / <a
                                                        href="#">Edit</a></span></div>
                                        <div class="wrt_con"><span class="name">kahee</span> <span
                                                    class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span></div>
                                    </li>
                                    <!--댓글-->
                                    <li class="media comment">
                                        <div class="wrt_mem"><img class="img-circle" src="../image/album_p6.jpg"
                                                                  style="width:55px; height:55px;"></div>
                                        <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Edit</a></span>
                                        </div>
                                        <div class="wrt_con"><span class="name">kahee</span> <span
                                                    class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span></div>
                                    </li>
                                </ul>
                            </div>
                            <!--view_body_fix-->

                            <!--3댓글쓰기-->
                            <div class="view_footer bg_dblue">
                                <img class="img-circle mem" src="../icon/Music_pop_up/user_man.svg"
                                     style="width:55px; height:55px;">
                                <img class="wrt" src="../icon/Music_pop_up/Comment.svg"
                                     style="width:30px; height:30px; filter:invert()">
                                <input class="wrt_input" type="text" id="usr" placeholder="write...">
                            </div>
                        </div><!--modal-content-->


                        <div class="container mgb_100">

                            <div class="playgroupAR">
                                <div class="playlistAR">
                                    <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img
                                                src="../image/album_p2.jpg" class="album2"> <img
                                                src="../image/album_p3.jpg" class="album3"> <img
                                                src="../image/album_p4.jpg" class="album4"></div>
                                    <div class="playgroupTitle"><span class="left f500 f_1-3">Funky</span> <span><font
                                                    class="f_left f_09">8</font><font
                                                    class="label label-danger f_right"><a
                                                        href="#">edit</a></font></span></div>
                                </div>
                            </div>
                            <!--playgroupAR-->
                            <div class="playgroupAR">
                                <div class="playlistAR">
                                    <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img
                                                src="../image/album_p1.jpg" class="album2"> <img
                                                src="../image/album_p1.jpg" class="album3"> <img
                                                src="../image/album_p1.jpg" class="album4"></div>
                                    <div class="playgroupTitle"><span class="left f500 f_1-3">Funky</span> <span><font
                                                    class="f_left">8</font><font
                                                    class="label label-danger f_right">edit</font></span></div>
                                </div>
                            </div>
                            <!--playgroupAR-->
                            <div class="playgroupAR">
                                <div class="playlistAR">
                                    <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img
                                                src="../image/album_p1.jpg" class="album2"> <img
                                                src="../image/album_p1.jpg" class="album3"> <img
                                                src="../image/album_p1.jpg" class="album4"></div>
                                    <div class="playgroupTitle"><span class="left f500 f_1-3">재미있는노래</span> <span><font
                                                    class="f_left">8</font><font
                                                    class="label label-danger f_right">edit</font></span></div>
                                </div>
                            </div>
                            <!--playgroupAR-->
                            <div class="playgroupAR">
                                <div class="playlistAR">
                                    <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img
                                                src="../image/album_p1.jpg" class="album2"> <img
                                                src="../image/album_p1.jpg" class="album3"> <img
                                                src="../image/album_p1.jpg" class="album4"></div>
                                    <div class="playgroupTitle"><span class="left f500 f_1-3">피아노가좋은곡</span> <span><font
                                                    class="f_left">8</font><font
                                                    class="label label-danger f_right">edit</font></span></div>
                                </div>
                            </div>
                            <!--playgroupAR-->
                            <div class="playgroupAR">
                                <div class="playlistAR">
                                    <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img
                                                src="../image/album_p1.jpg" class="album2"> <img
                                                src="../image/album_p1.jpg" class="album3"> <img
                                                src="../image/album_p1.jpg" class="album4"></div>
                                    <div class="playgroupTitle"><span class="left f500 f_1-3">피아노가좋은곡</span> <span><font
                                                    class="f_left">8</font><font
                                                    class="label label-danger f_right">edit</font></span></div>
                                </div>
                            </div>
                            <!--playgroupAR-->
                            <div class="playgroupAR">
                                <div class="playlistAR">
                                    <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img
                                                src="../image/album_p1.jpg" class="album2"> <img
                                                src="../image/album_p1.jpg" class="album3"> <img
                                                src="../image/album_p1.jpg" class="album4"></div>
                                    <div class="playgroupTitle"><span class="left f500 f_1-3">피아노가좋은곡</span> <span><font
                                                    class="f_left">8</font><font
                                                    class="label label-danger f_right">edit</font></span></div>
                                </div>
                            </div>
                            <!--playgroupAR-->

                        </div><!--view_bodyAR-->
                    </div><!--modal-->


                    <!-- Modal 앨범상세보기 호출 -->
                    <div class="dynamic-popup">

                    </div>
                </div><!--grid-->
            </div><!--container-->
        </div><!--#wrapper-->
    </body>
</div>