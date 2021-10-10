<?php
ob_start();

if (isset($_GET["item"])) {
    session_start();
// We need the function!
    require_once("connections/connection.php");
    $id_produto = $_GET["item"];
// Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "SELECT artistas.id_artistas, artistas.nome, artistas.descricao, artistas.ref_id_paises, albuns.id_albuns, albuns.titulo, albuns.ano, albuns.descricao, albuns.ref_id_rotacoes, albuns.ref_id_editoras, produtos.img_capa, produtos.ref_id_condicoes, produtos.preco
FROM artistas
INNER JOIN albuns
ON artistas.id_artistas = albuns.ref_id_artistas
INNER JOIN produtos
ON albuns.id_albuns = produtos.ref_id_albuns
LEFT JOIN utilizadores
ON utilizadores.id_utilizadores = ref_id_utilizadores_vendedores
WHERE ref_id_utilizadores_vendedores = " . $_SESSION['id_user'] . " && produtos.id_produtos = ?";


    if (mysqli_stmt_prepare($stmt, $query)) {

        mysqli_stmt_bind_param($stmt, 'i', $id_produto);


        /* execute the prepared statement */
        mysqli_stmt_execute($stmt);

        /* bind result variables */
        mysqli_stmt_bind_result($stmt, $id_artistas, $artista_nome, $artista_desc, $artista_ref_id_paises, $id_album, $album_titulo, $ano, $album_desc, $album_rotacoes, $album_editora, $capaimg, $produto_condicoes, $preco);


        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_fetch($stmt);
            $_SESSION["id_artista"] = $id_artistas;
            $_SESSION["id_album"] = $id_album;
            $_SESSION["id_produto"] = $id_produto;
            ?>
            <main class="bg-light">
                <section class="container py-5">
                    <h3 class="pb-5">Editar informações</h3>
                    <!-- FORM VENDER-->
                    <form action="scripts/sc_editar_album_info.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div>
                                    <?php
                                    if (isset($_GET["msg"])) {
                                        $msg_show = true;
                                        switch ($_GET["msg"]) {
                                            case 0:
                                                $message = "Faltam informações do Intérprete";
                                                $class = "alert-danger";
                                                break;
                                            case 1:
                                                $message = "As Informações foram atualizadas";
                                                $class = "alert-success";
                                                break;
                                            case 2:
                                                $message = "Erro no preenchimento";
                                                $class = "alert-danger";
                                                break;
                                            default:
                                                $msg_show = false;
                                        }

                                        echo " <div class=\"alert $class alert-dismissible fade show\" role=\"alert\">
" . $message . "
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
  </button>
</div>";
                                        if ($msg_show) {
                                            echo '<script>window.onload=function (){$(\'.alert\').alert();}</script>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div id="novoInterprete">
                                    <div class="form-group">
                                        <label for="outrointerprete" class="font-weight-bold">Intérprete</label>
                                        <input type="text" class="form-control formvender"
                                               id="outrointerprete" value="<?= $artista_nome ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="descricao">Descrição</label>
                                        <textarea class="form-control formvender" id="descricao" name="artistadesc"
                                                  rows="5"><?= $artista_desc ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="paisartista">País</label>
                                        <div>
                                            <select id="paisartista" class="mb-1" name="paisartista">
                                                <option value="">Selecionar</option>
                                                <?php
                                                // We need the function!
                                                require_once("connections/connection.php");

                                                // Create a new DB connection
                                                $link = new_db_connection();

                                                /* create a prepared statement */
                                                $stmt = mysqli_stmt_init($link);

                                                $query = "SELECT id_paises, nome FROM paises";

                                                if (mysqli_stmt_prepare($stmt, $query)) {

                                                    /* execute the prepared statement */
                                                    mysqli_stmt_execute($stmt);

                                                    /* bind result variables */
                                                    mysqli_stmt_bind_result($stmt, $id_pais, $pais);

                                                    /* fetch values */
                                                    while (mysqli_stmt_fetch($stmt)) {
                                                        $selected = "";
                                                        if ($artista_ref_id_paises == $id_pais) {
                                                            $selected = "selected";
                                                        }

                                                        echo "<option value='$id_pais' $selected>$pais</option>";
                                                    }

                                                    /* close statement */
                                                    mysqli_stmt_close($stmt);

                                                    /* close connection */
                                                    mysqli_close($link);
                                                } else {
                                                    echo "Error: " . mysqli_error($link);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div id="novoAlbum">
                                    <div class="form-row">
                                        <div class="form-group col-md-9">
                                            <label for="tituloalbum" class="font-weight-bold">Álbum</label>
                                            <input type="text" class="form-control formvender"
                                                   id="tituloalbum" value="<?= $album_titulo ?>" disabled>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="ano">Ano</label>
                                            <input type="number" name="albumano" min="1900" max="2099" step="1"
                                                   class="form-control formvender" id="ano" value="<?= $ano ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-3">
                                            <label for="generoalbum" class="text-muted">Género Musical</label>
                                            <div class="dropdown" id="generoalbum">
                                                <button type="button" class="form-control formvender text-left"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    Géneros
                                                </button>
                                                <div class="dropdown-menu px-3 scrollable-menu">
                                                    <?php

                                                    // Create a new DB connection
                                                    $link = new_db_connection();

                                                    /* create a prepared statement */
                                                    $stmt = mysqli_stmt_init($link);
                                                    $query = "SELECT ref_id_estilos FROM `estilos_has_albuns` WHERE ref_id_albuns = ?";

                                                    if (mysqli_stmt_prepare($stmt, $query)) {

                                                        mysqli_stmt_bind_param($stmt, "i", $id_album);

                                                        /* execute the prepared statement */
                                                        mysqli_stmt_execute($stmt);

                                                        /* bind result variables */
                                                        mysqli_stmt_bind_result($stmt, $id_estilos);

                                                        /* fetch values */
                                                        while (mysqli_stmt_fetch($stmt)) {
                                                            $id_estilos_escolhidos[] = $id_estilos;
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($link);
                                                    }


                                                    $query = "SELECT id_estilos, tipo FROM `estilos` ORDER BY tipo";

                                                    if (mysqli_stmt_prepare($stmt, $query)) {

                                                        /* execute the prepared statement */
                                                        mysqli_stmt_execute($stmt);

                                                        /* bind result variables */
                                                        mysqli_stmt_bind_result($stmt, $id_estilos, $tipo);

                                                        /* fetch values */
                                                        while (mysqli_stmt_fetch($stmt)) {
                                                            $checked = "";
                                                            $resultado = array_search($id_estilos, $id_estilos_escolhidos);
                                                            //se a pesquisa do array retornou um valor, o album tem este estilo
                                                            if (is_numeric($resultado)) {
                                                                $checked = "checked";
                                                            }
                                                            echo "<input type='checkbox' id='check$id_estilos' name='estilos[]' value='$id_estilos' $checked> $tipo<br>";
                                                        }

                                                    } else {
                                                        echo "Error: " . mysqli_error($link);
                                                    }
                                                    /* close statement */
                                                    mysqli_stmt_close($stmt);
                                                    /* close connection */
                                                    mysqli_close($link);
                                                    ?>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="outrogeneroalbum" class="text-muted">Outro Género</label>
                                            <input type="text" name="outrogeneroalbum" class="form-control formvender"
                                                   id="outrogeneroalbum">
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <label for="rotacoes" class="text-muted">Rotações</label>
                                            <select id="rotacoes" name="rotacoes" class="form-control formvender"
                                                    name="rotacoes">
                                                <option value="">Selecionar</option>
                                                <?php

                                                // Create a new DB connection
                                                $link = new_db_connection();

                                                /* create a prepared statement */
                                                $stmt = mysqli_stmt_init($link);

                                                $query = "SELECT id_rotacoes, rpm FROM `rotacoes`";

                                                if (mysqli_stmt_prepare($stmt, $query)) {

                                                    /* execute the prepared statement */
                                                    mysqli_stmt_execute($stmt);

                                                    /* bind result variables */
                                                    mysqli_stmt_bind_result($stmt, $id_rotacoes, $rpm);

                                                    /* fetch values */
                                                    while (mysqli_stmt_fetch($stmt)) {
                                                        $selected = "";
                                                        if ($album_rotacoes == $id_rotacoes) {
                                                            $selected = "selected";
                                                        }
                                                        echo "<option value='$id_rotacoes' $selected>$rpm</option>";
                                                    }

                                                    /* close statement */
                                                    mysqli_stmt_close($stmt);

                                                    /* close connection */
                                                    mysqli_close($link);
                                                } else {
                                                    echo "Error: " . mysqli_error($link);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="editora">Editora</label>
                                            <select id="editora" name="editora" class="form-control formvender"
                                                    name="rotacoes">
                                                <option selected value="">Selecionar</option>
                                                <?php

                                                // Create a new DB connection
                                                $link = new_db_connection();

                                                /* create a prepared statement */
                                                $stmt = mysqli_stmt_init($link);

                                                $query = "SELECT id_editoras, editoras.nome FROM `editoras` ORDER BY editoras.nome";

                                                if (mysqli_stmt_prepare($stmt, $query)) {

                                                    /* execute the prepared statement */
                                                    mysqli_stmt_execute($stmt);

                                                    /* bind result variables */
                                                    mysqli_stmt_bind_result($stmt, $id_editoras, $editora);

                                                    /* fetch values */
                                                    while (mysqli_stmt_fetch($stmt)) {
                                                        $selected = "";
                                                        if ($album_editora == $id_editoras) {
                                                            $selected = "selected";
                                                        }
                                                        echo "<option value='$id_editoras' $selected>$editora</option>";
                                                    }
                                                    /* close statement */
                                                    mysqli_stmt_close($stmt);

                                                    /* close connection */
                                                    mysqli_close($link);
                                                } else {
                                                    echo "Error: " . mysqli_error($link);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="outraeditora">Outra Editora</label>
                                            <input type="text" name="outraeditora" class="form-control formvender"
                                                   id="outraeditora">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="descal" class="text-muted">Descrição</label>
                                        <textarea class="form-control formvender" id="descal" name="descalbum"
                                                  rows="5"><?= $album_desc ?></textarea>
                                    </div>
                                    <hr>
                                </div>
                                <div class="produto">
                                    <div class="form-row">
                                        <div class="form-group col-md-7">
                                            <label for="condicao">Condição</label>
                                            <select id="condicao" name="condicao" class="form-control formvender"
                                                    name="codicao"
                                                    required>
                                                <option selected disabled value="">Selecionar</option>
                                                <?php

                                                // Create a new DB connection
                                                $link = new_db_connection();

                                                /* create a prepared statement */
                                                $stmt = mysqli_stmt_init($link);

                                                $query = "SELECT id_condicoes, condicao FROM condicoes";

                                                if (mysqli_stmt_prepare($stmt, $query)) {

                                                    /* execute the prepared statement */
                                                    mysqli_stmt_execute($stmt);

                                                    /* bind result variables */
                                                    mysqli_stmt_bind_result($stmt, $id_condicao, $condicao);

                                                    /* fetch values */
                                                    while (mysqli_stmt_fetch($stmt)) {
                                                        $selected = "";
                                                        if ($produto_condicoes == $id_condicao) {
                                                            $selected = "selected";
                                                        }
                                                        echo "<option value='$id_condicao' $selected>$condicao</option>";
                                                    }

                                                    /* close statement */
                                                    mysqli_stmt_close($stmt);

                                                    /* close connection */
                                                    mysqli_close($link);
                                                } else {
                                                    echo "Error: " . mysqli_error($link);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="preco">Preço</label>
                                            <input type="number" name="preco" step="any"
                                                   class="form-control formvender" id="preco" value="<?= $preco ?>"
                                                   required>
                                        </div>
                                        <div class="form-group col-md-1 pt-4 mt-3">
                                            €
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="upfoto">Capa do Álbum</label>
                                    <div id="upfoto" class="uploadfoto position-relative">
                                        <label for="avatar" class="botaoupfoto" id="maquina">
                                            <i class="fas fa-camera iconedegrade bg-light"></i>
                                        </label>
                                        <input type="file" id="avatar" name="foto" accept="image/*"
                                               onchange="loadFile(event)">
                                        <img src="img/capas/<?= $capaimg ?>" class="fotoinput" id="output"/>
                                        <script>
                                            var loadFile = function (event) {
                                                var output = document.getElementById('output');
                                                output.src = URL.createObjectURL(event.target.files[0]);
                                                output.onload = function () {
                                                    URL.revokeObjectURL(output.src) // free memory
                                                }
                                            };
                                        </script>
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <input type="submit" name="submit" value="GUARDAR ALTERAÇÕES"
                                           class="btn btn-inform btn-block py-3">
                                </div>
                                <div class="pt-3">
                                    <button type="button" class="btn btn-delete btn-block" data-toggle="modal"
                                            data-target="#exampleModal">
                                        Eliminar Anúncio
                                    </button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content p-0">
                                            <div class="modal-body text-center text-dark">
                                                <h5 class="my-4">Eliminar permanentemente o anúncio?</h5>
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                         fill="#ce4545" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                        <path fill-rule="evenodd"
                                                              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                    </svg>
                                                </div>
                                                <p class="py-3 m-0">Esta ação é irreversível.</p>
                                            </div>
                                            <div class="modal-footer p-0">
                                                <a href="scripts/sc_album_delete.php?id=<?= $id_produto ?>"
                                                   name="submit"
                                                   class="btn botaomodal py-3 m-0 btn-block text-uppercase">Confirmar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </section>
            </main>

            <?php
        } else {
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
    header("Location:catalogo.php");
}


