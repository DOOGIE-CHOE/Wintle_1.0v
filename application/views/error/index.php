<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/12/2016
 * Time: 5:07 PM
 */
?>
<head>
    <style>
        #bg{
            position:fixed;
            height:100%;
            width:100%;
            background-repeat: no-repeat;
            background-image: url("<?php echo URL?>img/bg/bg1.png");
            background-size: cover;
        }

        #display-error{
            position:relative;
            width:500px;
            height:350px;
            background: rgba(0,0,0,0.5);
            margin:auto;
            top:70px;
        }
    </style>
</head>

    <body id="body">

    <div id="bg"></div>
    <div>
    <div id="display-error"></div>


    </div>
    <?php echo $this->msg;?>
    </body>
</div>

<div id="all">