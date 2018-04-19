<?php

$smarty = new Template();
$clientes = new Clientes();

if (isset($_POST['cli_nome']) and isset($_POST['cli_email']) and isset($_POST['cli_cpf'])) {
	//variaveis
	$cli_id = $_POST['cli_id'];
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
	$cli_senha = "";
	$cli_data_cad = "";
	$cli_hora_cad = "";

	$clientes->Preparar($cli_nome, $cli_sobrenome, $cli_data_nasc, $cli_rg, $cli_cpf, $cli_ddd, $cli_fone, $cli_celular, $cli_endereco, $cli_numero, $cli_bairro, $cli_cidade, $cli_uf, $cli_cep, $cli_email, $cli_data_cad, $cli_hora_cad, $cli_senha);

	if (!$clientes->EditarADM($cli_id)) {
		echo '<div class="alert alert-danger">Ocorreu um erro ao editar os dados</div>';

		exit();
	} else {

		echo '<div class="alert alert-success">Dados atualizados com sucesso!
     	</div>';
		Rotas::Redirecionar(1, Rotas::pag_ClientesADM());

	}

} else {
	/*Caso exista uma página/controller dentro o array de páginas na URL, por exemplo:
				     t12store.com.br/adm_clientes_editar/1
				     t12store.com.br/parametro 0 do array/parâmetro 01 do array,
		               no caso é ID do cliente
	*/
	if (isset(Rotas::$pag[1])) {
		$id = Rotas::$pag[1];
	} else {
		/*Caso não tenha o ID é nulo e não conseguira nenhuma info para editar
          */
		$id = 0;
	}

	/*Aula 30 Mdl5- Editando os clientes*/
	/*Passando o valor do ID para percorrer o foreach abaixo*/
	$id = Rotas::$pag[1];

	/*Passando quem são os clientes, que é a busca do cliente através do ID
     */
	$clientes->GetClientesID($id);

	/*Percorrer a lista de clientes buscando os dados deles;
		     na posição 1, pq estou buscando em outro controller/tabela onde cada um dos campos receberá o valor encontrado, no caso os clientes
	*/
	foreach ($clientes->GetItens()[1] as $campo => $valor) {

		/*É criado um ASSIGN, em StrToUpper para converter para maiusculo
          */
		$smarty->assign(strtoupper($campo), $valor);
	}

	$smarty->display('adm_clientes_editar.tpl');

}

?>