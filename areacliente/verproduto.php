<?php

include("../conectadb.php");

session_start();
//coleta de dados de clientes na SESSAO
$idcliente = $_SESSION['idcliente'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $nomeproduto = $_POST['nomeproduto'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    //TOTAL ITEM É A SOMA DO PREÇO UNITARIO * QUANTIDADE
   $totalitem = ($preco * $quantidade);
 // GERAR UM HASH PARA DEFINIR UM CARRINHO ÚNICO E EXCLUSIVO
 $numerocarrinho = MD5($_SESSION['idcliente']. date('d-m-Y H:i:s')); // MD5 é um tipo de criptografia hash


 // VALIDA CLIENTE
 if($idcliente <=0){
 echo"<script>window.alert('VOCÊ PRECISA LOGAR PARA ADD ITEM AO CARRINHO');</script>";
 echo"<script>window.location.href='loja.php';</script";
 }
 else{
    // VERIFICA SE O CLIENTE TEM CARRINHO ABERTO
    $sql = "SELECT COUNT(car_numero_carrinho) FROM itens_carrinho INNER JOIN clientes on fk_cli_id
    WHERE cli_id = '$idcliente' AND car_finalizado = 'n'";
    $retorno = mysqli_query($link,$sql);

    while($tbl = mysqli_fetch_array($retorno)){
        $cont = $tbl[0];


      if ($cont == 0){
        //SE O CARRINHO NÃO EXISTE NO BANCO, GERA UM NOVO MD5 E INSERE OS ITENS
        //NA TABELA

        $sql = "INSERT INTO itens_carrinho (fk_pro_id, car_item_quantidade,fk_cli_id, car_total_carrinho,
        VALUES($id, '$quantidade','idcliente', 'totalitem,' '$numerocarrinho', 'n')";
        mysqli_query($link, $sql);

        $_SESSION['carrinho'] = $numerocarrinho;

        echo"<script>window.alert('VOCÊ PRODUTO ADICIONADO AO CARRINHO');</script>";
        echo"<script>window.location.href='loja.php';</script";
      }
      else{
        $sql = "SELECT DISTINCT(car_numero_carrinho) FROM ITENS_carrinho
        WHERE FK_cli_id = '$idcliente' AND car_finalizado = 'n'";
        $retorno = mysqli_query($link,$sql);


        while($tbl = mysqli_fetch_array($retorno)){
        $numerocarrinho = $tbl[0];
        $_SESSION['carrinhoid'] = $numerocarrinhocliente;
        $sql = "INSERT INTO itens_carrinho (fk_pro_id, car_item_quantidade, fk_cli_id, car_total_carrinho,
        car_numero_carinho, car_finalizado) VALUES($id,'quantidade', '$idcliente', '$totalitem','numerocarrinhocliente', 'n')";


        mysqli_query($link,$sql);
       echo"<script>window.alert('PRODUTO ADICIONADO AO CARRINHO $numerocarrinhocliente');</script>";
       echo"<script>window.location.href='loja.php';</script";
         }
       }
     }
   }
}

  //TRAZENDO DADOS VIA URL (GET)
    $id = $_GET['id'];
    $sql = "SELECT * FROM produtos WHERE pro_id = '$id'";
    while($tbl = mysqli_query($link, $sql)){
    $nomeproduto = $tbl[1];
    $descricao = $tbl[2];
    $preco = $tbl[3];
    $imagem_atual = $tbl[4];
 }
?>





<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/estiloadm.css">

    <title>VER PRODUTO</title>

</head>

<body>

    <!-- NOSSO MENU GLOBAL -->
    <header>
    <nav>
        <ul class="menu">
        <li><a href="loja.php"></a>HOME</li> <!-- BOTÃO NOME -->
        <li><a href="#"></a>PRODUTOS/li>

        <!--VALIDA SE CLIENTE LOGOU -->
        <?php
         if(isset($_SESSION ['idcliente'])){
         ?>
         <form class="formmenu"action="logout.php" method="post">
            <h3 class="menu-right2">
           olá <?= $_SESSION['nomecliente'];?>
            </h3>
           <li class="menu-right"><a href="perfil.php?id=<?$sessao_idcliente?>">PERFIL</a></li>
           <li class="menu-right"><a href="logout.php">LOGOUT</a></li>
         </form>
         <?php
         }
          else {

         ?>
         <form class="formmenu2">
           <li class="menu-right"><a href="logincliente.php" style="float: right">ENTRAR</a></li>
           <li class="menu-right"><a href="cadastracliente.php">CADASTRAR</a></li>
         </form>
         <?php
          }
        ?>
         
    </nav>
  </header>
     <!-- FIM MENU GLOBAL -->

 

   
     <div class="formulario">
       <form class="visualizaproduto" action="verproduto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id" nome="<?= $id?>">
          <label>NOME</label>
          <input type="text" name="nomeproduto" id="nome" value="<?= $nome?>">

            <label>DESCRIÇÃO</label>
           <textarea name="descrição" readonly><?= $descricao?></textarea>

            <label>QUANTIDADE</label>
           <input type="number" id="quantidade" name="quantidade">

            <label>PREÇO</label>
            <input type="decimal" name="preco" id="preco" value="<?= $preco?>" readonly>
        
            <br>

            <input type="submit" value="ADICIONAR AO CARRINHO">

        </form>

    </div>
    <div>
 

    <!-- PEÇA ESSENCIAL PARA COLETAR IMAGEM ATUAL -->
     <td><img name="imagem_atual" class="imagem_atual" src="data:image/jpeg;base64,<?= $imagem_atual?>"></td>

    </div>

 

</body>

</html>