<?php

header("Access-Control-Allow-Origin: *");
if(isset($_GET["q"])){
    $query = $_GET["q"];
}
else{
    exit("No Query specified");
}

date_default_timezone_set('Asia/Kolkata');
$t = microtime(true);
$micro = sprintf("%03d",($t - floor($t)) * 1000);
$ist = gmdate('Y-m-d\TH:i:s.', $t).$micro.'Z';


$post = json_encode([
    'text' => $query
]);

$ch = curl_init('http://riba-testing0.herokuapp.com/chatterbot/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

// do anything you want with your response
$out = json_decode($response, true);


echo '{
  "query": "'; echo $query; 
  echo'",
           "count": 1,
           "client_id": "aG9zdF8xNzIuNjguMTQ2LjE4NF81YzJiYjE3MQ==",
           "query_date": "';
           echo $ist;
           echo'",
           "answers": [{
             "data": [
               {
                   "example": "search dog"
                 },
      
               {"idea": 
               {
                   "id": 1282021749,
                 "actions": [{
                   "select": "random",
                   "language": "en",
                   "type": "answer",
                   "phrases": ["Das verstehe ich nicht. Du kannst auf diese Frage nur ja oder nein antworten."]
                 }]
               }}
             ],
            
             "actions": [
              {
                 "language": "en",
                 "type": "answer",
                 "expression": "'; echo $out['text'];
                 echo'"
               }
             ],
             "skills": ["/susi_skill_data/models/general/Knowledge/en/websearch.txt"],
             "persona": {}
           }],
           "answer_date": "';
           echo $ist;
           echo'",
           "answer_time": 90,
           "language": "en",
           "session": {
             "identity": {
             "type": "host",
             "name": "172.68.146.184_5c2bb171",
             "anonymous": true
           }}
         }'


?>