<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 2/15/17
 * Time: 1:18 PM
 */

?>
<div id="all" class="bg_black">

    <script>

        function tttest(){

                var html =  '<div class="adddata_write_input">'+
                     '<ul>'+
                        '<li>'+
                         '<input type="text" class="form-control" name="content_title"'+
                                 'placeholder="Please enter title" autocomplete="off">'+
                         '<div style="width:100%; height:auto; display:none;" id="preview-div">'+
                '<img id="preview-image" src="#"  style="height:100%;width:100%;"/>'+
                '<audio id="preview-audio" controls></audio>'+
                '</div>'+
            '<textarea id="textcontent" rows="5" onkeydown="resize(this)" onkeyup="resize(this)"'+
                'class="form-control" placeholder="show us your inspiration"'+
                'style="resize:none;" name="content_comments" autocomplete="off"></textarea>'+
                '<input type="text" class="form-control" name="hashtags" id="hashtags[]"'+
            'placeholder="Please enter title" autocomplete="off">'+
                '<input type="file" name="content_path_audio" id="file-5-audio" class="inputfile inputfile-4 f_bred"'+
            'accept="audio/mpeg3,audio/x-wav" style="display:none;"/>'+
                '<label for="file-5-audio" >'+
                '<img src="<?php echo URL ?>img/musical-note.svg" style="width:20px; height:20px;">'+
                '</label>'+

                '<input type="file" name="content_path_image" id="file-5-image" class="inputfile inputfile-4 f_bred"'+
            'accept="image/x-png,image/gif,image/jpeg" style="display:none;" />'+
                '<label for="file-5-image">'+
                '<img src="<?php echo URL ?>img/frame-landscape.svg" style="width:20px; height:20px;">'+
                '</label>'+

                '<input type="submit" id="upload-content" class="btn f_right f_bred" value="Upload" style="margin-top:20px;">'+
                '</li>'+
                '</div>';
                $("#upload-project-form").append(html);
        }

    </script>
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
                                               <button type="button" class="f_white btn btn-danger btn-sm" onclick="tttest();">add your talent to the music</button>
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
                            <span class="user" onclick="$.pagehandler.loadContent('<?php echo URL.$this->data['profile_url']?>' ,'all');"\>
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

                        <?php
                        if($this->data['content_title'] != ""){ ?>
                            <li>
                                <span class='music_title'> <?php echo $this->data['content_title']?></span>
                            </li>
                        <?php } ?>

                        <li>
                            <span>
                                <?php
                                    if($this->data['content_type_name'] == 'lyrics'){ ?>
                                        <div class='albumT'> <?php
                                            echo str_replace("\n","<br />",$this->data['content_path']);
                                            ?></div>
                                <?php } else if($this->data['content_type_name'] == 'audio'){ ?>
                                        <div class='albumA'><img src='<?php
                                            $path  = explode('/', $this->data['content_path']);
                                            $filename = explode('.', $path[3]);
                                            echo URL . "wave" . DS . $path[1] . DS . $path[2] . DS . $filename[0].".png";
                                            ?>' alt=''/></div>
                                <?php     }else if($this->data['content_type_name'] == 'image'){?>
                                        <div class='albumP'><img src='<?php echo URL.$this->data['content_path']?>' alt=''/></div>
                                <?php }?>
                            </span>
                        </li>

                        <?php
                        if($this->data['comments'] != ""){ ?>
                            <li>
                                <span class='music_name'> <?php echo $this->data['comments']?></span>
                            </li>
                        <?php } ?>

                        <?php if($this->data['comments'] != ""){ ?>
                            <li>
                                <?php
                                $hashs = explode (",", $this->data['hashtags']);
                                foreach($hashs as $tag) {
                                    echo "<span class='f_dwhite' style='margin:2px; font-size:1em; padding:0 5px 0 5px;'>$tag</span>";
                                }
                                ?>
                            </li>
                        <?php } ?>
                        <li>
                            <form id="upload-project-form" action="" method="post" enctype="multipart/form-data">
                            </form>
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
