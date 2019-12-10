<?php

/*
   Class produtos
  */

require_once 'connect.php';

class Usuario extends Connect
{

	public function index($perm)
	{
		// Somente administradores podem editar dados dos usuários:

		if ($perm == 1) {
			$this->query = "SELECT * FROM `usuario`";
			$this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL));

			while ($this->row = mysqli_fetch_array($this->result)) {

				$role = ($this->row['Permissao'] == 1) ? 'Administrador' : 'Vendedor';

				$userString = '<li>';
				$userString .= '<span class="text"><span class="badge left" style="margin-right: 15px;">' . $this->row['idUser'] . '</span>';
				$userString .=  $this->row['Username'] . ' / Tipo de Permissão: ' . $role . '</span>';
				$userString .= '<div class="tools right">';
				$userString .= '<a title="Alterar Dados" href="#" data-toggle="modal" data-target="#modalEdit' . $this->row['idUser'] . '">';
				$userString .= '<i class="fa fa-edit"></i>';
				$userString .= '</a>';
				$userString .= '</div>';
				$userString .= $this->makeEditModal($this->row['idUser'], $this->makeEditForm($this->row), '../../App/Database/updateUsuario.php');
				$userString .= '</li>';

				echo $userString;
			}
		} else {
			echo "Você não tem permissão de acesso a este conteúdo!";
		}
	}

	public function makeEditForm($row)
	{
		$form = '<input type="hidden" name="edit" value="' . $row['idUser'] . '" />';
		$form .= '<input type="hidden" name="old-img" value="' . $row['imagem'] . '" />';

		$form .= '<img class="img-rounded" width="100" style="margin-bottom: 20px;" height="auto" src="../../views/' . $row['imagem'] . '" />';
		$form .= '<div class="form-group">';
		$form .= '<label>Nova imagem:</label>';
		$form .= '<input class="form-control" name="new-img" type="file">';
		$form .= '</div>';

		$dataIndex = [
			'Username' 		  => 'Username',
			'Email' 		  => 'Email',
		];

		foreach ($dataIndex as $label => $field) {
			$form .= '<div class="form-group">';
			$form .= '<label class="form-label">' . $label . '</label>';
			$form .= '<input class="form-control" type="text" id="' . strtolower($label) . '" name="' . strtolower($label) . '" value="' . $row[$field] . '" />';
			$form .= '</div>';
		}

		$form .= '<div class="form-group">';
		$form .= '<label class="form-label">Tipo de Usuário</label>';
		$form .= '<select class="form-control" name="role">';

		foreach (['1' => 'Administrador', '2' => 'Vendedor'] as $type => $label) {
			$checked = '';

			if ($row['Permissao'] == $type) {
				$checked = 'selected';
			}

			$form .= '<option value="' . $type . '" ' . $checked . '>' . $label . '</option>';
		}

		// $form .= '<option value="1">Administrador</option>';
		$form .= '</select>';
		$form .= '</div>';

		$form .= '<div class="form-group">';
		$form .= '<label class="form-label">Cadastrar nova senha</label>';
		$form .= '<input class="form-control" type="text" name="new-password" />';
		$form .= '</div>';

		return $form;
	}

	public function makeEditModal($modalId, $modalText, $formAction)
	{
		$modal = '<div class="modal fade" id="modalEdit' . $modalId . '" tabindex="-1" role="dialog" aria-labelledby="modalLabel">';
		$modal .= '<div class="modal-dialog" role="document">';
		$modal .= '<div class="modal-content">';
		$modal .= '<form enctype="multipart/form-data" id="delprod1" name="delprod1" action="' . $formAction . '" method="post" style="color:#000;">';
		$modal .= '<div class="modal-header">';
		$modal .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>';
		$modal .= '<h4 class="modal-title" id="modalLabel">Editar dados do usuário</h4>';
		$modal .= '</div>';
		$modal .= '<div class="modal-body">';
		$modal .= $modalText;
		$modal .= '</div>';
		$modal .= '<div class="modal-footer">';
		$modal .= '<button type="button" value="Cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>';
		$modal .= '<button type="submit" name="update" value="update" class="btn btn-primary">Salvar</button>';
		$modal .= '</div>';
		$modal .= '</div>';
		$modal .= '</div>';
		$modal .= '</form>';
		$modal .= '</div>';

		return $modal;
	}

	public function InsertUser($username, $email, $password, $pt_file, $perm)
	{
		$this->query = "INSERT INTO `usuario`(`idUser`,`Username`,`Email`,`Password`,`imagem`,`Dataregistro`,`Permissao`)VALUES (NULL, '$username', '$email', '$password', '$pt_file' , CURRENT_TIMESTAMP , '$perm' )";

		$this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL));
		mysqli_insert_id($this->result);
		if ($this->result) {
			header('Location: ../../views/usuarios/index.php?alert=1');
		} else {
			header('Location: ../../views/usuarios/index.php?alert=0');
		}
	}

	public function update($data, $userId)
	{
		$username = mysqli_real_escape_string($this->SQL, $data['user']);
		$email = mysqli_real_escape_string($this->SQL, $data['email']);
		$role = mysqli_real_escape_string($this->SQL, $data['role']);
		$password = mysqli_real_escape_string($this->SQL, md5($data['password']));
		$img = mysqli_real_escape_string($this->SQL, $data['img']);

		$image = ($img != '') ? ", `imagem`='$img'" : "";
		$pass = ($password != '') ? "`Password`='$password', " : "";

		$this->query = "UPDATE `usuario` SET ". $pass ."`Username`='$username', `Email`='$email', `Permissao`='$role'" . $image . " WHERE `idUser`= '$userId'";
		$this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL));


		if ($this->result === true) {
			return true;
		} else {
			return false;
		}
	}
}

$usuario = new Usuario;
