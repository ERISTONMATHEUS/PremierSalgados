<?php
	require_once '../auth.php';
	require_once '../Models/cliente.class.php';

	if(isset($_POST['update']) && $_POST['update'] !== ''){
		$id = (int) $_POST['update'];
		$status = (int) ($_POST['status'] === '1' ? '0' : '1');

		$cliente = new Cliente();
		$cliente->statusCliente($status, $id);
	}

	header('Location: ../../views/cliente/index.php?alert=1');