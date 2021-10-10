<?php
session_start();
require_once "../connections/connection.php";


if (isset($_SESSION["id_user"]) && isset($_GET["id"])) {

    $id_user = $_SESSION["id_user"];
    $id_produto = $_GET["id"];
    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);

    //para alem de verificar se existe sessão, temos de verificar se essa sessão tem o "poder" de eliminar o album escolhido
    //ou seja, se album lhe pertence
    $query = "SELECT id_produtos FROM produtos WHERE produtos.ref_id_utilizadores_vendedores = ? AND produtos.id_produtos = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {

        mysqli_stmt_bind_param($stmt, "ii", $id_user, $id_produto);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $id);

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) != 0) {

            //vamos eliminar!

            //primeiro eliminar possiveis comentários existentes
            $query = "DELETE FROM guardados WHERE ref_id_produtos = ?";

            if (mysqli_stmt_prepare($stmt, $query)) {

                mysqli_stmt_bind_param($stmt, 'i', $id_produto);

                /* execute the prepared statement */
                if (!mysqli_stmt_execute($stmt)) {
                    echo "Error: " . mysqli_stmt_error($stmt);
                } else {
                    //agora eliminar o album
                    $query = "DELETE FROM produtos WHERE id_produtos = ?";

                    if (mysqli_stmt_prepare($stmt, $query)) {

                        mysqli_stmt_bind_param($stmt, 'i', $id_produto);

                        /* execute the prepared statement */
                        if (!mysqli_stmt_execute($stmt)) {
                            echo "Error: " . mysqli_stmt_error($stmt);
                        } else {
                            header("Location: ../catalogo.php");
                        }
                    }
                }
            }

        } else {
            //o user tentou eliminar um album que não é dele..
            header("Location: ../catalogo.php");
        }
    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);

} else {
    header("Location: ../catalogo.php");
}
