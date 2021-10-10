<?php
session_start();
if (isset($_SESSION["id_user"]) && isset($_GET["id"]) && isset($_GET["album"]) && isset($_GET["user"])) {
    //só avançamos se o comentário for do user
    if ($_GET["user"] != $_SESSION["id_user"]) {
        header("Location: ../index.php");
    } else {

        $id_user = $_SESSION["id_user"];
        $id_album = $_GET["album"];
        $id_produto = $_GET["id"];

        // We need the function!
        require_once("../connections/connection.php");

        // Create a new DB connection
        $link = new_db_connection();

        /* create a prepared statement */
        $stmt = mysqli_stmt_init($link);

        $query = "DELETE FROM review_albuns WHERE review_albuns.ref_id_utilizadores = ? AND review_albuns.ref_id_albuns = ?";

        if (mysqli_stmt_prepare($stmt, $query)) {
            /* Bind paramenters */
            mysqli_stmt_bind_param($stmt, "ii", $id_user, $id_album);
            /* execute the prepared statement */
            if (!mysqli_stmt_execute($stmt)) {
                echo "Error description: " . mysqli_stmt_error($link);
            } else {
                header("Location: ../album_info.php?item=" . $id_produto . "#reviewtitle");
            }
        } else {
            echo "Error description: " . mysqli_error($link);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($link);
    }
} else {
    header("Location: ../index.php");
}
