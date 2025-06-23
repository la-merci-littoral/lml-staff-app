<?php

    // Prevent variable collisions when including this file in informations.php
    namespace fetchChildren;

    require('../../../db_config.php');

    if (isset($_GET['id'])) {

        $id = mysqli_real_escape_string($conn, $_GET['id']);

        // make sql
        $sql = "SELECT * FROM `preinscriptions` WHERE parentNode = '$id'";

        // get the query results
        $result = mysqli_query($conn, $sql);

        // print_r($result);
        // echo '<br>';

        // fetch result in array format
        // $data = mysqli_fetch_assoc($result);

        $data = [];
        
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $array = [
                'id'=>$row['id'],
                'fname'=>$row['fname'],
                'lname'=>$row['lname'],
                'age'=>$row['age'],
                'price'=>$row['price'],
                'hasPaid'=>$row['hasPaid']
            ];

            $data[] = $array;

            $i++;

        }

        mysqli_free_result($result);
        mysqli_close($conn);
    
    } else {
        $data = [
            'status' => '404',
        ];
    }
    
    echo json_encode($data);

?>