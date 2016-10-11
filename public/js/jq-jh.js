$(function () {  // 시작

    // 이용하기/ 체험하기 버튼
    var $UseBtn = $('header .introbtn');

    // 헤더 숨길 객체
    var $hiddenObj = $('header .info-content');

    $('.hidden').css('display', 'none');

    // 헤더 높이 설정
    // (모바일 & PC)
    var filter = "win16|win32|win64|mac|macintel";
    var header_height;
    if( navigator.platform ){
        if (filter.indexOf(navigator.platform.toLowerCase()) < 0) {
            // mobile
            header_height = '100px';
        } else {
            // pc
            header_height = '37px';
        }
    }

    $UseBtn.on('click', function () {
        var playtime = 1000;
        $hiddenObj.animate({
            opacity: 0
        }, playtime)
        $('header').animate({
            height: header_height
        }, playtime);
        $('.hidden').css('display', 'block');

        $(".body").css("margin-top","30px");
    })




}); // 마지막