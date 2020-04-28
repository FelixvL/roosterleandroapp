<?php
    require "../includes/werkdagenfunctions.php";
    $conn = getConnection();

    $dagcode = $_REQUEST['dagcode'];
    $sql = "DELETE FROM werkdag WHERE id = $dagcode";
    $rs = $conn->query($sql);
    echo "verwijdert";
?>