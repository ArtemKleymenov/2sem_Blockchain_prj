<?php
header('Access-Control-Allow-Origin: *');
ini_set('session.save_path', './session');
ini_set('session.cookie_secure', 0);

session_name('masession');
session_start();

$filename = './session.json';
$handle = fopen($filename, "r");
$content = json_decode(file_get_contents($filename), true);

if (isset($_GET['curr_login']) or isset($_GET['curr_pswd']) 
    or isset($_GET['curr_addr']) or isset($_GET['is_ver'])) {
    $cu = $content['user'];
    // print_r($cu);
    $fname = './accounts.json';
    $inner_h = fopen($fname, "r"); 
    $inner_c = json_decode(file_get_contents($fname), true);
    foreach($inner_c as $item) { //foreach element in $arr
        if($item['belong'] == $cu) {
            if(isset($_GET['curr_login']))
                echo $item['login'];
            if(isset($_GET['curr_pswd']))
                echo $item['pswd'];
            if(isset($_GET['curr_addr']))
                echo $item['address'];
            if(isset($_GET['is_ver']))
                echo $item['verified'];
            break;
        }
    }
    fclose($inner_h);
}

if (isset($_POST['verified'])) {
    $cu = $content['user'];
    // print_r($cu);
    $fname = './accounts.json';
    $inner_h = fopen($fname, "r"); 
    $inner_c = json_decode(file_get_contents($fname), true);
    foreach($inner_c as &$item) { //foreach element in $arr
        if($item['belong'] == $cu) {
            $item['verified'] = $_POST['verified'];
            break;
        }
    }
    file_put_contents($fname, json_encode($inner_c));
    fclose($inner_h);
}

fclose($handle);
?>