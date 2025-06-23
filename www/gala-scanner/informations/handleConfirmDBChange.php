<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require('../../../db_config.php');

    if (isset($_GET['ids'])) {
        
        $ids = json_decode($_GET['ids']);
        for ($i = 0; $i < count($ids); $i++) {
            $id = $ids[$i];
            $author = 'Confirmed Payment: ' . $_SESSION['identifiant'];
            $sql = "UPDATE preinscriptions SET hasPaid = 1, actionAuthor = '$author' WHERE id = $id";
            if (!mysqli_query($conn, $sql)) {
                $ans = [
                    "status" => 500,
                    "error" => mysqli_error()
                ];
                echo json_encode($ans);
                exit(500);
            }
        }

        $ans = [
            "status" => 200
        ];

        echo json_encode($ans);
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $author = 'Confirmed Payment: ' . $_SESSION['identifiant'];
        $sql = "UPDATE preinscriptions SET hasPaid = 1, actionAuthor = '$author' WHERE id = $id";
        if (!mysqli_query($conn, $sql)) {
            $ans = [
                "status" => 500,
                "error" => mysqli_error()
            ];
            echo json_encode($ans);
            exit(500);
        }
        $ans = [
            "status" => 200
        ];
        echo json_encode($ans);
    }

?>