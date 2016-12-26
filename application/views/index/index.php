<div id="all">
    <script>
        $(function(){
            var wall = new Freewall(".grid");
            wall.reset({
                selector: '.grid-item',
                animate: true,
                cellW: 200,
                cellH: 'auto'
            });
            //put this instead of on load function;
            wall.fitZone(setwidthgrid(),'auto');
            $( window ).resize(function(){
                wall.fitZone(setwidthgrid(),'auto');
            });
        });


        function setwidthgrid(){
            $(".grid").width("95%");
            var $grid = $(".grid").css("width");
            var tmp = parseInt($grid);
            var w = parseInt(tmp / 210);
            var width = w * 210;
            $(".grid").css("width",width + "px");
            return width;
        }

        //put this instead of on load function;
        $.get("<?php echo URL?>index/loadNewContents/<?php echo 0?>", function(o) {
            var value = jQuery.parseJSON(o);
            if (value == null) {
                //display default image
            } else {
                for (var i = 0; i < value.length; i++) {
                    if(!(value[i].content_type_name == "image" || value[i].content_type_name == "lyrics")){

                    }else{

                        var html = "<div class='grid-item' style='height:auto;'>";
                        if(value[i].profile_photo_path == null){
                            value[i].profile_photo_path = 'img/defaultprofile.png';
                        }
                        if (value[i].content_type_name == "image") {
                            html += "<div class='albumP'><img src='" + value[i].content_path + "' alt=''/></div>"; <!--앨범사진-->

                            // ** path **
                            // to replace \ to /
                            //value[i].content_path = value[i].content_path.replace(/\\/g,'/');
                        }else if (value[i].content_type_name == "lyrics") {
                            html +="<div class='albumT'>" + value[i].content_path + "</div>"; <!--lyrics-->
                        }else{}
                        html +=
                            "<div class='userinfo'>" +
                            "<div class='userphoto'>" +
                            "<img src='"+value[i].profile_photo_path+"' class='img-circle'></div>" +
                            "<div class='musictext'><ul><li><span class='music_title'>"+value[i].content_title+"</span></li>" +
                            "<li><span class='music_name'>"+value[i].user_name+"</span></li>" +
                            "<li class='music_tag'>";

                        if(value[i].hashtags != null){
                            var hsh = value[i].hashtags.split(",");
                        }

                        for(var j = 0 ; j< hsh.length ; j++){
                            html += "<span class='label label-primary'>"+"\#"+hsh[j]+"</span>";
                        }

                        html +=
                            "</li></ul></div></div>" + <!--userinfo-->
                            "<div class='btm_info bg_beige'>" + <!--공유및 종아요버튼외-->
                            "<span class='col-sm-4'><a href='#'><img src='icon/Details_Content/like_fill.svg'  class='w20px' /></a></span>" +
                            "<span class='col-sm-4'><a href='#'><img src='icon/Details_Content/Comment.svg'  class='w20px' /></a></span>" +
                            "<span class='col-sm-4'><a href='#'><img src='icon/Details_Content/share.svg'  class='w20px' /></a></span>" +
                            "</div>" +
                            "</div>";
                        $(".grid").append(html);
                    }
                }
            }
        }).done(function(){
            var count = 0;
            var arrange = setInterval(function()
                {
                    $(window).trigger('resize'); // resize grid-item
                    count ++;
                    if(count >= 10){
                        clearInterval(arrange);
                    }
                }, 300);
        });
    </script>
    <body class="body_bg02">
    <div id="sub-header">
        <div id="container">
            <div id="subclass">
                <div><p style="border-bottom: 3px solid #ff8243; padding-bottom: 2px;" onclick="$.pagehandler.loadContent('<?php echo URL?>index','all');">All</p></div>
                <div><p onclick="$.pagehandler.loadContent('<?php echo URL?>topchart','all');">Seed</p></div>
                <div><p onclick="$.pagehandler.loadContent('<?php echo URL?>recommend','all');">Recommended</p></div>
            </div>
            aa.html
            <div id="sort">
                <!--<img src="<?php /*echo URL*/?>img/search.png" style="height:18px; right:0; margin-right:10px;">-->
                <img src="<?php echo URL?>img/filter.png" style="height:18px; right:0; margin-right:10px;">
            </div>
        </div>
    </div>


    <div id="wrapper">
        <div class="container bg_dgray">

            <!--앨범전체 AREA-->
            <div class="grid mgt_35" data-layout-mode="masonry">


                <!-- Modal 앨범상세보기 호출 -->
                <div class="modal fade " id="myModal" role="dialog">
                    <div class="modal_close" data-dismiss="modal"><a href="#" >&times;</a></div>

                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!--앨범상세 header-->
                            <div class="view_header bg_dblue">
                                <a href="#" title="상세보기" ><div class="de_view"><span class="glyphicon glyphicon-menu-right"></span></div></a>
                                <div class="album_p"><img src="image/album_p1.jpg" class="w100"></div>
                                <div class="album_con">
                                    <ul>
                                        <!--앨범사진및 공유버튼등 제공-->
                                        <li class="li_size01" >
                                            <div class="musictext w40 f_left">
                                                <ul>
                                                    <li><span class="music_name f_2">Andrew</span></li>
                                                    <li class="music_tag">
                                                        <span class="label label-primary">#한줄만</span>
                                                        <span class="label label-primary">#Classic</span>
                                                        <span class="label label-primary">#jazz</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="w60 f_left pdt_15">
                                                <div class="w70px center f_white f_08 f_left">
                                                    <a href="#" class="dpb"><img src="icon/Details_Content/like_fill.svg" class="w25px"  /></a>
                                                    <font class="clear f_brown mgt_2">like 200</font>
                                                </div>
                                                <div class="w90px center f_white f_08 f_left">
                                                    <a href="#" class="dpb"><img src="icon/Details_Content/Comment.svg" class="w25px" style="filter:invert()" /></a>
                                                    <font class="clear f_brown mgt_2">l &nbsp;&nbsp;comment 200</font>
                                                </div>
                                                <div class="w70px center f_white f_08 f_left">
                                                    <a href="#" class="dpb"><img src="icon/Details_Content/share.svg" class="w25px" style="filter:invert()"  /></a>
                                                    <font class="clear f_brown mgt_2">l &nbsp;&nbsp;share 200</font>
                                                </div>
                                            </div>
                                        </li>
                                        <!--가서정보안내-->
                                        <li class="li_size02">
                                            <div class="ofh f_08">
                                                Look at the stars,
                                                Look how they shine for you,
                                                And everything you do,
                                                Yeah they were all yellow,

                                                I came along
                                                I wrote a song for you
                                                And all the things you do
                                                And it was called yellow

                                                So then I took my turn
                                                Oh all the things I've done
                                                And it was all yellow  Look at the stars,
                                                Look how they shine for you,
                                                And everything you do,
                                                Yeah they were all yellow,

                                                I came along
                                                I wrote a song for you
                                                And all the things you do
                                                And it was called yellow

                                                So then I took my turn
                                                Oh all the things I've done
                                                And it was all yellow  Look at the stars,
                                                Look how they shine for you,
                                                And everything you do,
                                                Yeah they were all yellow,

                                                I came along
                                                I wrote a song for you
                                                And all the things you do
                                                And it was called yellow

                                                So then I took my turn
                                                Oh all the things I've done
                                                And it was all yellow
                                            </div>
                                        </li>
                                    </ul>
                                </div><!--album_con-->
                            </div><!--view_header-->

                            <!--앨범관련 커뮤니티area-->
                            <div class="view_body">
                                <!--media-->
                                <ul class="media-list">
                                    <li class="media">
                                        <div class="wrt_mem"><img class="img-circle" src="image/album_p6.jpg" style="width:55px; height:55px;"></div>
                                        <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Comment</a> / <a href="#">Edit</a></span></div>
                                        <div class="wrt_con">
                                            <span class="name">kahee</span>
                                            <span class="dpb mgt_8 pdl_15">첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다</span>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="wrt_mem"><img class="img-circle" src="image/album_p3.jpg" style="width:55px; height:55px;"></div>
                                        <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Comment</a> / <a href="#">Edit</a></span></div>
                                        <div class="wrt_con">
                                            <span class="name">kahee</span>
                                            <span class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span>
                                        </div>
                                    </li>
                                    <!--댓글-->
                                    <li class="media comment">
                                        <div class="wrt_mem"><img class="img-circle" src="image/album_p6.jpg" style="width:55px; height:55px;"></div>
                                        <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Edit</a></span></div>
                                        <div class="wrt_con">
                                            <span class="name">kahee</span>
                                            <span class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span>
                                        </div>
                                    </li>
                                    <!--댓글-->
                                    <li class="media comment">
                                        <div class="wrt_mem"><img class="img-circle" src="image/album_p3.jpg" style="width:55px; height:55px;"></div>
                                        <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Edit</a></span></div>
                                        <div class="wrt_con">
                                            <span class="name">kahee</span>
                                            <span class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span>
                                        </div>
                                    </li>
                                    <!--댓글-->
                                    <li class="media comment">
                                        <div class="wrt_mem"><img class="img-circle" src="image/album_p3.jpg" style="width:55px; height:55px;"></div>
                                        <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Edit</a></span></div>
                                        <div class="wrt_con">
                                            <span class="name">kahee</span>
                                            <span class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span>
                                        </div>
                                    </li>
                                    <!--댓글-->
                                    <li class="media comment">
                                        <div class="wrt_mem"><img class="img-circle" src="image/album_p3.jpg" style="width:55px; height:55px;"></div>
                                        <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Edit</a></span></div>
                                        <div class="wrt_con">
                                            <span class="name">kahee</span>
                                            <span class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span>
                                        </div>
                                    </li>
                                    <!--댓글-->
                                    <li class="media comment">
                                        <div class="wrt_mem"><img class="img-circle" src="image/album_p3.jpg" style="width:55px; height:55px;"></div>
                                        <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Edit</a></span></div>
                                        <div class="wrt_con">
                                            <span class="name">kahee</span>
                                            <span class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span>
                                        </div>
                                    </li>
                                </ul>
                            </div><!--view_body-->

                            <!--댓글쓰기-->
                            <div class="view_footer bg_dblue">
                                <img class="img-circle mem" src="icon/Music_pop_up/user_man.svg" style="width:55px; height:55px;">
                                <img class="wrt" src="icon/Music_pop_up/Comment.svg" style="width:30px; height:30px; filter:invert()">
                                <input class="wrt_input w70 mgl_60" type="text"  id="usr" placeholder="write...">
                            </div>

                        </div><!--modal-content-->
                    </div><!--modal-dialog-->

                    <!--각 그리드 자동 가로정렬 필요함-->
                    <script>

                        /*var tmp = parseFloat($(".albumT").css("height"));
                         console.log(tmp);
                         tmp += 500;
                         $("#lyrics").css("height",tmp + "px");
                         console.log($("#lyrics").css("height"));*/

                            /*
                             var wall = new Freewall(".grid");
                             wall.reset({
                             selector: '.grid-item',
                             animate: true,
                             cellW: 200,
                             cellH: 'auto',
                             onResize: function() {
                             wall.fitWidth();
                             }
                             });
                             //put this instead of on load function;
                             wall.fitWidth();
                             console.log(3);*/







                        /*
                         //not working i dunno why..
                         wall.container.find('.grid-item img').on('load',function() {
                         wall.fitWidth();
                         });
                         */

                    </script>
                </div><!--modal-->
            </div><!--grid-->
        </div><!--container-->
    </div><!--#wrapper-->
    </body>
</div>