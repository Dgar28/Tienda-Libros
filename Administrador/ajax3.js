src = "js/jquery-3.3.1.min.js"
function actualizaEstilos() {
    var filasVisibles = $('.centrar table tr:visible').not(':first'); // Ignora la fila del encabezado
    filasVisibles.each(function(index) {
        $(this).css('background-color', index % 2 === 0 ? '#87CEEB' : '#AFEEEE');
    });
}

function confirmEliminar(id) {
    if (confirm("¿Estás seguro de que quieres eliminar este empleado?")) {
        enviaAjax(id);
    }
}

function enviaAjax(id) {
    if (id && id > 0) {
        $.ajax({
            url: 'promociones_eliminar.php',
            type: 'POST',
            data: { id: id },
            dataType: 'text',
            success: function(res) {
                if (ban === '1') {
                    $('#fila_' + id).fadeOut('slow', function() {
                        $(this).remove();
                        actualizaEstilos();
                        $('.centrar td[colspan="6"] h1').text(function(i, text) { // Actualiza el contador en el encabezado
                            return text.replace(/\(\d+\)/, function(match) {
                                return '(' + (parseInt(match.slice(1, -1)) - 1) + ')';
                            });
                        });
                    });
                }
            },
            error: function() {
                alert("Error en la comunicación con el servidor.");
            }
        });
    }
}
