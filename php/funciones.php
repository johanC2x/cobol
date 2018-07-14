<?php

    $op = $_POST["op"];

    require_once('./utils.php');

    switch($op){
        case 1:
            $list = array();
            $value = (isset($_POST["name"]) && !empty($_POST["name"])) ? $_POST["name"] : false;

            $array = [];
            $name_file = "";
            $directorio = '../file';
            $ficheros  = scandir($directorio);

            foreach($ficheros as $file){
                $pos = strpos($file,".txt");
                if(!empty($pos)){
                    $content = fopen("../file/".$file, "r");
                    while(!feof($content)){
                        $line = fgets($content);
                        $pos_file = strpos($line,$value);
                        if(!empty($pos_file)){
                            $name_file = str_replace(" ","",str_replace("JOB","",str_replace(".txt","",$file)));
                        }
                    }
                    fclose($content);
                }
            }

            if(!empty($name_file) && $value){
                $list = obtenerLista($name_file);
                if(sizeof($list["children"]) > 0){
                    foreach($list["children"] as $key => $children){
                        $list_children = obtenerListaChildren($children);
                        if(!empty($list_children)){
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
                    echo json_encode(["success" => true,"data" => $list]);
                }else{
                    echo json_encode(["success" => false,"msg" => "el valor buscado no se encuentra"]);
                }
            }else{
                echo json_encode(["success" => false]);
            }
            break;
        case 2:
            $value = (isset($_POST["name"]) && !empty($_POST["name"])) ? $_POST["name"] : false;
            if($value){
                $list = obtenerLista($value);
                if(sizeof($list["children"]) > 0){
                    foreach($list["children"] as $key => $children){
                        $list_children = obtenerListaChildren($children);
                        if(!empty($list_children)){
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
                    echo json_encode(["success" => true,"data" => $list]);
                }else{
                    echo json_encode(["success" => false,"msg" => "el valor buscado no se encuentra"]);
                }
            }else{
                echo json_encode(["success" => false]);
            }
            break;
        case 3:
            $list = array();
            $value = (isset($_POST["name"]) && !empty($_POST["name"])) ? $_POST["name"] : false;

            $array = [];
            $name_file = "";
            $directorio = '../file';
            $ficheros  = scandir($directorio);

            if(sizeof($ficheros) > 0){
                foreach($ficheros as $file){
                    $pos = strpos($file,".txt");
                    if(!empty($pos)){
                        $content = fopen("../file/".$file, "r");
                        while(!feof($content)){
                            $line = fgets($content);
                            $pos_file = strpos($line,$value);
                            if(!empty($pos_file)){
                                $name = str_replace(" ","",str_replace("JOB","",str_replace(".txt","",$file)));
                                $array[] = array(
                                    "name" => $name
                                );
                            }
                        }
                        fclose($content);
                    }
                }
                if(sizeof($array) > 0){
                    echo json_encode(["success" => true,"data" => $array]);
                }else{
                    echo json_encode(["success" => false]);
                }
            }else{
                echo json_encode(["success" => false]);
            }
            break;
        //LOGIN DE ACCESO
        case 4:
            $user = (isset($_POST["user"]) && !empty($_POST["user"])) ? $_POST["user"] : false;
            $pass = (isset($_POST["pass"]) && !empty($_POST["pass"])) ? $_POST["pass"] : false;
            if($user && $pass){
                $user = obtenerUsuario($user,$pass);
                if(!empty($user)){
                    $_SESSION['user'] = $user;
                    echo json_encode(["success" => true]);
                }else{
                    echo json_encode(["success" => false]);
                }
            }else{
                echo json_encode(["success" => false]);
            }
            break;
        case 5:
            unset($_SESSION['user']);
            break;
    }

?>