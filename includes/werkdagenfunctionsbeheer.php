<?php
function toonWerkdagenBeheer($dataset){
    echo "<table border=1>";
    while($row = $dataset->fetch_assoc()) {
        echo extraLijnen($row);
        if($row["status"] != 5){
            echo "<tr><td class='".getClassOptie($row["status"])."'></td><td class='".getClassOptie($row["status"])."'> ".$row["id"]." </td><td>". toonDatumBeheer($row["datum"]). "</td><td class=".getClass($row["informatie_id"])."> ".codeNaarPlaatsNaam(substr($row["informatie_id"],1 ), "admin")."   (".$row['status'].") </td><td>".getButtons($row)."</td><td>".getTextInputs($row)."</td></tr>\n";
        }
    }
    echo "</table>";

}
function toonBetaaldeDagen($dataset){
    echo "<table border=1>";
    while($row = $dataset->fetch_assoc()) {
        echo extraLijnen($row);
        if($row["status"] == 5 || $row["status"] == 6){
            echo "<tr><td ></td><td></td><td>". toonDatumBeheer($row["datum"]). "</td><td class=".getClass($row["informatie_id"])."> ".codeNaarPlaatsNaam(substr($row["informatie_id"],1 ), "admin")." (".$row['factuurnummer'].")  (".$row['status'].") </td><td>".toonGegevens($row)."</td><td><input type=\"button\" value=\"archiverenBTWBetaald\" onclick=archiveren(".$row["id"].")></td></tr>\n";
        }
    }
    echo "</table>";
}

function toonDatumBeheer($datum){
        $timestamp = strtotime($datum);
        $weekdag = getWeekdag(date('N', $timestamp));
        $daginmaand = date('j', $timestamp);
        $maand = getMaandNaam(date('n', $timestamp));
        $jaar = date('Y', $timestamp);
        return substr($weekdag,0,2) . " ". $daginmaand ." " . substr($maand,0,3) . " " . $jaar;
}

function getButtons($record){
    $buttonString = "<input type=button value=uitgvrd onclick=uitgevoerd(".$record["id"].")>";
    //$buttonString .= "<input type=button value=gefactureerd onclick=gefactureerd(".$record["id"].")>";
    $buttonString .= "<input type=button value=btld onclick=betaald(".$record["id"].")>";
    $buttonString .= "<input type=button value=rst onclick=resetten(".$record["id"].")>";
    $buttonString .= "<input type=button value=blok onclick=blokkeren(".$record["id"].")>";
    $buttonString .= "<input type=checkbox onchange=definitief(".$record["id"].",this.checked) ".isCheckedReserved($record["status"])." >";
    return $buttonString;
}

function factuurdagen($dataset){
    while($row = $dataset->fetch_assoc()) {
        echo "dag:".toonDatum($row["datum"])."<br>";
    }
}
function getTextInputs($record){
    $inputString = "<input value=\"".$record["factuurnummer"]."\" size=4 onchange=\"addfactuurnummer(".$record["id"].",this)\"><input value=\"".$record["prijs"]."\" size=4 onchange=\"addprijs(".$record["id"].",this)\"><input value=\"".$record["compub"]."\" onchange=\"addcompub(".$record["id"].",this)\"><input value=\"".$record["compri"]."\" onchange=\"addcompri(".$record["id"].",this)\">";
//    <input
    return $inputString;
}
$totaalBTWOmzet = 0;
function toonGegevens($record){
    $dagPrijs = $record["prijs"];
    global $totaalBTWOmzet;
    $totaalBTWOmzet += $dagPrijs;
    $gegevensString = "".$dagPrijs."</td><td>".($dagPrijs*0.21)."</td><td>". ($dagPrijs*1.21);
    return $gegevensString;
}
?>