<?php

    $fileContent = file_get_contents("http://webapps3.cfans.umn.edu/media/uploads/141482739154548d7fa6df7.png");
    echo "<img src='data:image/png;base64,".base64_encode($fileContent)."'>"; 

