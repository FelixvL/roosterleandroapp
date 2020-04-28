<?php
if(isset($_POST['inloggen']) && md5($_POST['inloggen'])== "baa84a8e8361ff6ccfa98011faeefe28"){
	setcookie("wachtwoord", md5($_POST['inloggen']));
	header("Location: overzicht.php");	
}
if(isset($_COOKIE["wachtwoord"]) && $_COOKIE["wachtwoord"] == "baa84a8e8361ff6ccfa98011faeefe28"){
    require "includes/werkdagenfunctions.php";
?>
<style>
    .normaledag{
        background-color: green;
    }
    .weekenddag{
        background-color: orange;
    }

</style>
<link rel="stylesheet" type="text/css" href="includes/werkdagen.css">
<script src="includes/werkdagenfunctions.js"></script>
<script>

    var nu = new Date(Date.now());
    function toondata(){
        var vandaag = new Date(nu.getFullYear(), nu.getMonth(), nu.getDate(), 12, 0, 0);
        var dagen = verkrijgDagen(vandaag);
        toonDagen(dagen);
    }
    function verkrijgDagen(eersteDag){
        var dagen = [];
        for(var x = 0 ; x < gebi("aantalDagen").value ; x++){
            eersteDag = addDays(eersteDag, 1);
            dagen.push(eersteDag);
        }
        nu = dagen[dagen.length - 1];
        return dagen;
    }
    function toonDagen(deDagen){
        var returnString = "<table border=1>";
        returnString += dagenSelectieTabelHeader();
        for(var x = 0 ; x < deDagen.length ; x++){
            returnString += dagenSelectieRegel(deDagen[x]);
        }
        returnString += "</table>";
        var nieuweDagenDiv = gebi("nieuwedagen");
        nieuweDagenDiv.innerHTML += returnString;
    }
    function dagenSelectieTabelHeader(){
        var returnString = "<tr><th>reserveer</th><th>Weekdag</th><th>Dag</th><th>Maand</th><th>Jaar</th></tr>";
        return returnString;
    }
    function dagenSelectieRegel(deWerkdag){
        var returnString = "";
        if(deWerkdag.getDay() == 0 || deWerkdag.getDay() == 6){
            var rijClass = "normaledag";
        }else{
            var rijClass = "weekenddag";
        }
        if(newMonth(deWerkdag.getMonth())){
            returnString += "<tr><td>"+deWerkdag.getMonth()+"</td><td></td><td></td><td></td><td></td></tr>";
        }
        returnString += "<tr class="+rijClass+"><td><input type=checkbox onclick=activeerDag("+deWerkdag.getTime()+") ></td><td>"+deWerkdag.toDateString()+"</td><td>"+deWerkdag.getDate()+"</td><td>"+deWerkdag.getMonth()+"</td><td>"+deWerkdag.getFullYear()+"</td></tr>";
        return returnString;
    }
    var previousMonth = -1;
    function newMonth(month){
        if(previousMonth == month){
            return false;
        }
        previousMonth = month;
        return true;
    }
    function addDays(date, days) {
        var result = new Date(date);
        result.setDate(result.getDate() + days);
        return result;
    }
    function activeerDag(dagCode){
        backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxvoegdagtoe.php?dagcode="+dagCode, demodata);
    }
 
    function demodata(responseText){
        gebi("demo").innerHTML = responseText;
    }

    function verwijderDag(dagId){
        backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxverwijderdag.php?dagcode="+dagId, herladen);
    }
    function keurGoed(dagId){
        backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxgoedkeurendag.php?dagcode="+dagId, herladen);
    }
    function keurFout(dagId){
        backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxfoutkeurendag.php?dagcode="+dagId, herladen);
    }
    function definitief(dagId, checkedOrNot){
        if(checkedOrNot){
            backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxveranderstatusdag.php?dagcode="+dagId+"&status=-1", herladen);
        }else{
            backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxveranderstatusdag.php?dagcode="+dagId+"&status=1", herladen);
        }
    }
    function addcompub(dagId,veld){
        backEndCall("GET","<?php echo $BASEURL ."/".basename(dirname(__FILE__)); ?>/ajax/ajaxvoegcommentstoe.php?dagcode="+dagId+"&compub="+veld.value, debug);
    }
</script>

<button onclick=toondata()>kijken</button><input type=number id=aantalDagen value=60><a href=beheer.php>Beheer</a>
<div id=nieuwedagen ></div>
<div id=demo ></div>
<table><tr><td>
<?php
$conn = getConnection();
$sql = "SELECT * FROM werkdag WHERE status < 4 ORDER BY datum ";
$rs = $conn->query($sql);

if ($rs->num_rows > 0) {
    toonWerkdagen("admin", $rs);
} else {
    echo "0 results";
}
?>
</td></tr></table>
<?php
echo md5("abc");
}else{
?>
    Beheer:<br>
    <form action="overzicht.php" method="post">
    <input type="password" name="inloggen">
    </form>
    
<?php
	
}

?>
