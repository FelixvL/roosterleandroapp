<?php
require "db.php";

function checkLogin($wachtwoord, $convertit){
    if($convertit){
        $wachtwoord = md5($wachtwoord);
    }

    if(
        $wachtwoord == "baa84a8e8361ff6ccfa98011faeefe28"         
    ){
        return true;
    }else{
        return false;
    }

}
function getGebruikerNaam($wachtwoord){
    switch($wachtwoord){
        case "baa84a8e8361ff6ccfa98011faeefe28":    // 57795779
            return "Administrator";    
        }
}

function codeNaarPlaatsNaam($code, $rol){
    if($rol == "anoniem"){
        return $code;
    }else{
        switch($code){
            case 11:
                return "UtrechtQ";
            case 12:
                return "Amsterdam";
            case 13:
                return "Leiden";
            case 14:
                return "Zwolle";
            case 15:
                return "Groningen";
            case 16:
                return "UtrechtATA";
            case 17:
                return "Zaandam";
            default:
                return "vrij";        
        }
    }
}
function toonWerkdagen($rol , $dataset){
    echo "<table>";
    while($row = $dataset->fetch_assoc()) {
        echo extraLijnen($row);
        if($row["status"] != 2 || $rol == "admin"){
            echo "<tr><td ></td><td class='checkboxrij ".getClass($row["informatie_id"])."".getClassOptie($row["status"])."' >" . selecteerKolom($rol, $row["id"], $row['status']). "</td>
            <td id=dag".$row['id']." class=".getClass($row["informatie_id"])." >" . toonDatum($row). "</td>
            <td class=".getClass($row["informatie_id"])." >" . toonStatus($rol, $row). "</td>
            <td class=".getClass($row["informatie_id"])." >".getDefinitiefCheckBox($row, $rol)."</td>
            <td class=".getClass($row["informatie_id"])." >".adminActies($rol, $row["id"], $row['status'],$row)."</td>
            <td class=".getClass($row["informatie_id"])." >".$row["compub"] ."</td>
            <td class='".getClass($row["informatie_id"])."".getClassOptie($row["status"])."'></td></tr>\n\n";
        }
    }
    echo "</table>";

}
function getClassOptie($status){
    if($status == -1){
        return " optie";
    }
}
function getClass($informatieId){
    switch(substr($informatieId,1)){
        case 11:
            return "utrechtQ";
        case 12:
            return "amsterdam";
        case 13:
            return "leiden";
        case 14:
            return "zwolle";
        case 15:
            return "groningen";
        case 16:
            return "utrechtATA";
        case 17:
            return "zaandam";
        case 99:
            return "blocked";
        default:
            return "vrij";
        
    }
    return "abc".$informatieId;
}
$nieuweMaandChecker = -1;
$nieuweWeeknrChecker = -1;
function extraLijnen($rij){
    global $nieuweMaandChecker;
    global $nieuweWeeknrChecker;
    $timestamp = strtotime($rij['datum']);
    $weekNr = date('W', $timestamp);
    $maandNr = date('n', $timestamp);
    if($nieuweMaandChecker != $maandNr){
        $nieuweMaandChecker = $maandNr;
        $nieuweWeeknrChecker = $weekNr;
        return "<tr><td align='left' class=maand colspan=8>".getMaandNaam($maandNr)."</td></tr>";
    }
    if($nieuweWeeknrChecker != $weekNr){
        $nieuweWeeknrChecker = $weekNr;
        return "<tr><td align='left' class=weeknr colspan=8>week: $weekNr</td></tr>";
    }
    return "";
}
function toonStatus($rol, $gegevens){
    
    $status = $gegevens["status"];
    $dagId = $gegevens["id"];
    $informatieId = $gegevens["informatie_id"];
    $betaalcode = $gegevens["betalingskenmerk"];

    if($rol == "klant"){
        switch($status){
            case 3:
                return "";
            case 1:
            case -1;
                return codeNaarPlaatsNaam(substr($informatieId ,1 ), $rol);
        }
    }else{
        switch($status){
            case 3:               
                return ""; 
            case 2:
                return "<input type=button class=annuleerbutton value=annuleer onclick=keurFout($dagId)><input type=button class=betaaldbutton value=goedkeuren onclick=keurGoed($dagId)>";          
            case 1:
            case -1;
                return codeNaarPlaatsNaam(substr($informatieId ,1 ), $rol) ." "; 
        }
    }
}
function getDefinitiefCheckBox($row, $rol){
    if($rol != "anoniem" && $rol != "klant"){
        return 
        "<label class=container>
            <input type=checkbox onclick=definitief(".$row["id"].",this.checked) ".isCheckedReserved($row["status"]).">
            <span class=checkmark></span>
            </label>";
    }
}
function adminActies($rol, $dagId, $status,$record){
    if($rol == "klant" || $rol == "anoniem"){
        if($status == -1){
            return "optie";
        }
        if($status == 3){
            return "vrij";  
        }elseif($status == 0){
            return "--";
        }else{
            return "bezet";
        }
    }else{
        return "<input type=button class=verwijderbutton onclick=verwijderDag(".$dagId.") value=verwijder> <span>&nbsp;</span> <input value=\"".$record["compub"]."\" onchange=\"addcompub(".$record["id"].",this)\">";
    }
}

//<input type=checkbox onchange=definitief(".$dagId.",this.checked) ".isCheckedReserved($status)." >
function isCheckedReserved($status){
    if($status == -1){
        return "checked=checked";
    }
}
function selecteerKolom($rol, $dagId, $status){
    if($rol == "klant"){
        if($status == 1 || $status == 0 || $status == -1){
            return "";
        }
        return "<label class=container>
        <input type=checkbox onclick=selecteerDag($dagId,this)>
        <span class=checkmark></span>
      </label>";
    }else{
        return "";
    }
}
function toonDatum($rij){
    $timestamp = strtotime($rij["datum"]);
    $weekdag = getWeekdag(date('N', $timestamp));
    $daginmaand = date('j', $timestamp);
    $maand = getMaandNaam(date('n', $timestamp));
    $jaar = date('Y', $timestamp);
    if($rij["status"] == 0){
        return substr($weekdag, 0, 2);
    }else{
        return $weekdag . " ". $daginmaand ." " . $maand . " " . $jaar;
    }
}
function getWeekdag($dagnr){
    switch($dagnr){
        case 1:
            return "Maan";
        case 2:
            return "Dins";
        case 3:
            return "Woen";
        case 4:
            return "Don";
        case 5:
            return "Vrij";
        case 6:
            return "Zat";
        case 7:
            return "Zon";
    }
}
function getMaandNaam($maandnr){
    switch($maandnr){
        case 1:
            return "Jan";
        case 2:
            return "Feb";
        case 3:
            return "Mrt";
        case 4:
            return "Apr";
        case 5:
            return "Mei";    
        case 6:
            return "Juni";
        case 7:
            return "Juli";
        case 8:
            return "Aug";
        case 9:
            return "Sept";
        case 10:
            return "Okt";
        case 11:
            return "Nov";
        case 12:
            return "Dec";
    }
}
?>