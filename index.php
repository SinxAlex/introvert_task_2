<?php
require ('vendor/autoload.php');
?>

<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    header('Content-Type: application/json');

    $data=new \IntrovertTest\IntrovertApi('testDate2','2025-05-15',[24374824,57202302,247654035]);

    echo json_encode(['success' => true, 'message' => 'AJAX-ответ', 'data' => $data->returnJsonData()]);
    exit();
}

header("Location: /view/web/index.html");
exit();


?>

