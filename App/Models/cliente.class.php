<?php

/**
 * Class Cliente
 */

require_once 'connect.php';

class Cliente extends Connect
{

  function index($value, $perm)
  {
    if ($perm != 1) {
      echo "Você não tem permissão de acesso a este conteúdo!";
    } else {

      if ($value == NULL) {
        $value = 1;
      }

      $this->query = "SELECT * FROM `cliente` WHERE `statusCliente` = '$value'";
      $this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL));

      if ($this->result) {

        while ($row = mysqli_fetch_array($this->result)) {
          $clientString = '<li>';
          $clientString .= '<form class="label" name="alterarCliente" action="/App/Database/">';
          $clientString .= '<input type="checkbox" id="status" name="status" checked value="' . $row['statusCliente'] . '" onclick="this.form.submit();">';
          $clientString .= '</form>';
          $clientString .= '<span class="text left" style="display:inline-block;width: 25%;">';
          $clientString .= '<span class="badge left" style="margin-right: 10px;">' . $row['idCliente'] . '</span>';
          $clientString .= $row['NomeCliente'] . '</span>';
          $clientString .= '<span style="padding-left: 15px;border-left: 1px solid #999;display:inline-block;width: 20%;" class="left"><b>CPF:</b> ' . $this->format_CPF($row['cpfCliente']) . '</span>';
          $clientString .= '<div class="tools right">';
          $clientString .= '<a href="#" data-toggle="modal" data-target="#modalEdit' . $row['idCliente'] . '">';
          $clientString .= '<i class="fa fa-edit"></i>';
          $clientString .= '</a>';
          $clientString .= '<a href="#" data-toggle="modal" data-target="#modalUpdate' . $row['idCliente'] . '">';
          $clientString .= '<i class="glyphicon glyphicon-ok"></i>';
          $clientString .= '</a>';
          $clientString .= '</div>';
          $clientString .= $this->makeEditModal($row['idCliente'], $this->makeEditForm($row), '../../App/Database/updateCliente.php');
          $clientString .= $this->makeUpdateModal($row['idCliente'], $row['NomeCliente'], '../../App/Database/delCliente.php', $row['statusCliente']);
          $clientString .= '</li>';

          echo $clientString;
        }
      }
    }
  } //fim -- index

  public function makeEditModal($modalId, $modalText, $formAction)
  {
    $modal = '<div class="modal fade" id="modalEdit' . $modalId . '" tabindex="-1" role="dialog" aria-labelledby="modalLabel">';
    $modal .= '<div class="modal-dialog" role="document">';
    $modal .= '<div class="modal-content">';
    $modal .= '<form id="delprod1" name="delprod1" action="' . $formAction . '" method="post" style="color:#000;">';
    $modal .= '<div class="modal-header">';
    $modal .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>';
    $modal .= '<h4 class="modal-title" id="modalLabel">Editar dados do cliente</h4>';
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


  public function makeUpdateModal($modalId, $modalContent, $formAction, $status)
  {
    $statusText = ($status == '1') ? 'desativar' : 'ativar';

    $modal = '<div class="modal fade" id="modalUpdate' . $modalId . '" tabindex="-1" role="dialog" aria-labelledby="modalLabel">';
    $modal .= '<form id="delprod1" name="delprod1" action="' . $formAction . '" method="post" style="color:#000;">';
    $modal .= '<div class="modal-dialog" role="document">';
    $modal .= '<div class="modal-content">';
    $modal .= '<div class="modal-header">';
    $modal .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>';
    $modal .= '<h4 class="modal-title" id="modalLabel">Você tem certeza que deseja ' . $statusText . ' o cliente?</h4>';
    $modal .= '</div>';
    $modal .= '<div class="modal-body">';
    $modal .= '<input type="hidden" name="update" value="' . $modalId . '">';
    $modal .= '<input type="hidden" name="status" value="' . $status . '">';
    $modal .= $modalContent;
    $modal .= '</div>';
    $modal .= '<div class="modal-footer">';
    $modal .= '<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>';
    $modal .= '<button type="submit" class="btn btn-primary">Sim</button>';
    $modal .= '</div>';
    $modal .= '</div>';
    $modal .= '</div>';
    $modal .= '</form>';
    $modal .= '</div>';

    return $modal;
  }

  public function makeEditForm($client)
  {
    $form = '<input type="hidden" name="edit" value="' . $client['idCliente'] . '" />';
    $fieldList = ['Nome' => 'NomeCliente', 'Email' => 'EmailCliente', 'CPF' => 'cpfCliente'];

    foreach ($fieldList as $label => $field) {
      $form .= '<div class="form-group">';
      $form .= '<label class="form-label">' . $label . '</label>';
      $form .= '<input class="form-control" type="text" id="' . strtolower($label) . '" name="' . strtolower($label) . '" value="' . $client[$field] . '" />';
      $form .= '</div>';
    }

    return $form;
  }



  function insertCliente($NomeCliente, $EmailCliente, $cpfCliente, $idUsuario, $perm)
  {
    if ($perm == 1) {

      $cpfCliente = $this->limpaCPF_CNPJ($cpfCliente);

      $idCliente = $this->idCliente($cpfCliente);

      if ($idCliente > 0) {
        return 2;
      } else {

        $NomeCliente = mysqli_real_escape_string($this->SQL, $NomeCliente);
        $EmailCliente = mysqli_real_escape_string($this->SQL, $EmailCliente);
        $cpfCliente = mysqli_real_escape_string($this->SQL, $cpfCliente);

        $query = "INSERT INTO `cliente`(`idCliente`, `NomeCliente`, `EmailCliente`, `cpfCliente`, `statusCliente`, `Usuario_idUsuario`) VALUES (NULL,'$NomeCliente','$EmailCliente','$cpfCliente',1,'$idUsuario')";
        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

        if ($result) {

          return 1;
        } else {
          return 0;
        }
      }

      mysqli_close($this->SQL);
    }
  } //Insert Cliente

  function updateCliente($idCliente, $NomeCliente, $EmailCliente, $cpfCliente, $idUsuario, $perm)
  {

    if ($perm == 1) {

      $cpfCliente = $this->limpaCPF_CNPJ($cpfCliente);

      $NomeCliente = mysqli_real_escape_string($this->SQL, $NomeCliente);
      $EmailCliente = mysqli_real_escape_string($this->SQL, $EmailCliente);
      $cpfCliente = mysqli_real_escape_string($this->SQL, $cpfCliente);

      $this->query = "UPDATE `cliente` SET `NomeCliente`='$NomeCliente',`EmailCliente`='$EmailCliente',`cpfCliente`='$cpfCliente', `Usuario_idUsuario`= '$idUsuario' WHERE `idCliente`= '$idCliente'";
      $this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL));

      if ($this->result) {
        return 1;
      } else {
        return 0;
      }

      mysqli_close($this->SQL);
    }
  }

  function statusCliente($status, $idCliente)
  {

    $this->query = "UPDATE `cliente` SET `statusCliente`= '$status' WHERE `idCliente`= '$idCliente'";

    $this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL));

    if ($this->result) {
      return 1;
    } else {
      return 0;
    }

    mysqli_close($this->SQL);
  }

  function deleteCliente($idCliente)
  {

    $this->query = "DELETE FROM `cliente` WHERE `idCliente`= '$idCliente'";

    $this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL));

    if ($this->result) {
      return 1;
    } else {
      return 0;
    }

    mysqli_close($this->SQL);
  }

  public function idcliente($cpfCliente)
  {

    $this->client = "SELECT * FROM `cliente` WHERE `cpfCliente` = '$cpfCliente'";

    if ($this->resultcliente = mysqli_query($this->SQL, $this->client)  or die(mysqli_error($this->SQL))) {

      $row = mysqli_fetch_array($this->resultcliente);
      return $idCliente = $row['idCliente'];
    }
  }

  function search($value)
  {

    if (isset($value)) {
      //$output = '';  
      $query = "SELECT * FROM `cliente` WHERE `cpfCliente` LIKE '" . $value . "%' OR `NomeCliente` LIKE '" . $value . "%' LIMIT 5";
      $result = mysqli_query($this->SQL, $query);

      if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_array($result)) {

          $output[] = $row;
        }

        return array('data' => $output);
      } else {

        return 0;
      }
    }
  } //------

  function searchdata($value)
  {

    $value = explode(' ', $value);
    $valor = str_replace(".", "", $value[0]); // Primeiro tira os pontos
    $valor = str_replace("-", "", $valor); // Depois tira o taço
    $value = $valor;

    if (isset($value)) {
      $query = "SELECT * FROM `cliente` WHERE `cpfCliente` LIKE '%$value%'";
      $result = mysqli_query($this->SQL, $query);
      if (mysqli_num_rows($result) > 0) {

        if ($row = mysqli_fetch_array($result)) {
          $output[] = $row;
        }
        
        return array('data' => $output);
      } else {
        return $value;
      }
    }
  } //----searchdata------

  public function dadoscliente($idCliente)
  {

    $this->client = "SELECT * FROM `cliente` WHERE `idCliente` = '$idCliente'";

    if ($this->resultcliente = mysqli_query($this->SQL, $this->client)  or die(mysqli_error($this->SQL))) {

      $row = mysqli_fetch_array($this->resultcliente);
      return $row;
    }
  }
}
