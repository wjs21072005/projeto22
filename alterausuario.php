<?php
   include("conectadb.php");

   session_start();
   $nomeusuario =$_SESSION['nomeusuario'];

   #TRAZ DADOS DO BANCO PARA COMPLETAR OS CAMPOS
$id = $_GET['id'];
$sql = "SELECT * FROM usuarios WHERE usu_id = '$id'";
$retorno = mysqli_query($link, $sql);


#PRENCHENDO O ARRAY SEMPRE 
while($tbl= mysqli_fetch_array($retorno)){
$nome = $tbl[1]; # CAMPO NOME DA TABELA DO BANCO
$senha= $tbl[2]; #CAMPO SENHA NA TABELA DO BANCO
$ativo = $tbl[3]; # CAMPO ATIVO DA TABELA DO BANCO

if($_SERVER['REQUEST_METHOD']== 'POST'){
$id = $_POST['id'];
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$ativo = $_POST['ativo'];

$sql = "UPDATE usuarios SET usu_nome = '$nome',usu_senha = '$senha',usu_ativo = '$ativo' ]
WHERE usu_id = $id";


mysqli_query($link, $sql);

echo"<scripit>window.alert('USUARIO ALTERADO COM SUCESSO!');</scripit>";
echo"<scripit>window.location.href='admhome.php';</scripit>";

}
}


?>

<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estiloadm.css">
    <title>ALETERA USUARIOS</title>
 </head>
 <body>
    <div>
       <ul class="menu">
        <li><a href="alterausuario.php">CADASTRA USUARIO</a></li>
        <li><a href="listausuario.php">LISTA USUARIO</a></li>
        <li><a href="cadastraproduto.php">CADASTRA PRODUTO</a></li>
        <li><a href="listaproduto.php">LISTA PRODUTO</a></li>
        <li><a href="cadastracliente.php">CADASTRA CLIENTE</a></li>
        <li><a href="listacliente.php">LISTA CLIENTE</a></li>
       <li class="menuloja"><a href="./areacliente/loja.php">LOJA</a></li>
       <ul>
    </div>
    
    <div>
         <form action="alterausuario.php" method="post">
         <input type="hidden" nome="id" value="<?=$id?>">
         <br>
         <input type="text" nome="nome"  value="<?=$nome?>" required>
         <br>
         <input type="password" nome="senha" id="senha" value="<?=$senha?>" required>
         <br>
         <input type="radio" nome="ativo" value="s" <?$ativo =="s"?"checked":""?>>ATIVO
         <br>
         <input type="radio" nome="ativo" value="n" <?$ativo =="n"?"checked":""?>>INATIVO
       
         <input type="submit" nome="salvar" id="salvar" value="SALVAR">
         </form>
    </div>

 </body>
 </html>