<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 1/28/17
 * Time: 6:45 PM
 */
?>


<div id="all">
    <script>
        var offset_search = 0;
        var limit = 3;
        var flag_search = true;   //job flag
        var url;
        var gets;
        var blockwidth;

        $(function () {
            //GET 으로 얻은 해쉬테그 문자열 처리
            url = window.location.href;
            gets = url.substring(url.indexOf("?") + 1);
            gets = gets.replace(/#/gi, '%23');

            if (flag_search) {
                flag_search = false;
                loadSearchContent();

            }

            //스크롤 높이에 따른 추가 콘텐츠 로드
            $(window).bind('scroll',function () {
                // do whatever you need here.
                if (document.body.scrollHeight - $(window).scrollTop() < $(window).height() + 300 && flag_search == true) {
                    flag_search = false;    // wait until the job is done
                    loadSearchContent(); // call loading card function
                }
            });


            // 반응형 웹 구현을 위한 부분
            // 전체 해상도를 가지고 온 다음 각 블록(컨텐츠)의 최대 해상도인 width 400 이상인지 이하인지
            // 파악 한 뒤, 400이상이면 최대치인 width:400px 를 사용하며, 그 이하면 해당 해상도에 맞게 블록 크기 설정
            var screenWidth = window.screen.availWidth;
            var margin;

            if(screenWidth <= 400){
                blockwidth = screenWidth;
                //여기서 -20 을 해주는 이유는 margin이 좌/우 측으로 10씩 들어가기 때문
                blockwidth -= 20;
                margin = 10;
            }else{
                blockwidth = 400;
                // margin 크기만큼 - 를 해주지 않는 이유는 스크린이 블록 최대치인 400px 보다 크기 때문
                margin  = 25;
            }

            wall = new Freewall(".grid");
            wall.reset({
                selector: '.grid-item',
                animate: true,
                cellW: blockwidth,
                cellH: 'auto',
                gutterX: margin,
                gutterY: margin
            });
            //put this instead of on load function;

            wall.fitZone(setwidthgrid(blockwidth), 'auto');
//            $(window).resize(function () {
//                wall.fitZone(setwidthgrid(blockwidth), 'auto');
//            });

            //팝업창 바깥부분 클릭 시 페이지 뒤로 돌아가기 수행
            $('#playDetailModal').on('click', function (e) {
                if ($(e.target).attr('class') == "view_bodyAR") {
                    var opened = $('#playDetailModal').hasClass('modal in');
                    if (opened === true) {
                        window.history.back();
                    }
                }
            });

        });

        function loadSearchContent(){
            $.get("<?php echo URL?>search/searchBlocks/"+ limit + "/" + offset_search + "?"+ gets, function (o) {
                var value = jQuery.parseJSON(o);
                offset_search += 3;
                if (value == null) {
                    //display default image
                } else {
                    for (var i = 0; i < value.length; i++) {
                        displayContent(value[i],".grid-search", "freewall");
                    }
                }
            }).done(function () {
                var interval = setInterval(function () {
                    wall.fitZone(setwidthgrid(blockwidth), 'auto');
                    clearInterval(interval);
                },300);
                var interval_load = setInterval(function () {
                    flag_search = true; // the job is done
                    clearInterval(interval_load);
                },1000);
            });
        }

        function setwidthgrid(blocksize) {
            var $grid = $(".grid").css("width");
            var tmp = parseInt($grid);
            var blocknum = tmp / blocksize;

            blocknum = parseInt(blocknum);
            blocknum = (blocknum == 0) ? 1 : blocknum;
            var gridwidth = blocksize * blocknum;
            $(".grid-search").css("width", gridwidth + "px");

            return gridwidth;

        }

//        function setwidthgrid() {
//            $(".grid").width("100%");
//            var $grid = $(".grid").css("width");
//            var tmp = parseInt($grid);
//            console.log(tmp);
//            //     var w;
//            var width;
//            if (tmp >= 1250) {
//                //  w = parseInt(tmp / 400);
//                width = (3 * 400);
//            } else if (tmp <= 1100 && tmp >= 850) {
//                width = (2 * 400);
//            } else if (tmp < 850) {
//                width = 400;
//            }
//
//            $(".grid").css("width", width + "px");
//            //   return width;
//        }

        function islikedcontent(content_id){
            return $.ajax({
                url:"<?php echo URL?>common/islikedcontent/" + content_id,
                async:false
            });
        }
    </script>
    <style>
        /* very important, do not delete it*/
        .grid-item{
            max-width:400px;
        }
    </style>
    <body class="body_bg02 popup-background, bg_deepgray">
    <div class="modal" id="playDetailModal" role="dialog"></div>
    <div id="wrapper" style="min-height:800px;">
        <div class="container bg_deepgray">
            <!--앨범전체 AREA-->
            <div class="grid grid-search" data-layout-mode="masonry" style="max-width: 1250px;">

            </div>
        </div>
    </div>
    </body>
</div>

