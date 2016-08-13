<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/13/2016
 * Time: 5:33 PM
 */

?>
<script>
    function showError(message){
        alert(message);
    }


</script>
<style>
    .alert {
        position:absolute;
        padding: 20px;
        background-color: #f44336;
        color: white;
        margin-bottom: 15px;
        top : 60px;
        opacity: 1;
        transition: opacity 0.6s;
        -webkit-transition:0.2s;
        -moz-transition:0.2s;
        right:0;
        z-index:1000;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }

</style>

<div class="alert">
    <span class="closebtn">&times;</span>
    Indicates a dangerous or potentially negative action.
</div>

<script>
    var close = document.getElementsByClassName("closebtn");
    var i;

    for (i = 0; i < close.length; i++) {
        close[i].onclick = function(){
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function(){ div.style.display = "none"; }, 600);
        }
    }
</script>