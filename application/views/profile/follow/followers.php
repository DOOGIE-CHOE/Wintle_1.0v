<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/25/2016
 * Time: 1:51 PM
 */

?>
    <script>
        var limit = 12;
        var offset_followers = 0;
        var flag_followers  = true;   //job flag
        var follow = "followers";

        $(function () {
            if (flag_followers) {
                flag_followers = false;
                loadMyfollowers();
            }

            //스크롤 높이에 따른 추가 콘텐츠 로드
            $(window).bind('scroll',function () {
                // do whatever you need here.
                if (document.body.scrollHeight - $(window).scrollTop() < $(window).height() + 300 && flag_followers == true) {
                    flag_followers = false;    // wait until the job is done
                    loadMyfollowers(); // call loading card function
                }
            });
        });


        function loadMyfollowers() {
            // 보고있는 프로필 ID를 파라메타로 넘긴다. 프로필이용자에 컨텐츠를 가져오기 위함
            $.get("<?php echo URL?>profile/loadMyFollow/" + limit + "/" + offset_followers + "/" + <?php echo $profile_id?> + "/" + follow, function (o) {
                var data = jQuery.parseJSON(o);
                if(data.length > 0)
                    offset_followers += 12;
                if (data == null) {
                } else {
                    // i <= data.length '='을 붙인 이유는 마지막으로 출력된 follow카드는
                    // css 적용안되어 한번더 displayFollow를 호출하여 css적용시킴
                    for (var i = 0; i <= data.length; i++) {
                        displayFollow(data[i],".grid-follow", "grid", follow);
                    }
                }
            }).done(function () {
                var interval_load = setInterval(function () {
                    flag_followers = true; // the job is done
                    clearInterval(interval_load);
                },1000);
            });
        }
    </script>
<div class="profile_container" style="">
    <div class="grid grid-follow" data-layout-mode="masonry" ></div>
</div>
<!--  Do not remove this-->
<!-- it's for profile page -->
    </div><!-- contents -->
</body>
</div><!-- all -->
<!-- ------------------ -->
