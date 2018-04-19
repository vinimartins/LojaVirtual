<?php
/*Já valida o login, se não estiver manda p pág de login
 */
if (!Login::Logado()) {
	Login::AcessoNegado();
	Rotas::Redirecionar(2, Rotas::pag_ClienteLogin());

/*Caso esteja dá continuidade no processo
 */
} else {

/*Se houver a sessão de produtos
 */
	if (isset($_SESSION['PRO'])) {

		/*Faz o filtro para passar pelas opções do FRETE
		*/
		if (!isset($_SESSION['PED']['frete'])) {

			Rotas::Redirecionar(1, Rotas::pag_Carrinho() . '#dadosfrete');

			/*Manda msg para selecionar o frete
			*/
			exit('<h4 class="alert alert-danger"> Precisa selecionar o frete! </h4>');
		}

		/*Cria a referência para o smarty, e carrinho
		*/
		$smarty = new Template();
		$carrinho = new Carrinho();

		/*Cria a variavel pra receber a referência (Concatenação do ano,mes,dia,hora,milisegundo com a ID do cliente)
		*/
		$ref_cod_pedido = date('ymdHms') . $_SESSION['CLI']['cli_id'];

		/*Faz o filtro pra validar a existência da SESSION do pedido, se não houver a sessão recebe a referência.
		*/
		if (!isset($_SESSION['PED']['pedido'])) {
			$_SESSION['PED']['pedido'] = $ref_cod_pedido;
		}

		/*Faz o filtro pra atribuir a referência para o respectivo valor
		*/
		if (!isset($_SESSION['PED']['ref'])) {
			$_SESSION['PED']['ref'] = $ref_cod_pedido;
		}

		/*Instancia o objeto na memória
		*/
		$pedido = new Pedidos();

		/*Captura o valor da Session e atribui para as respectivas variáveis
		*/
		$cliente = $_SESSION['CLI']['cli_id'];
		$cod = $_SESSION['PED']['pedido'];
		$ref = $_SESSION['PED']['ref'];
		$frete = $_SESSION['PED']['frete'];

		/*Cria-se as TAG'S para serem trabalhadas no template
		*/
		$smarty->assign('PRO', $carrinho->GetCarrinho());
		$smarty->assign('NOME_CLIENTE', $_SESSION['CLI']['cli_nome']);
		$smarty->assign('REF', $ref);
		$smarty->assign('SITE_NOME', Config::SITE_NOME);

		$smarty->assign('TOTAL', Sistema::MoedaBR($carrinho->GetTotal()));
		$smarty->assign('FRETE', Sistema::MoedaBR($_SESSION['PED']['frete']));
		$smarty->assign('TOTAL_FRETE', Sistema::MoedaBR($_SESSION['PED']['total_com_frete']));

		$smarty->assign('SITE_HOME', Rotas::get_SiteHOME());
		$smarty->assign('PAG_MINHA_CONTA', Rotas::pag_CLientePedidos());
		$smarty->assign('TEMA', Rotas::get_SiteTEMA());
		$smarty->assign('PAG_RETORNO', Rotas::pag_PedidoRetorno());
		$smarty->assign('PAG_ERRO', Rotas::pag_PedidoRetornoERRO());

		/*cria a referência para classe EnviarEmail
		*/
		$email = new EnviarEmail();

		/*Atribui valor a variavel destinatarios para o e-mail, capturando o email da sessão do cliente e do email_ADM em config
		*/
		$destinatarios = array(Config::SITE_EMAIL_ADM, $_SESSION['CLI']['cli_email']);
		$assunto = 'Pedido da Loja Freitas - ' . Sistema::DataAtualBR();
		$msg = $smarty->fetch('email_compra.tpl');

		/*Chamando a função enviar passando os dados
		*/
		$email->Enviar($assunto, $msg, $destinatarios);

		/*Se pedido foi gravado
		*/
		if ($pedido->PedidoGravar($cliente, $cod, $ref, $frete)) {

			/*referencia a classe de Pgto do PagSeguros
			*/
			$pag = new PagamentoPS();

			/*Manda a sessão do cliente, pedido e a consulta pelo que tem no carrinho
			*/
			$pag->Pagamento($_SESSION['CLI'], $_SESSION['PED'], $carrinho->GetCarrinho());

			//  var_dump($pag);

			/*Criando as tags para ficar passando para o template, os dados do PS
			*/
			$smarty->assign('PS_URL', $pag->psURL);

			/*Referente ao TOKEN PS*/
			$smarty->assign('PS_COD', $pag->psCod);
			$smarty->assign('PS_SCRIPT', $pag->psURL_Script);

			/*Limpa a sessão
			*/
			$pedido->LimparSessoes();
		}

		/*Manda o display
		*/
		$smarty->display('pedido_finalizar.tpl');

		/*Se não houver a SESSÃO de PRODUTOS é pq n tem produtos no carrinho
		*/
	} else {
		echo '<h4 class="alert alert-danger"> Não possui produtos no carrinho! </h4>';
		Rotas::Redirecionar(3, Rotas::pag_Produtos());
	}

}

/*
echo '<pre>';
var_dump($carrinho->GetCarrinho());
echo '</pre>';
 */
?>