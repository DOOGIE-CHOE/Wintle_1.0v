/**
 * Created by Daniel on 9/25/2016.
 */

//구글 트레킹 클레스
var GoogleAnalyticsTracking = {
    container: null,
    url : null,
    init:function(url){
        this.url = url;
    },
    //페이지 뷰 URL을 서버에 전송
    doTrack:function(){
        ga('send', {
            hitType: 'pageview',
            page: this.url
        });
    }
};


$.pagehandler = $.pagehandler || {};
$.pagehandler.loadContent = function (url, type) {
    var pageUrl = url;
    var id;
    if (type == "all") {
        id = "#all";
        //스크롤 이벤트(스크롤 높이에 따른 추가 콘텐츠 로드기능에 의해 index/index, profiel/home에서 사용)
        $(window).unbind('scroll');
    } else if (type == "contents") {
        id = "#contents";
        //스크롤 이벤트(스크롤 높이에 따른 추가 콘텐츠 로드기능에 의해 index/index, profiel/home에서 사용)
        $(window).unbind('scroll');
    } else if (type == "playDetailModal") {
        id = "#playDetailModal";
    } else if (type == "comment"){
        id = "#comment-part";
    }

    // $("#body").load(pageUrl);

    // $('.ajax-loader').show();
    $.ajax({
        //url: pageUrl + '?type=ajax',
        url: pageUrl,
        success: function (data) {
            if (id == "#all")
                $(id).html($(data).filter(id).html());
            else if (id == "#contents")
                $(id).html($(data).find(id).html());
            else if (id == "#playDetailModal")
                $(id).html($(data).filter("#all").html());
            else if (id == "#comment-part"){
                $(id).html($(data).find(id).html());
            }
            //로드된 새로운 페이지에 언어 설정
            var userLang = navigator.language || navigator.userLanguage;
            setLanguage(userLang);

            GoogleAnalyticsTracking.init(pageUrl);
            GoogleAnalyticsTracking.doTrack();
        }
    });
    if(id == "#comment-part"){

    }else if (pageUrl != window.location) {
        window.history.pushState({path: pageUrl}, '', pageUrl);
    }
};


$.pagehandler.backForwardButtons = function () {
    $(window).on('popstate', function () {
        // search 시 헤쉬테그로 검색하기 때문에 아래에 있는 if 문을 통과하지 못함. 따라서 주석 처리
        // if (window.location.href.indexOf("#") == -1) {
            //스크롤 이벤트(스크롤 높이에 따른 추가 콘텐츠 로드기능에 의해 index/index, profiel/home에서 사용)
            loadOtherPage(location.pathname);
            GoogleAnalyticsTracking.init(location.pathname);
            GoogleAnalyticsTracking.doTrack();
        // }
    });
};

$.pagehandler.backForwardButtons();

//만약 블록 페이지가 팝업으로 열려 있다면, 팝업창을 종료함.
// 블록 페이지가 팝업이 아니라 페이지로 접속이 되어 있다면 일반적인 뒤로가기 기능 수행
function loadOtherPage(pathname){
    var tmp = (pathname).split("/");
    if (tmp[1] !== "block" || tmp[1] === "") {
        //팝업이 열려있는지 확인
        if (($("#playDetailModal").data('bs.modal') || {}).isShown) {
            $('#playDetailModal').modal('hide');
            return;
        }
    }
    $.ajax({
        url: pathname,
        success: function (data) {
            $(window).unbind('scroll');
            $('#all').html($(data).filter("#all").html());
        }
    });



}

