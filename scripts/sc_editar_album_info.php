<?php
session_start();
require_once "../connections/connection.php";

if (isset($_POST['artistadesc']) && isset($_POST['paisartista'])) {

    $descartista = $_POST['artistadesc'];
    $paisartista = $_POST['paisartista'];

    $link = new_db_connection();

    $stmt = mysqli_stmt_init($link);

    $query = "UPDATE artistas SET descricao = ?, ref_id_paises = ? WHERE id_artistas = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'sii', $descartista, $paisartista, $_SESSION["id_artista"]);

        if (mysqli_stmt_execute($stmt)) {
            // Artista atualizado. Vamos atualizar o album
            $ano = $_POST["albumano"];
            !empty($_POST["descalbum"]) ? $descalbum = $_POST["descalbum"] : $descalbum = null;
            !empty($_POST["rotacoes"]) ? $rotacoes = $_POST["rotacoes"] : $rotacoes = null;
            //adicionar editora se n existe..
            if (!empty($_POST["outraeditora"])) {
                $editora = $_POST["outraeditora"];

                $query = "INSERT INTO editoras (editoras.nome) VALUES (?)";
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, 's', $editora);
                    if (mysqli_stmt_execute($stmt)) {
                        //guardar id da editora criada, para posteriormente fazer update do album
                        $id_editora = mysqli_insert_id($link);
                    } else {
                        echo "Error:" . mysqli_stmt_error($stmt);
                    }
                } else {
                    echo "Error:" . mysqli_error($link);
                }
            } else {
                if (!empty($_POST["editora"])) {
                    //se não criou nenhuma editora nova..
                    $id_editora = $_POST["editora"];
                } else {
                    $id_editora = null;
                }
            }


            $query = "UPDATE albuns SET ano = ?, albuns.descricao = ?, ref_id_rotacoes = ?, ref_id_editoras = ? WHERE id_albuns = ?";

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, 'ssiii', $ano, $descalbum, $rotacoes, $id_editora, $_SESSION["id_album"]);

                if (mysqli_stmt_execute($stmt)) {


                    //vamos ver se o user adicionou novos estilos musicais e fazer insert na tabelas estilos
                    if (!empty($_POST["outrogeneroalbum"])) {
                        //vamos adicionar um ou mais novos géneros musicais à base de dados...
                        $outrosgeneros = explode(', ', $_POST["outrogeneroalbum"]);

                        $query = "INSERT INTO estilos (estilos.tipo) VALUES (?)";
                        if (mysqli_stmt_prepare($stmt, $query)) {
                            mysqli_stmt_bind_param($stmt, 's', $outrogenero);

                            foreach ($outrosgeneros as $outrogenero) {
                                if (mysqli_stmt_execute($stmt)) {
                                    $array_generos[] = mysqli_insert_id($link);
                                } else {
                                    echo "Error5:" . mysqli_stmt_error($stmt);
                                }
                            }
                        } else {
                            echo "Error6:" . mysqli_error($link);
                        }

                    }


                    //fazer delete de todas as relações de estilos com este album
                    $query = "DELETE FROM estilos_has_albuns WHERE estilos_has_albuns.ref_id_albuns = ?";

                    if (mysqli_stmt_prepare($stmt, $query)) {

                        mysqli_stmt_bind_param($stmt, 'i', $_SESSION["id_album"]);

                        /* execute the prepared statement */
                        if (!mysqli_stmt_execute($stmt)) {
                            echo "Error7: " . mysqli_stmt_error($stmt);
                        }

                    }

                    //voltar a fazer insert dos novos estilos
                    $query = "INSERT INTO estilos_has_albuns (ref_id_estilos, ref_id_albuns) VALUES (?, ?)";

                    if (mysqli_stmt_prepare($stmt, $query)) {

                        mysqli_stmt_bind_param($stmt, 'ii', $id_estilos, $_SESSION["id_album"]);

                        //vamos relacionar ao album (o novos estilos)
                        if (isset($array_generos)) {
                            foreach ($array_generos as $id_estilos) {
                                if (!mysqli_stmt_execute($stmt)) {
                                    echo "Error8: " . mysqli_stmt_error($stmt);
                                }
                            }
                        }
                        // execute para todos os estilos escolhidos
                        foreach ($_POST["estilos"] as $id_estilos) {

                            if (!mysqli_stmt_execute($stmt)) {
                                echo "Error9: " . mysqli_stmt_error($stmt);
                            }
                        }
                        //artista e album com upload feito
                        //falta apenas criar o produto: estado, preço, imagem e vendedor (utilizador com a sessão iniciado)
                        $preco = $_POST["preco"];
                        $condicao = $_POST["condicao"];

                        include_once "sc_upload_imagem.php";
                        $nome_img = uploadImagem($_FILES["foto"], "capas", 400);

                        //significa que o user nao alterou a foto
                        if (!isset($nome_img)) {
                            $query = "SELECT img_capa FROM produtos WHERE id_produtos = ?";

                            if (mysqli_stmt_prepare($stmt, $query)) {
                                mysqli_stmt_bind_param($stmt, "i", $_SESSION["id_produto"]);
                                /* execute the prepared statement */
                                mysqli_stmt_execute($stmt);
                                /* bind result variables */
                                mysqli_stmt_bind_result($stmt, $capa);
                                /* fetch values */
                                if (mysqli_stmt_fetch($stmt)) {
                                    $nome_img = $capa;
                                }
                            }
                        } else {
                            echo "Error: " . mysqli_error($link);
                        }


                        $query = "UPDATE produtos SET ref_id_condicoes = ?, img_capa = ?, preco = ? WHERE id_produtos = ?";
                        if (mysqli_stmt_prepare($stmt, $query)) {
                            mysqli_stmt_bind_param($stmt, 'issi', $condicao, $nome_img, $preco, $_SESSION["id_produto"]);
                            if (mysqli_stmt_execute($stmt)) {
                                //anuncio atualizado
                                header("Location: ../editar-album-info.php?item=" . $_SESSION["id_produto"] . "&msg=1");
                            } else {
                                echo "Error:" . mysqli_stmt_error($stmt);
                            }
                        } else {
                            echo "Error:" . mysqli_error($link);
                        }


                    } else {
                        echo "Error:" . mysqli_error($link);
                    }
                } else {
                    echo "Error:" . mysqli_stmt_error($stmt);
                }
            } else {
                echo "Error:" . mysqli_error($link);
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
    header("Location: ../editar-album-info.php?item=" . $_SESSION["id_produto"] . "&msg=2");
}
