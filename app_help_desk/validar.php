<?php 
session_start();
   $_SESSION['logado'] = false;
   $usuario_valido = false;
   $usuario = array(
        array('email' => 'admin@admin.com', 'senha' => '123456'),
        array('email' => 'usuario', 'senha' => '123' ),
    );
    foreach($usuario as $user){
        if($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']){
            $usuario_valido = true;
        }
    }
    if($usuario_valido){
        $_SESSION['logado'] = true;
        header('Location: home.php');
    }else{
        header('Location: index.php?login=error');
    }


?>