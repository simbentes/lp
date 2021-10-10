<nav class="navbar navbar-expand-md  <?php if ($_SERVER['REQUEST_URI'] == "/deca_20L4/deca_20L4_03/MP/" || $_SERVER['REQUEST_URI'] == "/deca_20L4/deca_20L4_03/MP/index.php") {
    echo "bg-degrade navbar-dark";
} else {
    echo "bg-white navbar-light border-bottom";
} ?> fixed-top">
    <div class="container">
        <a id="indexLogin" class="navbar-brand secondhand mr-md-4" href="index.php">

            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="auto" fill="currentColor"
                 viewBox="0 0 1024 445.8">
                <g>
                    <path d="M458.5,349.6v96.2H0V0h114.6v349.6H458.5z"/>
                    <path d="M1024,163.7c0,99.3-69.4,163-170.7,163H617.7v119.1H503.1V0h350.2C954.6,0,1024,64.3,1024,163.7z M909.4,163.7
		c0-67.5-53.5-67.5-87.9-67.5H617.7v134.4h203.8C855.9,230.5,909.4,230.5,909.4,163.7z"/>
                </g>
            </svg>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a id="catalogoLogin" class="nav-link text-center text-md-left"
                       href="catalogo.php">Catálogo<span class="sr-only">(current)</span></a>
                </li>
                <?php
                if (isset($_SESSION["id_user"])) {
                    ?>
                    <li id="vender" class="nav-item">
                        <a class="nav-link text-center text-md-left" href="vender.php">Vender</a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item">
                    <a id="sobreLogin" class="nav-link text-center text-md-left" href="sobre.php">Sobre</a>
                </li>
            </ul>
            <?php
            if (!isset($_SESSION["id_user"])) {
                ?>
                <a id="entrar" href="login.php">
                    <div class="btn btn-conta px-3 py-2">Iniciar Sessão</div>
                </a>
                <?php
            } else {
                ?>
                <div id="perfil" class="dropdown text-center text-md-right">
                    <button class="btn btn-conta" type="button" id="dropdownConta"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="img-fluid mr-2 rounded-circle p-1 fotoperfilnavtop"
                             src='img/users/<?= $_SESSION["fperfil"] ?>' alt="<?= $_SESSION["nome"] ?>">
                        <span class="pr-3"><?= $_SESSION["nome"] ?></span>
                    </button>
                    <div class="dropdown-menu perfildrop" aria-labelledby="dropdownConta">
                        <a class="dropdown-item" href="conta.php"><b>Conta</b></a>
                        <a class="dropdown-item" href="historico-compras.php"><b>Histórico de compras</b></a>
                        <a class="dropdown-item" href="guardados.php"><b>Guardados</b></a>
                        <hr>
                        <a class="dropdown-item" href="scripts/sc_logout.php">Terminar Sessão</a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</nav>



