<?php 

require("aaa/serv_db_cred.php");

error_reporting(-1); ini_set('display_errors', 'On'); $response =


array("error" => FALSE); $servername = "localhost"; //db host


if(isset($_POST['brandname'])){
    $brandname= $_POST['brandname'];
}
else{
    exit("No Brandname specified");
}

$conn = new

mysqli($servername, $username, $password, $dbname); // Check connection

if ($conn->connect_error) {

     die("Connection failed: " . $conn->connect_error);

}

$sql = "SELECT * FROM `MED` WHERE NAME = '$brandname' "; $result1 =

$conn->query($sql); if ($result1->num_rows > 0) {

    // output data of each row

    while($result = $result1->fetch_assoc()) { $response["error"] =

FALSE; $response["Manufacturer"] = $result["Manufacturer"];

$response["Brand"] = $result["Brand"]; $response["Type"] =

$result["Type"]; $response["Unit"] = $result["Unit"];

$response["PackageUnit"] = $result["PackageUnit"]; $response["PackagePrice"] =

$result["PackagePrice"]; $response["PricePerUnit"] = $result["PricePerUnit"];

$response["Genericsubstitutes"] = $result["Genericsubstitutes"];

$response["Indication"] = $result["Indication"];

$response["Prescription"] = $result["Prescription"]; $response["Caution"] =

$result["Caution"]; $response["SideEffects"] = $result["SideEffects"]; $response["Constituents"] = $result["Constituents"] ;

}

}

else { $response["error"] = true;

}
header("Content-type:application/json");
echo json_encode($response); $conn->close(); ?>

