<?php
header('Access-Control-Allow-Origin: *');
ini_set('session.save_path', './session');
ini_set('session.cookie_secure', 0);

session_name('masession');
session_start();

$filename = './predictions.json';
$handle = fopen($filename, "a+");
// true = array, false = object
$content = json_decode(file_get_contents($filename), true);

if (isset($_POST['tokenId']) && isset($_POST['json'])) {
    if ($content == null) {
        $var = array(
            $_POST['tokenId'] => $_POST['json']
        );
        file_put_contents($filename, json_encode($var));
    }
    else {
        $content[$_POST['tokenId']] = $_POST['json'];
        file_put_contents($filename, json_encode($content));
    }
}

if (isset($_GET['tokenId'])) {
    echo json_encode($content[$_GET['tokenId']]);
}

fclose($handle);
?>
