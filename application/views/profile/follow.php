<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/25/2016
 * Time: 1:51 PM
 */

?>
<script>
    //팔로워 숫자를 가져옴
    $.get("<?php echo URL?>common/getFollowNumber/<?php echo $profile_id?>",function(o){
        var value = jQuery.parseJSON(o);
        //$('#follow_number font').text(value['follow_num']);
    });

    function setUserFollow(profile_id){
        //팔로우하게되면 1을 반환하고 text는 following 변환
        var following = 1;

        //팔로우 취소하게되면 2를 반환 text는 follow 변환
        var follow = 2;

        //main.js에서 profile_id를 던져줌
        $.get("<?php echo URL?>profile/setUserFollow/" + profile_id , function (o) {
            var data = $.parseJSON(o);

            //followCheck 와 unfollowCheck의 css :before를 이용하여 텍스트 치환
            if (data[0] == following) {
                $('#'+profile_id).addClass("followCheck");
                $('#'+profile_id).removeClass("unfollowCheck");
            } else if (data[0] == follow) {
                $('#'+profile_id).addClass("unfollowCheck");
                $('#'+profile_id).removeClass("followCheck");
            }
        });
    }

    $(window).bind('resize',function (){
        // profile_container 가로 크기
        var container_outerWidth = $('.profile_container').outerWidth();

        // profile_container의 85% 만큼 follow card들을 담을 사이즈를 구한다.
        var size_85 = (85/100);
        var _container_outerWidth = size_85 * container_outerWidth;

        // profile_container크기에서 85%부분을 제외한 나머지를 margin을 구한다.
        var follow_margin = container_outerWidth - _container_outerWidth;

        // 팔로우 Card 사이즈
        var followCardSize;

        // 팔로우 갯수
        var followCardNum;

        // 팔로우 Card 이미지 사이즈
        var size_95 = (95 / 100);
        var followCardImageSize;

        // 가로 크기 별로 follow 출력 계수 지정 모바일 화면 크기에서는 무조건 2개 씩 보여줌
        if(1920 >= container_outerWidth){ followCardNum = 8; }
        if(1600 >= container_outerWidth){ followCardNum = 7; }
        if(1440 >= container_outerWidth){ followCardNum = 6; }
        if(1020 >= container_outerWidth){ followCardNum = 5; }
        if(840  >= container_outerWidth){ followCardNum = 4; }
        if(720  >= container_outerWidth){ followCardNum = 3; }
        if(600  >= container_outerWidth){ followCardNum = 2; }
        if(480  >= container_outerWidth){ followCardNum = 2; }
        if(360  >= container_outerWidth){ followCardNum = 2; }

        // follow card의 mergin은 left, right가 있는데 동일한 값을 가진다.
        // 카드당 margin값을 구하려면 (follow card * 2)이런 식이 나온다.
        // 그러나 카드간에 간격이 많이 넓어 보이기 때문에 곱하기3을 하여 간격을 줄임.
        follow_margin = follow_margin / (followCardNum * 3);

        // follow card의 사이즈는 (profile_container 85%크기 / follow card 수)
        followCardSize = _container_outerWidth /  followCardNum;

        // follow card image 사이즈는 follow card 95% 크기이다.
        followCardImageSize = size_95 * followCardSize;

        $('.followAR').css({'width' : followCardSize, 'margin-left': follow_margin, 'margin-right': follow_margin});
        $('.followAR img').css({'width' : followCardImageSize, 'height' : followCardImageSize});
    });

</script>
<div id="contents" class="ofh bg_deepgray" style="">
    <div class="profile_container bg_deepgray">
        <nav id="nav" class="navbar" style="top:0; width:30%; margin-top: 65px; margin-bottom: 20px;">
            <ul class="nav row">
                <li class="col-lg-6 col-md-6 col-sm-6 col-xs-6 active" id="followers">
                    <a onclick="$.pagehandler.loadContent('<?php echo URL.Session::get('profile_url')."/followers"?>','contents')">followers(<font></font>)</a>
                </li>
                <li class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="following">
                    <a onclick="$.pagehandler.loadContent('<?php echo URL.Session::get('profile_url')."/following"?>','contents')">following(<font></font>)</a>
                </li>
            </ul>
        </nav>
    </div>

