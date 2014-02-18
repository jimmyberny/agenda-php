<?php 
require_once( 'admin.php' );
?>
<!doctype html>
<html lang="es">
    <head>
        <?php include 'basic_css.php' ?>
        <title>Configuración</title>
    </head>
    <body>
        <!-- Empieza el encabezado -->
        <?php include 'header.php' ?>
        <!-- Termina el encabezado -->

        <div class="container">
            <h1>Configuración</h1>
            <div class="panel panel-default hidden-xs">
                <div class="panel-heading">
                    <div class="btn-group">
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-default" type="button" onclick="guardarConfiguracion()">
                            <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
                        </button>
                    </div>
                </div>
                <div class="panel-body item-form">
                    <form id="frm-configuracion" class="form-horizontal" role="form">
                        <!-- Campos ocultos -->
                        <input type="hidden" id="accion" name="accion" value="guardar" />
                        <!-- Campos editables -->
                        <div class="form-group">
                            <label for="dias" class="col-lg-3 control-label">Recordatorio</label>
                            <div class="col-lg-9">
                                <select id="dias" name="dias" class="form-control">
                                    <option value="1">1 dia</option>
                                    <option value="7">7 dias</option>
                                    <option value="15">15 dias</option>
                                </select>
                            </div>
                        </div>
                        <!-- Configuracion del smtp para enviar emails -->
                        <div class="form-group">
                            <label for="smtp_servidor" class="col-lg-3 control-label">Servidor SMTP</label>
                            <div class="col-lg-9">
                                <input id="smtp_servidor" name="smtp_servidor" type="text" class="form-control" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="smtp_puerto" class="col-lg-3 control-label">Puerto SMTP</label>
                            <div class="col-lg-9">
                                <input id="smtp_puerto" name="smtp_puerto" type="text" class="form-control" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="smtp_usuario" class="col-lg-3 control-label">Usuario SMTP</label>
                            <div class="col-lg-9">
                                <input id="smtp_usuario" name="smtp_usuario" type="text" class="form-control" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="smtp_clave" class="col-lg-3 control-label">Contraseña SMTP</label>
                            <div class="col-lg-9">
                                <input id="smtp_clave" name="smtp_clave" type="password" class="form-control" required />
                            </div>
                        </div>
                        <!-- termina configuracion de smtp -->
                    </form>
                </div>
            </div>
            <!-- Mensajes -->
            <div id="mensajes">
            </div>
        </div>
        <!-- Empieza el pie -->
        <?php include 'footer.php' ?>
        <!-- Terminal el pie -->
        <!-- Empieza javascript -->
        <?php include 'basic_js.php' ?>

        <script type="text/javascript">
            $(document).ready(function() {
                // Mostrar la configuracion
                cargarConfiguracion();
            });

            function cargarConfiguracion() {
                $.getJSON('configuracion_controller.php',
                    {accion: 'obtener'},
                    function(json) {
                        if (json.resultado) {
                            $('#recordatorio').val(json.item.recordatorio);
                            //
                            $('#smtp_servidor').val(json.item.smtp_servidor);
                            $('#smtp_puerto').val(json.item.smtp_puerto);
                            $('#smtp_usuario').val(json.item.smtp_usuario);
                            $('#smtp_clave').val(json.item.smtp_clave);
                            $('#dias').focus();
                        } else {
                            uxErrorAlert('No se encontró la configuración')
                        }
                    });
            }

            function guardarConfiguracion() {
                var params = $('#frm-configuracion').serializeArray();
                $.post('configuracion_controller.php',
                    params,
                    function(json) {
                        if (json.resultado) {
                            uxSuccessAlert('Configuración guardada correctamente');
                        } else {
                            uxErrorAlert('No se pudo guardar la configuración');
                        }
                    });
            }
        </script>
    </body>
</html>