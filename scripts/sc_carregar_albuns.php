<?php

session_start();

if (isset($_GET['carregar']) && isset($_GET['id'])) {


    if (isset($_SESSION["id_user"])) {
        $id_user = $_SESSION["id_user"];
    } else {
        $id_user = null;
    }

    $limite = $_GET['limite'];

    //buscar id do ultimo album, para impedir que existam repeticoes
    if (isset($_GET["id"])) {
        //se estiver empty é sinal que é o primeiro pedido ajax
        if (!empty($_GET["id"])) {
            $ultimo_album = $_GET['id'];
            $ultimo_id = "AND id_produtos < ?";
        } else {
            $ultimo_id = "";
        }
    } else {
        $ultimo_id = "";
    }

    //pesquisar um album. se a query string for 0, a pesquisa não foi feita
    if ($_GET["string"] != "") {
        //nao dá para fazer bind assim '%?%'...
        $pesquisastring = $_GET["string"];
        $pesquisa = "%" . $pesquisastring . "%";

        $pesquisaquery = "albuns.titulo LIKE ? AND";
    } else {
        $pesquisaquery = "";
    }

    //estilo um album. se a query string for 0, a pesquisa não foi feita
    if ($_GET["estilo"] != "") {
        //nao dá para fazer bind assim '%?%'...
        $id_estilo = $_GET["estilo"];

        $estiloquery = "id_estilos = ? AND";
        $joinestilos = "LEFT JOIN estilos_has_albuns
    ON estilos_has_albuns.ref_id_albuns = id_albuns
LEFT JOIN estilos
ON estilos_has_albuns.ref_id_estilos = estilos.id_estilos";
    } else {
        $estiloquery = "";
        $joinestilos = "";
    }


    $query = "SELECT artistas.nome, albuns.titulo, produtos.preco, produtos.img_capa, produtos.id_produtos, guardado, ref_id_utilizadores_vendedores, utilizadores.nome, utilizadores.apelido, fotoperfil
FROM artistas
INNER JOIN albuns
ON artistas.id_artistas = albuns.ref_id_artistas " . $joinestilos . " INNER JOIN produtos
ON albuns.id_albuns = produtos.ref_id_albuns
LEFT JOIN guardados
ON produtos.id_produtos = guardados.ref_id_produtos AND guardados.ref_id_utilizadores = ?
LEFT JOIN utilizadores
ON utilizadores.id_utilizadores = ref_id_utilizadores_vendedores WHERE " . $pesquisaquery . " " . $estiloquery . " produtos.ref_id_encomendas IS NULL " . $ultimo_id . " AND ativo = 1 ORDER BY `produtos`.`id_produtos` DESC LIMIT 0, ?";


    require_once "../connections/connection.php";

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);


    if (mysqli_stmt_prepare($stmt, $query)) {


        //o bind dos parametros depende se houve pesquisa. se a query string for 0, a pesquisa não foi feita
        if (!empty($_GET["string"])) {
            if (!empty($_GET["estilo"])) {
                //se nao exitir (last) id, significa que é o primeiro pedido
                if (!empty($_GET["id"])) {
                    mysqli_stmt_bind_param($stmt, "isiii", $id_user, $pesquisa, $id_estilo, $ultimo_album, $limite);
                } else {
                    mysqli_stmt_bind_param($stmt, "isii", $id_user, $pesquisa, $id_estilo, $limite);
                }
            } else {
                //se nao exitir (last) id, significa que é o primeiro pedido
                if (!empty($_GET["id"])) {
                    mysqli_stmt_bind_param($stmt, "isii", $id_user, $pesquisa, $ultimo_album, $limite);
                } else {
                    mysqli_stmt_bind_param($stmt, "isi", $id_user, $pesquisa, $limite);
                }
            }
        } else {
            //sem adiconar pesquisa
            if (!empty($_GET["estilo"])) {
                if (!empty($_GET["id"])) {
                    mysqli_stmt_bind_param($stmt, "iiii", $id_user, $id_estilo, $ultimo_album, $limite);
                } else {
                    mysqli_stmt_bind_param($stmt, "iii", $id_user, $id_estilo, $limite);
                }
            } else {
                //se nao exitir (last) id, significa que é o primeiro pedido e ninguem pesquisou
                if (!empty($_GET["id"])) {
                    mysqli_stmt_bind_param($stmt, "iii", $id_user, $ultimo_album, $limite);
                } else {
                    mysqli_stmt_bind_param($stmt, "ii", $id_user, $limite);
                }
            }
        }


        mysqli_stmt_execute($stmt);


        mysqli_stmt_bind_result($stmt, $artista, $titulo, $preco, $capa, $id, $guardado, $vendedor, $nome, $apelido, $fperfil);


        mysqli_stmt_store_result($stmt);

        $numrows = mysqli_stmt_num_rows($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $album = [];

            while (mysqli_stmt_fetch($stmt)) {
                //botao editar ou ver mais
                if ($id_user != $vendedor) {
                    $editar = false;
                } else {
                    $editar = true;
                }

                if (isset($_SESSION["id_user"]) && $_SESSION["id_user"] != $vendedor) {
                    $btnShow = true;
                } else {
                    $btnShow = false;
                }

                if (isset($guardado)) {
                    $guardadoChecked = "checked";
                } else {
                    $guardadoChecked = "";
                }

                // enviar dados dos albuns para serem renderizados em js
                $album[] = ["artista" => $artista, "titulo" => $titulo, "preco" => $preco, "capa" => $capa, "id" => $id, "guardado" => $guardado, "vendedor" => $vendedor, "nome" => $nome, "apelido" => $apelido, "fperfil" => $fperfil, "btnShow" => $btnShow, "guardadoChecked" => $guardado, "editar" => $editar, "pesquisa" => $_GET["string"], "estilo" => $_GET["estilo"], "repeticoes" => $numrows];
            }

            die(json_encode($album));
        } else {
            die("fim");
        }


        mysqli_stmt_close($stmt);
        mysqli_close($link);

    } else {
        echo "Error: " . mysqli_error($link);
    }


}
