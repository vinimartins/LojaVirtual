<?php

$smarty = new Template();

$produtos = new Produtos();
/*Se vier algo da url, na posição 1 do array = .com.br/pos-0/pos-01
 */
if (isset(Rotas::$pag[1])) {

	/*Manda pegar todos produtos pelo id da categoria
	*/
	$produtos->GetProdutosCateID(Rotas::$pag[1]);
} else {

	/*Se não, traz toda lista de produtos
	*/
	$produtos->GetProdutos();
}

/*Trazendo a lista de produtos no banco de dados*/
$smarty->assign('PRO', $produtos->GetItens());

$smarty->assign('PRO_INFO', Rotas::pag_ProdutosInfo());
$smarty->assign('PRO_TOTAL', $produtos->TotalDados());
$smarty->assign('PAGINAS', $produtos->ShowPaginacao());
$smarty->assign('PAG_PRODUTO_NOVO', Rotas::pag_ProdutosNovoADM());

/*Sendo utilizado na adm_produtos.tpl
 */
$smarty->assign('PAG_PRODUTO_EDITAR', Rotas::pag_ProdutosEditarADM());
$smarty->assign('PAG_PRODUTO_IMG', Rotas::pag_ProdutosImgADM());

$smarty->display('adm_produtos.tpl');

?>