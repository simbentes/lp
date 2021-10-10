<div id="album<?= $id ?>" class="col-sm-6 col-lg-4 col-xl-3 mb-5">
    <div class="card h-100">
        <div class="position-relative">
            <a href="album_info.php?item=<?= $id ?>">
                <div class="quadrado">
                    <div style="background-image: url('img/capas/<?= $capa ?>')"
                         class="card-img-top">
                    </div>
                </div>
            </a>
            <div class="guardar">
                <input id="heart<?= $id ?>" value="<?= $id ?>" class="heart"
                       type="checkbox" <?php if ($guardado == 1) {
                    echo "checked";
                } ?> onclick="guardarAlbum(this.checked,this.value)"/>
                <label class="labelheart p-1" for="heart<?= $id ?>"><i class="fas fa-heart"></i></label>
            </div>
        </div>
        <div class="card-body">
            <div class="row no-gutters px-2 justify-content-between align-items-center mt-1">
                <div class="col-auto">
                    <div class="text-pequeno"><?= $artista ?></div>
                    <p class="mb-0 h4 titulocard">
                        <strong>
                            <?= $titulo ?>
                        </strong>
                    </p>
                </div>
            </div>
            <div class="row justify-content-between align-items-center no-gutters">
                <div class="col-auto">
                    <p class="h5 mb-2 ml-2"><?= $preco . "€" ?></p>
                </div>
                <div class="col-auto">
                    <div class="mb-2 mr-2">
                        <span class="small font-weight-bold"><?= $nome . " " . $apelido ?></span>
                        <img class="img-fluid rounded-circle fotoperfilalbuns"
                             src='img/users/<?= $fperfil ?>' alt="<?= $nome . " " . $apelido ?>">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="album_info.php?item=<?= $id ?>"
                   class="btn btn-degrade btn-block h-100 text-uppercase py-2">
                    Ver Detalhes
                    <i class="fa fa-angle-right pl-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>