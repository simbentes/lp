<?php


if (!empty($_POST["artista"]) && !empty($_POST["condicao"]) && !empty($_POST["preco"])) {

    require_once "../connections/connection.php";

    // Create a new DB connection
    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);


    if ($_POST["artista"] !== "novoartista") {
        //se for escolhido um artista que já está na base de dados, já podemos atribuir o id
        $id_artista = $_POST["artista"];
        if ($_POST["album"] !== "novoalbum") {
            //existe ainda a possiblidade de o utilizador querer vender um album que já foi vendido
            $id_album = $_POST["album"];
        }
    } else {
        //vamos adicionar um novo artista à nossa tabela

        if (!empty($_POST["nomeartista"]) && !empty($_POST["artistadesc"]) && !empty($_POST["paisartista"])) {

            $query = "INSERT INTO artistas (nome, descricao, ref_id_paises) VALUES (?,?,?)";


            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, 'ssi', $_POST["nomeartista"], $_POST["artistadesc"], $_POST["paisartista"]);

                if (mysqli_stmt_execute($stmt)) {
                    //o id do artista é a ultima PK inserida na base de dados. vai ser util para criar o album
                    $id_artista = mysqli_insert_id($link);
                    echo $id_artista;
                } else {
                    echo "Error:" . mysqli_stmt_error($stmt);
                }
            } else {
                echo "Error:" . mysqli_error($link);
            }
        } else {
            //falta info do artista
            header("Location: ../vender.php?msg=0");
            die();
        }

        //se escolheu criar novo artista, não existem albúns na bd
    }

    //se ainda não existe id_album, significa que o user escolheu criar um novo artista ou vender um novo album
    if (!isset($id_album)) {

        if (!empty($_POST["tituloalbum"]) && !empty($id_artista) && !empty($_POST["albumano"])) {

            //estes inputs não são obrigatórios
            !empty($_POST["descalbum"]) ? $descalbum = $_POST["descalbum"] : $descalbum = null;
            !empty($_POST["rotacoes"]) ? $rotacoes = $_POST["rotacoes"] : $rotacoes = null;

            if (!empty($_POST["outraeditora"])) {
                $editora = $_POST["outraeditora"];

                $query = "INSERT INTO editoras (editoras.nome) VALUES (?)";
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, 's', $editora);
                    if (mysqli_stmt_execute($stmt)) {
                        $id_editora = mysqli_insert_id($link);
                    } else {
                        echo "Error:" . mysqli_stmt_error($stmt);
                    }
                } else {
                    echo "Error:" . mysqli_error($link);
                }
            } else {
                if (!empty($_POST["editora"])) {
                    $id_editora = $_POST["editora"];
                } else {
                    $id_editora = null;
                }
            }


            $query = "INSERT INTO albuns (titulo, ref_id_artistas, ano, descricao, ref_id_rotacoes, ref_id_editoras) VALUES (?,?,?,?,?,?)";

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, 'sissii', $_POST["tituloalbum"], $id_artista, $_POST["albumano"], $descalbum, $rotacoes, $id_editora);

                if (mysqli_stmt_execute($stmt)) {
                    //o id do album é a ultima PK inserida na base de dados. vai ser util para criar o produto
                    $id_album = mysqli_insert_id($link);

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
                                    echo "Error:" . mysqli_stmt_error($stmt);
                                }
                            }
                        } else {
                            echo "Error:" . mysqli_error($link);
                        }

                    }


                    $query = "INSERT INTO estilos_has_albuns (ref_id_estilos, ref_id_albuns) VALUES (?, ?)";

                    if (mysqli_stmt_prepare($stmt, $query)) {

                        mysqli_stmt_bind_param($stmt, 'ii', $id_estilos, $id_album);

                        //vamos relacionar ao album
                        if (isset($array_generos)) {
                            foreach ($array_generos as $id_estilos) {
                                if (!mysqli_stmt_execute($stmt)) {
                                    echo "Error: " . mysqli_stmt_error($stmt);
                                }
                            }
                        }


                        // execute para todos os estilos escolhidos
                        foreach ($_POST["estilos"] as $id_estilos) {

                            if (!mysqli_stmt_execute($stmt)) {
                                echo "Error: " . mysqli_stmt_error($stmt);
                            }
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
            //falta info do album
            header("Location: ../vender.php?msg=1");
        }
    }

    //artista e album com upload feito
    //falta apenas criar o produto: estado, preço, imagem e vendedor (utilizador com a sessão iniciado)
    $preco = $_POST["preco"];
    $condicao = $_POST["condicao"];
    session_start();
    $ref_id_vendedor = $_SESSION["id_user"];


    //upload imagem
    include_once "sc_upload_imagem.php";
    $nome_img = uploadImagem($_FILES["foto"], "capas", 400);
    if (!isset($nome_img)) {
        $nome_img = "capa_default.png";
    }


    $query = "INSERT INTO `produtos` (`ref_id_albuns`, `ref_id_utilizadores_vendedores`, `ref_id_condicoes`, `img_capa`, `preco`) VALUES (?,?,?,?,?)";
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'iiiss', $id_album, $ref_id_vendedor, $condicao, $nome_img, $preco);
        if (mysqli_stmt_execute($stmt)) {
            //anuncio publicado
            header("Location: ../vender.php?msg=2");
        } else {
            echo "Error:" . mysqli_stmt_error($stmt);
        }
    } else {
        echo "Error:" . mysqli_error($link);
    }


    mysqli_stmt_close($stmt);
    mysqli_close($link);
}


