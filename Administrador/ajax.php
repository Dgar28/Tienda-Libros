
        function confirmEliminar(id) {
            if (confirm("¿Estás seguro de que quieres eliminar este empleado?")) {
            enviaAjax(id);
            }
            }
        function enviaAjax(id){
            var numero = $('#numero').val();
            var id = $('#id').val();
            if (id && id > 0){
                $.ajax({
                    url         : 'empleados_eliminar.php?id='+id,
                    type        : 'post',
                    datatype    : 'text',
                    data        : 'numero='+numero+'&id='+id,
                    success     : function(res){
                            console.log(res);
                            $('#mensaje').show();
                            if(res == 1){
                                $('#mensaje').html('Empleado eliminado');
                            }
                            else{
                                $('#mensaje').html('Error al aliminar');
                            }
                            setTimeout("$('#mensaje').html(''); $('#mensaje').hide();",5000);
                    }
                });
            }
        }

