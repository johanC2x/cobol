    <?php include_once('header.php'); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" style="padding-top: 20px;" >
                        <div class="panel panel-primary">
                            <div class="panel-heading">Crear Usuario</div>
                            <div class="panel-body">
                                <form id="frm_user" role="form">
                                    <fieldset>
                                        <div class="form-group">
                                            <label>Usuario</label>
                                            <input type="text" name="user" id="user" class="form-control"/>
                                            <input type="hidden" name="id" id="id" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Contraseña</label>
                                            <input type="password" name="pass" id="pass" class="form-control"/>
                                        </div>
                                    </fieldset>
                                    <button id="btn_save" type="button" class="btn btn-primary" style="float: right;">
                                        Crear Usuario
                                    </button>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <!-- <div class="error_user" style="display:none;"></div> -->
                        <div class="alert alert-danger error_user" style="display:none;">
                            Los campos usuario y contraseña son requeridos
                        </div>
                        <br/>
                        <table id="table_user" class="table table-striped table-border table-hover">
                            <thead>
                                <tr>
                                    <th><center>ID</center></th>
                                    <th><center>USUARIO</center></th>
                                    <th><center>CONTRASEÑA</center></th>
                                    <th colspan="2"><center>ACCIONES</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4">
                                        <center>NO SE ENCONTRARON RESULTADOS</center>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal_user" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <center>
                            <h3>Operación Correcta</h3>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_error" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <center>
                            <h3>Ha ocurrido un error</h3>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_validate" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <center>
                            <h3 class="msg_user"></h3>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_delete" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <center>
                            <h3>¿Seguro desea eliminar el siguiente usuario?</h3>
                        </center>
                        <input type="hidden" name="id_delete" id="id_delete"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" onclick="eliminarUsuario();" >
                            Aceptar
                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                //LISTANDO USUARIO
                obtenerUsuarios();
                
                //INSERTANDO USUARIO
                $("#btn_save").click(function(){
                    var id = $("#id").val();
                    if(id !== '' && id !== undefined){
                        actulizarUsuario();
                    }else{
                        insertarUsuario();
                    }
                });
            });

            function eliminarUsuario(){
                var id = $("#id_delete").val();
                $.ajax({
                    type: "POST",
                    url:"./php/funciones.php",
                    data: {
                        op : 13,
                        id : id
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if(data.success){
                            $("#modal_delete").modal("hide");
                            $("#modal_user").modal("show");
                            obtenerUsuarios();
                        }else{
                            $("#modal_error").modal("show");
                        }
                    }
                });
            }

            function actulizarUsuario(){
                var id = $("#id").val();
                var user = $("#user").val();
                var pass = $("#pass").val();
                $.ajax({
                    type: "POST",
                    url:"./php/funciones.php",
                    data: {
                        op : 11,
                        id : id,
                        user : user,
                        pass : pass
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if(data.success){
                            $("#modal_user").modal("show");
                            document.getElementById("frm_user").reset();
                            obtenerUsuarios();
                        }else{
                            $("#modal_error").modal("show");
                        }
                    }
                });
            }

            function insertarUsuario(){
                var user = $("#user").val();
                var pass = $("#pass").val();
                if(user === '' || pass === ''){
                    setTimeout(function() {
                        $(".error_user").css("display", "block").fadeOut(3000);
                    });
                }else{
                    $.ajax({
                        type: "POST",
                        url:"./php/funciones.php",
                        data: {
                            op : 10,
                            user : user,
                            pass : pass
                        },
                        success: function (response) {
                            var data = JSON.parse(response);
                            if(data.success){
                                $("#modal_user").modal("show");
                                document.getElementById("frm_user").reset();
                                obtenerUsuarios();
                            }else if(data.hasOwnProperty("msg")){
                                $(".msg_user").text(data.msg);
                                $("#modal_validate").modal("show");
                            }else{
                                $("#modal_error").modal("show");
                            }
                        }
                    });
                }
            }

            function obtenerPorId(id,action){
                $.ajax({
                    type: "POST",
                    url:"./php/funciones.php",
                    data: {
                        op : 12,
                        id : id
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if(data.success){
                            if(action === 'update'){
                                $("#user").val(data.data.user);
                                $("#pass").val(data.data.pass);
                                $("#id").val(data.data.id);
                            }else if(action === 'delete'){
                                $("#id_delete").val(data.data.id);
                                $("#modal_delete").modal("show");
                            }
                        }else{

                        }
                    }
                });
            }

            function obtenerUsuarios(){
                $.ajax({
                    type: "POST",
                    url:"./php/funciones.php",
                    data: {
                        op : 9
                    },
                    success: function (response) {
                        var tbody = '';
                        var data = JSON.parse(response);
                        $("#table_user tbody").empty();
                        if(data.success){
                            if(data.data.length > 0){
                                for(var i = 0;i < data.data.length;i++){
                                    tbody += `<tr>
                                                <td><center>`+ data.data[i].id +`</center></td>
                                                <td><center>`+ data.data[i].user +`</center></td>
                                                <td><center>`+ data.data[i].pass +`</center></td>
                                                <td><a href="javascript:void(0);" onclick="obtenerPorId(`+ data.data[i].id +`,'update');" >Editar</a></td>
                                                <td><a href="javascript:void(0);" onclick="obtenerPorId(`+ data.data[i].id +`,'delete');" >Eliminar</a></td>
                                            </tr>`;
                                }
                                $("#table_user tbody").append(tbody);
                            }
                        }else{
                            tbody = `<tr>
                                        <td colspan="3">
                                            <center>NO SE ENCONTRARON RESULTADOS</center>
                                        </td>
                                    </tr>`;
                            $("#table_user tbody").append(tbody);
                        }
                    }
                });
            }

        </script>
    </body>
</html>