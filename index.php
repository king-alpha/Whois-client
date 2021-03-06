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
  <div class="root">
    <div class="main-content">
      <form action="index.php" method="POST" >
        <input id="domain-input" name="domainName" type="text" placeholder="search a domain" >
        <button id="search" type="submit">Search</button>
      </form>
    </div>
  </div>

  <?php 
    if(isset($_POST["domainName"])) {
      $domain = $_POST["domainName"];

      $data = array("domainName" => $domain, "apiKey" => "at_jnQ1HKkyv7cyqHL21HQZe8SK0C2al",
      "outputFormat" => "JSON");
  
      $string = http_build_query($data); 
  
      $ch = curl_init("https://www.whoisxmlapi.com/whoisserver/WhoisService");
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response =  curl_exec($ch);
      curl_close($ch);
      $json_response =  json_decode($response, true);

      // Checking to see if domain name is invalid 
      if(isset($json_response["ErrorMessage"])) {
        // if domain name is invalid, quit php process and display the error message
        die($json_response["ErrorMessage"]["msg"]);
      }
      
      // parsing response from Whois API to php associative array
      $whois_record = $json_response["WhoisRecord"];

      // checking if property domainName exists on the array, if so return 
      //that value else return an empty string, same principle applies to the rest
      //of the code below.
      $domainName = $whois_record["domainName"] ? $whois_record["domainName"] : "";

      if(isset($whois_record["technicalContact"])) {
        // fetch property technicalContact on the whosis_record assoc array
        $technical_contact = $whois_record["technicalContact"];

        // fetch individual properties on the technical_contact assoc array
        $organization = $technical_contact["organization"];
        $city = $technical_contact["city"];
        $state = $technical_contact["state"];
        $country = $technical_contact["country"];
        $email = $technical_contact["email"];
        $telephone = $technical_contact["telephone"];
        $name = $technical_contact["name"];
      } else  {
        // fall back values to use when the if side does not run
        $organization = "";
        $city = "";
        $state = "";
        $country = "";
        $email = "";
        $telephone = "";
        $name = "";
      }
      
      $created_date = isset($whois_record["createdDate"]) ? 
        $whois_record["createdDate"] : "";
      
      $updated_date = isset($whois_record["updatedDate"]) ?
        $whois_record["updatedDate"] : "";

      $expiration_date = isset($whois_record["expiresDate"]) ?
        $whois_record["expiresDate"] : "";
      
      $host_names = isset($whois_record["nameServers"]) ?
        $whois_record["nameServers"]["hostNames"] : "";
      
      $registrar = isset($whois_record["registrarName"]) ?
        $whois_record["registrarName"] : "";
      
      // displaying results from Whois API
      echo "<div class='response-content'>";
      echo "<h4>" . "Domain Name: " . "<label>" . $domainName . "</label>" . "</h4>";
      foreach($host_names as $host_name) {
        echo "<h4>" . "Host Names: " . "<label>" . $host_name . "</label>" . "</h4>";
      }
      echo "<h4>" . "Name: " . "<label>" . $name . "</label>" . "</h4>";
      echo "<h4>" . "Registrar: " . "<label>" . $registrar . "</label>" . "</h4>";
      echo "<h4>" . "Organization: " . "<label>" . $organization . "</label>" . "</h4>";
      echo "<h4>" . "City: " . "<label>" . $city . "</label>" . "</h4>";
      echo "<h4>" . "State: " . "<label>" . $state . "</label>" . "</h4>";
      echo "<h4>" . "Country: " . "<label>" . $country . "</label>" . "</h4>";
      echo "<h4>" . "Creation Date: " . "<label>" . $created_date . "</label>" . "</h4>";
      echo "<h4>" . "Updated Date: " . "<label>" . $updated_date . "</label>" . "</h4>";
      echo "<h4>" . "Expiration Date: " . "<label>" . $expiration_date . "</label>" . "</h4>";
      echo "<h4>" . "Email: " . "<label>" . $email . "</label>" . "</h4>";
      echo "<h4>" . "Telephone: " . "<label>" . $telephone . "</label>" . "</h4>";
      echo "</div>";
    }

  ?>
</body>
</html>