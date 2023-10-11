<?php

$mysql = new PDO('mysql:host=localhost;dbname=fair-housework', 'root', '');

if(@$_REQUEST['email']){
    $sql = "INSERT INTO usuario (email, senha, nome_usuario, sobrenome_usuario) VALUES (?, ?, ?, ?)";
    $insert = $mysql->prepare($sql);
    $insert->execute([$_REQUEST['email'], md5($_REQUEST['senha']), $_REQUEST['nome'], $_REQUEST['sobrenome']]);
    echo '<script>alert("Cadastrado. Redirecionando.")</script>';
    header('Location: ../view/login.html');
}

?>
