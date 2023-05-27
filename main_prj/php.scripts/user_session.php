<?php
header('Access-Control-Allow-Origin: *');
ini_set('session.save_path', './session');
ini_set('session.cookie_secure', 0);

session_name('masession');
session_start();

$login = (string)$_POST['LOGIN'];
$pswd = (string)$_POST['PASSWORD'];

$str_tmp = $login . $pswd;

$_SESSION['ulogin'] = $login;
$_SESSION['upswd'] = $pswd;

$filename = './accounts.json';
$handle = fopen($filename, "r+"); 
$content = json_decode(file_get_contents($filename), true);
foreach($content as &$item) { //foreach element in $arr
    if($item['belong'] == $str_tmp)
        break;

    if($item['is_busy'] != 'yes') {
        $item['belong'] = $str_tmp;
        $item['is_busy'] = 'yes';
        $item['login'] = $login;
        $item['pswd'] = $pswd;
        break;
    }
}
file_put_contents($filename, json_encode($content));
fclose($handle);

$filename = './session.json';
$handle = fopen($filename, "r+");
$content = json_decode(file_get_contents($filename), true);
$content['user'] = $str_tmp;

file_put_contents($filename, json_encode($content));
fclose($handle);
?>
