window.onload = function() {
    baja();
}

function objetoAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function baja() {
    var restaurantes = document.getElementById('restaurantes');
    var buscador = document.getElementById('searchCocina1').value;
    var buscador2 = document.getElementById('searchPrecio1').value;
    var ajax = new objetoAjax();
    var token = document.getElementById('token').getAttribute('content');
    // Busca la ruta read y que sea asyncrono
    ajax.open('POST', 'mostrarbaja', true);
    var datasend = new FormData();
    datasend.append('filtro', buscador);
    datasend.append('filtro2', buscador2);
    datasend.append('_token', token);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(ajax.responseText);
            var tabla = '';
            tabla += '<div class="row contenidoCartas">';
            for (let i = 0; i < respuesta.length; i++) {
                tabla += '<div class="col-sm-12 col-md-6 col-lg-3 p-1">';
                tabla += '<div class="card d-flex text-white bg-cards">';
                tabla += '<img class="card-img-top img-fluid mx-auto pt-2 imgCard" style="width: 250px; height: 215px;" src="data:image/png;base64,' + respuesta[i].foto + '" alt="Card image cap"></img>';
                tabla += '<div class="card-body">';
                tabla += '<h2 class="card-title">' + respuesta[i].nombre + '</h2>';
                tabla += '<p class="card-text text-truncate">Dirección: ' + respuesta[i].ciudad + ', ' + respuesta[i].calle + ', ' + respuesta[i].cp + '</p>';
                tabla += '<p class="card-text text-truncate">Tipo cocina: ' + respuesta[i].tipo_cocina + '</p>';
                tabla += '<p class="card-text text-truncate">Precio: ' + respuesta[i].precio_medio + '€</p>';
                tabla += '</div>';
                tabla += '<div class="d-flex justify-content-center">';
                tabla += '<form class="w-auto m-2" method="GET" action="modificar/' + respuesta[i].id_restaurante + '"><button class="btn btn-success" type="sumbit">Modificar</button></form>';
                tabla += '<form class="w-auto m-2" method="GET" action="alta/' + respuesta[i].id_restaurante + '"> <button class="btn btn-danger" type="sumbit">Alta</button></form>';
                tabla += '</div>';
                tabla += '</div>';
                tabla += '</div>';
            }
            tabla += '</div>';
        }
        restaurantes.innerHTML = tabla;
    }
    ajax.send(datasend);
}