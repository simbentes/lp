<?php
session_start();
require_once "../connections/connection.php";


if (isset($_SESSION["id_user"]) && isset($_GET["guardado"]) && isset($_GET["produto"])) {
    $id_user = $_SESSION["id_user"];
    $id_album = $_GET["produto"];
    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);
    //se a checkbox estiver cheked, o user quer guardar um albun
    if ($_GET["guardado"] == "true") {
        $guardado = 1;
        $query = "INSERT INTO guardados (guardado,ref_id_utilizadores,ref_id_produtos) VALUES (?,?,?)";
    } else {
        $guardado = 0;
        //se não estiver, o user quer remover
        $query = "DELETE FROM guardados WHERE ref_id_utilizadores = ? AND ref_id_produtos = ?";
    }

    if (mysqli_stmt_prepare($stmt, $query)) {
        if ($guardado == 0) {
            mysqli_stmt_bind_param($stmt, 'ii', $id_user, $id_album);
        } else {
            mysqli_stmt_bind_param($stmt, 'iii', $guardado, $id_user, $id_album);

        }

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error:" . mysqli_stmt_error($stmt);
        }
    } else {
        echo "Error:" . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}





