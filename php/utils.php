<?php

    require_once('../util/coneccion.php');

    function obtenerUsuario($user,$pass){
        $obj_user = [];
        $sql = "SELECT * FROM user where user = '$user' and pass = '$pass'";
        $conexion = new Conexion();
        $cn = $conexion->Conectarse();
        $result = mysql_query($sql,$cn);
        $rows = mysql_num_rows($result);
        if(!empty($rows)){
            while ($user = mysql_fetch_array($result)) {
                $obj_user = array(
                    "id" => $user["id"],
                    "user" => $user["user"],
                    "pass" => $user["pass"]
                );
            }
        }
        return $obj_user;
    }

    function validarProc($value){
        $sql = "SELECT * FROM proc where name like '%$value%'";
        $conexion = new Conexion();
        $cn = $conexion->Conectarse();
        $result = mysql_query($sql,$cn);
        $rows = mysql_num_rows($result);
        return $rows;
    }

    function obtenerLista($value){
        $list = [];
        $sql = "SELECT replace(value,'JOB----- ','') as value from jobs 
                where value <> '' and replace(value,'JOB----- ','') like '%$value%'";
        $conexion = new Conexion();
        $cn = $conexion->Conectarse();
        $result = mysql_query($sql,$cn);
        $rows = mysql_num_rows($result);   
        if(!empty($rows)){
            while ($jobs = mysql_fetch_array($result)) {
                if(!empty($jobs)){
                    $pos = strpos($jobs["value"], $value);
                    if((int)$pos === 0){
                        $pos_children = strpos($jobs["value"], "ADD(");
                        if($pos_children !== ""){
                            $value = substr($jobs["value"],$pos_children + 4,strlen($jobs["value"]));
                            $pos_second = strpos($value, ".");
                            if($pos_second !== ""){
                                $value_children = substr($value,0,$pos_second);
                                $list["children"][] = $value_children;
                            }
                        }
                    }else if((int)$pos > 0){
                        $pos_parent = strpos($jobs["value"], ".");
                        if($pos_parent !== ""){
                            $value_parent = substr($jobs["value"],0,$pos_parent);
                            $list["parent"][] = $value_parent;
                        }
                    }
                }
            }
        }
        return $list;
    }

    function obtenerListaChildren($value){
        $list_children = [];
        $sql = "SELECT replace(value,'JOB----- ','') as value from jobs 
                where value <> '' and replace(value,'JOB----- ','') like '%$value%'";
        $conexion = new Conexion();
        $cn = $conexion->Conectarse();
        $result = mysql_query($sql,$cn);
        $rows = mysql_num_rows($result);    
        if(!empty($rows)){
            while ($jobs = mysql_fetch_array($result)) {
                if(!empty($jobs)){
                    $pos = strpos($jobs["value"], $value);
                    if((int)$pos === 0){
                        $pos_children = strpos($jobs["value"], "ADD(");
                        if($pos_children !== ""){
                            $value = substr($jobs["value"],$pos_children + 4,strlen($jobs["value"]));
                            $pos_second = strpos($value, ".");
                            if($pos_second !== ""){
                                $value_children = substr($value,0,$pos_second);
                                $list_children["children"][] = array(
                                    "name" => "JOB",
                                    "title" => $value_children
                                );;
                            }
                        }
                    }else if((int)$pos > 0){
                        $pos_parent = strpos($jobs["value"], ".");
                        if($pos_parent !== ""){
                            $value_parent = substr($jobs["value"],0,$pos_parent);
                            $list_children["parent"][] = array(
                                "name" => "JOB",
                                "title" => $value_parent
                            );
                        }
                    }
                }
            }
        }
        return $list_children;
    }

?>