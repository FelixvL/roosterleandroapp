<?php
    require "../includes/werkdagenfunctions.php";
    $conn = getConnection();

    $dagcode = $_REQUEST['dagcode'];
    $factuurnummer = $_REQUEST['factuurnummer'];
    

    $sql = "UPDATE werkdag SET factuurnummer = $factuurnummer WHERE id = $dagcode";
    $rs = $conn->query($sql);
?>