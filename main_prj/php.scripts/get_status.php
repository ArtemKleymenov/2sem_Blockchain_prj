<?php
header('Access-Control-Allow-Origin: *');
ini_set('session.save_path', './session');
ini_set('session.cookie_secure', 0);

session_name('masession');
session_start();

$filename = './session.json';
$handle = fopen($filename, "r+");
$content = json_decode(file_get_contents($filename), true);

if (isset($_POST['is_deployed'])) {
    $val = $content['is_deployed'];
    if ($val != (string)'true') {
        $content['is_deployed'] = 'true';
        file_put_contents($filename, json_encode($content));
    }
}

if (isset($_GET['user'])) {
    echo $content['user'];
}

if (isset($_GET['is_deployed'])) {
    echo $content['is_deployed'];
}

fclose($handle);
//echo phpinfo();
//header('location:contract_status.php');
?>
