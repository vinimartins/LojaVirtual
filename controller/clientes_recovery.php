<?php

$smarty = new Template();
$cliente = new Clientes();

/*Se existe o e-mail via POST, seta o valor do e-mail*/
if (isset($_POST['cli_email'])) {
	$cliente->setCli_email($_POST['cli_email']);

/*Se voltar algum e-mail de cliente, é pq ja existe no banco e será trocada a senha*/
	if ($cliente->GetClienteEmail($cliente->getCli_email()) > 0) {

		/*Toda vez que esquecer a senha, será gerada uma nova*/
		$novasenha = Sistema::GerarSenha();

		/*Dá o comando de Update na senha, passando a nova e o e-mail como parâmetro*/
		$cliente->SenhaUpdate($novasenha, $cliente->getCli_email());

		//enviar o email para o cliente
		$email = new EnviarEmail();

		/*Gerando o assunto do e-mail
		*/
		$assunto = 'Nova Senha - ' . Config::SITE_NOME;

		/*Enviando a mensagem
		*/
		$msg = "Olá cliente, uma nova senha foi solicitada por você, acesse o site: " . Config::SITE_NOME;
		$msg .= "<br> Nova Senha =  " . $novasenha;

		/*Mandando pros destinatários*/
		$destinatarios = array($cliente->getCli_email(), Config::SITE_EMAIL_ADM);

		/*Enviando o e-mail*/
		$email->Enviar($assunto, $msg, $destinatarios);

		/*Imprimindo a mensagem de sucesso na tela*/
		echo '<div class="alert alert-success"> <p>Olá, foi enviada uma nova senha para acesso ao site em seu email de cadastro!!</p></div>';

		/*Mandando pro login, de volta
 		*/
		Rotas::Redirecionar(5, Rotas::pag_ClienteLogin());

		/*Só dará errado se não existir o e-mail na base de dados*/
	} else {
		echo '<div class="alert alert-danger"> <p>Este email não está cadastrado na loja!</p></div>';
		Rotas::Redirecionar(2, Rotas::pag_ClienteRecovery());
	}

} else {
	$smarty->display('clientes_recovery.tpl');
}

?>