<?php
    require "../includes/werkdagenfunctions.php";
    $conn = getConnection();

    $dagcode = $_REQUEST['dagcode'];
    $status = $_REQUEST['status'];
    $extra = "";
    if($status == 3 || $status == 0){
        if($status == 0){
            $ii = 199;
        }else{
            $ii = 0;
        }
        $extra = ", koper = '', betalingskenmerk = 0, informatie_id = $ii "; 
    }

    $sql = "UPDATE werkdag SET status = $status $extra WHERE id = $dagcode";
    $rs = $conn->query($sql);
?>