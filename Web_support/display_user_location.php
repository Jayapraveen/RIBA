<?php
require("aaa/serv_db_cred.php");

function getaddress($latitude, $longitude) {
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($latitude) . ',' . trim($longitude) . '&sensor=false&key=AIzaSyCP70c3N4QUnMZOivvivF0zS8cBIbnbaRI';
    $json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    return( $data->results[0]->formatted_address);
   
}

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection = new mysqli($servername, $username, $password, $dbname); // Check connection

if ($connection->connect_error) {

     die("Connection failed: " . $connection->connect_error);

}


// Select all the rows in the markers table
$query = "SELECT * FROM users_info WHERE 1";
$user_info = "SELECT * FROM `login_db` WHERE 1 ; SELECT * FROM users_info WHERE 1";
$result = $connection->query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}


header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while($row = $result->fetch_assoc()) {
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name",$row['Name']);
  $newnode->setAttribute("address", getaddress( $row['latitude'],$row['longitude']));
  $newnode->setAttribute("lat", $row['latitude']);
  $newnode->setAttribute("lng",  $row['longitude']);
}

echo $dom->saveXML();

?>