<?php


if (!empty($_POST['nome']) && !empty($_POST['apelido']) && !empty($_POST['nascimento']) && !empty($_POST['password']) && !empty($_POST['password2']) && !empty($_POST['tel']) && !empty($_POST['nif'])) {

    require_once "../connections/connection.php";

    $email = $_POST['email'];

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "SELECT email FROM utilizadores WHERE email = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {

        // Bind variables by type to each parameter
        mysqli_stmt_bind_param($stmt, 's', $email);

        /* execute the prepared statement */
        mysqli_stmt_execute($stmt);

        /* bind result variables */
        mysqli_stmt_bind_result($stmt, $email_resultados);

        mysqli_stmt_store_result($stmt);


        if (mysqli_stmt_num_rows($stmt) != 0) {
            //já existe uma conta com este mail
            header("Location: ../registar.php?msg=1");
        } else {
            //vamos criar uma nova conta
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $apelido = $_POST['apelido'];
            $nascimento = date("Y-m-d", strtotime($_POST["nascimento"]));

            if ($_POST['password'] !== $_POST['password2']) {
                header("Location: ../registar.php?msg=3");
                die;
            }

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $tel = $_POST['tel'];
            $nif = $_POST['nif'];

            //upload imagem
            include_once "sc_upload_imagem.php";
            $fotoperfil = uploadImagem($_FILES["foto"], "users", 300);
            if (!isset($fotoperfil)) {
                $fotoperfil = "user_default.png";
            }


            if (!empty($_POST["rua"]) && !empty($_POST["codigopostal"]) && !empty($_POST["cidade"]) && !empty($_POST["pais"])) {

                $rua = $_POST['rua'];
                $codigopostal = $_POST['codigopostal'];
                $cidade = $_POST['cidade'];
                $pais = $_POST['pais'];

                $stmt = mysqli_stmt_init($link);
                $query = "INSERT INTO moradas (rua, codigo_postal, cidade, ref_id_paises) VALUES (?,?,?,?)";
                //adicionar morada de um user
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, 'sssi', $rua, $codigopostal, $cidade, $pais);

                    if (mysqli_stmt_execute($stmt)) {
                        $id_morada = mysqli_insert_id($link);
                    } else {
                        echo "Error:" . mysqli_stmt_error($stmt);
                    }
                } else {
                    echo "Error:" . mysqli_error($link);
                }
            } else {
                if (!empty($_POST["rua"]) || !empty($_POST["codigopostal"]) || !empty($_POST["cidade"]) || !empty($_POST["pais"])) {
                    header("Location: ../registar.php?msg=2");
                    die;
                }
                $id_morada = null;
            }

            $query = "INSERT INTO utilizadores (nome, apelido, email, password, fotoperfil, data_nascimento, telemovel, nif, ref_id_moradas) VALUES (?,?,?,?,?,?,?,?,?)";

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, 'sssssssii', $nome, $apelido, $email, $password, $fotoperfil, $nascimento, $tel, $nif, $id_morada);


                // Devemos validar também o resultado do execute!
                if (mysqli_stmt_execute($stmt)) {
                    // Registo feito
                    //enviar email de boas vindas
                    $assunto_mail = 'Bem-vindo à comunidade LP!';
                    $corpo_mail = '<h1>Bem-vindo(a) à LP, ' . $nome . '</h1><div>Olá <b>' . $nome . '</b>! Ficamos felizes por te ter cá.</div>';

                    include_once "sc_mail.php";
                    enviarMail($nome . " " . $apelido, $email, $assunto_mail, $corpo_mail, null);

                    //ao criar a conta iniciamos automaticamente sessão
                    session_start();
                    //pesquisa o último id inserido, ou seja, o do novo user
                    $_SESSION["id_user"] = mysqli_insert_id($link);
                    $_SESSION["nome"] = $nome . " " . $apelido;
                    $_SESSION["fperfil"] = $fotoperfil;
                    $_SESSION["email"] = $email;
                    header("Location: ../index.php");
                } else {
                    // Erro. O registo não foi efetuado corretamente
                    echo "Error:" . mysqli_stmt_error($stmt);
                    //vamos eliminar a morada, se ela foi criada.
                    if (!is_null($id_morada)) {
                        $query = "DELETE FROM moradas WHERE id_moradas = ?";

                        if (mysqli_stmt_prepare($stmt, $query)) {

                            mysqli_stmt_bind_param($stmt, 'i', $id_morada);
                            /* execute the prepared statement */
                            if (!mysqli_stmt_execute($stmt)) {
                                echo "Error: " . mysqli_stmt_error($stmt);
                            }
                            /* close statement */
                            mysqli_stmt_close($stmt);
                        }
                    }
                }
            } else {
                // Acção de erro
                echo "Error:" . mysqli_error($link);
            }

        }

    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);

} else {
    header("Location: ../registar.php?msg=0");
}




