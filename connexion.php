<?php

#information de connection a la base de données
@ini_set('display_errors', 'on');
$serverName = "info88.cegepthetford.ca"; //addresse du serveur
$connectionInfo = array( "Database"=>"3r3_dev", 
"UID"=>"dev", "PWD"=>"videoRonald2021*");
// "61ueNxPCDUoEGuqx");
$conn = sqlsrv_connect($serverName, $connectionInfo);

//if( $conn ) {
 //echo "Connexion réussie.<br />";
 //echo "Bienvenue ".$_POST['email'];
//}else{
 //echo "Connexion échouée.<br />";
 //die( print_r( sqlsrv_errors(), true));

#email et password venant du form
$email = $_POST['email'];
$passwd = $_POST['password'];

#vérif si form remplis
if(empty($_POST['email']) || empty($_POST['password'])){
?>
<script type="text/javascript">
alert("S'il vous plait, veuillez remplir tous les champs!");
window.location.href = "form.php";
</script>
<?php
}else{

#vérif correspondance hash de la DB avec le mot de passe donné
$query = "SELECT passwd FROM [dbo].[Gestionnaires] WHERE courriel='{$email}'";
$resultHash = sqlsrv_query($conn, $query);  
//echo sqlsrv_fetch_array($result);

#vérif si le hash est identique au mot de passe
if($resultHash === false){
 die( print_r( sqlsrv_errors(), true));
} else {
   $result = password_verify($password, $resultHash);
   if($result) {
session_start();
while($row = sqlsrv_fetch_array($result)){
   $_SESSION['id'] = $row['id'];
   $_SESSION['courriel'] = $row['courriel'];
}
header("Location: gestion.php");
      }
   }
}
sqlsrv_close( $conn);
?>
