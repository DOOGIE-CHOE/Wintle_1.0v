<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 1/28/17
 * Time: 6:45 PM
 */
?>


<div id="all">
    <body class="body_bg02 popup-background, bg_black">


    <div id="wrapper">
        <div class="container bg_black">

            <!--앨범전체 AREA-->
            <div class="grid" data-layout-mode="masonry">

            </div>
        </div>
    </div>
    </body>


    <script>
        $(function () {
            $.get("<?php echo URL?>search/searchBlocks" + window.location.search, function (o) {

                var value = jQuery.parseJSON(o);
                console.log(value);

                if (value == null) {
                    //display default image
                } else {
                    console.log(value);
                    for (var i = 0; i < value.length; i++) {
                        if (!(value[i].content_type_name == "image" || value[i].content_type_name == "lyrics")) {

                        } else {
                            var html = "<div class='grid-item'>";
                            if (value[i].profile_photo_path == null) {
                                value[i].profile_photo_path = 'img/defaultprofile.png';
                            }
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
                                "<div class='userphoto'>" +
                                "<img src='<?php echo URL?>" + value[i].profile_photo_path + "' class='img-circle'></div>" +
                                "<div class='musictext'><ul><li><span class='music_title'>" + value[i].content_title + "</span></li>" +
                                "<li><span class='music_name'>" + value[i].user_name + "</span></li>" +
                                "<li class='music_tag'>";

                            if (value[i].hashtags != null) {
                                var hsh = value[i].hashtags.split(",");
                            }

                            for (var j = 0; j < hsh.length; j++) {
                                html += "<span class='label label-primary'>" + "\#" + hsh[j] + "</span>";
                            }

                            html +=
                                "</li></ul></div></div>" + <!--userinfo-->
                                "<div class='btm_info' style='background-color : rgba(0,0,0,0)'>" + <!--공유및 종아요버튼외-->
                                "<span class='col-sm-4'><a href='#'><img src='icon/Details_Content/like_fill.svg'  class='w20px' /></a></span>" +
                                "<span class='col-sm-4'><a href='#'><img src='icon/Details_Content/Comment.svg'  class='w20px' /></a></span>" +
                                "<span class='col-sm-4'><a href='#'><img src='icon/Details_Content/share.svg'  class='w20px' /></a></span>" +
                                "</div>" +
                                "</div>";
                            $(".grid").append(html);
                        }
                    }
                }

            });
        });
    </script>
</div>

