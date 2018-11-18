<?php

header("Access-Control-Allow-Origin: *");
if(isset($_GET["q"])){
    $query = $_GET["q"];
}
else{
    exit("No Query specified");
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Android Parser</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
  </head>
  <body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
requrl = "https://riba-testing0.herokuapp.com/chatterbot/"
function messenger() {
  
  var inputData = {
          'text':<?php echo $query; ?>
        }
  
        var $submit = $.ajax({
          type: 'POST',
          url: requrl,
          data: JSON.stringify(inputData),
          contentType: 'application/json'
        });
        $submit.done(function(statement) {
        document.write(statement.text);
        })
  }
messenger()
document.write("he");
</script>

 </body>
</html>