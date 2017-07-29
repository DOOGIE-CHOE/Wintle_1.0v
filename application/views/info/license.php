<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 5/30/17
 * Time: 8:13 PM
 */

?>


<div id="all">


    <style>
        .container {
            width: 85% !important;
            margin-top: 70px;
        }

        .info-nav-bar {
            width: 100%;
            padding: 20px;
        }

        .divider {
            width: auto;
            height: 1px;
            margin: 9px 10px;
            overflow: hidden;
            background-color: gray;
            border-bottom: 1px solid gray;
        }

        .nav-header {
            border-bottom: 1px solid #f2f2f2;
            margin-top: 20px;

        }

        .nav-header > span {
            padding: 10px 15px;
        }

        .nav > li > a {
            color: #999 !important
        }

        .nav-header:hover, .nav-header:focus, .nav-header > a:hover, .nav-header > a:focus {
            background: none !important;
        }

        .contents .terms {
            padding: 50px;
        }

        .contents .terms .article {
            margin: 25px 0;

        }

        .contents .terms .article-title h2 {
            line-height: 4;
        }

        .contents .terms .article-subtitle h3 {
            line-height: 3;
        }

        .contents .terms .article h4 {
            line-height: 2;
        }

        .contents .terms .article p {
            white-space: pre-line
        }

    </style>
    <div class="container">
        <div class="row">
            <?php
            include_once "sidebar.php";
            ?>
            <div class="contents col-lg-9">
                <div class="terms grid-item">
                    <div class="article-title">
                        <h2>
                            wintle 라이센스 관련
                        </h2>
                    </div>
                    <div class="article">
                        <h4 class="article-title">
                            wintle에서 제공되는 서비스 및 콘텐츠는 이용약관을 따르며, 별도로 사용 할 시 저작자 표시 및 비영리를 목적으로 사용 하여야 하며 저작물을 변경해서는 안됩니다.
                        </h4>
                        <h4 class="article-title">

                        </h4>
                        <p class="article-text">
                            <a rel="license" target="_blank" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img
                                        alt="크리에이티브 커먼즈 라이선스" style="border-width:0"
                                        src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png"/></a><br/>이 저작물은 <a
                                    rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank">크리에이티브 커먼즈
                                저작자표시-비영리-변경금지 4.0 국제 라이선스</a>에 따라 이용할 수 있습니다.
                        </p>
                    </div>
                </div><!-- terms -->
            </div><!-- contents -->
        </div> <!-- row -->
    </div><!-- container -->
</div>
