<?php
    require_once('./utils.php');

    $list = array();
    $list_parent = array();
    $value = (isset($_GET["value"]) && !empty($_GET["value"])) ? $_GET["value"] : false;
    if($value){
        $list = obtenerLista($value);
        if(sizeof($list["parent"]) > 0){
            foreach($list["parent"] as $key => $parent){
                $list_parent["children"][$key] = array(
                    "name" => "JOB",
                    "title" => $parent,
                );
            }
        }

        if(sizeof($list["children"]) > 0){
            foreach($list["children"] as $key => $children){
                $list_children = obtenerListaChildren($children);
                $last_pos = sizeof($list_children["children"]) - 1;
                unset($list_children["children"][(int)$last_pos]);
                if(!empty($list_children)){
                    if($value === $children){
                        foreach($list_children["children"] as $key_sec => $children_sec){
                            $list_children_sec = obtenerListaChildren($children_sec["title"]);
                            if(!empty($list_children_sec)){
                                $list["children"][$key_sec] = array(
                                    "name" => "JOB",
                                    "title" => $children_sec["title"],
                                    "children" => $list_children_sec["children"]
                                );
                            }
                        }
                    }else{
                        $list["children"][$key] = array(
                            "name" => "JOB",
                            "title" => $children,
                            "children" => $list_children["children"]
                        );
                        foreach($list_children["children"] as $key_sec => $children_sec){
                            $list_children_sec = obtenerListaChildren($children_sec["title"]);
                            if(!empty($list_children_sec)){
                                $list["children"][$key]["children"][$key_sec] = array(
                                    "name" => "JOB",
                                    "title" => $children_sec["title"],
                                    "children" => $list_children_sec["children"]
                                );
                            }
                        }
                    }
                }
            }
        }
        // echo "<pre/>";print_r($list_parent)."\n";
        // echo "<pre/>";print_r($list);
        // exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>INFODOC</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/mihojadeestilos.css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Slabo+27px">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/jquery.orgchart.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    </head>
    <body>
        <header>
            <section id="tituloPrincipal">
                <h1>INFODOC</h1>
            </section>
        </header>
        <section id="buscador">
            <h3>LISTA DE PREDECESORES</h3>
            <div id="chart-parent-container"></div>
            <br/>
            <h3>LISTA DE SUCESORES</h3>
            <div id="chart-container"></div>
        </section>
        <footer>
        </footer>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/stefanpenner/es6-promise/master/dist/es6-promise.auto.min.js"></script>
        <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        
        <script type="text/javascript" src="https://cdn.rawgit.com/stefanpenner/es6-promise/master/dist/es6-promise.auto.min.js"></script>
        <script type="text/javascript" src="../js/html2canvas.min.js"></script>
        <script type="text/javascript" src="../js/jspdf.min.js"></script>
        <script type="text/javascript" src="../js/jquery.orgchart.js"></script>

        <script>
            $(document).ready(function(){
                var list = {};
                var list_parent = {};
                var result = JSON.parse('<?php echo json_encode(["success" => true,"data" => $list]); ?>');
                var result_parent = JSON.parse('<?php echo json_encode(["success" => true,"data" => $list_parent]); ?>');
                if(result.success){
                    $("#chart-container").empty();
                    var data = result.data;
                    var list_children = data.children;
                    if(list_children.length > 0){
                        $("#msg").html('');
                        list.name = "JOB"
                        list.title = "<?php echo $value; ?>";
                        list.children = list_children;
                        $('#chart-container').orgchart({
                            'data' : list,
                            'visibleLevel': 3,
                            'nodeContent': 'title',
                            //'verticalLevel': 2,
                            'exportButton': true,
                            'exportFilename': 'diagrama'
                        });
                    }
                }
                if(result_parent.success){
                    $("#chart-parent-container").empty();
                    var data_parent = result_parent.data;
                    var list_children = data_parent.children;
                    if(list_children.length > 0){
                        $("#msg").html('');
                        list_parent.name = "JOB"
                        list_parent.title = "<?php echo $value; ?>";
                        list_parent.children = list_children;
                        $('#chart-parent-container').orgchart({
                            'data' : list_parent,
                            'visibleLevel': 3,
                            'nodeContent': 'title',
                            //'verticalLevel': 2,
                            'exportButton': true,
                            'exportFilename': 'diagrama'
                        });
                    }
                }
            });
        </script>

    </body>
</html>