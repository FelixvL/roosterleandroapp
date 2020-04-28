
<?php
    require "../includes/werkdagenfunctions.php";
    $conn = getConnection();

    $dagcode = $_REQUEST['dagcode'];
    echo "<br>";
    echo $dagcode;
    echo "<br>";
    $newDate = date("Y-m-d", ($dagcode/1000));
    echo $newDate;
    echo "<br>";
    $sql = "INSERT INTO werkdag (`status`, `datum`) VALUES (3, '$newDate') ";
    echo $sql;
    $rs = $conn->query($sql);

?>