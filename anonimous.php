<?php
    require "includes/werkdagenfunctions.php";
?>
<link rel="stylesheet" type="text/css" href="includes/werkdagen.css">
<form action="?" method=GET>
<input class=annuleerbutton type=text name=srcstr>
<input class=annuleerbutton type=submit value=zoek>
</form>
<table class=buitenkant style=width:1200px>
<tr><td valign="top"><div>
<?php


$conn = getConnection();
$subSQL = "";
    if(isset($_REQUEST['srcstr'])){
        $searchStr = $_REQUEST['srcstr'];
        if(preg_match("/^\w{3}$/", $searchStr)){
            $subSQL = "AND compub LIKE '%".$searchStr."%'";
        }else{
            if($searchStr == ""){
                $subSQL = "";
            }else{
                echo "code bestaat uit drie letters";
                DIE;
            }
        }
    }
$sql = "SELECT * FROM werkdag WHERE status < 4  ".$subSQL." ORDER BY datum";
$rs = $conn->query($sql);


if ($rs->num_rows > 0) {
    toonWerkdagen("anoniem", $rs);
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

