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

#searches for email and password in the database
$query = "SELECT * FROM [dbo].[Gestionnaires] WHERE courriel='{$email}' AND passwd='{$passwd}'";
$result = sqlsrv_query($conn, $query);  
//echo sqlsrv_fetch_array($result);

#checks if the search was made
if($result === false){
 die( print_r( sqlsrv_errors(), true));
}

#checks if the search brought some row and if it is one only row
if(sqlsrv_has_rows($result) != 1){
   echo "Email/password not found";
}else{
  
while($row = sqlsrv_fetch_array($result)){
echo $row['courriel'];
}
#redirects user
header("Location: gestion.html");
}
}
sqlsrv_close( $conn);
?>