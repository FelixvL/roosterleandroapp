<?php
    require "../includes/werkdagenfunctions.php";
    $conn = getConnection();

    $dagcode = $_REQUEST['dagcode'];

    $sql = "UPDATE werkdag SET status = 1 WHERE id = $dagcode";
    $rs = $conn->query($sql);
?>