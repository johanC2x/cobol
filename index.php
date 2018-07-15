<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.

PRUEBAS => JP1CC105

CON CTL EN EL PROCEDIMIENTO

CON JOB EN EL 

-->
<?php
/*
    $server = true;
    if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        if($server){
            header('Location: '.$actual_link."/cobol/login.php");
        }else{
            header('Location: '.$actual_link."/login.php");
        }
    }
*/
?>
<html>
    <head>
        <title>INFODOC</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/mihojadeestilos.css"/>
        <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
        <link rel="stylesheet" href="./css/font-awesome.min.css">
        <link rel="stylesheet" href="./css/jquery.orgchart.css">
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    </head>
    <body>
        <header>
            <section id="tituloPrincipal">
                <h1>INFODOC</h1>
            </section>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a id="btn_logout" href="javascript:void(0);">
                                    Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>
            <nav id="navegadorPrincipal">
                <ul>
                    <li><input type="checkbox" id="jobs" onchange="changeCkJob();">Jobs</li>
                    <li><input type="checkbox" id="procedimientos" onchange="changeCkProc();">Procedimientos</li>
                    <li><input type="checkbox" id="ctl" onchange="changeCkCtl();">ctl</li>
                    <li><input type="checkbox" id="programas" onchange="changeCkProg();">Programas</li>
                </ul>
            </nav>
        </header>
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
                        <table id="table" class="table table-striped table-border table-hover" >
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
        var parent = [];
        var children = [];
        $(document).ready(function(){
            var list = {};
            var tbody = '';
            var array = [];

            $("#lk_diagrama").hide();
            $("#lk_diagrama_child").hide();
            $("#table").hide();
            
            var url = '';
            var server = true;
            var user = localStorage.getItem("user");
            if(user === undefined || user === '' || user === null){
                if(server){
                    url = window.location.origin + '/cobol/login.php';
                }else{
                    url = window.location.origin + '/login.php';
                }
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

        function logOut(){
            var url = '';
            var server = true;
            localStorage.removeItem("user");
            if(localStorage.getItem("user") === undefined || localStorage.getItem("user") === '' || localStorage.getItem("user") === null){
                if(server){
                    url = window.location.origin + '/cobol/index.php';
                }else{
                    url = window.location.origin + '/index.php';
                }
                window.location.replace(url);
            }
            /*
            $.ajax({
                type:"POST",
                url:"./php/funciones.php",
                data:{
                    op:5
                },
                success:function(response){
                    window.location.reload();
                }
            });
            */
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
                        $("#job_name").text(value);
                        var tbody = '';
                        $("#table_child tbody").empty();
                        if(result.data.children.length > 0){
                            for(var i=0;i < result.data.children.length;i++){
                                var title = result.data.children[i].title;
                                tbody += `<tr>
                                            <td><center>`+ i +`</center></td>
                                            <td><center>`+ title +`</center></td>
                                            <td>
                                                <center>
                                                    <a href="javascript:void(0);" onclick="obtenerListadoPorJob('`+ title +`');" >
                                                        ver
                                                    </a>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <a href="/cobol/php/diagrama.php?value=`+ title +`" target="_blank">
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
            var name = $("#name").val();
            var ck_jobs = $("#jobs").prop("checked");
            var ck_proc = $("#procedimientos").prop("checked");
            var ck_ctl = $("#ctl").prop("checked");
            var ck_prog = $("#programas").prop("checked");
            if(name !== ''){
                if(ck_jobs){
                    obtenerListadoPorJobs(name);
                }else if(ck_proc){
                    
                }else if(ck_ctl){
                
                }else if(ck_prog){

                }else{
                    $("#msg").html("Es necesario seleccionar una opción");
                    $("#table").hide();
                }
            }else{
                $("#msg").html("Es necesario seleccionar una opción");
                $("#table").hide();
            }
        }

        function obtenerListadoPorJobs(name){
            $.ajax({
                type:"POST",
                url:"./php/funciones.php",
                data:{
                    op:3,
                    name:name
                },
                beforeSend: function() {
                    $("#chart-container").empty();
                    $("#msg").html('<img src="/img/loader.gif" width="20px" />');
                },
                success:function(response){
                    var result = JSON.parse(response);
                    if(result.success){
                        if(result.data.length > 0){
                            $("#table").show();
                            $("#msg").html("");
                            var tbody = '';
                            $("#table tbody").empty();
                            for(var i=0;i < result.data.length;i++){
                                var title = result.data[i].name;
                                tbody += `<tr>
                                            <td><center>`+ (i + 1) +`</center></td>
                                            <td><center>`+ title +`</center></td>
                                            <td>
                                                <center>
                                                    <a href="javascript:void(0);" onclick="obtenerListadoPorJob('`+ title +`');" >
                                                        ver
                                                    </a>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <a href="/cobol/php/diagrama.php?value=`+ title +`" target="_blank">
                                                        ver diagrama
                                                    </a>
                                                </center>
                                            </td>
                                          </tr>`;
                            }
                            /*
                            for(var i=0;i < result.data.children.length;i++){
                                var title = result.data.children[i].title;
                                tbody += `<tr>
                                            <td><center>`+ i +`</center></td>
                                            <td><center>`+ title +`</center></td>
                                            <td>
                                                <center>
                                                    <a href="javascript:void(0);" onclick="obtenerListadoPorJob('`+ title +`');" >
                                                        ver
                                                    </a>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <a href="/php/diagrama.php?value=`+ title +`" target="_blank">
                                                        ver diagrama
                                                    </a>
                                                </center>
                                            </td>
                                          </tr>`;
                            }
                            */
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