<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/styles.css">
  <title>Whois client</title>
</head>
<body>
<h2>Details </h2>

  <?php 
  var_dump($_GET);
    if(isset($_GET["patientID"])) {
      echo "This is the id to use to searhc the database for the patient details" . $_GET["patientId"];
    } else {
      echo "Please add the Patient Id to this request";
    }
  ?>
</body>
</html>