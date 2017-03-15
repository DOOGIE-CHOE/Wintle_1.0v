<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/13/2016
 * Time: 5:33 PM
 */

?>
<div class="alert">
    <span class="closebtn">&times;</span>
    <a id="error-message" style="color:white"></a>
</div>
<div class="cssload-overlay">
    <div class="cssload-container" >
        <div class="cssload-whirlpool"></div>
    </div>
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