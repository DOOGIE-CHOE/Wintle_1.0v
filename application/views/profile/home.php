<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/25/2016
 * Time: 1:51 PM
 */

?>
<div id="contents">

    <style>
        @media all and (min-width: 700px) {
            .grid-item{
                margin:25px auto;
            }
        }

    </style>
    <script>
        var limit = 2;
        var offset_home = 0;
        var flag_home = true;   //job flag


        $(function () {

            //파일 업로드 시 해쉬테그 입력란 관련 스크립트
            $('#hashtags').tagEditor({
                delimiter: ' ,', /* space and comma */
                placeholder : "#",
                //테그의 상태에 변화가 있을떄
                onChange: function(field, editor, tags) {
                    var tmp = $(".tag-editor-tag");
                    var all = $('li', editor).find(tmp);

                    // 이전에 입력되었던 테그인지 확인
                    for(var j = 0; j< tags.length ; j++ ){
                        if(tags[j] == "#"+ tags[tags.length-1] ) {
                            //입력되었던 테그가 있다면 마지막으로 추가된 테그 삭제 후 종료
                            $('li', editor).last().remove();
                            /*
                             * 기존에 존재하는 해쉬테그가 있어서 함수 실행이 종료 될 경우, 종료 된 후에도 중복이 되는 해쉬테그를 입력하게 되면
                             * 이곳 함수 전체 (onChange)가 실행되지 않고 바로 웹상에서 헤쉬테그를 입력하는 부분에 해당 해쉬테그가 삽입됨.
                             * 해당 버그를 찾아내는것이 최선이지만, 현재 상황으로써는 php에서 해쉬테그를 업로드 할 때, 첫번째 문자가 #으로 시작하지 않는경우
                             * 데이터베이스 입력을 생략하고 넘어감.
                             *
                             *
                             * 가끔가다가 onchange가 연속 두번으로 실행되는 버그도 존재함
                             * */

                            return false;
                        }
                    }
                    for(var i = 0; i < all.length ; i++){
                        if(all[i].innerHTML != "" && (all[i].innerHTML).substring(0,1) != "<" && (all[i].innerHTML).substring(0,1) != "#"){
                            // 영어 숫자 한글 특수문자 _ 를 제외한 나머지 문자는 제거
                            all[i].innerHTML = all[i].innerHTML.replace(/[^a-z\d_ㄱ-ㅎ|ㅏ-ㅣ|가-힣]+/gi, "");

                            //마지막으로 추가된 해쉬테그의 앞쪽에 # 삽입
                            all[i].innerHTML = "#" + all[i].innerHTML;
                        }
                    }
                }
            });


            if (flag_home) {
                flag_home = false;
                loadMyContent();
            }
            //스크롤 높이에 따른 추가 콘텐츠 로드
            $(window).bind('scroll', function () {
                // 페이지 전체 높이 - 페이지 첫 시작부분 부터 현재화면 상단부 < 현재 스크린 높이
                if (document.body.scrollHeight - $(window).scrollTop() < $(window).height() + 300 && flag_home == true) {
                    flag_home = false;    // wait until the job is done
                    loadMyContent(); // call loading card function
                }
            });

            //콘텐츠 검색기능 예전 방식. 지금은 사용 안함
//
//            $("#search").blur(function () {
//                if (!this.value) { //if it's empty
//                } else {
//                    $.get("<?php //echo URL?>//viewlist/loadContentsByHash?hashtags=" + $("#search").val(), function (o) {
//                            var value = jQuery.parseJSON(o);
//                        if (value.error != null) {
//                            errorDisplay(value.error);
//                        } else {
//                            console.log(value);
//                        }
//                    });
//                }
//            }).keypress(function (e) {
//                if (e.which === 32)
//                    return false;
//            });

            //팝업창 바깥부분 클릭 시 페이지 뒤로 돌아가기 수행
            $('#playDetailModal').bind('click', function (e) {
                if ($(e.target).attr('class') == "view_bodyAR") {
                    var opened = $('#playDetailModal').hasClass('modal in');
                    if (opened === true) {
                        window.history.back();
                    }
                }
            });
        });



        function loadMyContent() {
            //put this instead of on load function;
            $.get("<?php echo URL?>profile/loadMyContents/" + limit + "/" + offset_home + "/" + <?php echo $profile_id?> , function (o) {
                    limit = 2;
                    offset_home += 2;
                    var value = jQuery.parseJSON(o);
                    if (value == null) {
                        //display default image
                    } else {
                        for (var i = 0; i < value.length; i++) {
                            if (value[i].constructor === Array) {
                                if(value[i][value[i].length - 1].content_id == null){
                                    var param = {
                                        container:".grid-main",
                                        project_id : value[i][value[i].length - 1].project_id
                                    };
                                    //삭제된 컨텐츠 보여줄 필요없음
                                    //DisplayDeletedContent.init(param);
                                    //DisplayDeletedContent.display();
                                }else{
                                    displayProject(value[i][value[i].length - 1], value[i].length,".grid-main", "grid");
                                }
                            } else {
                                displayContent(value[i], ".grid-main", "grid");
                            }
                        }
                    }
                    $(".grid").css("height",$(".container").css("height"));
                }
            ).done(function () {
                var interval = setInterval(function () {
                    flag_home = true; // the job is done
                    clearInterval(interval);
                },1000);
            });
        }

    </script>

            <div class="modal" id="playDetailModal" role="dialog"></div>
            <div id="wrapper">
                <div class="container bg_deepgray">
                    <div class="grid grid-main row" style="max-width:650px;" >
                    </div><!--grid-->
                </div><!-- container-->
            </div><!--wrapper -->
<!--  Do not remove this-->
<!-- it's for profile page -->
        </div><!-- contents -->
    </body>
</div><!--all -->
<!-- ------------------ -->
