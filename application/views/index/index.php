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
        //    $(".popup-background").on("click", "div.dynamic-popup", function (e) {
                //when the mymodal is hidden (after toggled)
            //    $('#myModal').on('hidden.bs.modal', function (e) {
                    //remove appended popup
             //       $(".dynamic-popup").empty();
             //   });
//                 var container = $("#mymodal");
//                 var block = $(".modal-dialog");
//                  clicking outside of popup
//                 if ((!container.is(e.target) && container.has(e.target).length === 0) && (!block.is(e.target) && block.has(e.target).length === 0) )
//                 {
//                    $(".pop").empty();
//                 }
            //});

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


            // to close modal window has id named playDetail by clicking background
            $('#playDetailModal').bind('click', function (e) {
                if ($(e.target).attr('class') == "view_bodyAR") {
                    var opened = $('#playDetailModal').hasClass('modal in');
                    if (opened === true) {
                        $('#playDetailModal').modal('hide');
                        var pageUrl = "<?php echo URL?>";
                        window.history.pushState({ path: pageUrl }, '', pageUrl);
                    }
                }
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
                                html += "<div class='albumP' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL.'block/'?>" + value[i].content_id + "','playDetailModal');\"><img src='" + value[i].content_path + "' alt=''/></div>";
                                <!--앨범사진-->

                                // ** path **
                                // to replace \ to /
                                //value[i].content_path = value[i].content_path.replace(/\\/g,'/');
                            } else if (value[i].content_type_name == "audio") {
                                var path = value[i].content_path;
                                path = path.split("\/");
                                var imagename = path[3].split('.');
                                var content_path = "<?php echo URL?>" + "wave/" + path[1] + "/" + path[2] + "/" + imagename[0] + ".png";
                                html += "<div class='albumA' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL.'block/'?>" + value[i].content_id + "','playDetailModal');\"><img src='" + content_path + "' alt=''/></div>";
                            }
                            else if (value[i].content_type_name == "lyrics") {
                                html += "<div class='albumT'  data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL.'block/'?>" + value[i].content_id + "','playDetailModal');\">" + value[i].content_path.replace(/\n/g, '<br />') + "</div>";
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
            $(".dynamic-popup").append(html);
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

    <div class="modal" id="playDetailModal" role="dialog">
    </div>

    <div id="wrapper">
        <div class="container bg_black">
            <!--앨범전체 AREA-->
            <div class="grid grid-main" data-layout-mode="masonry">
                <!--앨범-->

                <div class="grid-item">
                    <div class="albumP"><a href="#" data-toggle="modal" data-target="#playDetailModal"><img
                                    src="../image/p2.jpg" alt=""/></a></div>
                </div>

                <!-- Modal 앨범상세보기 호출 -->
                <div class="dynamic-popup">

                </div>
            </div><!--grid-->
        </div><!--container-->
    </div><!--#wrapper-->
    </body>

</div>