<main class="bg-light">
    <section class="container py-5">
        <!-- FORM VENDER-->
        <section class="m-auto text-center pt-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="auto" fill="currentColor"
                 viewBox="0 0 1024 445.8">
                <g>
                    <path d="M458.5,349.6v96.2H0V0h114.6v349.6H458.5z"/>
                    <path d="M1024,163.7c0,99.3-69.4,163-170.7,163H617.7v119.1H503.1V0h350.2C954.6,0,1024,64.3,1024,163.7z M909.4,163.7
		c0-67.5-53.5-67.5-87.9-67.5H617.7v134.4h203.8C855.9,230.5,909.4,230.5,909.4,163.7z"/>
                </g>
            </svg>
        </section>
        <form action="scripts/sc_user_login.php" method="post">
            <div class="row justify-content-center py-5">
                <div class="col-md-6">
                    <div>
                        <?php
                        if (isset($_GET["msg"])) {
                            $msg_show = true;
                            switch ($_GET["msg"]) {
                                case 0:
                                    $message = "O e-mail ou a senha fornecidos não correspondem às informações dos nossos registros. Verifique-as e tente novamente.";
                                    $class = "alert-danger";
                                    break;
                                case 1:
                                    $message = "Para efectuar compras, inicia sessão ou cria uma conta.";
                                    $class = "alert-danger";
                                    break;
                                case 2:
                                    $message = "Para fazeres reviews, inicia sessão ou cria uma conta.";
                                    $class = "alert-danger";
                                    break;
                                case 3:
                                    $message = "Password alterada com sucesso.";
                                    $class = "alert-success";
                                    break;
                                case 4:
                                    $message = "A sua conta está suspensa.";
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
                    </div>
                    <div class="form-group">
                        <label for="nome">Email</label>
                        <input type="email" class="form-control forminfo" id="nome" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control forminfo" id="password" name="password" required>
                    </div>
                    <div class="form-group pt-4">
                        <button class="btn btn-inform btn-block py-4" type="submit">INICIAR SESSÃO</button>
                    </div>
                    <?php
                    if (isset($_SESSION["msg_erro"])) {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            Email ou Password incorretos.
                        </div>
                        <?php
                        unset($_SESSION["msg_erro"]);
                    }
                    ?>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-9">
                            <div class="form-group pt-4">
                                <a href="registar.php" class="btn btn-registar btn-block" type="submit">CRIAR CONTA</a>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-9">
                            <div class="form-group pt-4 text-center pass">
                                <a href="repor-password.php" class="font-weight-bold text-center">Não sabes a tua
                                    palavra-passe?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>