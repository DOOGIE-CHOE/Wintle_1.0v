<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 11/4/2016
 * Time: 2:31 PM
 */

?>

<style>

    .overlay {
        position: fixed;
        z-index: 100;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
    }

    .overlay:target {
        visibility: visible;
        opacity: 1;
    }


</style>


<div>

    <div id="popup2" class="overlay">
    </div>

</div>
