<?php
session_start();

if (array_key_exists('emailAdmLogado', $_SESSION) == false)
{
	$_SESSION['erroLogin'] = "Identifique-se para acessar a administração";
	header('location: paginaloginadm.php');
	exit();
}

if (array_key_exists('emailUsuarioLogado', $_SESSION) == true)
{
	header('location: paginahome.php');
	exit();
}

if (array_key_exists('errocadastro', $_SESSION))
{
$erros = $_SESSION['errocadastro'];
unset($_SESSION['errocadastro']);
}
else
{
	$erros = null;
}
?>
<!DOCTYPE html>
<html>
<style>

#menufixo {
	width: auto;
	position: fixed;
	right: 0;
	left: 0;
	top: 0;
	height: 60px;
	background-color: white;
	z-index: 99;
  bottom: 0;
	border-bottom: 1px solid #e4e6e8;
}

.listamenu {
	padding-top: 20px;
	list-style:none;
	margin: 0px;
	margin-left: 20%;
	float: left;
}

.listamenu li {
	display: inline;
}

.listamenu li a {
	padding: 2px 20px;
  display: inline-block;
	color: black;
	text-decoration:none;
}

.listamenu li a:hover{
	color:#black;
	border-bottom: 2px solid #f8e8a2;
}

#img_menufixo {
	width: 17px;
	margin-left: 5px;
}

#logo_menufixo {
	width: 50px;
	height: 50px;
	padding: 5px;
  float: left;
	margin-left: 50px;
}

#input-email {
	width: 300px;
}

.input {
	padding:8px;
	border:none;
	border-bottom:1px solid #ccc;
	width:160px;
}

#titulo {
  font-family: fantasy;
  font-size: 50px;
  text-align: center;
  padding: 0px;
  -webkit-margin-after: 15px;
	border: none;
	border-radius: 0;
	border-top: 1px ;
	border-bottom: 1px ;
	min-height: 44px;

}

#corpo {


  margin: auto;
  width: 400px;
  padding-top: 10px;
	padding-bottom: 15px;
	margin: 0px;
  border-bottom: 1px solid #e4e6e8;
	margin-left: 26px;
	margin-right: 26px;
}


#logo {
	width:60px;
	height: 60px;
	position:relative;
	top:50%;
	left:50%;
	margin-left:-30px;
}

#corpo {
  margin: auto;
  width: 700px;
  background: #fff;
  border: 400px;
  margin-top: 100px;
  padding-top: 10px;
	border-radius: 10px;
	border: 1px solid black;
}

#divtítulo {
  background-color:white;
	margin: 10px;
}


#cadastrologin {
	 float: right;
}

#cadastrologin a {
		padding: 4px;
}

#cadastrologin a:hover {
    color: #ff9600;
    border-bottom:3px solid #f3b205;
}

#cadastrologin a:-webkit-any-link {
    color: black;
    cursor: pointer;
    text-decoration: none;
}

#formulario {
    font-family: Arial;
    font-size: 15px;
		padding: 30px;
		width: auto;
		display: flex;
		flex-direction: row;
    justify-content: center;
    align-items: center;
		border: 1px;

}

 #erromensagem {
	 border: 1px solid;
	 background-color: #ffef8a;
	 padding: 5px;
 }

 .loguese {
 	font-size: 10px;
 	margin-left: auto;
 	margin-right: auto;
 	text-align: center;
 }

 #linklogin {
 	color: blue;
 }

 .botao {
 		background-color: #f8e8a2;
     border: 1px solid black;
 	  	border-radius: 4px;
     padding: 5px;
     text-align: center;
     display: inline-block;
     font-size: 15px;
 		margin-left: 43%;
 }
</style>
<head>
  <title>Cadastramento</title>
  <meta charset = "utf-8">
	<link rel="shortcut icon" href="../logo/favicon.ico" />
</head>


<body>
	<div id = "menufixo">
		<img id="logo_menufixo" src="../logo/logo_allforone.png">
    <ul class="listamenu">
          <li><img id="img_menufixo" src="../menu fixo/home.png"><a href="paginahome.php">HOME </a></li>|
					<li><a href="paginacadastroconteudo.php">CADASTRO DE CONTEÚDO</a></li>|
					<li><a href="paginacadastroadm.php">NOVO ADM</a></li>
    </ul>
		<a class="botao" href="Controlador/sair.php">Sair</a>
	</div>

  <div id="corpo">


		<div id="divtítulo">
			<img src="../logo/logo_allforone.png" align= "center" id="logo">
			<p id="titulo">CADASTRO</p>
		</div>


		<?php if ($erros != null) { ?>
			<div id='erromensagem'>
					<p>Erro:
						<?php foreach($erros as $erro)
						  {
							echo $erro;
							} ?>
					</p>
			</div>
		<?php } ?>


	<div id="formulario">
	<form method="POST" action="Controlador/cadastroadm.php">
   	<label>Username: <input id="input-email" class="input" name="username" type="text" required/> <br/></label> <br>
   	<label>Senha: <input class="input" minlength="6" maxlength="12" name="senha" type="password"/></label>
   	<label>Confirmar senha:<input class="input" minlength="6" maxlength="12" name="confirmaSenha" type="password"/></label> <br/> <br>

 		<input class="botao" type="submit" value="Cadastrar"/>
		<br>
		<p class= "loguese"> Já possui uma conta? <a href='paginaloginadm.php' id='linklogin'> Login </a> </p>

 </div>
</div>
</body>
</html>
