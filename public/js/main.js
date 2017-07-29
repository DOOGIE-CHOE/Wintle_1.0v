/**
 * Created by daniel on 3/7/17.
 */


var userInfo = {




};




// main js
// Add everything that are used for each html/php files
var waveSequence = 0;
var wall;
function displayContent(content, container, type) {
    if (content == null) {

    }
    else {
        if (content.profile_photo_path == null) {
            content.profile_photo_path = 'img/defaultprofile.png';
        }

        var html = "<div class='grid-item  col-lg-12 col-md-12 col-sm-12 col-xs-12'>" +
            "<div class='user' onclick=\"$.pagehandler.loadContent(\'"+_URL+ content.profile_url +"\','all');\">" +
            "<div class='userphoto' style=\"background-image:url("+_URL + content.profile_photo_path +")\">" +
            "</div>" +
            "<div class='musictext'>" +
            "<ul>" +
            "<li><span class='user_name'>" + content.user_name + "</span></li>" +
            "</ul></div></div>";

        if (content.content_title != "" && content.content_title != null) {
            html += "<div class='albumTitle'  data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent(\'" + _URL + "block/" + content.content_id + "\','playDetailModal');\"><span class='music_name'>";

            //replace all html tags from the string into html name
            content.content_title = content.content_title.escapeHTML();
            html += content.content_title + "</span></div>";
        }

        if (content.content_type_name == "image") {
            html += "<div class='albumP' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent(\'"+_URL+"block/" + content.content_id + "\','playDetailModal');\"><img src='"+ _URL+ content.content_path + "' alt=''/></div>";

            <!--앨범사진-->

        } else if (content.content_type_name == "audio") {
            html += "<div class='albumA' id='waveform-"+ waveSequence + "' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent(\'"+_URL+"block/" + content.content_id + "\','playDetailModal');\"></div>";
        }
        if (content.comments != "" && content.comments != null) {
            html += "<div class='albumT lyricsPadding lyricsFontSize' style='color:white;' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent(\'"+_URL+"block/"+ content.content_id + "\','playDetailModal');\"><span class='text'>";

            //replace all html tags from the string into html name
            content.comments = content.comments.escapeHTML();
            var tmp = content.comments.split("\n");
            tmp.forEach(function(comment){
                html += '<p>' + comment + '</p>';
            });
            html +=   "</span></div>";

        }

        html +=
            "<div class='music_tag'> <div class='tag_container'>";
        if (content.hashtags != null) {
            var hsh = content.hashtags.split(",");
            for (var j = 0; j < hsh.length; j++) {
                if(hsh.length == 1 && hsh[0] == " "){

                }else{
                    //replace all html tags from the string into html name
                    hsh[j] = hsh[j].escapeHTML();
                    html += "<span class='label'>" + hsh[j] + "</span>";
                }
            }
        }



        html +=
            "</div></div>" + <!--userinfo-->
            "<div class='btm_info'>";
        $.when(getLikeNum(content.content_id,"content")).done(function(o){
            var value =  jQuery.parseJSON(o);
            html += "<span class='like'>Stars <span id='likenum'>"+ value + "</span> 개 </span>";
        });

        html +="<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:10%;'>";

        $.when(islikedcontent(content.content_id)).done(function(o){
            var value = jQuery.parseJSON(o);
            if(value == 1){
                html += "<img src='"+ _URL + "icon/Details_Content/stared.svg' class='w25px' onclick='likecontent("+content.content_id+",this);'/></span>";
            }else{
                html += "<img src='"+ _URL + "icon/Details_Content/star.svg' class='w25px' onclick='likecontent("+content.content_id+",this);'/></span>";
            }
            html += "</div>";

            if(type == "grid"){
                $(container).append(html);
            }else if(type == "freewall"){
                wall.appendBlock(html);
            }

            if(content.content_type_name == "audio") {
                var tmp = content.content_path.split('.');
                var filename_scaled = tmp[0] + "_scaled." + tmp[1];

                var filename_scaled_replaced = filename_scaled.replace(/\//g,"-");
                var element = '#waveform-' + waveSequence++;

                $.ajax({
                    url : _URL+"common/checkfileexistence/"+filename_scaled_replaced,
                    async : false,
                    success:function(result){
                        if(result === "true"){
                            // console.log(filename_scaled);
                            createWaveform(_URL + filename_scaled, element);
                        }else{
                            // console.log(content.content_path);
                            createWaveform(_URL + content.content_path, element);
                        }
                    },
                    error: function(o){

                    }
                });

            }
        });

    }
}

function displayProject(content, number, container, type) {
    if (content == null) {

    }
    else {
        if (content.profile_photo_path == null) {
            content.profile_photo_path = 'img/defaultprofile.png';
        }
        var html = "<div class='grid-item col-lg-12 col-md-12 col-sm-12  col-xs-12'>" +
            "<div class='user' onclick=\"$.pagehandler.loadContent(\'"+_URL+ content.profile_url +"\','all');\">" +
            "<div class='userphoto' style=\"background-image:url("+_URL + content.profile_photo_path +")\">" +
            "</div>" +
            "<div class='musictext'>" +
            "<ul>" +
            "<li><span class='user_name'>" + content.user_name + "</span> <span class='project-number'>" + number + "</span></li>" +
            "</ul></div></div>";

        if (content.content_title != "" && content.content_title != null) {
            html += "<div class='albumTitle'  data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent(\'" + _URL + "block/" + content.content_id + "\','playDetailModal');\"><span class='music_name'>";

            //replace all html tags from the string into html name
            content.content_title = content.content_title.escapeHTML();
            html += content.content_title + "</span></div>";
        }if (content.content_type_name == "image") {

            html += "<div class='albumP' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent(\'"+_URL+"block/" + content.project_id + "\','playDetailModal');\"><img src='"+ _URL + content.content_path + "' alt=''/></div>";

            <!--앨범사진-->
        } else if (content.content_type_name == "audio") {
            html += "<div class='albumA' id='waveform-"+ waveSequence + "' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent(\'"+_URL+"block/" + content.project_id + "\','playDetailModal');\"></div>";
        }
        if (content.comments != "" && content.comments != null) {
            html += "<div class='albumT lyricsPadding lyricsFontSize' style='color:white;' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent(\'"+_URL+"block/"+ content.project_id + "\','playDetailModal');\"><span class='text'>";

            //replace all html tags from the string into html name
            content.comments = content.comments.escapeHTML();
            var tmp = content.comments.split("\n");
            tmp.forEach(function(comment){
                html += '<p>' + comment + '</p>';
            });
            html +=   "</span></div>";

        }


        <!--lyrics-->
        html +=
            "<div class='music_tag'><div class='tag_container'>";

        if (content.hashtags != null) {
            var hsh = content.hashtags.split(",");
            for (var j = 0; j < hsh.length; j++) {
                if(hsh.length == 1 && hsh[0] == " "){

                }else{
                    //replace all html tags from the string into html name
                    hsh[j] = hsh[j].escapeHTML();
                    html += "<span class='label'>" + hsh[j] + "</span>";
                }
            }
        }

        html +=
            "</div></div>" + <!--userinfo-->

            "<div class='btm_info'>";


        $.when(getLikeNum(content.project_id,"project")).done(function(o){
            var value =  jQuery.parseJSON(o);
            html += "<span class='like'>Stars <span id='likenum'>"+ value + "</span> 개 </span>";
        });

        html+="<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:10%;'>";

            // "<a href='#'><img src='"+_URL+"icon/Details_Content/share.svg' class='w25px'/></a></span>" ;

        // html +="<span style='position:relative;min-height:1px;padding-right:5px;padding-left:5px; float:right; width:10%;'>";

        $.when(islikedcontent(content.project_id)).done(function(o){
            var value = jQuery.parseJSON(o);
            if(value == 1){
                html += "<img src='"+ _URL + "icon/Details_Content/stared.svg' class='w25px' onclick='likecontent("+content.project_id+",this);'/></span>";
            }else{
                html += "<img src='"+ _URL + "icon/Details_Content/star.svg' class='w25px' onclick='likecontent("+content.project_id+",this);'/></span>";
            }
            html += "</div>";


            if(type == "grid"){
                $(container).append(html);
            }else if(type == "freewall"){
                wall.appendBlock(html);
            }


            if(content.content_type_name == "audio") {

                var tmp = content.content_path.split('.');
                var filename_scaled = tmp[0] + "_scaled." + tmp[1];

                var filename_scaled_replaced = filename_scaled.replace(/\//g,"-");
                var element = '#waveform-' + waveSequence++;

                $.ajax({
                    url : _URL+"common/checkfileexistence/"+filename_scaled_replaced,
                    async : false,
                    success:function(result){
                        if(result === "true"){
                            // console.log(filename_scaled);
                            createWaveform(_URL + filename_scaled, element);
                        }else{
                            // console.log(content.content_path);
                            createWaveform(_URL + content.content_path, element);
                        }
                    },
                    error: function(o){

                    }
                });
            }
        });

    }
}


var DisplayDeletedContent = {
    param:{
        project_id : null,
        container : null
    },
    init:function(param){
        _.extend(this.param, param);
    },
    display:function(){
        var html =  "<div class='grid-item col-lg-12 col-md-12 col-sm-12 col-xs-12'>"+
            "<div class='deleted-content' data-toggle='modal' data-target='#playDetailModal' onclick = \"$.pagehandler.loadContent(\'" + _URL + "block/" + this.param.project_id + "\','playDetailModal');\">"+
                 "<span>삭제된 게시글 입니다.</span>"+
            "</div>"+
        "</div>";

        $(this.param.container).append(html);
    }
};


//쿠키 얻어오는 메소드(쿠키명)

function getCookie(cname) {
    var name = cname + "=";
    //한글깨짐 방지

    var decodedCookie = decodeURIComponent(document.cookie);
    //cookie값이 ;으로 구분되어있음.

    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        //구분되어있는 쿠키값의 첫 글자가 빈칸인지 확인 후 제거를 위한 반복문
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

//쿠키 저장 메소드(쿠키명, 쿠키값, 시간(일단위))
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

//replace all html tags from the string into html name
String.prototype.escapeHTML = function () {
    return(
        this.replace(/>/g,'&gt;').
        replace(/</g,'&lt;').
        replace(/"/g,'&quot;')
    );
};

function islikedcontent(content_id){
    return $.ajax({
        url:_URL + "common/islikedcontent/" + content_id,
        async:false
    });
}

function getLikeNum(content_id, type){
    return $.ajax({
        url:_URL+"common/getlikenum/"+content_id+"/"+type,
        async:false
    });
}

function likecontent(content_id, img_element){
    var value = null;
    $.get(_URL+"common/likecontent/" + content_id, function (o) {
        value = jQuery.parseJSON(o);
    }).done(function () {
        var result = value.result;
        if(result == "liked"){
            //현재 컨텐츠에 표시되어 있는 좋아요 갯수 가져오기
            var num = $(img_element).parent().parent().find("#likenum").text();
            num = parseInt(num);
            //좋아요 갯수 +1 후 출력
            $(img_element).parent().parent().find("#likenum").text(num+=1);
            img_element.src = _URL + "icon/Details_Content/stared.svg";
        }else if(result == "unliked"){
            //현재 컨텐츠에 표시되어 있는 좋아요 갯수 가져오기
            var num = $(img_element).parent().parent().find("#likenum").text();
            num = parseInt(num);
            //좋아요 갯수 -1 후 출력
            $(img_element).parent().parent().find("#likenum").text(num-=1);
            img_element.src = _URL + "icon/Details_Content/star.svg";
        }
    });
}

function playSingleAudio(el){
    // wavesurfer_list.forEach(function(item){
    //     if(item.elementid == "#" + $(el).attr('id')){
    //         item.wavesurfer.playPause();
    //     }
    // });
}

function displayFollow(content, container, type, follow) {
    //팔로워와 팔로우 체크를 위한 함수
    var follow_check;

    //유저ID를 담는 함수
    var user_id;

    //유저명을 담는 함수
    var user_name;

    //프로필 경로를 담는 함수(사진을 가져오기위함)
    var profile_url;

    //프로필 사진이 없을 경우 기본 이미지를 담는다.
    var profile_photo;

    //profile_container 가로 크기
    var container_outerWidth = $('.profile_container').outerWidth();

    //profile_container의 85% 만큼 follow card들을 담을 사이즈를 구한다.
    var size_85 = (85/100);
    var _container_outerWidth = size_85 * container_outerWidth;

    //profile_container크기에서 85%부분을 제외한 나머지를 margin을 구한다.
    var follow_margin = container_outerWidth - _container_outerWidth;

    //팔로우 Card 사이즈
    var followCardSize;

    //팔로우 갯수
    var followCardNum;

    //팔로우 Card 이미지 사이즈
    var size_95 = (95 / 100);
    var followCardImageSize;

    //팔로우 인지 판단
    var fCheck;

    //가로 크기 별로 follow 출력 계수 지정 모바일 화면 크기에서는 무조건 2개 씩 보여줌
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

    //follow card의 사이즈는 (profile_container 85%크기 / follow card 수)
    followCardSize = _container_outerWidth /  followCardNum;

    //follow card image 사이즈는 follow card 95% 크기이다.
    followCardImageSize = size_95 * followCardSize;

    $('.followAR').css({'width' : followCardSize, 'margin-left': follow_margin, 'margin-right': follow_margin});
    $('.followAR img').css({'width' : followCardImageSize, 'height' : followCardImageSize});

    if (content == null) {

    }
    else {
        if(follow == "followers"){
            //해당 프로필을 팔로우 하는 사람 정보
            user_id = content.user_id_1;
            user_name = content.user_name_1;
            profile_url = content.profile_url_1;
            profile_photo = content.profile_photo_path_1;
        } else if(follow == "following"){
            //해당 프로필 팔로잉 정보
            user_id = content.user_id_2;
            user_name = content.user_name_2;
            profile_photo = content.profile_photo_path_2;
            profile_url = content.profile_url_2;
        }

        //팔로우인지 체크
        $.ajax({
            url : _URL + "profile/getUserFollow/" + user_id,
            async : false,
            success:function(result){
                var data = $.parseJSON(result);

                //팔로우 하면 followCheck 언팔로우면 unfollowCheck
                if(data == "following"){
                    fCheck = "followCheck";
                } else {
                    fCheck = "unfollowCheck";
                }
            },
            error: function(o){

            }
        });

        //프로필 이미자가 없을 경우 기본이미지
        if (profile_photo == null) {
            profile_photo = 'img/defaultprofile.png';
        }

        var html =
            "<div class='followAR'>" +
            "<img class='user' onclick=\"$.pagehandler.loadContent(\'"+_URL+ profile_url +"\','all');\" " +
            "src=\'"+_URL + profile_photo +"\'>" +
            "<span class='followName'>" + user_name + "</span>" +
            "<span class=\'"+fCheck+"\' id=\'"+user_id+"\' onclick=\"setUserFollow(\'"+user_id+"\')\" >&nbsp;</span>" +
            "</div>";

        if(type == "grid"){
            $(container).append(html);
        }
    }
}