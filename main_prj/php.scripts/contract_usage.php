<?php
header('Access-Control-Allow-Origin: *');
ini_set('session.save_path', './session');
ini_set('session.cookie_secure', 0);

session_name('masession');
session_start();

$filename = './contract.json';
$handle = fopen($filename, "r+");
$content = json_decode(file_get_contents($filename), true);

if (isset($_POST['contract'])) {
    $content['address'] = $_POST['contract'];
    echo $_POST['contract'];
    file_put_contents($filename, json_encode($content));
}

if (isset($_GET['contract'])) {
    echo $content['address'];
}

fclose($handle);
?>
