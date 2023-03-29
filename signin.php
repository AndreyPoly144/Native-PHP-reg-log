<?php
ini_set('session.save_path', "/var/www/html/session");
session_start();
if(empty($_POST)){header("Location: /Project_Login_Register/");}
require_once 'includes/connect.php';
if(!empty($_POST['login']) && !empty($_POST['password'])){
    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `Логин`='{$_POST['login']}'");
    $data=mysqli_fetch_all($result, MYSQLI_ASSOC);
    //print_r($data);
    if(empty($data)){      
        $_SESSION['message']='errorIN';    
        $_SESSION['login']=$_POST['login']; $_SESSION['password']=$_POST['password'];
        header('Location: /Project_Login_Register/index.php');
        exit;
    }
    $hash=$data[0]['Пароль'];    
    if(!password_verify($_POST['password'], $hash)){ 
        $_SESSION['message']='errorINPW';
        $_SESSION['login']=$_POST['login']; $_SESSION['password']=$_POST['password'];
        header('Location: /Project_Login_Register/');
        exit;
    }
}
//Успешный вход
//$_SESSION['login']=$_POST['login']; $_SESSION['password']=$_POST['password'];
session_unset();
?>
<p>Welcome, <?=$data[0]['Имя']?>, ваш логин - <?=$data[0]['Логин']?></p>
<a href="/Project_Login_Register/logout.php">Выйти</a>


