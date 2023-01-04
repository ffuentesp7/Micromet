/*
* JqNews - JQuery NewsTicker
* Author: Gravagnola Saverio and Iuliano Renato
* Version: 2.0 Orizzontale e Verticale
*/

// Settings for the vertical rotation.
var newsVisualVertical = 4; //Number of news to be displayed
var intervalloVert = 4000; // time > 2500
var numNewsVert;
//Enter the same value used in the file css/style.css for "jqnewsVert"
var larghezzaDivVert = 150; //width div
var altezzaDivVert = 118; //height div
var margineDivVert = 5; //margin between div

// Settings for the horizontal rotation.
var newsVisualOrizzontal = 2;   //Number of news to be displayed
var intervalloOriz = 5000; // time > 1500
var numNewsOrizzontal;
//Enter the same value used in the file css/style.css for "jqnewsOriz"
var larghezzaDivOriz = 500; // width div
var altezzaDivOriz = 17; // height div
var margineDivOriz = 5; // margin between div

FIELDID = '';

function startNewsTickerVert(fieldid) {

    FIELDID = fieldid;
    // Totale news
    numNewsVert = $(FIELDID).children().length;

    // Se si è creato il div per le news a rotazione verticale
    if (numNewsVert > 0) {
        jqnewsVertical();
    }
}

function startNewsTickerHor(fieldid){
    FIELDID = fieldid;
    // Totale news orizzontali
    numNewsOrizzontal = $(FIELDID).children().length;
    
    // Se si è creato il div per le news a rotazione orizzontale
    if (numNewsOrizzontal > 0) {
        jqnewsOrizzontal();
    }
}


function jqnewsVertical() {
    // Controllo di overflow
    if (newsVisualVertical > numNewsVert) {
        newsVisualVertical = numNewsVert;
    }

    // Hide delle news superflue all'inizializzazione
    for (var i = newsVisualVertical; i < numNewsVert; i++) {
        $($(FIELDID).children()[i]).css("opacity", "0");
    }

    var gestInter = setInterval(jqNewsRotateVertical, intervalloVert);

    // Gestione del mouseover-mouseout
    $(FIELDID).mouseover(function() { clearInterval(gestInter) });
    $(FIELDID).mouseout(function() { gestInter = setInterval(jqNewsRotateVertical, intervalloVert); });
}

function jqNewsRotateVertical() {
    // Hide della prima news
    $($(FIELDID).children()[0]).animate({ opacity: 0 }, 1000, "linear", function() {
        // Movimento verso l'alto
        $($(FIELDID).children()[0]).animate({ marginTop: -altezzaDivVert }, 1000, "linear", function() {
            // Ripristino posizione elemento nascosto
        $($(FIELDID).children()[0]).css("margin", margineDivVert);
        // Spostamento in coda dell'elemento nascosto
        $(FIELDID).append($($(FIELDID).children()[0]));
            // Visualizzazione dell'ultima news
        $($(FIELDID).children()[newsVisualVertical - 1]).animate({ opacity: 1 }, 1000);
        });
    });
}

function jqnewsOrizzontal() {
    // Controllo di overflow
    if (newsVisualOrizzontal > numNewsOrizzontal) {
        newsVisualOrizzontal = numNewsOrizzontal;
    }

    // Hide delle news superflue all'inizializzazione
    for (var i = newsVisualOrizzontal; i < numNewsOrizzontal; i++) {
        $($(FIELDID).children()[i]).css("opacity", "0");
    }

    var gestInter = setInterval(jqNewsRotateOrizzontal, intervalloOriz);

    // Gestione del mouseover-mouseout
    $(FIELDID).mouseover(function() { clearInterval(gestInter) });
    $(FIELDID).mouseout(function() { gestInter = setInterval(jqNewsRotateOrizzontal, intervalloOriz); });
}

function jqNewsRotateOrizzontal() {    
    // Hide della prima news
    $($(FIELDID).children()[0]).animate({ opacity: 0 }, 400, "linear", function() {
        // Movimento verso l'alto
        $($(FIELDID).children()[0]).animate({ marginLeft: -larghezzaDivOriz }, 400, "linear", function() {
            // Ripristino posizione elemento nascosto
            $($(FIELDID).children()[0]).css("margin", margineDivOriz);
            // Spostamento in coda dell'elemento nascosto
            $(FIELDID).append($($(FIELDID).children()[0]));
            // Visualizzazione dell'ultima news
            $($(FIELDID).children()[(newsVisualOrizzontal - 1)]).animate({ opacity: 1 }, 400);
        });
    });
}