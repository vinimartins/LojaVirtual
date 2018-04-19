<?php

$smarty = new Template();
/*Chama o Menu do cliente*/
Login::MenuCliente();

/*Antes de chamar o template, faz a verificação se existe algum POST chegando
´Se o POST de cli_senha e senha_atual existirem, entra no bloco
 */
if (isset($_POST['cli_senha_atual']) and isset($_POST['cli_senha'])) {

/*1º recebe a senha atual*/
	$senha_atual = md5($_POST['cli_senha_atual']);

/*2º Recebe a senha nova*/
	$senha_nova = $_POST['cli_senha'];

/*3º recebe a variavel p receber o E-mail*/
	$email = $_SESSION['CLI']['cli_email'];

	if ($senha_atual != $_SESSION['CLI']['cli_pass']) {
		echo '<div class="alert alert-danger"> A senha atual está incorreta</div>';
		Rotas::Redirecionar(3, Rotas::pag_CLienteSenha());
		exit();
	}

	$clientes = new Clientes();
	$clientes->SenhaUpdate($senha_nova, $email);
	//echo'<div class="alert alert-success"> A senha foi alterada com sucesso, faça login com a nova senha!!</div>';

	//Rotas::Redirecionar(3, Rotas::pag_Logoff());

	echo '<script> alert("A senha foi alterada com sucesso"); </script>';
	$login = new Login();
	$login->GetLogin($email, $senha_nova);
	Rotas::Redirecionar(0, Rotas::pag_MinhaConta());

} else {
	$smarty->display('cliente_senha.tpl');
}

?>