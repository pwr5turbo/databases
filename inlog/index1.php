<?php

function bootstrap(){
    $php_files = glob('/*.php');

    foreach($php_files as $files)
        include($files);
    }
echo "true";

?>