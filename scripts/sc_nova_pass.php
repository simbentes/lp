<?php

require_once "../connections/connection.php";

if (!empty($_POST["password"]) && !empty($_POST["password2"])) {
    session_start();
    $validacao = $_SESSION["token"];
    $selector = $_SESSION["selector"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    if ($password !== $password2) {
        header("Location: ../nova-password.php?msg=0");
    }

    $tempoPresente = date("U");

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);

    //baseado no selector do url, vou procurar a hash do token associado
    $query = "SELECT token, ref_id_utilizadores FROM repor_password WHERE selector = ? AND validade >= ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'ss', $selector, $tempoPresente);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $tokenBD, $userBD);

        if (mysqli_stmt_fetch($stmt)) {

            $tokenBinario = hex2bin($validacao);

            if (password_verify($tokenBinario, $tokenBD)) {
                //alterar password
                $query = "UPDATE utilizadores SET password = ? WHERE id_utilizadores = ?";

                if (mysqli_stmt_prepare($stmt, $query)) {
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, 'si', $password_hash, $userBD);

                    if (mysqli_stmt_execute($stmt)) {
                        //eliminar token usado
                        $query = "DELETE FROM repor_password WHERE ref_id_utilizadores = ?";

                        if (mysqli_stmt_prepare($stmt, $query)) {
                            mysqli_stmt_bind_param($stmt, 'i', $userBD);

                            if (mysqli_stmt_execute($stmt)) {
                                header("Location: ../login.php?msg=3");
                            } else {
                                // Acção de erro
                                echo "Error:" . mysqli_stmt_error($stmt);
                            }
                        } else {
                            // Acção de erro
                            echo "Error:" . mysqli_error($link);
                        }
                    } else {
                        // Acção de erro
                        echo "Error:" . mysqli_stmt_error($stmt);
                    }
                } else {
                    // Acção de erro
                    echo "Error:" . mysqli_error($link);
                }
            } else {
                header("Location: ../nova-password.php?msg=1");
            }
        } else {
            header("Location: ../nova-password.php?msg=1");
        }
    } else {
        // Acção de erro
        echo "Error:" . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);

} else {
    header("Location: ../index.php");
}