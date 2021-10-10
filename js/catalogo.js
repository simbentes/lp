var proximo = true;
var limite = 4;
var maximo = false;
//id do ultimo album
var lastalbum = "";
var lastpesquisa = "";
var lastestilo = "";
var texto = "";
var i

$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 10) {
        if (proximo) {
            //last pesquisa, porque se existir uma pesquisa ativa, se fizermos scroll, precisamos de saber qual é para não aparecem albuns não correspondentes
            carregarAlbuns(lastpesquisa, lastestilo);
            proximo = false;

        }
    }
});

$(document).ready(function () {
    lastalbum = "";
    carregarAlbuns("", "");
});

document.getElementById("estilos").addEventListener("change", function () {
    selecionarEstilos(this.value)
});


function carregarAlbuns(pesquisa, estilo) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var albuns = JSON.parse(this.responseText);
            for (let i = 0; i < albuns[0].repeticoes; i++) {


                //verificar atraves do objeto json se o user tem algum album guardado
                if (albuns[i].guardadoChecked == 1) {
                    var checked = 'checked'
                }

                //se tem sessao iniciada mostramos o btn
                if (albuns[i].btnShow) {
                    checkbox = '<div class="guardar"> <input id="heart' + albuns[i].id + '" value="' + albuns[i].id + '" class="heart" type="checkbox" ' + checked + ' onclick="guardarAlbum(this.checked,this.value)"/> <label class="labelheart p-1" for="heart' + albuns[i].id + '"><i class="fas fa-heart"></i></label> </div>'
                } else {
                    checkbox = ''
                }
                //botao ver detalhes || botao editar
                if (!albuns[i].editar) {
                    botao = '<div class="d-flex justify-content-between"> <a href="album_info.php?item=' + albuns[i].id + '" class="btn btn-degrade btn-block h-100 text-uppercase py-2"> Ver Detalhes <i class="fa fa-angle-right pl-1"></i> </a> </div>'
                } else {
                    botao = '<div class="d-flex justify-content-between"> <a href="editar-album-info.php?item=' + albuns[i].id + '" class="btn btn-editar btn-block h-100 text-uppercase py-2"> Editar <i class="fa fa-angle-right pl-1"></i> </a> </div>'
                }

                //guardar ultimo album, pesquisa e estilo
                lastpesquisa = albuns[i].pesquisa
                lastestilo = albuns[i].estilo
                lastalbum = albuns[i].id;

                //desenhar o card
                var div = document.createElement('div');
                div.setAttribute('class', 'col-sm-6 col-lg-3 mb-5');
                div.innerHTML = '<div class="card h-100"><div class="position-relative"><a href="album_info.php?item=' + albuns[i].id + '"><div class="quadrado"><div style="background-image: url(\'img/capas/' + albuns[i].capa + '\')"class="card-img-top"></div></div></a>' + checkbox + '</div> <div class="card-body"> <div class="row no-gutters px-2 justify-content-between align-items-center mt-1"> <div class="col-auto"> <div class="text-pequeno">' + albuns[i].artista + '</div> <p class="mb-0 h4 titulocard"> <strong> ' + albuns[i].titulo + ' </strong> </p> </div> </div> <div class="row justify-content-between align-items-center no-gutters"> <div class="col-auto"> <p class="h5 mb-2 ml-2">' + albuns[i].preco + '€</p> </div> <div class="col-auto" {PERFILSHOW}> <div class="mb-2 mr-2"> <span class="small font-weight-bold">' + albuns[i].nome + ' ' + albuns[i].apelido + '</span> <img class="img-fluid rounded-circle fotoperfilalbuns" src=\'img/users/' + albuns[i].fperfil + '\' alt="' + albuns[i].nome + ' ' + albuns[i].apelido + '"> </div> </div> </div> ' + botao + ' </div> </div>'

                document.getElementById('albuns').appendChild(div);
            }


            proximo = true;
        }
    };

    xmlhttp.open("GET", "scripts/sc_carregar_albuns.php?carregar=1&limite=" + limite + "&id=" + lastalbum + "&string=" + pesquisa + "&estilo=" + estilo, true);
    xmlhttp.send();

}

//adicionar album aos favoritos
function guardarAlbum(estado, produto) {
    //vamos enviar por ajax o produto e estado do botao(checkbox), para saber se o user "guardou" ou "removeu dos guardados"
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "scripts/sc_guardar_album.php?guardado=" + estado + "&produto=" + produto, true);
    xmlhttp.send();

}


// às vezes, quando pesquisava muito rápído, repetia os álbuns porque não tinha tempo de os apagar apagar
//depois de pesquisar bastante, encontrei esta solução
//só envia o valor do input passado algum tempo
var input = document.getElementById('search-bar');

var timeout = null;

input.addEventListener('keyup', function (e) {

    clearTimeout(timeout);

    timeout = setTimeout(function () {
        pesquisarAlbuns(input.value);
    }, 300);
});


function pesquisarAlbuns(string) {
    clearTimeout(timeout);
    document.getElementById("albuns").innerHTML = ""
    timeout = setTimeout(function () {
        if (document.getElementById("albuns").innerHTML == "") {
            document.getElementById("albuns").innerHTML = "<div class='col-12'><h1 class='py-5 my-5 text-center'>Sem resultados.</h1></div>";
        }
    }, 700)


    var estilo = document.getElementById("estilos").value

    //se for igual a "" o user apagou a sua pesquisa, ou seja, vamos repor todos os albuns
    if (string != "") {
        //repor as variaveis de ultimo album e row. para evitar que se o user tiver já feito scroll e ter chegado ao fim
        // não apareçam mais albuns
        lastalbum = "";
        carregarAlbuns(string, estilo);
    } else {
        document.getElementById("albuns").innerHTML = "";
        limite = 4;
        maximo = false;
        lastalbum = "";
        carregarAlbuns("", estilo);
    }

}


function selecionarEstilos(estilo) {
    clearTimeout(timeout);
    document.getElementById("albuns").innerHTML = ""
    timeout = setTimeout(function () {
        if (document.getElementById("albuns").innerHTML == "") {
            document.getElementById("albuns").innerHTML = "<div class='col-12'><h1 class='py-5 my-5 text-center'>Sem resultados.</h1></div>";
        }
    }, 700)

    document.getElementById("albuns").innerHTML = "";
    var pesquisa = document.getElementById("search-bar").value
    if (estilo != "") {
        //repor as variaveis de ultimo album e row. para evitar que se o user tiver já feito scroll e ter chegado ao fim
        // não apareçam mais albuns
        lastalbum = "";
        carregarAlbuns(pesquisa, estilo);
    } else {
        document.getElementById("albuns").innerHTML = "";
        limite = 4;
        maximo = false;
        lastalbum = "";
        carregarAlbuns(pesquisa, "");
    }


}

