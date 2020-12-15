<?php

#includes a database connection
@ini_set('display_errors', 'on');
$serverName = "info88.cegepthetford.ca"; //serverName\instanceName
$connectionInfo = array( "Database"=>"3r3_dev", 
"UID"=>"dev", "PWD"=>"videoRonald2021*");
// "61ueNxPCDUoEGuqx");
$conn = sqlsrv_connect($serverName, $connectionInfo);

//if( $conn ) {
 //echo "Connection established.<br />";
 //echo "Bienvenue ".$_POST['email'];
//}else{
 //echo "Connection could not be established.<br />";
 //die( print_r( sqlsrv_errors(), true));

#catches user/password submitted by html form
$email = $_POST['email'];
$passwd = $_POST['password'];

#checks if the html form is filled
if(empty($_POST['email']) || empty($_POST['password'])){
?>
<script type="text/javascript">
alert("S'il vous plait, veuillez remplir tous les champs!");
window.location.href = "form.php";
</script>
<?php
}else{

#verifies hash from database with given password
$query = "SELECT passwd FROM [dbo].[Gestionnaires] WHERE courriel='{$email}'";
$resultHash = sqlsrv_query($conn, $query);  
//echo sqlsrv_fetch_array($result);

#checks if hash was identical (right password)
if($resultHash === false){
 die( print_r( sqlsrv_errors(), true));
} else {
   $result = password_verify($password, $resultHash);
   if($result) {
#redirects user
session_start();
while($row = sqlsrv_fetch_array($result)){
   $_SESSION['id'] = $row['id'];
   $_SESSION['courriel'] = $row['courriel'];
header("Location: gestion.php");
      }
   }
}
sqlsrv_close( $conn);
?>
