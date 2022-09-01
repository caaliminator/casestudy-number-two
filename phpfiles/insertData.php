<?php
    require_once("connection.php");

    if (empty($_POST['FirstName']) || empty($_POST['LastName'])) {
        echo json_encode('Empty');
    } else {

        $stmt= $conn->prepare("INSERT INTO martian (first_name, last_name, base_id, super_id) VALUES (:fname, :lname, :base_id, :super_id);");

        $stmt->bindParam(':fname', $_POST['FirstName']);
        $stmt->bindParam(':lname', $_POST['LastName']);
        $stmt->bindParam(':base_id', $_POST['Base']);
        $stmt->bindParam(':super_id', $_POST['Superior']);

        $stmt->execute();

        $stmt = $conn->query("SELECT m.martian_id, m.first_name, m.last_name, b.base_name FROM martian AS m INNER JOIN base AS b ON m.base_id = b.base_id ORDER BY m.martian_id ASC");
        $arr = array();
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                array_push($arr,$row);
                
        }
        echo json_encode($arr);

    }

?>