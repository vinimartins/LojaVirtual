<?php

$smarty = new Template();

/*Se tiver algo vindo destes campos, cli_nome, cli_email , e cli_cpf serão armazenados os dados nas variáveis*/

if (isset($_POST['cli_nome']) and isset($_POST['cli_email']) and isset($_POST['cli_cpf'])) {

	//variaveis
	$cli_nome = $_POST['cli_nome'];
	$cli_sobrenome = $_POST['cli_sobrenome'];
	$cli_data_nasc = $_POST['cli_data_nasc'];
	$cli_rg = $_POST['cli_rg'];
	$cli_cpf = $_POST['cli_cpf'];
	$cli_ddd = $_POST['cli_ddd'];
	$cli_fone = $_POST['cli_fone'];
	$cli_celular = $_POST['cli_celular'];
	$cli_endereco = $_POST['cli_endereco'];
	$cli_numero = $_POST['cli_numero'];
	$cli_bairro = $_POST['cli_bairro'];
	$cli_cidade = $_POST['cli_cidade'];
	$cli_uf = $_POST['cli_uf'];
	$cli_cep = $_POST['cli_cep'];
	$cli_email = $_POST['cli_email'];

	/*Classe Sistema faz uma HASH para criar uma senha para o usuário final*/
	$cli_senha = Sistema::GerarSenha();

	/*Armazena no BD na hora Americana*/
	$cli_data_cad = Sistema::DataAtualUS();

	/*Quando for chamar pra tela, mostra o modelo em PTBR */
	$cli_hora_cad = Sistema::HoraAtual();

	/*Instancia o objeto na memória*/
	$clientes = new Clientes();

	/*Chama o método para preparar os dados a serem inseridos no BD*/
	$clientes->Preparar($cli_nome, $cli_sobrenome, $cli_data_nasc, $cli_rg, $cli_cpf, $cli_ddd, $cli_fone, $cli_celular, $cli_endereco, $cli_numero, $cli_bairro, $cli_cidade, $cli_uf, $cli_cep, $cli_email, $cli_data_cad, $cli_hora_cad, $cli_senha);

	/*Insere no BD*/
	$clientes->Inserir();

	/*Assigns para o TEMPLATE, NOME, EMAIL E SENHA serão constantes*/
	$smarty->assign('NOME', $cli_nome);
	$smarty->assign('EMAIL', $cli_email);
	$smarty->assign('SENHA', $cli_senha);

	/*Criando os Assigns para rotear*/
	$smarty->assign('PAG_MINHA_CONTA', Rotas::pag_ClienteConta());
	$smarty->assign('SITE_HOME', Rotas::get_SiteHOME());

	/*Instanciando o objeto na memória*/
	$email = new EnviarEmail();

	/*Declarando o assunto do e-mail*/
	$assunto = 'Cadastro Efetuado - ' . Config::SITE_NOME;

	/*Fetch() retorna a saída do template*/
	$msg = $smarty->fetch('email_cliente_cadastro.tpl');

	/*Manda a lista de destinatários, para o cliente e para o ADM*/
	$destinatarios = array($cli_email, Config::SITE_EMAIL_ADM);

	/*Envia*/
	$email->Enviar($assunto, $msg, $destinatarios);

	/*Mensagem após cadastro*/
	echo '<div class="alert alert-success"> Cadastro Efetuado!! A senha para fazer login foi enviada para seu email cadastrado. <br>' . 'Acesse seu email e confira!</div>';

	/*Redireciona para pág cliente login*/
	Rotas::Redirecionar(5, Rotas::pag_ClienteLogin());

/*Se não estiver vindo nome, email e cpf via POST chama o display pra poder cadastrar*/
} else {
	$smarty->display('cadastro.tpl');

}

?>