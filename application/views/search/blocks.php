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
            <div class="grid grid-search" data-layout-mode="masonry">

            </div>
        </div>
    </div>
    </body>


    <script>
        var offset = 0;
        var flag = true;   //job flag
        var url;
        var gets;
        $(function () {
            url = window.location.href;
            gets = url.substring(url.indexOf("?") + 1);
            gets = gets.replace(/#/gi, '%23');
            $.get("<?php echo URL?>search/searchBlocks?" + gets, function (o) {
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
                                html += "<div class='albumP'><img src='<?php echo URL?>" + value[i].content_path + "' alt=''/></div>";
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
                            $(".grid-search").append(html);
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

        });


    </script>
</div>

