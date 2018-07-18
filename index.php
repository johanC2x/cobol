<?php include_once('header.php'); ?>
    <nav id="navegadorPrincipal">
        <ul>
            <li><input type="checkbox" id="jobs" onchange="changeCkJob();">Jobs</li>
            <li><input type="checkbox" id="procedimientos" onchange="changeCkProc();">Procedimientos</li>
            <li><input type="checkbox" id="ctl" onchange="changeCkCtl();">ctl</li>
            <li><input type="checkbox" id="programas" onchange="changeCkProg();">Programas</li>
        </ul>
    </nav>
    <section id="buscador">
        <div>
            <ul>
                <form name="busqueda" id="busqueda" method="get">
                    <li>
                    <input type="text" name="name" id="name"/>
                    </li>
                    <li>
                        <button id="btn_buscar" type="button">Buscar</button>
                    </li>
                </form>
            </ul>
        </div>
        <!--
        <div>
            <ul>
                <li>Scheduler</li>
                <li>Diagramado</li>
            </ul>
        </div>
        -->
        <br/>
        <div id="msg"></div>
        <br/>
        <div id="chart_table">
            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <!-- TABLE FOR PROCEDIMIENTO -->
                    <table id="table" class="table table-striped table-border table-hover" >
                        <thead>
                            <tr>
                                <th><center>Nro.</center></th>
                                <th><center>Job</center></th>
                                <th><center>PROCEDIMIENTO</center></th>
                                <th colspan="2"><center>Acción</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    NO SE ENCONTRARON RESULTADOS
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- TABLE FOR JOBS -->
                    <table id="table_job" class="table table-striped table-border table-hover" >
                        <thead>
                            <tr>
                                <th><center>Nro.</center></th>
                                <th><center>Job</center></th>
                                <th colspan="2"><center>Acción</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    NO SE ENCONTRARON RESULTADOS
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- TABLE FOR CTL -->
                    <table id="table_ctl" class="table table-striped table-border table-hover" >
                        <thead>
                            <tr>
                                <th><center>Nro.</center></th>
                                <th><center>Job</center></th>
                                <th><center>PROCEDIMIENTO</center></th>
                                <th><center>CTL</center></th>
                                <th colspan="2"><center>Acción</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5">
                                    NO SE ENCONTRARON RESULTADOS
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- TABLE FOR PRG -->
                    <table id="table_prg" class="table table-striped table-border table-hover" >
                        <thead>
                            <tr>
                                <th><center>Nro.</center></th>
                                <th><center>Job</center></th>
                                <th><center>PROCEDIMIENTO</center></th>
                                <th><center>PROGRAMA</center></th>
                                <th colspan="2"><center>Acción</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5">
                                    NO SE ENCONTRARON RESULTADOS
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
        <!-- <div id="chart-container"></div> -->
    </section>
    <footer>
        
    </footer>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">JOB <span id="job_name"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <a id="lk_diagrama_child" href="javascript:void(0);" target="_blank">
                                Ver Diagrama
                            </a>
                        </div>
                    </div>
                    <br/>
                    <table id="table_child" class="table table-striped table-border table-hover" >
                        <thead>
                            <tr>
                                <th><center>Nro.</center></th>
                                <th><center>Nombre</center></th>
                                <th colspan="2"><center>Acción</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    NO SE ENCONTRARON RESULTADOS
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal_child" class="modal fade" role="dialog">

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/stefanpenner/es6-promise/master/dist/es6-promise.auto.min.js"></script>
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/jquery.orgchart.js"></script>
    <script type="text/javascript">
        var server = false;
        var parent = [];
        var children = [];
        var path_img = (window.location.origin.search("54") !== undefined && window.location.origin.search("54") !== -1) ? "/cobol/img" : "/img";
        $(document).ready(function(){
            var list = {};
            var tbody = '';
            var array = [];

            $("#lk_diagrama").hide();
            $("#lk_diagrama_child").hide();
            
            hideTables();
            
            var path = (window.location.origin.search("54") !== undefined && window.location.origin.search("54") !== -1) ? "/cobol" : "";
            var url = window.location.origin + path + '/login.php';
            if(localStorage.getItem("user") === undefined || localStorage.getItem("user") === '' || localStorage.getItem("user") === null){
                window.location.replace(url);
            }

            //OBTENER LISTADO DE JOBS
            if(document.getElementById("btn_buscar") !== null){
                document.getElementById("btn_buscar").onclick = function () {
                    obtenerListadoJobs();
                };
            }
            //CERRAR SESIÓN
            if(document.getElementById("btn_logout") !== null){
                document.getElementById("btn_logout").onclick = function () {
                    logOut();
                };
            }
        });

        function hideTables(){
            $("#table").hide();
            $("#table_job").hide();
            $("#table_ctl").hide();
            $("#table_prg").hide();
        }

        function logOut(){
            localStorage.removeItem("user");
            var path = (window.location.origin.search("54") !== undefined && window.location.origin.search("54") !== -1) ? "/cobol" : "/";
            var url = window.location.origin + path + '/login.php';
            if(localStorage.getItem("user") === undefined || localStorage.getItem("user") === '' || localStorage.getItem("user") === null){
                window.location.replace(url);
            }
        }

        function obtenerListadoPorJob(value){
            $.ajax({
                type:"POST",
                url:"./php/funciones.php",
                data:{
                    op:2,
                    name:value
                },
                beforeSend: function() {},
                success:function(response){
                    var result = JSON.parse(response);
                    if(result.success){
                        var tbody = '';
                        var path = (window.location.origin.search("54") !== undefined && window.location.origin.search("54") !== -1) ? "/cobol/php" : "/php";
                        $("#job_name").text(value);
                        $("#table_child tbody").empty();
                        if(result.data.children.length > 0){
                            for(var i=0;i < result.data.children.length;i++){
                                var title = result.data.children[i].title;
                                tbody += `<tr>
                                            <td><center>`+ i +`</center></td>
                                            <td><center>`+ title +`</center></td>
                                            <td>
                                                <center>
                                                    <a href=`+ path +`/diagrama.php?value=`+ title +` target="_blank">
                                                        ver diagrama
                                                    </a>
                                                </center>
                                            </td>
                                          </tr>`;
                            }
                        }else{
                            tbody = `<tr>
                                        <td colspan="3">
                                            NO SE ENCONTRARON RESULTADOS
                                        </td>
                                     </tr>`;
                        }
                        $("#table_child tbody").append(tbody);
                        $("#myModal").modal("show");
                        $("#msg").html('');
                        $("#lk_diagrama_child").show();
                        $("#lk_diagrama_child").attr("href", "/cobol/php/diagrama.php?value="+value);
                    }
                }
            });
        }

        function obtenerListadoJobs(){
            hideTables();
            var name = $("#name").val();
            var ck_jobs = $("#jobs").prop("checked");
            var ck_proc = $("#procedimientos").prop("checked");
            var ck_ctl = $("#ctl").prop("checked");
            var ck_prog = $("#programas").prop("checked");
            if(name !== ''){
                if(ck_jobs){
                    obtenerListadoPorJobs(name);
                }else if(ck_proc){
                    obtenerListadoPorProc(name);
                }else if(ck_ctl){
                    obtenerListadoPorCtl(name);
                }else if(ck_prog){
                    obtenerListadoPorPrg(name);
                }else{
                    $("#msg").html("Es necesario seleccionar una opción");
                    $("#table").hide();
                }
            }else{
                $("#msg").html("Es necesario escribir en la caja de texto y seleccionar una opción");
                $("#table").hide();
            }
        }

        function obtenerListadoPorPrg(name){
            hideTables();
            $.ajax({
                type:"POST",
                url:"./php/funciones.php",
                data:{
                    op:7,
                    name:name
                },
                beforeSend: function() {
                    $("#chart-container").empty();
                    $("#msg").html('<img src="'+ path_img +'/loader.gif" width="20px" />');
                },
                success:function(response){
                    var result = JSON.parse(response);
                    var path = (window.location.origin.search("54") !== undefined && window.location.origin.search("54") !== -1) ? "/cobol/php" : "/php";
                    if(result.success){
                        if(result.data.length > 0){
                            $("#msg").html("");
                            var tbody = '';
                            $("#table_prg tbody").empty();
                            for(var i=0;i < result.data.length;i++){
                                var prg = result.data[i].name_prg;
                                var proc = result.data[i].name_pro;
                                var title = result.data[i].name_job;
                                tbody += `<tr>
                                            <td><center>`+ (i + 1) +`</center></td>                                            
                                            <td><center>`+ title +`</center></td>
                                            <td><center>`+ proc +`</center></td>
                                            <td><center>`+ prg +`</center></td>
                                            <td>
                                                <center>
                                                    <a href="javascript:void(0);" onclick="obtenerListadoPorJob('`+ title +`');" >
                                                        ver
                                                    </a>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <a href="`+ path +`/diagrama.php?value=`+ title +`" target="_blank">
                                                        ver diagrama
                                                    </a>
                                                </center>
                                            </td>
                                          </tr>`;
                            }
                            $("#table_prg tbody").append(tbody);
                            $("#table_prg").show();
                            $("#msg").html('');
                        }
                    }else if(result.hasOwnProperty("msg")){
                        $("#msg").html(result.msg);
                        $("#table_prg").hide();
                    }else{
                        $("#msg").html("No se encontraron resultados");
                        $("#table_prg").hide();
                    }
                }
            });
        }

        function obtenerListadoPorCtl(name){
            hideTables();
            $.ajax({
                type:"POST",
                url:"./php/funciones.php",
                data:{
                    op:6,
                    name:name
                },
                beforeSend: function() {
                    $("#chart-container").empty();
                    $("#msg").html('<img src="'+ path_img +'/loader.gif" width="20px" />');
                },
                success:function(response){
                    var result = JSON.parse(response);
                    var path = (window.location.origin.search("54") !== undefined && window.location.origin.search("54") !== -1) ? "/cobol/php" : "/php";
                    if(result.success){
                        if(result.data.length > 0){
                            $("#msg").html("");
                            var tbody = '';
                            $("#table_ctl tbody").empty();
                            for(var i=0;i < result.data.length;i++){
                                var ctl = result.data[i].name_ctl;
                                var proc = result.data[i].name_pro;
                                var title = result.data[i].name_job;
                                tbody += `<tr>
                                            <td><center>`+ (i + 1) +`</center></td>                                            
                                            <td><center>`+ title +`</center></td>
                                            <td><center>`+ proc +`</center></td>
                                            <td><center>`+ ctl +`</center></td>
                                            <td>
                                                <center>
                                                    <a href="`+ path +`/diagrama.php?value=`+ title +`" target="_blank">
                                                        ver diagrama
                                                    </a>
                                                </center>
                                            </td>
                                          </tr>`;
                            }
                            $("#table_ctl tbody").append(tbody);
                            $("#table_ctl").show();
                            $("#msg").html('');
                        }
                    }else if(result.hasOwnProperty("msg")){
                        $("#msg").html(result.msg);
                        $("#table_ctl").hide();
                    }else{
                        $("#msg").html("No se encontraron resultados");
                        $("#table_ctl").hide();
                    }
                }
            });
        }

        function obtenerListadoPorJobs(name){
            $.ajax({
                type:"POST",
                url:"./php/funciones.php",
                data:{
                    op:8,
                    name:name
                },
                beforeSend: function() {
                    $("#chart-container").empty();
                    $("#msg").html('<img src="'+ path_img +'/loader.gif" width="20px" />');
                },
                success:function(response){
                    var result = JSON.parse(response);
                    var path = (window.location.origin.search("54") !== undefined && window.location.origin.search("54") !== -1) ? "/cobol/php" : "/php";
                    if(result.success){
                        if(result.data.length > 0){
                            $("#table_job").show();
                            $("#msg").html("");
                            var tbody = '';
                            $("#table_job tbody").empty();
                            for(var i=0;i < result.data.length;i++){
                                var title = result.data[i].name;
                                tbody += `<tr>
                                            <td><center>`+ (i + 1) +`</center></td>
                                            <td><center>`+ title +`</center></td>
                                            <td>
                                                <center>
                                                    <a href="`+ path +`/diagrama.php?value=`+ title +`" target="_blank">
                                                        ver diagrama
                                                    </a>
                                                </center>
                                            </td>
                                          </tr>`;
                            }
                            $("#table_job tbody").append(tbody);
                            $("#msg").html('');
                        }
                    }else if(result.hasOwnProperty("msg")){
                        $("#msg").html(result.msg);
                        $("#table_job").hide();
                    }else{
                        $("#msg").html("No se encontraron resultados");
                        $("#table_job").hide();
                    }
                }
            });
        }

        function obtenerListadoPorProc(name){
            $.ajax({
                type:"POST",
                url:"./php/funciones.php",
                data:{
                    op:3,
                    name:name
                },
                beforeSend: function() {
                    $("#chart-container").empty();
                    $("#msg").html('<img src="'+ path_img +'/loader.gif" width="20px" />');
                },
                success:function(response){
                    var result = JSON.parse(response);
                    var path = (window.location.origin.search("54") !== undefined && window.location.origin.search("54") !== -1) ? "/cobol/php" : "/php";
                    if(result.success){
                        if(result.data.length > 0){
                            $("#table").show();
                            $("#msg").html("");
                            var tbody = '';
                            $("#table tbody").empty();
                            for(var i=0;i < result.data.length;i++){
                                var title = result.data[i].name;
                                var name_proc = result.data[i].name_pro;
                                tbody += `<tr>
                                            <td><center>`+ (i + 1) +`</center></td>
                                            <td><center>`+ title +`</center></td>
                                            <td><center>`+ name_proc +`</center></td>
                                            <td>
                                                <center>
                                                    <a href="`+ path +`/diagrama.php?value=`+ title +`" target="_blank">
                                                        ver diagrama
                                                    </a>
                                                </center>
                                            </td>
                                          </tr>`;
                            }
                            $("#table tbody").append(tbody);
                            $("#msg").html('');
                        }
                    }else if(result.hasOwnProperty("msg")){
                        $("#msg").html(result.msg);
                        $("#table").hide();
                    }else{
                        $("#msg").html("No se encontraron resultados");
                        $("#table").hide();
                    }
                }
            });
        }

        function changeCkJob(){
            $("#procedimientos").prop("checked",false);
            $("#ctl").prop("checked",false);
            $("#programas").prop("checked",false);
        }

        function changeCkProc(){
            $("#jobs").prop("checked",false);
            $("#ctl").prop("checked",false);
            $("#programas").prop("checked",false);
        }

        function changeCkCtl(){
            $("#jobs").prop("checked",false);
            $("#procedimientos").prop("checked",false);
            $("#programas").prop("checked",false);
        }

        function changeCkProg(){
            $("#jobs").prop("checked",false);
            $("#procedimientos").prop("checked",false);
            $("#ctl").prop("checked",false);
        }

    </script>
    </body>
</html>