<?php
header('Access-Control-Allow-Origin: *');
ini_set('session.save_path', './session');
ini_set('session.cookie_secure', 0);

session_name('masession');
session_start();

$filename = './token_req.json';
$handle = fopen($filename, "r");
$content = json_decode(file_get_contents($filename), true);

if (isset($_POST['tokenId']) && isset($_POST['sender'])) {
    $data = array('tokenid' => $_POST['tokenId'],
                  'sender' => $_POST['sender'],
                  'status' => 'req');
    $content[] = $data;
    file_put_contents($filename, json_encode($content));
}

if (isset($_POST['delete_tok']) && isset($_POST['deleter'])) {
    foreach($content as $key => &$val) {
        $lhs = (string)$val['tokenid'];
        $rhs = (string)$_POST['delete_tok'];
        // https://www.php.net/manual/en/function.strcmp.php
        $equal = strcmp($lhs,$rhs); // return 0 if equal
        if (!$equal && $val['sender'] == $_POST['deleter']) {
            $val = null;
        }
    }
    file_put_contents($filename, json_encode($content));
}

if (isset($_POST['status']) && isset($_POST['whom']) && isset($_POST['what'])) {
    foreach($content as $key => &$val) {
        $lhs = (string)$val['tokenid'];
        $rhs = (string)$_POST['what'];
        // https://www.php.net/manual/en/function.strcmp.php
        $equal = strcmp($lhs,$rhs); // return 0 if equal
        if (!$equal) {
            if ($_POST['status'] == 'apv')
                $val['status'] = 'dec';
            if ($val['sender'] == $_POST['whom'])
                $val['status'] = $_POST['status'];
        }
    }
    file_put_contents($filename, json_encode($content));
}

if (isset($_GET['tokenId'])) {
    $ans = array();

    foreach($content as $key => $val) {
        $lhs = (string)$val['tokenid'];
        $rhs = (string)$_GET['tokenId'];
        // https://www.php.net/manual/en/function.strcmp.php
        $equal = strcmp($lhs,$rhs); // return 0 if equal
        if (!$equal) {
            $ans[] = $val;
        }
    }
    $out = array_values($ans);
    echo json_encode($out);
}

if (isset($_GET['sender'])) {
    $ans = [];
    foreach($content as $key => $val) {
        if ($val['sender'] == $_GET['sender']) {
            $ans[] = $val;
        }
    }
    $out = array_values($ans);
    echo json_encode($out);
}

if (isset($_GET['tokid']) && isset($_GET['user'])) {
    foreach($content as $key => $val) {
        $lhs = (string)$val['tokenid'];
        $rhs = (string)$_GET['tokid'];
        // https://www.php.net/manual/en/function.strcmp.php
        $equal = strcmp($lhs,$rhs); // return 
        if (!$equal && $val['sender'] == $_GET['user']) {
            echo 'true';
            return;
        }
    }
}


fclose($handle);
?>
