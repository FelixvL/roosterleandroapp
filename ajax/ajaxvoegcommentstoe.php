<?php
    require "../includes/werkdagenfunctions.php";
    $conn = getConnection();

    $dagcode = $_REQUEST['dagcode'];
    if(isset($_REQUEST['compub'])){
        $compub = $_REQUEST['compub'];
        $sql = "UPDATE werkdag SET compub = '".$compub."' WHERE id = $dagcode";
    }else{
        $compri = $_REQUEST['compri'];
        $sql = "UPDATE werkdag SET compri = '".$compri."' WHERE id = $dagcode";

    }
    $rs = $conn->query($sql);
    echo $sql;
?>