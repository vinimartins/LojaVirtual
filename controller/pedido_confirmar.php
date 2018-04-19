<?php

if (isset($_SESSION['PRO'])) {

	/*Se não existir POST com as opções de FRETE, será redirecionado ao carrinho para fazer a marcação

		É feita essa verificação, pq o PEDIDO FINALIZAR não funciona sem validar os RADIOS-BUTTON
	*/
	if (!isset($_POST['frete_radio'])) {
		Rotas::Redirecionar(1, Rotas::pag_Carrinho() . '#dadosfrete');

		/*Exit para não ocorrer erro na pág*/
		exit('<h4 class="alert alert-danger"> Precisa selecionar o frete! </h4>');
	}

	$smarty = new Template();

	$carrinho = new Carrinho();

	$smarty->assign('PRO', $carrinho->GetCarrinho());

/* A sessão de PEDIDO vai guardar o valor de FRETE, do que vem do POST do campo Frete_Radio
 */
	$_SESSION['PED']['frete'] = $_POST['frete_radio'];

	/*Guarda o que vem via post do frete radio + o total do carrinho
	*/
	$_SESSION['PED']['total_com_frete'] = ($_POST['frete_radio'] + $carrinho->GetTotal());

	$smarty->assign('TOTAL', Sistema::MoedaBR($carrinho->GetTotal()));

	/*Assign indicando o frete do Pedido, já convertendo pra moeda BR, PEGANDO da SESSION o valor*/
	$smarty->assign('FRETE', Sistema::MoedaBR($_SESSION['PED']['frete']));
	/*Assign TOTAL_FRETE pra chamar o valor somando tudo da Session*/
	$smarty->assign('TOTAL_FRETE', Sistema::MoedaBR($_SESSION['PED']['total_com_frete']));

	/*Apenas roteando pras págs*/
	$smarty->assign('PAG_CARRINHO_ALTERAR', Rotas::pag_CarrinhoAlterar());
	$smarty->assign('PAG_CARRINHO', Rotas::pag_Carrinho());
	$smarty->assign('PAG_FINALIZAR', Rotas::pag_PedidoFinalizar());

	$smarty->display('pedido_confirmar.tpl');

} else {
	echo '<h4 class="alert alert-danger"> Não possui produtos no carrinho! </h4>';
	Rotas::Redirecionar(3, Rotas::pag_Produtos());
}

/*
echo '<pre>';
var_dump($carrinho->GetCarrinho());
echo '</pre>';
 */
?>