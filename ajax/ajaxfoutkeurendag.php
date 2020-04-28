<?php
    require "../includes/werkdagenfunctions.php";
    $conn = getConnection();

    $dagcode = $_REQUEST['dagcode'];

    $sql = "UPDATE werkdag SET status = 3, betalingskenmerk = '', informatie_id = 0, koper = '' WHERE id = $dagcode";
    $rs = $conn->query($sql);
?>