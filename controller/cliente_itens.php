<?php

$smarty = new Template();

/*Ja chama a função do Menu do cliente, caso esteja logado mostra o menu, se não estiver manda p tela de login*/
Login::MenuCliente();

/*Se não existir o cod_pedido vindo via POST, manda p pagina de pedidos do cliente*/
if (!isset($_POST['cod_pedido'])) {

	Rotas::Redirecionar(1, Rotas::pag_ClientePedidos());
	exit();
}

/*Instanciando Itens
 */
$itens = new Itens();

/*FILTER VAR para filtrar que vier do codigo do pedido e FILTER SANITIZE para não aceitar mais nada além do código do pedido, para não ser feito manualmente via POST para evitar a SQLINJECTION*/
$pedido = filter_var($_POST['cod_pedido'], FILTER_SANITIZE_STRING);

/*Busca os Itens do Pedido passando o pedido como parâmetro*/
$itens->GetItensPedido($pedido);

/*Cria-se os Assign*/
$smarty->assign('ITENS', $itens->GetItens());
$smarty->assign('TOTAL', $itens->GetTotal());

/*caso o status do pagamento for NAO, mostra novamente o botão de pagar*/
if ($itens->GetItens()[1]['ped_pag_status'] == 'NAO'):

	// PAGAMENTO PS --------------------------
	$pag = new PagamentoPS();

	$pag->PagamentoITENS($_SESSION['CLI'], $itens->GetItens()[1], $itens->GetItens());

//         echo '<pre>';
	//         var_dump($itens->GetItens());
	//         echo '</pre>';

	// passando para o template dados do PS
	$smarty->assign('PS_URL', $pag->psURL);
	$smarty->assign('PS_COD', $pag->psCod);
	$smarty->assign('PS_SCRIPT', $pag->psURL_Script);
	$smarty->assign('REF', $pedido);
	$smarty->assign('PAG_RETORNO', Rotas::pag_PedidoRetorno());
	$smarty->assign('PAG_ERRO', Rotas::pag_PedidoRetornoERRO());
	$smarty->assign('TEMA', Rotas::get_SiteTEMA());

	/// fim do pagamento

endif;

$smarty->display('cliente_itens.tpl');

?>