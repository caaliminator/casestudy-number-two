<?php
    require_once("connection.php");

        $id = $_POST['martianID'];
        $stmt= $conn->prepare("DELETE FROM martian WHERE martian_id=$id");
        $stmt->execute();
        $stmt = $conn->query("SELECT m.martian_id, m.first_name, m.last_name, b.base_name FROM martian AS m RIGHT JOIN base AS b ON m.base_id = b.base_id ORDER BY martian_id ASC");
        $arr = array();
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            array_push($arr,$row);
        }
        echo json_encode($arr);
    


?>

        