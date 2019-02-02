<?php

header("Access-Control-Allow-Origin: *");
header("Content-type:application/json");

require("aaa/serv_db_cred.php");

function log_user_info($hash,$lat,$lon,$ip) {
require("aaa/serv_db_cred.php");
$conn = new mysqli($servername, $username, $password, $dbname); // Check connection

if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

$sql = "update users_info set ip = '$ip', latitude=$lat,longitude =$lon where hash = '$hash'"; 

$conn->query($sql); 
}



  function get_ip_address() {
    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      // check if multiple ips exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (validate_ip($ip))
                    return $ip;
            }
        } else {
            if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;

    // generate ipv4 network address
    $ip = ip2long($ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);
        // do private network range checking
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}


$skill = array('Realtime_marks_database','Chatbot_response');

date_default_timezone_set('Asia/Kolkata');
$t = microtime(true);
$micro = sprintf("%03d",($t - floor($t)) * 1000);
$ist = gmdate('Y-m-d\TH:i:s.', $t).$micro.'Z';


if(isset($_GET["q"])){
    $query = $_GET["q"];
}
else{
    exit("No Query specified");
}

if(isset($_GET["access_token"])){
    $hash = $_GET["access_token"];
}
else{
    $hash = NULL;
}
if(isset($_GET["device_type"])){
    $client = $_GET["device_type"];
}
else{
    $client = "Web client";
}
if(isset($_GET["latitude"])){
    $lat = $_GET["latitude"];
    $lon = $_GET["longitude"];
}
else{
    $lat = 0;
    $lon = 0;
}

log_user_info($hash,$lat,$lon,get_ip_address());

$client_id = base64_encode(get_ip_address());

$subjects_list = array("Fundamentals of Computing", "Theory of Computation", "Graph Theory", "Data Structures", "Mathematics" , "Operating systems" , "Database and SQL" , "Networking" , "Mobile computing");

$sub_count = count($subjects_list);

$post = json_encode([
  'text' => $query
]);

$ch = curl_init('https://rec-riba.herokuapp.com/chatterbot/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

// do anything you want with your response
$out = json_decode($response, true);


$marks_check = "mark";
$grade_check = "grade";


if ((strstr($query, $marks_check) || strstr($query, $grade_check)) && $hash != NULL) {

error_reporting(-1); ini_set('display_errors', 'On'); 


$conn = new mysqli($servername, $username, $password, $dbname); // Check connection

if ($conn->connect_error) {

     die("Connection failed: " . $conn->connect_error);

}

if ($hash != NULL){
$sql = "SELECT * FROM `marks` WHERE hash= '$hash' "; 

$result1 = $conn->query($sql); 
$row_count = $result1->num_rows;
if ($row_count > 0) {
    while($result = $result1->fetch_assoc()) {   
        $response=array(
            'query' => $query,
            'count' => 1,
            'client_id' => $client_id,
            'access_token' => $hash,
            'query_date' => $ist,
            'answers' => array(array(
                
                    'metadata' => array(
                        'count' => 8,
                    ),
                    'actions'=> array(array(
                      'columns' => array(
                        'subjectname' =>"Subject Name",
                        'marks' =>'Marks'
                                        ),
                      'type' => 'table'
                  ),),
            'skills' => array($skill[0]),
            'persona' => array(),
            ),),
            'answer_date' => $ist,
            'answer_time' => '60',
            'language' => 'en',
            'session' => array(
                'identity' => array(
                    'type' => $client,
                    'name' => $client_id,
                    'anonymous' => false,
                ),
            ),
            
            ); 

        foreach (range(0, 8) as $number) {
                 $marks_arr[] = array(
                    'subjectname' => $subjects_list[$number],
                    'marks' => $result[$subjects_list[$number]]
                );
              }  

              $response['answers'][]['data'] = $marks_arr;
}
}

else { 
    $response["error"] = true;
}

echo json_encode($response); 

$conn->close(); 
}

}

else{
   $phrases = array('RIBA_ANSWER');
   $response = array(
      'query' => $query,
      'count' => 1,
      'client_id' => $client_id,
      'query_date' => $ist,
      'answers'=> array(array(
               'data' => array(array(
                     'example' => "What is your name?",
                   ),),
        
                'idea' =>  array(
                     'id' => 1282021749,
                     'actions' => array(array(
                     'select' => 'random',
                     'language' => 'en',
                     'type' => 'answer',
                     'phrases' => $phrases,
                   ),),
                ),
               'actions' => array(array(
                   'language' => 'en',
                   'type' => 'answer',
                   'expression' => $out['text'],
                 ),),
               'skills' => array($skill[1]),
               'persona' => array(),
             ),),
             'answer_date' => $ist,
             'answer_time' => 90,
             'language' => "en",
             'session' => array(
               'identity'=> array(
               'type'=> 'host',
               'name'=> '172.68.146.184_5c2bb171',
               'anonymous'=> true
             ),),
           );
  echo json_encode($response);
 }

?>