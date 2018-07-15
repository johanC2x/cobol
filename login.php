<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" style="padding-top: 100px;" >
                        <div class="panel panel-primary">
                            <div class="panel-heading">Iniciar Sesión</div>
                            <div class="panel-body">
                                <form role="form">
                                    <fieldset>
                                        <div class="form-group">
                                            <label>Usuario</label>
                                            <input type="text" name="user" id="user" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Contraseña</label>
                                            <input type="password" name="pass" id="pass" class="form-control"/>
                                        </div>
                                    </fieldset>
                                    <button id="btn_login" type="button" class="btn btn-primary" style="float: right;">
                                        Iniciar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <script>
            var server = false;
            $(document).on("ready",function(){
                if(document.getElementById("btn_login") !== null){
                    document.getElementById("btn_login").onclick = function () {
                        login();
                    };
                }
            });

            function login(){
                var user = $("#user").val();
                var pass = $("#pass").val();
                $.ajax({
                    type: "POST",
                    url:"./php/funciones.php",
                    data: {
                        op : 4,
                        user : user,
                        pass : pass
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        var path = (window.location.origin.search("54") !== undefined && window.location.origin.search("54") !== -1) ? "/cobol" : "/";
                        if(data.success){
                            var url = window.location.origin + path + '/index.php';
                            var user = JSON.stringify(data.data);
                            localStorage.setItem("user", user);
                            window.location.replace(url);
                        }
                    }
                });
            }

        </script>
    </body>
</html>