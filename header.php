<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.

PRUEBAS => JP1CC105

CON CTL EN EL PROCEDIMIENTO OBTENIENDO EL PRO OBTENIENDO EL NOMBRE BUSCAR EN JOBS

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
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <a href="index.php">
                                    Inicio
                                </a>
                            </li>
                            <li>
                                <a href="usuarios.php">
                                    Usuarios
                                </a>
                            </li>
                        </ul>
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
        </header>