<?php
require ('vendor/autoload.php');
?>

<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    header('Content-Type: application/json');

    $data=new \IntrovertTest\IntrovertApi('fga_date','2025-05-15',[24374824,57202302,247654035]);

    echo  $data->returnJsonData();
    exit();
}

header("Location: /view/web/index.html");
exit();


?>

