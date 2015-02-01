<?
  $servername = getenv("DB_SERVER_NAME");
  $username = getenv("DB_USER_NAME");
  $password = getenv("DB_PASSWORD");
  $dbname = getenv("DB_NAME");
  try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
?>