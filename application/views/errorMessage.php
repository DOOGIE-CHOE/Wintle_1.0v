<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/13/2016
 * Time: 5:33 PM
 */

?>
<style>
    .alert {
        display:none;
        position:fixed;
        padding: 20px;
        background-color: #f44336;
        color: white;
        margin-bottom: 15px;
        top : 60px;
        opacity: 1;
        transition: opacity 0.6s;
        -webkit-transition:0.3s;
        -moz-transition:0.3s;
        right:-700px;
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
    <a id="error-message"></a>
</div>

<script>

    function errorDisplay(error){
        if($(".alert").css("display") == "none"){
            $("#error-message").text(error);
            var alert = $(".alert");
            alert.show(0).css("right","0");
            setTimeout(function(){ alert.hide(0).css("right","-800px")},3000);
        }
    }

    var close = document.getElementsByClassName("closebtn");
    for (var i = 0; i < close.length; i++) {
        close[i].onclick = function(){
            var div = this.parentElement;
            setTimeout(function(){ div.style.display = "none"; }, 300);
        }
    }

</script>