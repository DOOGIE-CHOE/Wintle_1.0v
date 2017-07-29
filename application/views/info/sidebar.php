<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 5/30/17
 * Time: 8:11 PM
 */

?>

<div class="sidebar-nav col-lg-3">
    <div class="grid-item info-nav-bar">
        <ul class="nav nav-list">
            <li class="nav-header"><a><span data-langNum="1225">Legal</span></a></li>
            <li onclick="$.pagehandler.loadContent(_URL+'info/terms','all')"><a><span data-langNum="1226">이용약관</span></a></li>
            <li onclick="$.pagehandler.loadContent(_URL+'info/privacy','all')"><a><span data-langNum="1227">개인정보처리방침 </span></a></li>
<!--            <li onclick="$.pagehandler.loadContent(_URL+'info/license','all')"><a>라이센스 </a></li>-->
        </ul>
    </div>
</div>
