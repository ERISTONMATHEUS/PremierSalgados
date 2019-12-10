<?php
require_once '../auth.php';
require_once('../Models/cliente.class.php');

$client = new Cliente;
 
if($_POST["query"]){

	$result = $client->search($_POST["query"]);

	echo '<ul id="pesqcpf" class="list-unstyled ulcpf">';
	if($result == 0){
		echo '<li class="licpf">Nenhum resultado encontrado!</li>';
	}else{

		foreach ($result['data'] as $user){
			echo  '<li id="li['. $user['idCliente'] .']" class="licpf">'. $user['cpfCliente'] .' - '. $user['NomeCliente'] . '</li>';
		}
		echo '</ul>';
	}
}

?>