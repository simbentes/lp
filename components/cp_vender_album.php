<main class="bg-light">
    <section class="container py-5">
        <h3 class="pb-5">Vender Álbum</h3>
        <!-- FORM VENDER-->
        <form action="scripts/sc_vender_album.php" method="post" enctype="multipart/form-data">
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
                                    $message = "Faltam informações do Álbum";
                                    $class = "alert-danger";
                                    break;
                                case 2:
                                    $message = "<i class='far fa-check-circle pr-2'></i>Anúncio publicado com sucesso";
                                    $class = "alert-success";
                                    break;
                                default:
                                    $msg_show = false;
                            }

                            echo "<div class=\"alert $class alert-dismissible fade show\" role=\"alert\">
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
                    <div class="form-group">
                        <label for="interprete">Intérprete</label>
                        <div>
                            <select id="interprete" class="mb-1" name="artista" onchange="showUser(this.value)"
                                    required>
                                <option selected disabled value="">Selecionar</option>
                                <?php
                                // We need the function!
                                require_once("connections/connection.php");

                                // Create a new DB connection
                                $link = new_db_connection();

                                /* create a prepared statement */
                                $stmt = mysqli_stmt_init($link);

                                $query = "SELECT id_artistas, nome FROM artistas";

                                if (mysqli_stmt_prepare($stmt, $query)) {

                                    /* execute the prepared statement */
                                    mysqli_stmt_execute($stmt);

                                    /* bind result variables */
                                    mysqli_stmt_bind_result($stmt, $id_artista, $artista);

                                    /* fetch values */
                                    while (mysqli_stmt_fetch($stmt)) {
                                        echo "<option value='$id_artista'>$artista</option>";
                                    }

                                    /* close statement */
                                    mysqli_stmt_close($stmt);

                                    /* close connection */
                                    mysqli_close($link);
                                } else {
                                    echo "Error: " . mysqli_error($link);
                                }
                                ?>
                                <option value="novoartista" class="font-weight-bolder">Novo Intérprete</option>
                            </select>
                        </div>
                    </div>
                    <div id="novoInterprete" style="display: none">
                        <div class="form-group">
                            <label for="outrointerprete">Nome</label>
                            <input type="text" name="nomeartista" class="form-control formvender"
                                   id="outrointerprete">
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control formvender" id="descricao" name="artistadesc"
                                      rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="paisartista">País</label>
                            <div>
                                <select id="paisartista" class="mb-1" name="paisartista">
                                    <option selected disabled>Selecionar</option>
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
                                            echo "<option value='$id_pais'>$pais</option>";
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
                    <div class="form-group" id="sectionAlbum" style="display: none">
                        <label for="textAlbum">Álbum</label>
                        <div>
                            <div id="selectAlbum" class="mb-1" name="album">
                                <select id="txtAlbum" name="album"></select>
                            </div>
                        </div>
                    </div>
                    <div id="novoAlbum" style="display: none">
                        <div class="form-row">
                            <div class="form-group col-md-9">
                                <label for="tituloalbum">Título</label>
                                <input type="text" name="tituloalbum" class="form-control formvender" id="tituloalbum">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="ano">Ano</label>
                                <input type="number" name="albumano" min="1900" max="2099" step="1"
                                       class="form-control formvender" id="ano">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-3">
                                <label for="generoalbum">Género Musical</label>
                                <div class="dropdown" id="generoalbum">
                                    <button type="button" class="form-control formvender text-left"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Géneros
                                    </button>
                                    <div class="dropdown-menu px-3 scrollable-menu">
                                        <?php

                                        // Create a new DB connection
                                        $link = new_db_connection();

                                        /* create a prepared statement */
                                        $stmt = mysqli_stmt_init($link);

                                        $query = "SELECT id_estilos, tipo FROM `estilos` ORDER BY tipo";

                                        if (mysqli_stmt_prepare($stmt, $query)) {

                                            /* execute the prepared statement */
                                            mysqli_stmt_execute($stmt);

                                            /* bind result variables */
                                            mysqli_stmt_bind_result($stmt, $id_estilos, $tipo);

                                            /* fetch values */
                                            while (mysqli_stmt_fetch($stmt)) {
                                                echo "<input type='checkbox' id='check$id_estilos' name='estilos[]' value='$id_estilos'> $tipo<br>";
                                            }

                                            /* close statement */
                                            mysqli_stmt_close($stmt);

                                            /* close connection */
                                            mysqli_close($link);
                                        } else {
                                            echo "Error: " . mysqli_error($link);
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group col-lg-6">
                                <label for="outrogeneroalbum" class="text-muted">Outro(s) Género(s) <small>(separar por vírgulas)</small></label>
                                <input type="text" name="outrogeneroalbum" class="form-control formvender"
                                       id="outrogeneroalbum">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="rotacoes" class="text-muted">Rotações</label>
                                <select id="rotacoes" name="rotacoes" class="form-control formvender" name="rotacoes">
                                    <option selected disabled>Selecionar</option>
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
                                            echo "<option value='$id_rotacoes'>$rpm</option>";
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
                                    <option selected>Selecionar</option>
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
                                            echo "<option value='$id_editoras'>$editora</option>";
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
                                      rows="5"></textarea>
                        </div>
                        <hr>
                    </div>
                    <div class="produto">
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label for="condicao">Condição</label>
                                <select id="condicao" name="condicao" class="form-control formvender" name="codicao"
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
                                            echo "<option value='$id_condicao'>$condicao</option>";
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
                                       class="form-control formvender" id="preco" max="999" required>
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
                                <i class="fas fa-camera iconedegrade"></i>
                            </label>
                            <input type="file" id="avatar" name="foto" accept="image/*" onchange="loadFile(event)">
                            <img class="fotoinput d-none" id="output"/>
                            <script>
                                var loadFile = function (event) {
                                    var output = document.getElementById('output');
                                    output.src = URL.createObjectURL(event.target.files[0]);
                                    output.onload = function () {
                                        URL.revokeObjectURL(output.src) // free memory
                                    }
                                    document.getElementById('maquina').classList.add("d-none");
                                    document.getElementById('output').classList.remove("d-none");
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-8 termos">
                    Concordo com o tratamento de dados seguindo os <strong>Termos e
                        Condições</strong> da LP,
                    que se regem pelo Regulamento Geral da Proteção de Dados
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <input type="submit" name="submit" value="VENDER" class="btn btn-inform btn-block py-3">
                </div>
            </div>
        </form>
    </section>
</main>
