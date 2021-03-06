<?php
require_once ('../Modelo/conexaobd.php');

function BuscaEmail($email)
{
$bd = ConexaoBD();

$select = $bd->prepare(
	'SELECT email
	 FROM usuario
	 WHERE email = :email'
);

$select->bindValue(':email', $email);

$select -> execute();

return $select -> fetch();
}

$erros = [];

$request = array_map('trim', $_REQUEST);

		$request = filter_var_array(
			$request,
			[
				'nomePróprio' => FILTER_DEFAULT,
				'sobrenome' => FILTER_DEFAULT,
        'email' => FILTER_VALIDATE_EMAIL,
        'senha' => FILTER_DEFAULT,
				'confirmaSenha' => FILTER_DEFAULT,
				'dataNasc' => FILTER_DEFAULT,
				'sexo' => FILTER_VALIDATE_INT,
			]
);

$nomeProprio = $request['nomePróprio'];

if ($nomeProprio == false)
{
	$erros[]= "O campo nome foi deixado nome em branco ou é inválido";
}
else if (strlen($nomeProprio) < 3 || 35 < strlen($nomeProprio))
{
	$erros[]= "O nome deve ter de 3 a 35 caracteres";
}

$sobrenome = $request['sobrenome'];

if ($sobrenome == false)
{
	$erros[]= "O campo sobrenome foi deixado em branco ou é inválido";
}
else if (strlen($nomeProprio) < 3 || 35 < strlen($nomeProprio))
{
	$erros[]= "O sobrenome deve ter de 3 a 35 caracteres";
}

$Email = $request['email'];

if ($Email == false)
{
	$erros[]= "O campo E-mail foi deixado em branco ou é inválido";
}

$confirmaEmail = BuscaEmail($Email);

if ($confirmaEmail['email'] == $Email)
{
	$erros[]= "O email já foi cadastrado";
}
$senha = $request['senha'];

if ($senha == false)
{
	$erros[]= "O campo senha foi deixado em branco ou é inválido";
}
else if (strlen($senha) < 6 || 12 < strlen($senha))
{
	$erros[]= "A senha deve ter de 6 a 12 dígitos";
}

$confirmasenha = $request['confirmaSenha'];

if ($senha != $confirmasenha)
{
	$erros[]="a confirmação de senha deve ser igual a senha";
}

$senha = password_hash($senha, PASSWORD_DEFAULT);

$dataNasc = $request['dataNasc'];

$data = DateTime::createFromFormat('Y-m-d', $dataNasc);

if ($data == false)
{
	$erros[]= "O valor da data é inválido";
}
else
{
	$hoje = new DateTime();
	$diferença = $data->diff($hoje);

	$anoscorridos = $diferença->y;
	if ($anoscorridos < 16)
	{
	 $erros[]= "A idade mínima para cadastro é 16 anos";
	}
}

$sexo = $request['sexo'];


if ($sexo =! 1 || $sexo =! 2 || $sexo =! 3)

{
	$erros[]= "O campo sexo foi deixado em branco ou é inválido";
}


if ($erros != null)
{
	session_start();
	$_SESSION['errocadastro'] = $erros;
	header('location: ../paginacadastro.php');
}
else
{
 $bd = new PDO('mysql:host=localhost;dbname=tcc-jambd;charset=utf8', 'tcc-jambd', 'jambdtcc');

  $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 $insert = $bd->prepare(
   'INSERT INTO usuario (nomePróprio, sobrenome, email, senha, datNasc, sexo)
    VALUES (:nomeProprio, :sobrenome, :email, :senha, :datNasc, :sexo)'
 );

 $insert->bindValue(':nomeProprio', $request['nomePróprio']);
 $insert->bindValue(':sobrenome', $request['sobrenome']);
 $insert->bindValue(':senha', $senha);
 $insert->bindValue(':email', $request['email']);
 $insert->bindValue(':datNasc', $request['dataNasc']);
 $insert->bindValue(':sexo', $request['sexo']);

 $insert -> execute();

 session_start();
 $_SESSION['emailUsuarioLogado'] = $Email;
unset($_SESSION['emailAdmLogado']);
 header('location: ../paginahome.php');

}
?>
