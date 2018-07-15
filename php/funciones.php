<?php

    $op = $_POST["op"];

    require_once('./utils.php');

    switch($op){
        case 1:
            $list = array();
            $value = (isset($_POST["name"]) && !empty($_POST["name"])) ? $_POST["name"] : false;

            $array = [];
            $name_file = "";
            $directorio = '../file/job';
            $ficheros  = scandir($directorio);

            foreach($ficheros as $file){
                $pos = strpos($file,".txt");
                if(!empty($pos)){
                    $content = fopen("../file/job/".$file, "r");
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
            $directorio = '../file/job';
            $ficheros  = scandir($directorio);

            if(sizeof($ficheros) > 0){
                foreach($ficheros as $file){
                    $pos = strpos($file,".txt");
                    if(!empty($pos)){
                        $content = fopen("../file/job/".$file, "r");
                        while(!feof($content)){
                            $line = fgets($content);
                            $pos_file = strpos($line,$value);
                            if(!empty($pos_file)){
                                $name = str_replace(" ","",str_replace("JOB","",str_replace(".txt","",$file)));
                                $array[] = array(
                                    "name" => $name,
                                    "name_pro" => $value
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
        case 4:
            $user = (isset($_POST["user"]) && !empty($_POST["user"])) ? $_POST["user"] : false;
            $pass = (isset($_POST["pass"]) && !empty($_POST["pass"])) ? $_POST["pass"] : false;
            if($user && $pass){
                $user = obtenerUsuario($user,$pass);
                if(!empty($user)){
                    //$_SESSION['user'] = $user;
                    echo json_encode(["success" => true,"data" => $user]);
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
        case 6:
            $list = array();
            $name_ctl = "";
            $value = (isset($_POST["name"]) && !empty($_POST["name"])) ? strtoupper($_POST["name"]) : false;

            $array = [];
            $response = [];
            $name_file = "";
            $directorio = '../file/pro';
            $ficheros  = scandir($directorio);
            
            if(sizeof($ficheros) > 0){
                $name_ctl = $value;
                foreach($ficheros as $file){
                    $pos = strpos($file,".txt");
                    if(!empty($pos)){
                        $content = fopen("../file/pro/".$file, "r");
                        while(!feof($content)){
                            $line = fgets($content);
                            $pos_file = strpos(str_replace(" ","",$line),str_replace(" ","",$value));
                            if(!empty($pos_file)){
                                $name = str_replace(" ","",str_replace("PRO","",str_replace(".txt","",$file)));
                                $array[] = array(
                                    "name" => $name
                                );
                            }
                        }
                        fclose($content);
                    }
                }

                $directorio_job = '../file/job';
                $ficheros_job = scandir($directorio_job);
                if(sizeof($array) > 0){
                    foreach($array as $key => $value){
                        if(!empty($value)){
                            if(sizeof($ficheros_job) > 0){
                                foreach($ficheros_job as $file_job){
                                    $pos_job = strpos($file_job,".txt");
                                    if(!empty($pos_job)){
                                        $content_job = fopen("../file/job/".$file_job, "r");
                                        while(!feof($content_job)){
                                            $line_job = fgets($content_job);
                                            $pos_file_job = strpos($line_job,strtoupper($value["name"]));
                                            if(!empty($pos_file_job)){
                                                $name_job = str_replace(" ","",str_replace("JOB","",str_replace(".txt","",$file_job)));
                                                $response[$key] = array(
                                                    "name_ctl" => $name_ctl,
                                                    "name_pro" => $value["name"],
                                                    "name_job" => $name_job
                                                );
                                            }
                                        }
                                        fclose($content_job);
                                    }
                                }
                            }
                        }
                    }
                }
                if(sizeof($array) > 0){
                    echo json_encode(["success" => true,"data" => $response]);
                }else{
                    echo json_encode(["success" => false]);
                }
            }else{
                echo json_encode(["success" => false]);
            }
            break;
        case 7:
            $list = array();
            $name_programa = "";
            $value = (isset($_POST["name"]) && !empty($_POST["name"])) ? strtoupper($_POST["name"]) : false;

            $array = [];
            $response = [];
            $name_file = "";
            $directorio = '../file/pro';
            $ficheros  = scandir($directorio);
            
            if(sizeof($ficheros) > 0){
                $name_programa = $value;
                foreach($ficheros as $file){
                    $pos = strpos($file,".txt");
                    if(!empty($pos)){
                        $content = fopen("../file/pro/".$file, "r");
                        while(!feof($content)){
                            $line = fgets($content);
                            $pos_file = strpos(str_replace(" ","",$line),str_replace(" ","",$value));
                            if(!empty($pos_file)){
                                $name = str_replace(" ","",str_replace("PRO","",str_replace(".txt","",$file)));
                                $array[] = array(
                                    "name" => $name
                                );
                            }
                        }
                        fclose($content);
                    }
                }

                $directorio_job = '../file/job';
                $ficheros_job = scandir($directorio_job);
                if(sizeof($array) > 0){
                    foreach($array as $key => $value){
                        if(!empty($value)){
                            if(sizeof($ficheros_job) > 0){
                                foreach($ficheros_job as $file_job){
                                    $pos_job = strpos($file_job,".txt");
                                    if(!empty($pos_job)){
                                        $content_job = fopen("../file/job/".$file_job, "r");
                                        while(!feof($content_job)){
                                            $line_job = fgets($content_job);
                                            $pos_file_job = strpos($line_job,strtoupper($value["name"]));
                                            if(!empty($pos_file_job)){
                                                $name_job = str_replace(" ","",str_replace("JOB","",str_replace(".txt","",$file_job)));
                                                $response[$key] = array(
                                                    "name_prg" => $name_programa,
                                                    "name_pro" => $value["name"],
                                                    "name_job" => $name_job
                                                );
                                            }
                                        }
                                        fclose($content_job);
                                    }
                                }
                            }
                        }
                    }
                }
                if(sizeof($array) > 0){
                    echo json_encode(["success" => true,"data" => $response]);
                }else{
                    echo json_encode(["success" => false]);
                }
            }else{
                echo json_encode(["success" => false]);
            }
            break;
        case 8:
            $list = array();
            $name_job = "";
            $value = (isset($_POST["name"]) && !empty($_POST["name"])) ? strtoupper($_POST["name"]) : false;

            $array = [];
            $response = [];
            $name_file = "";
            $directorio = '../file/job';
            $ficheros  = scandir($directorio);
            
            if(sizeof($ficheros) > 0){
                foreach($ficheros as $file){
                    $name = str_replace(" ","",str_replace("JOB","",str_replace(".txt","",$file)));
                    if($name === $value){
                        $array[] = array(
                            "name" => $name
                        );
                    }
                }
                fclose($content);
                if(sizeof($array) > 0){
                    echo json_encode(["success" => true,"data" => $array]);
                }else{
                    echo json_encode(["success" => false]);
                }
            }else{
                echo json_encode(["success" => false]);
            }
            break;
    }

?>