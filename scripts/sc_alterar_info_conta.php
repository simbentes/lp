<?php

session_start();
require_once "../connections/connection.php";


if (!empty($_POST["nome"]) && !empty($_POST["apelido"]) && !empty($_POST["email"]) && !empty($_POST["nascimento"]) && !empty($_POST["tel"]) && !empty($_POST["nif"]) && isset($_POST["rua"]) && isset($_POST["codigopostal"]) && isset($_POST["cidade"]) && isset($_POST["pais"])) {
    //verificar se a password está correta
    $password = $_POST['password'];

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "SELECT password FROM utilizadores WHERE id_utilizadores = " . $_SESSION["id_user"];


    if (mysqli_stmt_prepare($stmt, $query)) {

        /* execute the prepared statement */
        mysqli_stmt_execute($stmt);

        /* bind result variables */
        mysqli_stmt_bind_result($stmt, $password_hash);

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $password_hash)) {


                $nome = $_POST['nome'];
                $apelido = $_POST['apelido'];
                $email = $_POST['email'];
                $nascimento = date("Y-m-d", strtotime($_POST["nascimento"]));
                $tel = $_POST['tel'];
                $nif = $_POST['nif'];

                include_once "sc_upload_imagem.php";
                $nome_img = uploadImagem($_FILES["foto"], "users", 300);
                if (!isset($nome_img)) {
                    $nome_img = $_SESSION["fperfil"];
                }

                if (!empty($_POST['novapassword']) && !empty($_POST['passwordrepete'])) {
                    $password1 = $_POST['novapassword'];
                    $password2 = $_POST['passwordrepete'];
                    if ($password1 !== $password2) {
                        header("Location: ../informacoes.php?msg=4");
                        die;
                    }
                    //Se a nova password for igual á antiga.. não faz sentido alterar
                    if (!password_verify($_POST['novapassword'], $password_hash)) {
                        $passwordnova = password_hash($_POST['novapassword'], PASSWORD_DEFAULT);
                    } else {
                        header("Location: ../informacoes.php?msg=6");
                        die;
                    }
                } else {
                    $passwordnova = null;
                }

                //se estiver preenchida a morada
                if (!empty($_POST["rua"]) && !empty($_POST["codigopostal"]) && !empty($_POST["cidade"]) && !empty($_POST["pais"])) {

                    echo "tádando";

                    $rua = $_POST['rua'];
                    $codigopostal = $_POST['codigopostal'];
                    $cidade = $_POST['cidade'];
                    $pais = $_POST['pais'];

                    //vamos verificar se já existe alguma morada associada a este user. se existir atualizamos, caso contrário fazemos insert da morada..

                    $stmt = mysqli_stmt_init($link);

                    //posso concatenar, visto que o parametro não foi colocado pelo user
                    $query = "SELECT ref_id_moradas FROM `utilizadores` WHERE id_utilizadores = " . $_SESSION["id_user"];

                    if (mysqli_stmt_prepare($stmt, $query)) {


                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_bind_result($stmt, $refidmorada);


                        if (mysqli_stmt_fetch($stmt)) {
                            if ($refidmorada == null) {

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
                                mysqli_stmt_close($stmt);

                            } else {
                                // se o ref id morada não é null, significa que o user já tinha uma morada. vamos fazer update
                                $stmt = mysqli_stmt_init($link);

                                $query = "UPDATE moradas SET rua = ?, cidade= ?, codigo_postal = ?, ref_id_paises = ? WHERE moradas.id_moradas = " . $refidmorada;


                                if (mysqli_stmt_prepare($stmt, $query)) {
                                    mysqli_stmt_bind_param($stmt, 'sssi', $rua, $codigopostal, $cidade, $pais);

                                    if (mysqli_stmt_execute($stmt)) {
                                        $id_morada = $refidmorada;
                                    } else {
                                        echo "Error:" . mysqli_stmt_error($stmt);
                                    }
                                } else {
                                    echo "Error:" . mysqli_error($link);
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            echo "Error:" . mysqli_stmt_error($stmt);
                        }
                    } else {
                        echo "Error:" . mysqli_error($stmt);
                    }


                } else {
                    if (!empty($_POST["rua"]) || !empty($_POST["codigopostal"]) || !empty($_POST["cidade"]) || !empty($_POST["pais"])) {
                        header("Location: ../informacoes.php?msg=2");
                        die;
                    }
                    $id_morada = null;
                }
                //adicionar o user com a morada já criada/atualizada

                //podemos ou não querer alterar a password
                $stmt = mysqli_stmt_init($link);

                if (!isset($passwordnova)) {
                    $query = "UPDATE utilizadores SET nome = ?, apelido = ?, email = ?, fotoperfil = ?, telemovel = ?, data_nascimento = ?, ref_id_moradas = ?, nif= ? WHERE id_utilizadores = ?";
                } else {
                    $query = "UPDATE utilizadores SET nome = ?, apelido = ?, email = ?, password = ?, fotoperfil = ?, telemovel = ?, data_nascimento = ?, ref_id_moradas = ?, nif= ? WHERE id_utilizadores = ?";
                }

                if (mysqli_stmt_prepare($stmt, $query)) {

                    if (!isset($passwordnova)) {
                        mysqli_stmt_bind_param($stmt, 'ssssssiii', $nome, $apelido, $email, $nome_img, $tel, $nascimento, $id_morada, $nif, $_SESSION["id_user"]);
                        $msg = 1;
                    } else {
                        mysqli_stmt_bind_param($stmt, 'sssssssiii', $nome, $apelido, $email, $passwordnova, $nome_img, $tel, $nascimento, $id_morada, $nif, $_SESSION["id_user"]);
                        $msg = 5;
                    }

                    if (mysqli_stmt_execute($stmt)) {
                        // Informação atualizada

                        //novas variaveis de sessão baseadas nas alterações do user
                        session_start();
                        $_SESSION["nome"] = $nome . " " . $apelido;
                        $_SESSION["fperfil"] = $nome_img;
                        header("Location: ../informacoes.php?msg=" . $msg);
                    } else {
                        echo "Error:" . mysqli_stmt_error($stmt);
                    }
                } else {
                    echo "Error:" . mysqli_error($link);
                }

            } else {
                header("Location: ../informacoes.php?msg=0");
            }
        } else {
            echo "Error:" . mysqli_stmt_error($stmt);
        }
    } else {
        echo "Error:" . mysqli_error($link);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    header("Location: ../informacoes.php?msg=3");
}




