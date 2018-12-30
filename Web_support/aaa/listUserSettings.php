<?php 

if(isset($_GET['access_token'])){
    $token= $_GET['access_token'];

require("serv_db_cred.php");

error_reporting(-1); ini_set('display_errors', 'On'); 

$response = array("error" => FALSE); 

$conn = new mysqli($servername, $username, $password, $dbname); // Check connection

if ($conn->connect_error) {

     die("Connection failed: " . $conn->connect_error);

}

$sql = "SELECT * FROM `login_db` WHERE hash= '$token' "; 

$result1 = $conn->query($sql); 

if ($result1->num_rows > 0) {

    // output data of each row

    while($result = $result1->fetch_assoc()) {
        $user= $result["username"];
          
        $response=array(
            'lastLoginTime' => 'need to be implemented',
            'session' => array( 
                'identity' =>
                array(
                    'type' => 'email',
                    'name' => $user,
                    'anonymous' => false,
                    ),
                ),
            'accepted' => true,
            'message' => "Success: Showing user data",
            'lastLoginIP' => "needs to be implemented",
            
            );    
}

}

else { $response["error"] = true;

}

header("Content-type:application/json");
echo json_encode($response); 
$conn->close(); 

}
else{
    echo("HTTP ERROR 401 <br> ");
    exit("invalid access_token");
}

?>

