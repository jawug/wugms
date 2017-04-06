 <?php 
 // Connects to the Database 
$username="rbcpapp";
$password="rbcpapp";
$database="wugms";
$server="192.168.72.40";

$con=mysqli_connect($server,$username,$password,$database);
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?> 