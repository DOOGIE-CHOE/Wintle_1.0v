<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/25/2016
 * Time: 1:51 PM
 */

?>
<!--about컨텐츠-자기소개-->
    <div id="contents">
        <div  class="container pd_10 f_white">
            <div>
                <h3 class="w50 f_left">자기소개</h3>
                <span class="pdt_20 f_right">
                    <?php if(Session::get("loggedIn") == true && Session::get("user_id") == Session::get("profile_id")){ ?>
                    <button type="button" class="btn btn-danger btn-xs" id="textarea1_click">edit</button>
                    <button type="button" class="btn btn-primary btn-xs" id="textarea2_click">upload</button>
                    <?php } else { ?>
                        <!-- 버튼없는 빈칸 채우기 위함 -->
                        <div>&nbsp;</div>
                    <?php } ?>
                </span>
            </div>
            <div class="myinfor">
                <div class="text_view"> 안녕하세요 가사쓰는 찰스입니다. <br>
                    너무 흔한 사랑이야기가 아니라 모두에게 공감을 줄수 있는 스토리로.....<br>
                    Stay 내 눈물이 마를 때까지 <br>
                    Stay 내가 나를 모를 때까지<br>
                    Stay 아주 조금만 기다려 <br>
                    Stay 내 기억의 주인은 나야<br>
                    Stay 내가 널 보내줄 때까지 <br>
                    Stay 내 기억 속에서라도<br>
                    조금의(조금의) 따뜻함(따뜻함) 이라도(이라도) <br>
                    <br>
                    간직할 수 있게 해줘<br>
                    난 이미 얼어버릴 듯 한없이 차가워<br>
                    너마저(너마저) 떠나면(떠나면) 나에겐(나에겐)<br>
                    이제 아름다움이 없어<br>
                    난 이미 버려져 있고 한없이 더러워 <br>
                    Hey 이미 꽤 오랜 시간동안 <br>
                    내 안에 머물러 있었잖아<br>
                    이제 그냥 집이라고 생각해<br>
                    <br>
                    조금의(조금의) 따뜻함(따뜻함) 이라도(이라도) <br>
                    간직할 수 있게 해줘<br>
                    난 이미 얼어버릴 듯 한없이 차가워<br>
                    너마저(너마저) 떠나면(떠나면) 나에겐(나에겐)<br>
                    이제 아름다움이 없어<br>
                    난 이미 버려져 있고 한없이 더러워 <br>
                    Stay inside my dear <br>
                    Don't you come out my dear<br>
                    조금의(조금의) 따뜻함(따뜻함) 이라도(이라도) <br>
                    간직할 수 있게 해줘<br>
                    난 이미 얼어버릴 듯 한없이 차가워<br>
                    너마저(너마저) 떠나면(떠나면) 나에겐(나에겐)<br>
                    이제 아름다움이 없어<br>
                    난 이미 죽어 버릴 듯 한없이 더러워<br>
                    Stay my dear<br>
                    Stay my dear<br>
                </div>
                <!--입력및수정//- -->
                <div class="text_edit" style="display:none;">
                <textarea id="" rows="10" >
                    안녕하세요 가사쓰는 찰스입니다.
                    너무 흔한 사랑이야기가 아니라 모두에게 공감을 줄수 있는 스토리로.....
                    Stay 내 눈물이 마를 때까지
                    Stay 내가 나를 모를 때까지
                    Stay 아주 조금만 기다려
                    Stay 내 기억의 주인은 나야
                    Stay 내가 널 보내줄 때까지
                    Stay 내 기억 속에서라도
                    조금의(조금의) 따뜻함(따뜻함) 이라도(이라도)
                    간직할 수 있게 해줘
                    난 이미 얼어버릴 듯 한없이 차가워
                    너마저(너마저) 떠나면(떠나면) 나에겐(나에겐)
                    이제 아름다움이 없어
                    난 이미 버려져 있고 한없이 더러워
                    Hey 이미 꽤 오랜 시간동안
                    내 안에 머물러 있었잖아
                 </textarea>
                </div>
                <!-- ///입력및수정//- -->
                <div class="right" id="areaOfViewMoreBtn"><a href="#myinfor" id="btn_myinfor_viewMore">More</a></div>
            </div>
        </div>

        <!--about컨텐츠-소개링크-->
        <div class="container pd_10 f_white">
            <h3 class="w50 f_left">소개링크</h3>
            <p class="mylink">
                <span class="f_left">
                    <i class="glyphicon glyphicon-link mgr_10" ></i>www.wintle.co.kr/charles-101238942
                    <button type="button" class="btn bg_gray btn-xs f_white mgl_10">
                        <i class="glyphicon glyphicon-copy">복사</i>
                    </button>
                </span>
                <span class="f_right">
                    <i class="glyphicon glyphicon-share-alt pd_10">SNS공유</i>
                    <img src="../icon/icon_facebook.png" class="w30px pd_2">
                    <img src="../icon/icon_instagram.png" class="w30px pd_2">
                    <img src="../icon/icon_youtube.png" class="w30px pd_2">
                    <img src="../icon/icon_google.png" class="w30px pd_2">
                    <img src="../icon/icon_soundcloud.png" class="w30px pd_2">
                    <img src="../icon/icone_pinterest.png" class="w30px pd_2">
                </span>
            </p>
        </div>

        <!--about컨텐츠-포트폴리오-->
        <div class="container pd_10 f_white">
            <h3 class="f_left dpb">포트폴리오</h3>
            <div class="clear mgt_10">
                <div class="about_Stitle pd_10">
                    <h4>대표작품</h4>
                    <span class="wm_btn">
                        <?php if(Session::get("loggedIn") == true && Session::get("user_id") == Session::get("profile_id")){ ?>
                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#representYou">edit</button>
                        <?php } else { ?>
                            <!-- 버튼없는 빈칸 채우기 위함 -->
                            <div>&nbsp;</div>
                        <?php } ?>
                    </span>
                    <p class="dpb ofh">
                        <span class="f400 f_2 bg_brown pd_15 w200px">Funky</span>
                    </p>
                </div>
                <div class="portfolioAlbum">
                    <div class="albumP"><a href="/wintle/page/albumCommunity.html"><img src="../image/album_p1.jpg" alt="" /></a></div>
                    <div class="albumP"><a href="/wintle/page/albumCommunity.html"><img src="../image/album_p2.jpg" alt="" /></a></div>
                    <div class="albumP"><a href="/wintle/page/albumCommunity.html"><img src="../image/album_p3.jpg" alt="" /></a></div>
                    <div class="albumP"><a href="/wintle/page/albumCommunity.html"><img src="../image/album_p4.jpg" alt="" /></a></div>
                    <div class="albumP"><a href="/wintle/page/albumCommunity.html"><img src="../image/album_p5.jpg" alt="" /></a></div>
                    <div class="albumP"><a href="/wintle/page/albumCommunity.html"><img src="../image/album_p6.jpg" alt="" /></a></div>
                </div>
            </div>
            <div class="mgt_10">
                <div class="about_Stitle pd_10">
                    <h4>경력 및 기술</h4>
                    <span class="wm_btn">
                        <?php if(Session::get("loggedIn") == true && Session::get("user_id") == Session::get("profile_id")){ ?>
                        <button type="button" class="btn btn-danger btn-xs" id="btnEditHistory">edit</button>
                        <?php } else { ?>
                            <!-- 버튼없는 빈칸 채우기 위함 -->
                            <div>&nbsp;</div>
                        <?php } ?>
                    </span>
                </div>
                <div class="history_input" id="history_show">
                    <table class="table">
                        <caption>
                            경력 및 기술
                        </caption>
                        <colgroup>
                            <col width="18%" />
                            <col width="10%" />
                            <col width="*" />
                        </colgroup>
                        <thead>
                        <tr>
                            <th>항목</th>
                            <th>경력</th>
                            <th>활동정보</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>-</td>
                            <td>5년</td>
                            <td>메인보컬활동</td>
                        </tr>
                        <tr>
                            <td>Mary</td>
                            <td>5년</td>
                            <td>메인보컬활동</td>
                        </tr>
                        <tr>
                            <td>July</td>
                            <td>5년</td>
                            <td>메인보컬활동</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--입력및수정//- -->
                <div class="history_input" id="history_edit" style="display:none;">
                    <table class="table">
                        <caption>
                            경력 및 기술
                        </caption>
                        <colgroup>
                            <col width="18%" />
                            <col width="10%" />
                            <col width="*" />
                        </colgroup>
                        <thead>
                        <tr>
                            <th>항목</th>
                            <th>경력</th>
                            <th>활동정보</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="" class="form-control" id=""></td>
                            <td><input type="" class="form-control" id=""></td>
                            <td><input type="" class="form-control" id=""></td>
                        </tr>
                        <tr>
                            <td><input type="" class="form-control" id=""></td>
                            <td><input type="" class="form-control" id=""></td>
                            <td><input type="" class="form-control" id=""></td>
                        </tr>
                        <tr>
                            <td><input type="" class="form-control" id=""></td>
                            <td><input type="" class="form-control" id=""></td>
                            <td><input type="" class="form-control" id=""></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--///입력및수정//- -->
            </div>
        </div>
    </div>
<!--  Do not remove this-->
<!-- it's for profile page -->
    </div>
    </body>
</div>
<!-- ------------------ -->