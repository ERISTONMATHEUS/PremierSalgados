<?php

require_once '../auth.php';
require_once '../Models/usuario.class.php';

// userid, username, email, role, image, password:

if (isset($_POST['edit'])) {

    $id    = $_POST['edit'];

    $data['user']  = $_POST['username'];
    $data['email'] = $_POST['email'];
    $data['role']  = $_POST['role'];
    $data['password']  = $_POST['new-password'];
    $data['img']   = '';

    if ($_FILES['new-img']['tmp_name'] !== '') {

        if($_POST['old-img'] !== '' and is_file('../../views/' . $_POST['old-img'])){
            unlink('../../views/' . $_POST['old-img']);
        }

        $destino =  '../../views/dist/img/' . $_FILES['new-img']['name'];
        $arquivo_tmp = $_FILES['new-img']['tmp_name'];

        if (move_uploaded_file($arquivo_tmp, $destino)) {
            chmod($destino, 0644);
        }

        $data['img']   = 'dist/img/' . $_FILES['new-img']['name'];
    }


    if ($usuario->update($data, $id)) {
        header('Location: ../../views/usuarios/index.php?alert=1');

        exit;
    }

    header('Location: ../../views/usuarios/index.php?alert=0');

    exit;
}
