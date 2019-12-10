<?php

    require_once '../auth.php';
    require_once '../Models/cliente.class.php';

    if(isset($_POST['edit'])){
        $id    = $_POST['edit'];
        $name  = $_POST['nome'];
        $email = $_POST['email'];
        $cpf   = str_replace(['.', '-'], '', $_POST['cpf']);

        $cliente = new Cliente();
        $cliente->updateCliente($id, $name, $email, $cpf, $idUsuario, $perm);
    }

    header('Location: ../../views/cliente/');