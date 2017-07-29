<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/17/2016
 * Time: 3:55 PM
 */


?>

<html>
<head>
<style>

    .line-arrow {
        position: absolute;
        overflow: hidden;
        display: inline-block;
        font-size: 4px; /*set the size for arrow*/
        width: 4em;
        height: 4em;
    }

    .line-arrow.left {
        border-top: 3px solid black;
        border-left: 3px solid black;
        transform: rotate(-45deg) skew(0deg);
        margin-right:15px;
    }


    .line-arrow.right {
        border-top: 1px solid #a9a9a9;
        border-right: 1px solid #a9a9a9;
        transform: rotate(54deg) skew(20deg);
        right: 20px;
    }

</style>

</head>

<body>
<div id="pointers">
<div class="line-arrow left"></div>
<div class="line-arrow right"></div>
</div>
</body>

</html>
