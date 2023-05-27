<?php
header('Access-Control-Allow-Origin: *');
ini_set('session.save_path', './session');
ini_set('session.cookie_secure', 0);

session_name('masession');
session_start();

$_SESSION['contract_status'] = 'false';

$post_data = $_POST['GanacheAccounts'];
$filename ='./accounts.json';
$handle = fopen($filename, "r+"); 
$content = json_decode(file_get_contents($filename), true);
print_r($content);

if (empty($post_data)) {   
    fwrite($handle, 'Hmm, I did NOT get any data from AJAX');  
}
if (!empty($post_data) && ($content == null)) {
    $temp_array = array();
    foreach($post_data as $item) { //foreach element in $arr
        $temp_array[] = array("address" => $item, 
                                "is_busy" => 'no', 
                                "belong" => null); 
                            //   "login" => null, 
                            //   "pswd" => null);
    }
    $temp_array[0]['is_busy'] = 'yes';
    // https://stackoverflow.com/questions/8858848/php-read-and-write-json-from-file
    file_put_contents($filename, json_encode($temp_array));

    // Write an array
    //fwrite($handle, print_r($post_data, TRUE));
    // BASIC writing
    //fwrite($handle, $post_data);
}
fclose($handle);
?>