<?php

require_once '../auth.php';
require_once '../Models/itens.class.php';
require_once '../Helpers/Validation.php';
require_once '../Helpers/DateWorker.php';

if (isset($_POST['upload']) == 'Cadastrar') {

	$validation = [
		'qtitens'     => 'required,number',
		'valcompra'   => 'required,price',
		'valvenda'    => 'required,price',
		'datacompra'  => 'required,date',
		'datavenc'    => 'date',
	];

	$data['prodref']    = $_POST['codProduto'];
	$data['idfabri']    = $_POST['idFabricante'];
	$data['qtitens']    = $_POST['QuantItens'];
	$data['valcompra']  = str_replace(',', '.', $_POST['ValCompItens']);
	$data['valvenda']   = str_replace(',', '.', $_POST['ValVendItens']);
	$data['datacompra'] = $_POST['DataCompraItens'];
	$data['datavenc']   = $_POST['DataVenci_Itens'];

	// Validation routines:

	$validation = new Validation($data, $validation);
	$validation->run();

	if ($validation->hasErrors()) {

		$validation->saveCache();

		header('Location: ../../views/itens/additens.php?alert=3');

		exit;
	} else {
		$iduser = $_POST['iduser'];

		// formatting data:

		$dateCompra = new DateWorker($data['datacompra'], 'd/m/Y');
		$dateVenc   = new DateWorker($data['datavenc'], 'd/m/Y');

		if ($iduser == $idUsuario && $data['qtitens'] != NULL) {

			if (isset($_POST['idItens'])) {

				$idItens = $_POST['idItens'];
				$itens->updateItens($idItens, $data['qtitens'], $data['valcompra'], $data['valvenda'], $dateCompra->toDbFormat(), $dateVenc->toDbFormat(), $data['prodref'], $data['idfabri'], $idUsuario);
			} else {
				$itens->InsertItens($data['qtitens'], $data['valcompra'], $data['valvenda'], $dateCompra->toDbFormat(), $dateVenc->toDbFormat(), $data['prodref'], $data['idfabri'], $idUsuario);
			}

			unset($_SESSION['validation']);
		} else {
			header('Location: ../../views/itens/index.php?alert=3');
		}
	}
} else {
	header('Location: ../../views/itens/index.php');
}
