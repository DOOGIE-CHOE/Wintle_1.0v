<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/16/2016
 * Time: 2:04 PM
 */
?>

<div id="all">
    <body>

    <br>
    <br>
    <br>
    <br>
    <br>
<div style="margin:100px 100px 100px 300px">
    <form id="send-message-form" action="http://localhost/message/sendmessage" method="post"  enctype="multipart/form-data">
        <input type="text" id="title" name="title" required> title
        <br><br>
        <textarea rows="20" cols="35" id="lyrics" name="lyrics" style="width:auto" required></textarea> lyrics
        <br><br>
        <input type="text" id="comment" name="comment"> comment
        <br><br>
        <input type="text" id="hash" name="hash" required> hash
        <br><br>
        <input type="submit" id="test" name="test" value="send">
    </form>
</div>

    </body>
</div>