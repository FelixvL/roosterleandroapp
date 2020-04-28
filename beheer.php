<?php
if(isset($_POST['inloggen']) && md5($_POST['inloggen'])== "baa84a8e8361ff6ccfa98011faeefe28"){
	setcookie("wachtwoord", md5($_POST['inloggen']));
	header("Location: overzicht.php");	
}
if(isset($_COOKIE["wachtwoord"]) && $_COOKIE["wachtwoord"] == "baa84a8e8361ff6ccfa98011faeefe28"){
    require "includes/werkdagenfunctions.php";
    require "includes/werkdagenfunctionsbeheer.php";
?>
<link rel="stylesheet" type="text/css" href="includes/werkdagen.css">
<script src="includes/werkdagenfunctions.js"></script>
<script>
function uitgevoerd(dagId){
    backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxveranderstatusdag.php?dagcode="+dagId+"&status=4", herladen);
}
function resetten(dagId){
    backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxveranderstatusdag.php?dagcode="+dagId+"&status=3", herladen);
}
function blokkeren(dagId){
    backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxveranderstatusdag.php?dagcode="+dagId+"&status=0", herladen);
}
function betaald(dagId){
    backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxveranderstatusdag.php?dagcode="+dagId+"&status=5", herladen);
}
function archiveren(dagId){
    backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxveranderstatusdag.php?dagcode="+dagId+"&status=6", herladen);
}
function definitief(dagId, checkedOrNot){
    if(checkedOrNot){
        backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxveranderstatusdag.php?dagcode="+dagId+"&status=-1", herladen);
    }else{
        backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxveranderstatusdag.php?dagcode="+dagId+"&status=1", herladen);
    }
}
function addfactuurnummer(dagId,veld){
    backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxvoegfactuurnummertoe.php?dagcode="+dagId+"&factuurnummer="+veld.value, debug);
}
function addprijs(dagId,veld){
    backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxvoegprijstoe.php?dagcode="+dagId+"&prijs="+veld.value, debug);
}

function addcompri(dagId,veld){
    backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxvoegcommentstoe.php?dagcode="+dagId+"&compri="+veld.value, debug);
}

</script>
<!--
Beheer
<table><tr><td>
<input type=radio checked id=bedrijfsnaam name=bedrijfsnaam value=itph>itph<br>
<input type=radio id=bedrijfsnaam name=bedrijfsnaam value=qien>qien<br>
<input type=radio id=bedrijfsnaam name=bedrijfsnaam value=nextprogram>nextprogram<br>
</td><td>
<input type=button value=remindmail onclick=remindmail()>
<input type=button value=factuur onclick=maakfactuur()>
</td></tr></table>
-->
<a href=overzicht.php>overzicht</a>
<table><tr><td>
<?php
$conn = getConnection();
$sql = "SELECT * FROM werkdag WHERE status < 5 ORDER BY datum ";
$rs = $conn->query($sql);

if ($rs->num_rows > 0) {
    toonWerkdagenBeheer($rs);
    echo "<hr>BETAALD - BETAALD - BETAALD - BETAALD - BETAALD - BETAALD - BETAALD - BETAALD<hr>BETAALD - BETAALD - BETAALD - BETAALD - BETAALD - BETAALD - BETAALD - BETAALD<hr>";
    if(isset($_REQUEST["all"])){
        echo "HOIHOI";
        $sql = "SELECT * FROM werkdag WHERE status >= 5 ORDER BY datum ";
    }else{
        $sql = "SELECT * FROM werkdag WHERE status = 5 ORDER BY datum ";
    }

    $rs = $conn->query($sql);
    toonBetaaldeDagen($rs);
} else {
    echo "0 results";
}
?>
</td></tr>
</table>
<?php echo $totaalBTWOmzet ."-". $totaalBTWOmzet*0.21."-".$totaalBTWOmzet*1.21; ?>
<br><br>
reserveren/beheer.php?all=true
<?php



}else{
	header("Location: overzicht.php");	
}

?>
