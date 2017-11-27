<?php
include_once 'includes/db_connect.php';
session_start();
include_once 'checkuser/check_user.php';

function grab_valyuta($date, $price){
    $date_arr = explode('/', $date);
    $day = $date_arr[1];
    $moth = $date_arr[0];
    $year = $date_arr[2];
    $data = simplexml_load_file('https://www.cbar.az/currencies/'.$day.'.'.$moth.'.'.$year.'.xml');
    $json = json_encode($data);
    $array = json_decode($json,TRUE);
    $usd = $array["ValType"][1]["Valute"][44]["Value"];
    $azn = $price * $usd;
    return $azn;
}

if(empty($_POST['name']) || empty($_POST['last_name']) || empty($_POST['price']) || empty($_POST['date'])):
    $errors = '';
    if(empty($_POST['name'])){
        $errors .= '&name=1';
    }else{
        $errors .= '&name='.$_POST['name'];
    }

    if(empty($_POST['last_name'])){
        $errors .= '&last_name=1';
    }else{
        $errors .= '&last_name='.$_POST['last_name'];
    }

    if(empty($_POST['price'])){
        $errors .= '&price=a';
    }else{
        $errors .= '&price='.$_POST['price'];
    }

    if(empty($_POST['date'])){
        $errors .= '&date=1';
    }else{
        $errors .= '&date='.$_POST['date'];
    }

    if( $_POST['description'] ){
        $errors .= '&description='.$_POST['description'];
    }

    header("Location: ../index.php?$errors");
    else:
        $name = $_POST['name']; $name = strip_tags($name);
        $last_name = $_POST['last_name']; $last_name = strip_tags($last_name);
        $description = $_POST['description']; $description = strip_tags($description);
        $date = $_POST['date']; $date = strip_tags($date);
        $usd = $_POST['price']; $usd = strip_tags($usd);
        $azn = grab_valyuta($date, $usd);


        $add = $mysqli->prepare("INSERT INTO clients ( price_usa, price_azn, name, last_name, description, date ) VALUES ( ?, ?, ?, ?, ?, ? )");
        $add->bind_param("iissss", $usd, $azn, $name, $last_name, $description, $date );
        $add->execute();

        $show_to_client = $mysqli->prepare("Select * from clients  ORDER BY id DESC LIMIT 1");
        $show_to_client->execute();
        $result = $show_to_client->get_result();
        $row = $result->fetch_assoc();
        $show_to_client->close();
        $_SESSION['data'] = $row;
        header("Location: ../index.php");
endif;



