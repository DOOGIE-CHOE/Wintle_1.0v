<div id="all">

<!--    <script src="//cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.0.52/wavesurfer.min.js"></script>-->
    <script>
        var limit = 3;
        var offset = 0;
        var flag = true;   //job flag
        var wall;
        var wavesurfer;

        var sample1;

        $(function () {
            sample1 = Object.create(WaveSurfer);
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
            wall = new Freewall(".grid");
            wall.reset({
                selector: '.grid-item',
                animate: true,
                cellW: 400,
                cellH: 'auto',
                gutterX: 25,
                gutterY: 25
            });
            //put this instead of on load function;

            wall.fitZone(setwidthgrid(), 'auto');
            $(window).resize(function () {
                console.log("resized");
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
                        window.history.pushState({path: pageUrl}, '', pageUrl);
                    }
                }
            });

        });

        function setwidthgrid() {
            $(".grid").width("90%");
            var $grid = $(".grid").css("width");
            var tmp = parseInt($grid);
            //     var w;
            var width;
            if (tmp >= 1250) {
                //  w = parseInt(tmp / 400);
                width = (3 * 400);
            } else if (tmp <= 1100 && tmp >= 850) {
                width = (2 * 400);
            } else if (tmp < 850) {
                width = 400;
            }


            $(".grid").css("width", width + "px");
            //   return width;
        }

        function loadNewContent() {
            //put this instead of on load function;
            $.get("<?php echo URL?>viewlist/loadNewContents/" + limit + "/" + offset, function (o) {
                    limit = 3;
                    offset += 3;

                    var value = jQuery.parseJSON(o);
                    console.log(value);
                    if (value == null) {
                        //display default image
                    } else {
                        for (var i = 0; i < value.length; i++) {
                            if (value[i].constructor === Array) {

                                displayProjectSimple(value[i][value[i].length - 1], value[i].length);
                            } else {
                                displayContent(value[i]);
                            }
                        }
                    }

                }
            ).done(function () {
                //console.log("#waveform-" + waveSequence);

                var list = [];

                for (var i = 0; i < waveSequence; i++) {

//                    var wavesurfer = WaveSurfer.create({
//                        waveColor: '#0074d9',
//                        barWidth: 5,
//                        height: 200,
//                        interact: false,
//                        container: "#waveform-" + i
//                    });
//                    wavesurfer.load(path[i]);
                    //wavesurfer.destroy();


//
//                    var tmp = Object.create(WaveSurfer);
//                    var options = {
//                        waveColor: '#0074d9',
//                        barWidth: 5,
//                        height: 200,
//                        interact: false,
//                        container:"#waveform-" + i
//                    };
//                    console.log(options);
//                    tmp.init(options);
//                    list.push(wavesurfer);

//
//                    var wavesurfer = Object.create(WaveSurfer);
//                    wavesurfer.init({
//                        waveColor: '#0074d9',
//                        barWidth: 5,
//                        height: 200,
//                        interact: false,
//                        container:"#waveform-" + i
//                    });
//                    wavesurfer.load(path[i]);
                    //wavesurfer.destroy();

                  //  list.push(wavesurfer);

                }
//
//                $.each(list, function () {
//                    this.load(path[1]);
//                });


                setTimeout(function () {
                    $(window).trigger('resize'); // resize grid-item
                    flag = true; // the job is done
                }, 50);

            });
        }

        var allwave = [];
        function testwaveform(parentSelector){
            console.log(1);
//            var domEl = document.createElement('div');
//            document.querySelector(parentSelector).appendChild(domEl);

            var wavesurfer = WaveSurfer.create({
                container: parentSelector,
                waveColor: 'red',
                progressColor: 'purple',
                hideScrollbar: true
            });
//            wavesurfer.load(url);
//
//
//            var wavesurfer = Object.create(WaveSurfer);
//            wavesurfer.init({
//                waveColor: '#0074d9',
//                barWidth: 5,
//                height: 200,
//                interact: false,
//                container:"#waveform-0"
//            });
            var tmp = '<?php echo URL?>';
            console.log(tmp + path[0]);
            wavesurfer.load(tmp+path[0]);
            allwave.push(wavesurfer);
            //return wavesurfer;

        }

        var waveSequence = 0;
        var path = [];
        function displayContent(content) {
            if (content == null) {

            }
            else {
                if (content.profile_photo_path == null) {
                    content.profile_photo_path = 'img/defaultprofile.png';
                }

                var html = "<div class='grid-item'>" +
                    "<div class='user' onclick=\"$.pagehandler.loadContent('<?php echo URL?>" + content.profile_url + "','all');\" >" +
                    "<div class='userphoto'>" +
                    "<img src='<?php echo URL?>" + content.profile_photo_path + "' class='img-circle'>" +
                    "</div>" +
                    "<div class='musictext'>" +
                    "<ul>" +
                    "<li><span class='user_name'>" + content.user_name + "</span></li>" +
                    "</ul></div></div>";

                if (content.content_title != "" && content.content_title != null)
                    html += "<div class='albumTitle'  data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + content.content_id + "','playDetailModal');\"><span class='music_name'>" + content.content_title + "</span></div>";
                if (content.content_type_name == "image") {
                    html += "<div class='albumP' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + content.content_id + "','playDetailModal');\"><img src='" + content.content_path + "' alt=''/></div>";


                    <!--앨범사진-->

                    // ** path **
                    // to replace \ to /
                    //content.content_path = content.content_path.replace(/\\/g,'/');
                } else if (content.content_type_name == "audio") {
//                    var path = content.content_path;
//                    path = path.split("\/");
//                    var imagename = path[3].split('.');
//                    var content_path = "<?php //echo URL?>//" + "wave/" + path[1] + "/" + path[2] + "/" + imagename[0] + ".png";

//                    html += "<div class='albumA' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php //echo URL . 'block/'?>//" + content.content_id + "','playDetailModal');\"><img src='" + content_path + "' alt=''/></div>";


                    html += "<div class='albumA' id='waveform-"+ waveSequence +"' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + content.content_id + "','playDetailModal');\"></div>";
                    path.push(content.content_path);
                }

                if (content.comments != "" && content.comments != null) {
                    html += "<div class='albumT' style='font-size:1em; color:white;' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + content.content_id + "','playDetailModal');\"><span class='text'>" + content.comments.replace(/\n/g, '<br />') + "</span></div>";
                }


                html +=
                    "" +
                    "" +
                    "<div class='music_tag'>";
                if (content.hashtags != null) {
                    var hsh = content.hashtags.split(",");
                    for (var j = 0; j < hsh.length; j++) {
                        html += "<span class='label'>" + hsh[j] + "</span>";
                    }
                }

                html +=
                    "</div>" + <!--userinfo-->

                    "<div class='btm_info'>" +
                    "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                    "<a href='#'><img src='<?php echo URL?>icon/Details_Content/share.svg' class='w20px'/></a></span>" +
                    "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                    "<a href='#'><img src='<?php echo URL?>icon/Music_pop_up/list.svg' class='w20px'/></a></span>" +
                    "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                    "<a href='#'><img src='<?php echo URL?>icon/Details_Content/star.svg' class='w20px'/></a></span>" +
                    "</div>";

                wall.appendBlock(html);

                // $(".grid-main").append(html);
            }

            var wavesurfer = WaveSurfer.create({
                container: '#waveform-0',
                waveColor: 'red',
                progressColor: 'purple',
                hideScrollbar: true
            });
//            wavesurfer.load(url);
//
//
//            var wavesurfer = Object.create(WaveSurfer);
//            wavesurfer.init({
//                waveColor: '#0074d9',
//                barWidth: 5,
//                height: 200,
//                interact: false,
//                container:"#waveform-0"
//            });
            var tmp = '<?php echo URL?>';
            console.log(tmp + path[0]);
            wavesurfer.load(tmp+path[0]);
            allwave.push(wavesurfer);
            //return wavesurfer;

//            if (content.content_type_name == "audio") {
//                var container = '#waveform-' + waveSequence++;
//                console.log(container);
//                var wavesurfer = WaveSurfer.create({
//                    waveColor: '#0074d9',
//                    barWidth: 5,
//                    height: 200,
//                    interact: false,
//                    container:container
//                }).load(content.content_path);
//             //   wavesurfer.container = container;
//                wavesurfer.destroy();
//                console.log(wavesurfer);
//
//            }
        }


        function displayProjectSimple(content, number) {
            if (content == null) {

            }
            else {
                if (content.profile_photo_path == null) {
                    content.profile_photo_path = 'img/defaultprofile.png';
                }

                var html = "<div class='grid-item'>" +
                    "<div class='user' onclick=\"$.pagehandler.loadContent('<?php echo URL?>" + content.profile_url + "','all');\" >" +
                    "<div class='userphoto'>" +
                    "<img src='<?php echo URL?>" + content.profile_photo_path + "' class='img-circle'>" +
                    "</div>" +
                    "<div class='musictext'>" +
                    "<ul>" +
                    "<li><span class='user_name'>" + content.user_name + "</span> <span class='project-number'>" + number + "</span></li>" +
                    "</ul></div></div>";

                if (content.content_title != "" && content.content_title != null)
                    html += "<div class='albumTitle' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + content.project_id + "','playDetailModal');\"><span class='music_name'>" + content.content_title + "</span></div>";
                if (content.content_type_name == "image") {
                    html += "<div class='albumP' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + content.project_id + "','playDetailModal');\"><img src='" + content.content_path + "' alt=''/></div>";
                    <!--앨범사진-->

                    // ** path **
                    // to replace \ to /
                    //content.content_path = content.content_path.replace(/\\/g,'/');
                } else if (content.content_type_name == "audio") {
//                    var path = content.content_path;
//                    path = path.split("\/");
//                    var imagename = path[3].split('.');
//                    var content_path = "<?php //echo URL?>//" + "wave/" + path[1] + "/" + path[2] + "/" + imagename[0] + ".png";
//                    html += "<div class='albumA' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php //echo URL . 'block/'?>//" + content.project_id + "','playDetailModal');\"><img src='" + content_path + "' alt=''/></div>";
                    html += "<div class='albumA' id='waveform-"+ waveSequence +"' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + content.project_id + "','playDetailModal');\"></div>";
                    path.push(content.content_path);
                }

                if (content.comments != "" && content.comments != null) {
                    html += "<div class='albumT' style='font-size:1em; color:white;' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + content.project_id + "','playDetailModal');\"><span class='text'>" + content.comments.replace(/\n/g, '<br />') + "</span></div>";
                }

                <!--lyrics-->


                html +=
                    "<div class='music_tag'>";
                if (content.hashtags != null) {
                    var hsh = content.hashtags.split(",");
                    for (var j = 0; j < hsh.length; j++) {
                        html += "<span class='label'>" + hsh[j] + "</span>";
                    }
                }

                html +=
                    "</div>" + <!--userinfo-->
                    "<div class='btm_info'>" +
                    "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                    "<a href='#'><img src='<?php echo URL?>icon/Details_Content/share.svg' class='w20px'/></a></span>" +
                    "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                    "<a href='#'><img src='<?php echo URL?>icon/Music_pop_up/list.svg' class='w20px'/></a></span>" +
                    "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                    "<a href='#'><img src='<?php echo URL?>icon/Details_Content/star.svg' class='w20px'/></a></span>" +
                    "</div>";

                wall.appendBlock(html);

                var wavesurfer = WaveSurfer.create({
                    container: '#waveform-0',
                    waveColor: 'red',
                    progressColor: 'purple',
                    hideScrollbar: true
                });
//            wavesurfer.load(url);
//
//
//            var wavesurfer = Object.create(WaveSurfer);
//            wavesurfer.init({
//                waveColor: '#0074d9',
//                barWidth: 5,
//                height: 200,
//                interact: false,
//                container:"#waveform-0"
//            });
                var tmp = '<?php echo URL?>';
                console.log(tmp + path[0]);
                wavesurfer.load(tmp+path[0]);
                allwave.push(wavesurfer);
                //$(".grid-main").append(html);
//                if (content.content_type_name == "audio") {
//                    var container = '#waveform-' + waveSequence++;
//                    console.log(container);
//
//                    var sample1 = Object.create(WaveSurfer);
//
//                    var options = {
//                        waveColor: '#0074d9',
//                        barWidth: 5,
//                        height: 200,
//                        interact: false,
//                        container:container
//                    };
//
//                    sample1.init(options);
//
//                    sample1.load(content.content_path);
//                }
               // testwaveform('#waveform-'+waveSequence++);
            }
        }

        function displayProject(project) {
            // var lastContentUpload = project[project.length-1];
            var lastContentUpload = project;
            if (lastContentUpload != null) {
                if (lastContentUpload.profile_photo_path == null) {
                    lastContentUpload.profile_photo_path = 'img/defaultprofile.png';
                }

                var html = "<div class='grid-item'>" +
                    "<div class='user' onclick=\"$.pagehandler.loadContent('<?php echo URL?>" + lastContentUpload.profile_url + "','all');\" >" +
                    "<div class='userphoto'>" +
                    "<img src='<?php echo URL?>" + lastContentUpload.profile_photo_path + "' class='img-circle'>" +
                    "</div>" +
                    "<div class='musictext'>" +
                    "<ul>" +
                    "<li><span class='user_name'>" + lastContentUpload.user_name + "</span></li>" +
                    "</ul></div></div>";

                if (lastContentUpload.content_title != "" && lastContentUpload.content_title != null)
                    html += "<div  style='font-size:0.9em;padding:10px 13px 10px 13px; color:white; border-bottom:1px solid #eeeeee' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + lastContentUpload.project_id + "','playDetailModal');\"><span class='music_name'>" + lastContentUpload.content_title + "</span></div>";


                for (var i = 0; i < project.length; i++) {

                    if (project[i].content_type_name == "image") {
                        html += "<div class='albumP' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + project[i].project_id + "','playDetailModal');\"><img src='" + project[i].content_path + "' alt=''/></div>";
                        <!--앨범사진-->

                        // ** path **
                        // to replace \ to /
                        //content.content_path = content.content_path.replace(/\\/g,'/');
                    } else if (project[i].content_type_name == "audio") {
//                        var path = project[i].content_path;
//                        path = path.split("\/");
//                        var imagename = path[3].split('.');
//                        var content_path = "<?php //echo URL?>//" + "wave/" + path[1] + "/" + path[2] + "/" + imagename[0] + ".png";
//                        html += "<div class='albumA' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php //echo URL . 'block/'?>//" + project[i].project_id + "','playDetailModal');\"><img src='" + content_path + "' alt=''/></div>";
                        html += "<div class='albumA' id='waveform-" + waveSequence + "' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + project[i].project_id + "','playDetailModal');\"></div>";

                    }
                    if (project[i].comments != "" && project[i].comments != null) {
                        html += "<div class='albumT' style='font-size:1.1em; color:white;' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent('<?php echo URL . 'block/'?>" + project[i].project_id + "','playDetailModal');\"><span class='text'>" + project[i].comments.replace(/\n/g, '<br />') + "</span></div>";
                    }


                }


                html +=
                    "<div class='music_tag'>";
                if (lastContentUpload.hashtags != null) {
                    var hsh = lastContentUpload.hashtags.split(",");
                    for (var j = 0; j < hsh.length; j++) {
                        html += "<span class='label'>" + hsh[j] + "</span>";
                    }
                }


                html +=
                    "</div>" + <!--userinfo-->

                    "<div class='btm_info'>" +
                    "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                    "<a href='#'><img src='<?php echo URL?>icon/Details_Content/share.svg' class='w20px'/></a></span>" +
                    "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                    "<a href='#'><img src='<?php echo URL?>icon/Music_pop_up/list.svg' class='w20px'/></a></span>" +
                    "<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:15.33333333%;'>" +
                    "<a href='#'><img src='<?php echo URL?>icon/Details_Content/star.svg' class='w20px'/></a></span>" +
                    "</div>";
                $(".grid-main").append(html);


            }

        }
    </script>
    <body class="body_bg02 popup-background, bg_deepgray">

    <div class="modal" id="playDetailModal" role="dialog">
    </div>
    <div class='albumA' id='waveform'></div>

    <div id="wrapper">
        <div class="container bg_deepgray">
            <!--앨범전체 AREA-->
            <div class="grid grid-main" data-layout-mode="masonry">
                <!--앨범-->
            </div>
        </div><!--grid-->
    </div><!--container-->
</div><!--#wrapper-->

</body>

</div>
