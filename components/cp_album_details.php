<?php
require_once "connections/connection.php";


if (isset($_GET["item"])) {
    $id_produtos = $_GET["item"];


// Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "SELECT artistas.nome, artistas.descricao, paises.nome, albuns.titulo, albuns.ano, albuns.descricao, albuns.id_albuns, produtos.preco, produtos.img_capa, produtos.ref_id_utilizadores_vendedores, condicoes.id_condicoes, condicoes.condicao, rpm, utilizadores.nome, utilizadores.apelido, utilizadores.fotoperfil
FROM artistas
INNER JOIN paises
ON artistas.ref_id_paises = id_paises
INNER JOIN albuns
ON artistas.id_artistas = albuns.ref_id_artistas
INNER JOIN rotacoes
ON albuns.ref_id_rotacoes = rotacoes.id_rotacoes
INNER JOIN produtos
ON albuns.id_albuns = produtos.ref_id_albuns
INNER JOIN utilizadores
ON produtos.ref_id_utilizadores_vendedores = id_utilizadores
INNER JOIN condicoes
ON produtos.ref_id_condicoes = condicoes.id_condicoes
WHERE produtos.id_produtos = ? AND produtos.ref_id_encomendas IS NULL AND ativo = 1";

    if (mysqli_stmt_prepare($stmt, $query)) {

        // Bind variables by type to each parameter
        mysqli_stmt_bind_param($stmt, 'i', $id_produtos);

        /* execute the prepared statement */
        mysqli_stmt_execute($stmt);

        /* bind result variables */
        mysqli_stmt_bind_result($stmt, $artista, $artista_desc, $artista_pais, $titulo, $ano, $desc, $id_album, $preco, $capa, $vendedor, $condicao, $nome_condicao, $rpm, $nome, $apelido, $fperfil);

        /* store result */
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            /* fetch values */
            mysqli_stmt_fetch($stmt)

            ?>
            <main class="bg-light">
            <div class="container py-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="capa-album img-center fotorecorte"
                         style="background-image: url('img/capas/<?= $capa; ?>')" alt="<?= $artista ?>">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h2 class="section-heading mb-0"><?= $titulo ?> <span
                                        class="mb-0 anoalbum">(<?= $ano ?>)</span>
                        </div>
                        <div class="col-auto">
                            <?php
                            $query = "SELECT AVG(review_albuns.ref_id_classificacoes) FROM review_albuns WHERE review_albuns.ref_id_albuns = ?";
                            //adicionar morada de um user
                            if (mysqli_stmt_prepare($stmt, $query)) {
                                mysqli_stmt_bind_param($stmt, 'i', $id_album);

                                /* execute the prepared statement */
                                mysqli_stmt_execute($stmt);

                                /* bind result variables */
                                mysqli_stmt_bind_result($stmt, $media_classificacoes);

                                /* store result */
                                mysqli_stmt_store_result($stmt);

                                if (mysqli_stmt_fetch($stmt)) {
                                    //só se mostra a media se existirem classificacoes
                                    if (isset($media_classificacoes)) {

                                        // arredondar valores. o mysql devolve um valor com 4 casa decimais..
                                        $classificacoes = round($media_classificacoes, 1);
                                        echo "<span class='h4 font-weight-bold'>$classificacoes </span>";


                                        //mostrar o numero de estrelas (e meias estrelas) conforme a classificao
                                        if ($media_classificacoes < 0.5) {
                                            $repete = 0;
                                            $half = false;
                                        } else if ($media_classificacoes < 1) {
                                            $repete = 0;
                                            $half = true;
                                        } else if ($media_classificacoes < 1.5) {
                                            $repete = 1;
                                            $half = false;
                                        } else if ($media_classificacoes < 2) {
                                            $repete = 1;
                                            $half = true;
                                        } else if ($media_classificacoes < 2.5) {
                                            $repete = 2;
                                            $half = false;
                                        } else if ($media_classificacoes < 3) {
                                            $repete = 2;
                                            $half = true;
                                        } else if ($media_classificacoes < 3.5) {
                                            $repete = 3;
                                            $half = false;
                                        } else if ($media_classificacoes < 4) {
                                            $repete = 3;
                                            $half = true;
                                        } else if ($media_classificacoes < 4.5) {
                                            $repete = 4;
                                            $half = false;
                                        } else if ($media_classificacoes < 5) {
                                            $repete = 4;
                                            $half = true;
                                        } else {
                                            $repete = 5;
                                            $half = false;
                                        }
                                        for ($i = 0; $i < $repete; $i++) {
                                            echo "<i class='fas fa-star cor'></i>";
                                        }
                                        if ($half) {
                                            echo "<i class='fas fa-star-half cor'></i>";
                                        }
                                    }
                                } else {
                                    echo "Error:" . mysqli_error($link);
                                }
                            } else {
                                echo "Error:" . mysqli_error($link);
                            }
                            ?>
                        </div>
                    </div>
                    </h2>
                    <div>
                        <a data-toggle="collapse" href="#collapseExample" role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            <h4 class="section-subheading text-muted mb-2"><?= $artista ?></h4>
                        </a>
                        <div class="collapse mb-3" id="collapseExample">
                            <div class="card card-body">
                                <p class="px-3 pt-2 mb-0">
                                    <?= $artista_desc ?>
                                </p>
                                <p class="px-3 text-right font-weight-bold">
                                    País: <?= $artista_pais ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center no-gutters mb-2">
                        <?php
                        if (isset($rpm)) {
                            ?>
                            <div class="col-auto mr-2">
                                <div class="badge badge-secondary estilos d-flex align-items-center"><?= $rpm ?>
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            fill="currentColor" class="bi bi-vinyl ml-1"
                                            viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M8 6a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM4 8a4 4 0 1 1 8 0 4 4 0 0 1-8 0z"/>
                                        <path d="M9 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <?php
                        }

                        $query = "SELECT estilos.tipo FROM estilos_has_albuns
INNER JOIN estilos
ON estilos_has_albuns.ref_id_estilos = estilos.id_estilos
WHERE estilos_has_albuns.ref_id_albuns = ?";


                        if (mysqli_stmt_prepare($stmt, $query)) {

                            mysqli_stmt_bind_param($stmt, "i", $id_album);

                            /* execute the prepared statement */
                            mysqli_stmt_execute($stmt);

                            /* bind result variables */
                            mysqli_stmt_bind_result($stmt, $estilos);

                            /* fetch values */
                            while (mysqli_stmt_fetch($stmt)) {
                                ?>
                                <div class="col-auto mr-2">
                                    <div class="badge badge-primary estilos"><?= $estilos ?></div>
                                </div>
                                <?php
                            }

                        } else {
                            echo "Error: " . mysqli_error($link);
                        }


                        ?>
                    </div>
                    <p><?= $desc ?></p>

                    <div class="row justify-content-between align-items-center no-gutters">
                        <div class="col-lg-5 px-1">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <h6>Estado</h6>
                                </div>
                                <div class="col-auto">
                                    <h6><?= $nome_condicao ?></h6>
                                </div>
                            </div>
                            <?php
                            switch ($condicao) {
                                case 1:
                                    $cor_barra = "bg-barra-1";
                                    $size = "100";
                                    break;
                                case 2:
                                    $cor_barra = "bg-barra-2";
                                    $size = "75";
                                    break;
                                case 3:
                                    $cor_barra = "bg-barra-3";
                                    $size = "50";
                                    break;
                                case 4:
                                    $cor_barra = "bg-barra-4";
                                    $size = "25";
                                    break;
                                case 5:
                                    $cor_barra = "bg-barra-5";
                                    $size = "10";
                                    break;
                                default:
                                    $bar_show = false;

                            }

                            echo "<div class='progress'>
                                    <div class='progress-bar progress-bar $cor_barra' role='progressbar'
                                         style='width: $size%' aria-valuenow='$size' aria-valuemin='0'
                                         aria-valuemax='$size'></div>
                                </div>"
                            ?>

                        </div>
                        <div class="col-auto px-1">
                            <div class="small">Vendido por:</div>
                            <img class="img-fluid rounded-circle fotoperfilalbuns"
                                 src='img/users/<?= $fperfil ?>' alt="<?= $nome . " " . $apelido ?>">
                            <span class="small font-weight-bold"><?= $nome . " " . $apelido ?></span>
                        </div>
                        <div class="col-3 px-1">
                            <div class="py-3 text-right">
                                <?php
                                //só dá para comprar se o user tiver sessão iniciada
                                if (isset($_SESSION["id_user"])) {
                                    if ($vendedor != $_SESSION["id_user"]) {
                                        ?>
                                        <button type='button' id='checkout-button' value='<?= $id_produtos ?>'
                                                class='btn btn-degrade text-uppercase py-3 btn-block'
                                                onclick='comprar(this.value)'>
                                            Comprar
                                        </button>
                                        <div id='loading'></div>
                                        <?php
                                    } else {
                                        ?>
                                        <a href='editar-album-info.php?item=<?= $id_produtos ?>'
                                           class='btn btn-degrade bg-cinza text-dark text-uppercase py-3 btn-block'>
                                            Editar
                                        </a>
                                        <?php
                                    }
                                } else {
                                    echo "<a href='login.php?msg=1'
                                       class='btn btn-degrade text-uppercase py-3 btn-block'>
                                        Comprar
                                    </a>";
                                }
                                ?>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <hr class="mb-5" id="reviewtitle">
            <div class="row justify-content-center">
                <h3 class="col-8">Reviews</h3>
            </div>

            <?php
            $query = "SELECT review, ref_id_classificacoes, classificacoes.tipo, id_utilizadores, utilizadores.nome, utilizadores.apelido, utilizadores.fotoperfil FROM review_albuns INNER JOIN utilizadores ON review_albuns.ref_id_utilizadores = id_utilizadores INNER JOIN classificacoes ON review_albuns.ref_id_classificacoes = classificacoes.id_classificacoes WHERE ref_id_albuns = ?";
            //adicionar morada de um user
            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, 'i', $id_album);

                /* execute the prepared statement */
                mysqli_stmt_execute($stmt);

                mysqli_stmt_bind_result($stmt, $comentario, $ref_id_classificacoes, $classificacao_nome, $id_user_comment, $nome, $apelido, $fotoperfil);


                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 0) {
                    echo "<h6 class='text-center pt-3'>Ainda não existem reviews para este álbum.</h6>";
                }
                /* fetch values */
                while (mysqli_stmt_fetch($stmt)) {
                    ?>

                    <div class="row justify-content-center">
                        <div class="col-7">
                            <?php if ($id_user_comment == $_SESSION["id_user"]) {
                                ?>
                                <a href="scripts/sc_eliminar_comentario.php?id=<?= $id_produtos . "&album=" . $id_album . "&user=" . $id_user_comment ?>"
                                   class="close">
                                <span aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                              fill="currentColor" class="bi bi-trash"
                                                              viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
  <path fill-rule="evenodd"
        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
</svg></span>
                                </a>
                                <?php
                            } ?>
                            <hr>
                            <p><?= $comentario ?></p>
                            <div class="row justify-content-between align-items-center no-gutters">
                                <div class="col-auto">
                                    <div>
                                        <img class="img-fluid rounded-circle fotoperfilalbuns"
                                             src='img/users/<?= $fotoperfil ?>'
                                             alt="<?= $nome . " " . $apelido ?>">
                                        <span class="small font-weight-bold"><?= $nome . " " . $apelido ?></span>
                                    </div>
                                </div>
                                <div class="col-auto text-right">
                                    <div class="font-weight-bold"><?= $classificacao_nome ?></div>
                                    <?php
                                    //repete conforme o nr de estrelas..
                                    for ($i = 0; $i < $ref_id_classificacoes; $i++) {
                                        echo "<i class='fas fa-star cor'></i>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }


            } else {
                echo "Error:" . mysqli_error($link);
            }

            if (isset($_SESSION["id_user"])) {
                //vamos ver o numero de rows de revies (0 ou 1)
                //se não houverem rows significa que podemos fazer review a esse album
                $query = "SELECT * FROM `review_albuns` WHERE review_albuns.ref_id_utilizadores = ? && ref_id_albuns = ?";
                //adicionar morada de um user
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, 'ii', $_SESSION["id_user"], $id_album);

                    /* execute the prepared statement */
                    mysqli_stmt_execute($stmt);
                    //vamos ver quantas ocorrencias tem. se tiver mais de 0 significa que o user já comentou..
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 0) {

                        ?>
                        <div class="row justify-content-center">
                            <hr class="col-8">
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-8">
                                <form action="scripts/sc_comentar.php"
                                      method="get">
                                    <input type="hidden" name="id" value="<?= $id_produtos ?>">
                                    <input type="hidden" name="album" value="<?= $id_album ?>">
                                    <div class="form-group">
                                        <label for="comentarios1" class="font-weight-bold m-0">Publicar</label>
                                        <div class="small mb-3">De que forma te marcou este álbum?</div>
                                        <textarea class="form-control" name="review" id="comentarios1"
                                                  rows="3" required></textarea>
                                    </div>
                                    <div class="row justify-content-between align-items-center no-gutters">
                                        <div class="col-auto">
                                            <div class="mb-2 mr-2">
                                                <img class="img-fluid rounded-circle fotoperfilalbuns"
                                                     src='img/users/<?= $_SESSION["fperfil"] ?>'
                                                     alt="<?= $_SESSION["nome"] ?>">
                                                <span class="small font-weight-bold"><?= $_SESSION["nome"] ?></span>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <select name="classificacao" required>
                                                    <option value="" selected disabled>
                                                        Classificação
                                                    </option>
                                                    <?php
                                                    $query = "SELECT id_classificacoes, tipo FROM classificacoes ORDER BY id_classificacoes DESC";
                                                    //adicionar morada de um user
                                                    if (mysqli_stmt_prepare($stmt, $query)) {
                                                        ;

                                                        mysqli_stmt_execute($stmt);

                                                        mysqli_stmt_bind_result($stmt, $id_classificacoes, $tipo);

                                                        /* fetch values */
                                                        while (mysqli_stmt_fetch($stmt)) {
                                                            ?>
                                                            <option value="<?= $id_classificacoes ?>"><?= $id_classificacoes . "★ — " . $tipo ?></option>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo "Error:" . mysqli_error($link);
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-degrade py-2 px-3 mb-2">PUBLICAR
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>

                    </div>
                <?php } else {
                    //id do album não existe na base de dados
                    header("Location: catalogo.php");
                } ?>
                </main>
                <?php

            }

        } else {
            //não existe ou o seu vendedor está desativado
            header("Location: catalogo.php");
        }
        /* close statement */
        mysqli_stmt_close($stmt);

        /* close connection */
        mysqli_close($link);
    } else {
        echo "Error: " . mysqli_error($link);
    }
} else {
    //não existe nenhuma query string do album
    header("Location: catalogo.php");
}
