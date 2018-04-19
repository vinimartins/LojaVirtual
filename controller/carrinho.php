<!--Controller do carrinho-->
<?php

/*Se existir sessão chamada PRO, cria-se os assign do tipo Template para ser mostrado na view*/
if (isset($_SESSION['PRO'])) {

	$smarty = new Template();
	$carrinho = new Carrinho();

	$smarty->assign('PRO', $carrinho->GetCarrinho());

	/*Convertendo o total em R$*/
	$smarty->assign('TOTAL', Sistema::MoedaBR($carrinho->GetTotal()));

	/*Roteando...*/
	$smarty->assign('PAG_PRODUTOS', Rotas::pag_Produtos());
	$smarty->assign('PAG_CARRINHO_ALTERAR', Rotas::pag_CarrinhoAlterar());
	$smarty->assign('PAG_CONFIRMAR', Rotas::pag_PedidoConfirmar());

	/*Formatando o peso*/
	$smarty->assign('PESO', number_format($carrinho->GetPeso(), 3, '.', ''));

	/*Chamando o display*/
	$smarty->display('carrinho.tpl');

} /*Se não existir a sessão do Produto, é pq n tem no carrinho, manda pra pág de compras
*/
else {

	echo '<h4 class="alert alert-danger"> Não possui produtos no carrinho! </h4>';
	Rotas::Redirecionar(3, Rotas::pag_Produtos());
}

/*
echo '<pre>';
var_dump($carrinho->GetCarrinho());
echo '</pre>';
 */
?>