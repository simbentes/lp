<?php
require_once "../connections/connection.php";
require_once "sc_mail.php";


if (isset($_POST["email"])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = "https://labmm.clients.ua.pt/deca_20L4/deca_20L4_03/MP/nova-password.php?selector=" . $selector . "&token=" . bin2hex($token);
    $validade = date("U") + 1800;
    $email = $_POST["email"];


    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);

    //descobrir que user utiliza este email
    $query = "SELECT id_utilizadores FROM utilizadores WHERE email = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $email);

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_bind_result($stmt, $id_user_mail);

            if (mysqli_stmt_fetch($stmt)) {

                //eliminar possiveis repetições de tokens para o mesmo user
                $query = "DELETE FROM repor_password WHERE ref_id_utilizadores = ?";

                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, 'i', $id_user_mail);

                    if (mysqli_stmt_execute($stmt)) {
                        //criar novo token
                        $query = "INSERT INTO repor_password (ref_id_utilizadores, token, validade,selector) VALUES (?,?,?,?)";

                        if (mysqli_stmt_prepare($stmt, $query)) {

                            $token_hash = password_hash($token, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, 'isss', $id_user_mail, $token_hash, $validade, $selector);

                            if (mysqli_stmt_execute($stmt)) {
                                //enviar
                                $assunto_mail = "LP | Repor a password da tua conta";
                                $corpo_mail = "<h3>Repõe a tua password</h3><div>Recebemos um pedido de reposição de password. Clica no link em baixo para avançares.</div><div><a href='$url'>$url</a></div>";
                                include_once "sc_mail.php";
                                enviarMail(null, $email, $assunto_mail, $corpo_mail, null);
                                header("Location: ../repor-password.php?msg=1");
                            } else {
                                // Acção de erro
                                echo "Error1:" . mysqli_stmt_error($stmt);
                            }
                        } else {
                            // Acção de erro
                            echo "Error2:" . mysqli_error($link);
                        }
                    } else {
                        // Acção de erro
                        echo "Error3:" . mysqli_stmt_error($stmt);
                    }
                } else {
                    // Acção de erro
                    echo "Error:" . mysqli_error($link);
                }

            } else {
                // Email não existe na base de dados
                header("Location: ../repor-password.php?msg=0");
            }
        } else {
            // Acção de erro
            echo "Error5:" . mysqli_stmt_error($stmt);
        }
    } else {
        // Acção de erro
        echo "Error6:" . mysqli_error($link);
    }
    mysqli_stmt_close($stmt);


    mysqli_close($link);


} else {
    header("Location: ../repor-password.php");
}