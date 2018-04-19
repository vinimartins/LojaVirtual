<?php

$smarty = new Template();

/*Ja chama a função do Menu do cliente, caso esteja logado mostra o menu, se não estiver manda p tela de login*/
Login::MenuCliente();

/*strtoupper — Converte uma string para maiúsculas
 */
foreach ($_SESSION['CLI'] as $campo => $valor) {
	$smarty->assign(strtoupper($campo), $valor);
}

/*Se existe nome email e cpf vindo via POST, agrega os valores*/
if (isset($_POST['cli_nome']) and isset($_POST['cli_email']) and isset($_POST['cli_cpf'])) {

	//Dados sendo recuperados através da sessão
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
	$cli_senha = $_POST['cli_senha'];
	$cli_data_cad = $_SESSION['CLI']['cli_data_cad'];
	$cli_hora_cad = $_SESSION['CLI']['cli_hora_cad'];

	if ($_SESSION['CLI']['cli_pass'] != md5($cli_senha)) {
		echo '<div class="alert alert-danger"> <p>A senha para confirmar a alteração está incorreta</p>';
		Sistema::VoltarPagina();
		echo '</div>';
		exit();
	}

	/*Instanciando o objeto
     */
	$clientes = new Clientes();

	$clientes->Preparar($cli_nome, $cli_sobrenome, $cli_data_nasc, $cli_rg, $cli_cpf, $cli_ddd, $cli_fone, $cli_celular, $cli_endereco, $cli_numero, $cli_bairro, $cli_cidade, $cli_uf, $cli_cep, $cli_email, $cli_data_cad, $cli_hora_cad, $cli_senha);

	/*Se o usuário não conseguiu editar os dados por algum motivo, aparece uma mensagem de erro
     */
	if (!$clientes->Editar($_SESSION['CLI']['cli_id'])) {
		echo '<div class="alert alert-danger">Ocorreu um erro ao editar os dados</div>';

		/*Exit para sair da função e não conseguir mais editar
          */
		exit();

		/* Se conseguir, manda mensagem de sucesso
          */
	} else {
		echo '<script> alert("Dados alterados com sucesso! Atualizando os dados do Login..."); </script>';

		/*mandando msg de sucesso
          */
		echo '<div class="alert alert-success">Dados atualizados com sucesso! Atualiando dados do login...';
		echo '</div>';

		$login = new Login();

		/*Forçando o login do usuário*/
		$login->GetLogin($cli_email, $cli_senha);
	}

} else {
	$smarty->display('cliente_dados.tpl');

}

?>