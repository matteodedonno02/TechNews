function ricaricaJs()
{
    $("#scriptCategorie").remove();
    $("body").append("<script id='scriptCategorie' src='assets/js/selezioneCategorie.js'></script>");
}


function aggiungiCategoria(id, testo)
{
    testo = testo.replace("+ ", "");
    $("input[name=txtCategorie]").val($("input[name=txtCategorie]").val() + testo + "::");
    var temp = $("<button id='" + id + "' type='button' class='btn btn-outline-primary categoria-scelta' onclick=\"rimuoviCategoria('" + id + "', '- " + testo + "')\">- " + testo + "</button>");
    $(".categorie-scelte").append(temp);
    $("#" + id).remove();
    ricaricaJs();
}


function rimuoviCategoria(id, testo)
{
    $("#" + id).remove();
    testo = testo.replace("- ", "");
    $("input[name=txtCategorie]").val($("input[name=txtCategorie]").val().replace(testo + "::", ""));
    var temp = $("<button id='" + id + "' type='button' class='btn btn-outline-primary categoria' onclick=\"aggiungiCategoria('" + id + "', '+ " + testo + "')\">+ " + testo + "</button>");
    $(".categorie-rimanenti").append(temp);
    ricaricaJs();
}





