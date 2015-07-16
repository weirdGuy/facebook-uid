<?php

    require_once('core.class.php');
    $FUID = new FUID('YOURLOGIN', 'YOURPASS');
    $link = 'fbusernick';
    echo $FUID->getUid($link);
?>