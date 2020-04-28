<?php
    require "../includes/werkdagenfunctions.php";
    $conn = getConnection();

    $klantlocatie = $_REQUEST['klantlocatie'];
    $dagen = $_REQUEST['dagen'];
    $kenmerk = $_REQUEST['kenmerk'];
    $koper = $_REQUEST['koper'];
    $alledagen = explode("-", $dagen);

    for($x = 0 ; $x < sizeof($alledagen) ; $x++){
        $sql = "UPDATE werkdag SET status = 2, informatie_id = '$klantlocatie', betalingskenmerk = '$kenmerk', koper = '$koper' WHERE id = $alledagen[$x]";
        $rs = $conn->query($sql);
    }
    mail('digitaleservice@gmail.com', 'Dagen Gereserveerd 0111.nl', 'reservering gedaan op 0111.nl/reserveren/overzicht.php');
?>