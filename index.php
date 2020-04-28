<?php
    require "includes/werkdagenfunctions.php";
    if(isset($_POST['inloggen']) && checkLogin($_POST['inloggen'], true)){
    setcookie("wachtwoordNPRP", md5($_POST['inloggen']));
    setcookie("usernameNPRP" , getGebruikerNaam(md5($_POST['inloggen'])));
	header("Location: index.php");	
}
if(isset($_COOKIE["wachtwoordNPRP"]) && checkLogin($_COOKIE["wachtwoordNPRP"], false)){
?>
<link rel="stylesheet" type="text/css" href="includes/werkdagen.css">
<script src="includes/werkdagenfunctions.js"></script>
<script>
    function selecteerDag(dagId, element){
        if(element.checked){
            verwerkdag(dagId);            
        }else{
            alert("Graag in 1 keer alle juiste dagen selecteren, de reservering wordt afgebroken, probeer opnieuw.");
            location.reload();
        }
    }
    var counter = 0;
    var bedrag = 750;
    var betalingsKenmerk = Math.floor(Math.random() * 10000);
    var gereserveerdeDagen = "";
    var klantEnLocatieCode = "";
    var klantEnLocatieZin = "";
    function verwerkdag(dagId){
        counter++;
        var reserveringDiv = gebi("reservering");
        reserveringDiv.innerHTML += gebi("dag"+dagId).innerHTML + "<br>";
        if(counter == 1){
            gereserveerdeDagen += dagId;
        }else{
            gereserveerdeDagen += "-"+dagId;
        }
        toonFactuur();
    }
    function toonFactuur(){
        var factuurDiv = gebi("factuur");
        factuurDiv.innerHTML = "" + klantEnLocatieZin +"<br>";
       // factuurDiv.innerHTML += "Totaalbedrag: "+ ((counter * bedrag * 1.21).toFixed(2))+ " Euro <br><br> <br><br>betalingskenmerk: "+ betalingsKenmerk;
        factuurDiv.innerHTML += "<br><br><input type=button class=betaaldbutton value='Reserveer!' onclick=reserveer()><br><input class=annuleerbutton type=button value='annuleer bestelling' onclick=location.reload()><br><br>Bestelde dagen: <br>";
        
    }
    function reserveer(){
        backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxreserveerdagen.php?klantlocatie="+klantEnLocatieCode+"&dagen="+gereserveerdeDagen+"&kenmerk="+betalingsKenmerk+"&koper=<?php echo $_COOKIE["usernameNPRP"]; ?>", herladen);
    }
    function toonagenda(){
        var dropdownboxen = document.getElementsByTagName("select");
        klantEnLocatieCode = "" + dropdownboxen[0].options[dropdownboxen[0].selectedIndex].value +""+ dropdownboxen[1].options[dropdownboxen[1].selectedIndex].value;
  //      klantEnLocatieZin = "" +  dropdownboxen[0].options[dropdownboxen[0].selectedIndex].innerHTML + " Locatie " +  dropdownboxen[1].options[dropdownboxen[1].selectedIndex].innerHTML;
        dropdownboxen[0].hidden = 'hidden';dropdownboxen[1].hidden = 'hidden';
        gebi("selecteerstad").hidden='hidden';
        gebi("agenda").hidden='';
        gebi('aanhef').innerHTML = '<?php echo $_COOKIE["usernameNPRP"]; ?>, Selecteer dagen voor '+dropdownboxen[1].options[dropdownboxen[1].selectedIndex].innerHTML;
    }

</script>
<table class=buitenkant style=width:1200px>
<tr><td valign="top">
   <div id=selecteerstad> Dag <?php echo $_COOKIE["usernameNPRP"]; ?>, <br>Selecteer de stad.<br><br>
<select id=klant hidden=hidden><option value=1 selected> </option></select>
<select id=locatie size=7 onclick=toonagenda() onchange=toonagenda()>
<?php
for($x = 0 ; $x < 7 ; $x++){
    echo "<option value=1".($x+1)." >".codeNaarPlaatsNaam($x+11, "admin")."</option>";
}
?>
</select>




<br><br>
Bedrijfsgegevens:<br>
<br>
NextProgram B.V.<br>
Eindhoven<br><br>
digitaleservice@gmail.com<br>
06 - 15 51 79 62<br>
<br><br>
Met vriendelijke groet,<br>
<br>
Felix van Loenen
</div>
</td><td valign="top"><div id=agenda hidden>
<?php


$conn = getConnection();

$sql = "SELECT * FROM werkdag WHERE status < 4 ORDER BY datum";

$rs = $conn->query($sql);


if ($rs->num_rows > 0) {
    toonWerkdagen("klant", $rs);
} else {
    echo "0 results";
}
?>
</div></td>
<td valign="top">
    <div style=position:fixed;left:700px>
<div id=aanhef></div>
<div id=reservering >
<div id=factuur></div>
</div>
</div>
</td></tr></table>
<?php
}else{
?>
    KlantCode:<br>
    <form action="index.php" method="post">
    <input type="password" name="inloggen">
    </form>
    
<?php
	
}

?>