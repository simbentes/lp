<?php
session_start();
if (isset($_SESSION["produto_vendido"]) && isset($_SESSION["id_user"])) {

    $id_user = $_SESSION["id_user"];
    //recebe o id do produto vendido e elimina a variavel de sessão;
    $produto_vendido = $_SESSION["produto_vendido"];
    unset($_SESSION["produto_vendido"]);


    require_once("../connections/connection.php");

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);


    $query = "INSERT INTO encomendas (ref_id_utilizadores,encomendas.data) VALUES (?,CURRENT_DATE())";
    //inserir nova encomenda
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $id_user);

        if (mysqli_stmt_execute($stmt)) {
            //guarda o id da encomenda
            $id_encomenda = mysqli_insert_id($link);
            //e insere na tabela produtos
            $query = "UPDATE produtos SET produtos.ref_id_encomendas = ? WHERE id_produtos = ?";
            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, 'ii', $id_encomenda, $produto_vendido);
                if (mysqli_stmt_execute($stmt)) {
                    //anuncio atualizado
                    $nome = $_SESSION["nome"];
                    $email = $_SESSION["email"];
                    $assunto_mail = "LP | Compra efetuada com sucesso!";
                    $corpo_mail = "<h1>LP | Compra efetuada com sucesso!</h1><div>Aguardamos por ti novamente. Em anexo segue a fatura.</div>";
                    //criar fatura
                    $query = "SELECT artistas.nome, albuns.titulo, produtos.preco, id_encomendas, utilizadores.nif
                    FROM `produtos`
                    INNER JOIN albuns
                    ON produtos.ref_id_albuns = albuns.id_albuns
                    INNER JOIN artistas
                    ON albuns.ref_id_artistas = id_artistas
                    INNER JOIN utilizadores
                    ON produtos.ref_id_utilizadores_vendedores = utilizadores.id_utilizadores
                    INNER JOIN encomendas ON produtos.ref_id_encomendas = encomendas.id_encomendas
                    WHERE encomendas.ref_id_utilizadores = " . $_SESSION["id_user"] . " AND id_produtos = " . $produto_vendido;

                    if (mysqli_stmt_prepare($stmt, $query)) {

                        /* execute the prepared statement */
                        mysqli_stmt_execute($stmt);

                        /* bind result variables */
                        mysqli_stmt_bind_result($stmt, $artista, $titulo, $preco, $id_encomenda, $nif);

                        mysqli_stmt_store_result($stmt);

                        while (mysqli_stmt_fetch($stmt)) {
                            $phpdate = strtotime($data);
                            $data = date('m-d-Y', $phpdate);
                        }

                    } else {
                        echo "Error: " . mysqli_error($link);
                    }


                    // cria a fatura
                    include_once "../faturas/sc_fatura.php";
                    $faturafile = criarFatura($id_encomenda, $_SESSION["nome"], $nif, $artista . " — " . $titulo, $preco);


                    // envia o mail com a fatura
                    include_once "sc_mail.php";
                    enviarMail($nome, $email, $assunto_mail, $corpo_mail, $faturafile);

                    $_SESSION["compra"] = "efetuada";
                    header("Location: ../compra-efetuada.php");

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
}