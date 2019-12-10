<?php

/**
 * Vendas
 */

require_once 'connect.php';

class Vendas extends Connect
{
  public function itensVerify($iditem, $quant, $perm)
  {
    if ($perm < 1 || $perm > 2) {
      $_SESSION['msg'] =  'Erro - Você não tem permissão!';
      header('Location: ../../views/vendas/index.php');
      exit();
    }

    $this->query = "SELECT * FROM `itens`, `produtos` WHERE `CodRefProduto` = '$iditem' AND `Produto_CodRefProduto` = `CodRefProduto`";
    
    $this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL));
    $total = mysqli_num_rows($this->result);

    if ($total > 0) {

      if ($row = mysqli_fetch_array($this->result)) {

        $q = $row['QuantItens'];
        $v = $row['QuantItensVend'];
        $quantotal = $v + $quant;

        if ($q >= $quantotal) {

          return array('status' => '1', 'NomeProduto' => $row['NomeProduto'],);
        } else {
          $estoque = $q - $v;
          return array('status' => '0', 'NomeProduto' => $row['NomeProduto'], 'estoque' => $estoque);
        }
      }
    } else {

      $_SESSION['msg'] =  '<div class="alert alert-warning">
      <strong>Ops!</strong> Produto (' . $iditem . ') não encontrado!</div>';

      header('Location: ../../views/vendas/index.php');
      exit;
    }
  }

  public function itensVendidos($iditem, $quant, $cliente, $email, $cpfcliente, $cart, $idUsuario, $perm)
  {

    $cpfcliente = $this->limpaCPF_CNPJ($cpfcliente);

    $this->query = "SELECT * FROM `itens` WHERE `Produto_CodRefProduto`= '$iditem'";
    $this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL));

    if ($this->result) {

      //------Verificação da Venda-----------

      if ($row = mysqli_fetch_array($this->result)) {

        $q = $row['QuantItens'];
        $v = $row['QuantItensVend'];

        $quantotal = $v + $quant;

        // check if the total number of itens in stock is more than we want to sell:

        if ($q >= $quantotal) {

          $valor = ($row['ValVendItens'] * $quant);

          $id = $this->idCliente($cpfcliente); // Verifica se o cliente existe no DB.it;

          if ($id > 0) { // Se o cliente existir, Retorne o ID do cliente
            $idCliente = $id; // ID do cliente
          } else {

            $this->novoclient = "INSERT INTO `cliente`(`idCliente`, `NomeCliente`, `EmailCliente`, `cpfCliente`, `statusCliente`, `Usuario_idUsuario`) VALUES (NULL,'$cliente','$email','$cpfcliente',1,'$idUsuario')";

            if (mysqli_query($this->SQL, $this->novoclient) or die(mysqli_error($this->SQL))) {
              $idCliente = mysqli_insert_id($this->SQL);
            }
          }


          $this->query = "INSERT INTO `vendas`(`idvendas`, `quantitens`, `valor`, `iditem`, `cliente_idCliente`, `idusuario`, `cart`) VALUES (NULL, '$quant', '$valor', '$iditem', '$idCliente', '$idUsuario', '$cart')";
          
          if ($this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL))) {


            $this->query = "UPDATE `itens` SET `QuantItensVend` = '$quantotal' WHERE `Produto_CodRefProduto`= '$iditem'";
            if ($this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL))) {

              unset($_SESSION['itens']); //limpa itens da lista

              $_SESSION['notavd'] = $cart;
              $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Sucesso!</strong> Venda efetuada!</div>';
            }
          } else {
            $_SESSION['msg'] =  '<div class="alert alert-danger alert-dismissible">
                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                         <strong>Erro!</strong> Venda não efetuada! </div>';

            header('Location: ../../views/vendas/');
            exit();
          }
        } else {

          echo 'nao temos disponivel em estoque';

          $estoque = $row['QuantItens'] - $row['QuantItensVend'];

          $_SESSION['msg'] =  '<div class="alert alert-warning alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <strong>Ops!</strong> Quantidade maior do que em estoque! </br> Quantidade em estoque: <b>' . $estoque . '</b></div>';
          header('Location: ../../views/vendas/');
          exit();
        }

        header('Location: ../../views/vendas/notavd.php');
      }
      //------------------

    } else {
      $_SESSION['alert'] = 0;
      header('Location: ../../views/vendas/');
    }
  } // itensVendidos

  public function idcliente($cpfCliente)
  {

    $this->client = "SELECT * FROM `cliente` WHERE `cpfCliente` = '$cpfCliente'";

    if ($this->resultcliente = mysqli_query($this->SQL, $this->client)  or die(mysqli_error($this->SQL))) {

      $row = mysqli_fetch_array($this->resultcliente);
      return $idCliente = $row['idCliente'];
    }
  }

  //----------itemNome

  public function itemNome($idItens)
  {

    // $query = "SELECT * FROM `produtos` WHERE `CodRefProduto` IN (SELECT `Produto_CodRefProduto` FROM `itens` WHERE `idItens` = '$idItens')";

    $query = "SELECT * FROM `produtos` WHERE `CodRefProduto` = '$idItens'";

    $result = mysqli_query($this->SQL, $query)  or die(mysqli_error($this->SQL));

    $row = mysqli_fetch_array($result);

    if ($row['NomeProduto'] != NULL) {
      $resp = $row['NomeProduto'];
    } else {
      $resp = NULL;
    }

    return $resp;
  } //--itemNome

  public function notavd($cart)
  {

    $query = "SELECT * FROM `vendas` WHERE `cart` = '$cart' ";

    if ($this->result = mysqli_query($this->SQL, $query)  or die(mysqli_error($this->SQL))) {

      while ($row = mysqli_fetch_array($this->result)) {
        $out[] = $row;
      }
    }

    return $out;
  } //--notavd

  public function dadosItem($idItem)
  {

    $query = "SELECT * FROM `fabricante`, `produtos`, `itens` WHERE `CodRefProduto` = '$idItem' AND `Produto_CodRefProduto` = `CodRefProduto` AND `Fabricante_idFabricante` = `idFabricante`";

    if ($this->result = mysqli_query($this->SQL, $query)  or die(mysqli_error($this->SQL))) {

      $row = mysqli_fetch_array($this->result);

      return $row;
    }
  } //---dadosItem


}//Class
