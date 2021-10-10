<main class="bg-light">
    <section class="container py-5">
        <h3 class="pb-5">Criar Conta</h3>
        <!-- FORM VENDER-->
        <form action="scripts/sc_user_register.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <?php
                    if (isset($_GET["msg"])) {
                        $msg_show = true;
                        switch ($_GET["msg"]) {
                            case 0:
                                $message = "Ocorreu um erro no registo";
                                $class = "alert-danger";
                                break;
                            case 1:
                                $message = "Este email já tem uma conta na LP";
                                $class = "alert-danger";
                                break;
                            case 2:
                                $message = "Morada mal preenchida.";
                                $class = "alert-danger";
                                break;
                            case 3:
                                $message = "Palavras-passe não coincidem";
                                $class = "alert-danger";
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
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="titulo">Nome</label>
                            <input type="text" name="nome" class="form-control forminfo" id="nome" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="titulo">Apelido</label>
                            <input type="text" name="apelido" class="form-control forminfo" id="apelido" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control forminfo" id="nome" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control forminfo" id="password"
                                   minlength="6" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="password2">Confirmar Password<span id="msg_erro"
                                                                           class="pl-3 small"></span></label>
                            <input type="password" name="password2" class="form-control forminfo" id="password2"
                                   minlength="6" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="birthday">Data de Nascimento</label>
                            <input type="date" name="nascimento" class="form-control forminfo" id="birthday"
                                   max="2008-12-31" required>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="telemovel">Telemóvel</label>
                            <input type="tel" name="tel" id="telemovel" class="form-control forminfo" required>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="nif">NIF</label>
                            <input type="text" name="nif" id="nif" class="form-control forminfo" pattern="[0-9]{9}" required>
                        </div>
                    </div>
                    <hr class="my-3">
                    <h5>Morada
                        <div class="btn btn-outline-light" id="btnMorada">Adicionar</div>
                    </h5>
                    <div id="moradaGrupo" style="display: none">
                        <div class="form-group">
                            <label for="email">Rua</label>
                            <input type="text" name="rua" class="form-control forminfo" id="rua">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label for="codigopostal">Código Postal</label>
                                <input type="text" name="codigopostal" class="form-control forminfo" id="codigopostal">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="cidade">Localidade<span id="msg_erro" class="pl-3 small"></span></label>
                                <input type="text" name="cidade" class="form-control forminfo" id="cidade">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="pais">País<span id="msg_erro" class="pl-3 small"></span></label>
                                <select name="pais">
                                    <option disabled selected value="">Selecionar:</option>
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
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="upfoto">Foto de Perfil</label>
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
                    Ao clicar em Criar Conta, concordo com o tratamento de dados seguindo os <strong>Termos e
                        Condições</strong> da LP,
                    que se regem pelo Regulamento Geral da Proteção de Dados
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <input type="submit" name="submit" id="submit" value="CRIAR CONTA" class="btn btn-inform py-3 btn-block">
                </div>
            </div>
        </form>
        <p class="mt-5 mb-3 text-center">Já tens Conta? <a href="login.php"><strong>Iniciar Sessão</strong></a></p>
    </section>
</main>