<?php

    $stmt = $conn->query("SELECT b.base_id, b.base_name, COUNT(m.base_id) FROM base AS b LEFT JOIN martian AS m ON b.base_id = m.base_id GROUP BY b.base_id");
    $arr = array();
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        array_push($arr,$row);
    }



    echo json_encode($arr);