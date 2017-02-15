<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 2/15/17
 * Time: 1:18 PM
 */

?>

<script>
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

</script>


<div id="all" class="bg_black">
    <div>
        <div class="view_header_fix" style=" text-align:center">
            <!--            <div class="modal_close" data-dismiss="modal"><a href="#">&times;</a></div>-->
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
                        <li>
                            <span class="user">
                                <div class="userP">
                                    <img src="../image/p1.jpg" class="img-circle">
                                </div>
                                <div class="userN">
                                    <?php echo $this->data['user_name'] ?>
                                </div>
                            </span>
                            <span class="icon">
                                <a href="#"><img src="<?php echo URL?>icon/Details_Content/like.svg" style="filter:invert()"/></a>
                                <a href="#"><img src="<?php echo URL?>icon/Music_pop_up/list.svg" style="filter:invert()"/></a>
                                <a href="#"><img src="../icon/Details_Content/share.svg" style="filter:invert()"/></a>
                            </span>
                        </li>
                        <li>
                            <span>
                                <?php
                                    if($this->data['content_type_name'] == 'lyrics'){ ?>
                                        <div class='albumT'> <?php
                                            echo str_replace("\n","<br />",$this->data['content_path']);
                                            ?></div>
                                <?php } else if($this->data['content_type_name'] == 'audio'){ ?>
                                        <div class='albumA'><img src='<?php echo URL.$this->data['content_path']?>' alt=''/></div>
                                <?php     }else if($this->data['content_type_name'] == 'image'){?>
                                        <div class='albumP'><img src='<?php echo URL.$this->data['content_path']?>' alt=''/></div>
                                <?php }?>
                            </span>
                        </li>
                        <li>
                            <span class='music_title'><?php echo $this->data['content_title']?></span>
                        </li>
                        <li>
                            <span class='music_name'><?php echo $this->data['comments']?></span>
                        </li>
                        <li>
                            <?php
                                $hashs = explode (",", $this->data['hashtags']);
                                foreach($hashs as $tag) {
                                    echo "<span class='label f_dwhite'>$tag</span>";
                                }
                            ?>
                        </li>
                    </ul>



                    <!--media-->
                    <!--                    <ul class="media-list">-->
                    <!--                        <p class="comment_title"><img src="../icon/Music_pop_up/Comment.svg"> Comment <font-->
                    <!--                                    class="f_075">9</font><span><a href="#">More</a></span></p>-->
                    <!--                        <li class="media">-->
                    <!--                            <div class="wrt_mem"><img class="img-circle" src="../image/album_p6.jpg"-->
                    <!--                                                      style="width:55px; height:55px;"></div>-->
                    <!--                            <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Comment</a> / <a-->
                    <!--                                            href="#">Edit</a></span></div>-->
                    <!--                            <div class="wrt_con"><span class="name">kahee</span> <span-->
                    <!--                                        class="dpb mgt_8 pdl_15">첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다</span>-->
                    <!--                            </div>-->
                    <!--                        </li>-->
                    <!--                        <li class="media">-->
                    <!--                            <div class="wrt_mem"><img class="img-circle" src="../image/album_p3.jpg"-->
                    <!--                                                      style="width:55px; height:55px;"></div>-->
                    <!--                            <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Comment</a> / <a-->
                    <!--                                            href="#">Edit</a></span></div>-->
                    <!--                            <div class="wrt_con"><span class="name">kahee</span> <span-->
                    <!--                                        class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span></div>-->
                    <!--                        </li>-->
                    <!--                        <!--댓글-->
                    <!--                        <li class="media comment">-->
                    <!--                            <div class="wrt_mem"><img class="img-circle" src="../image/album_p6.jpg"-->
                    <!--                                                      style="width:55px; height:55px;"></div>-->
                    <!--                            <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Edit</a></span>-->
                    <!--                            </div>-->
                    <!--                            <div class="wrt_con"><span class="name">kahee</span> <span-->
                    <!--                                        class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span></div>-->
                    <!--                        </li>-->
                    <!--                    </ul>-->
                </div>
                <!--view_body_fix-->

                <!--3댓글쓰기-->
                <!--                <div class="view_footer bg_dblue">-->
                <!--                    <img class="img-circle mem" src="../icon/Music_pop_up/user_man.svg"-->
                <!--                         style="width:55px; height:55px;">-->
                <!--                    <img class="wrt" src="../icon/Music_pop_up/Comment.svg"-->
                <!--                         style="width:30px; height:30px; filter:invert()">-->
                <!--                    <input class="wrt_input" type="text" id="usr" placeholder="write...">-->
                <!--                </div>-->
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

    </div>
</div>
