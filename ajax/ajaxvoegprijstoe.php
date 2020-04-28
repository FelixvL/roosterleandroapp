<?php
    require "../includes/werkdagenfunctions.php";
    $conn = getConnection();

    $dagcode = $_REQUEST['dagcode'];
    $prijs = $_REQUEST['prijs'];
    

    $sql = "UPDATE werkdag SET prijs = $prijs WHERE id = $dagcode";
    $rs = $conn->query($sql);
?>