<?php
session_start();
if (isset($_SESSION["id_user"])) {

    if (isset($_GET["id"]) && isset($_GET["album"])) {

        if (!empty($_GET["review"]) && !empty($_GET["classificacao"])) {
            require_once "../connections/connection.php";

            // Create a new DB connection
            $link = new_db_connection();
            $stmt = mysqli_stmt_init($link);

            $query = "INSERT INTO `review_albuns` (`ref_id_albuns`, `ref_id_utilizadores`, `ref_id_classificacoes`, `review`) VALUES (?,?,?,?)";
            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, 'iiis', $_GET["album"], $_SESSION["id_user"], $_GET["classificacao"], $_GET["review"]);
                if (mysqli_stmt_execute($stmt)) {
                    //anuncio publicado
                    header("Location: ../album_info.php?item=" . $_GET["id"]. "#reviewtitle");
                } else {
                    echo "Error:" . mysqli_stmt_error($stmt);
                }
            } else {
                echo "Error:" . mysqli_error($link);
            }

            mysqli_stmt_close($stmt);
            mysqli_close($link);

        } else {
            header("Location: ../album_info.php?item=" . $_GET["id"]);
        }
    } else {
        header("Location: ../catalogo.php");
    }

} else {
    header("Location: ../login.php?msg=0");
}