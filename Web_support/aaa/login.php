<?php 


require("serv_db_cred.php");

if(isset($_GET['login'])){
    $user= $_GET['login'];
    $pass= $_GET['password'];


error_reporting(-1); ini_set('display_errors', 'On'); 

$conn = new mysqli($servername, $username, $password, $dbname); // Check connection

if ($conn->connect_error) {

     die("Connection failed: " . $conn->connect_error);

}

$sql = "SELECT * FROM `login_db` WHERE USERNAME= '$user' and PASSWORD= '$pass' "; 

$result1 = $conn->query($sql); 

if ($result1->num_rows > 0) {

    // output data of each row

    while($result = $result1->fetch_assoc()) {
        $hash = $result["hash"];    
        $response=array(
            'accepted' => 'true',
            'valid_seconds' => 604800,
            'uuid' => "cefb526f7622effd288e901bda3724db",
            'access_token' => $hash,
            'message' => "you are logged in as $user",
            'session' => array( 
                'identity' =>
                array(
                    'type' => 'host',
                    'name' => 'device_host',
                    'anonymous' => true,
                    ),
                ),
            
            );    
}

}

else { $response["error"] = true;
    echo(var_dump(http_response_code(422)));
    echo("<title>Error 422 Invalid credentials</title>");
    echo("HTTP ERROR 422 <br> ");
    exit("invalid credentials");

}

header("Content-type:application/json");
echo json_encode($response); 
$conn->close(); 

}
else{
    echo("<title>Error 400 Bad login parameters.</title>");
    echo("HTTP ERROR 400 <br>");
    exit("Bad login parameters.");
    
}

?>

