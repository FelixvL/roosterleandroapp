<?php
if(isset($_POST['inloggen']) && md5($_POST['inloggen'])== "55e761d1b015b0064833547ca9fdcd68"){
	setcookie("wachtwoord", md5($_POST['inloggen']));
	header("Location: overzicht.php");	
}
if(isset($_COOKIE["wachtwoord"]) && $_COOKIE["wachtwoord"] == "55e761d1b015b0064833547ca9fdcd68"){
    require "includes/werkdagenfunctions.php";
    require "includes/werkdagenfunctionsbeheer.php";
?>
REMINDMAIL
<?php
$conn = getConnection();
$sql = "SELECT * FROM werkdag WHERE status = 1 AND koper = '".$_REQUEST['klant']."' ORDER BY datum; ";
$rs = $conn->query($sql);

if ($rs->num_rows > 0) {
    factuurdagen($rs);
} else {
    echo "0 results";
}
?>
<?php



}else{
?>
    <form action="overzicht.php" method="post">
    <input type="password" name="inloggen">
    </form>
    
<?php
	
}

?>
