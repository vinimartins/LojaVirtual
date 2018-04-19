<?php

$smarty = new Template();

$pedidos = new Pedidos();

if (isset($_POST['ped_apagar'])) {
	$ped_cod = $_POST['cod_pedido'];
	if ($pedidos->Apagar($ped_cod)) {
		echo '<div class="alert alert-success"> Pedido Excluido!!</div>';

	}
}

/*É necessário verificar se tem parâmetro na posição 1 da URL = .com.br/controller-posição-0/id-do-pedido-posicao-01
na prática = .com.br/adm_pedidos/1
 */
if (isset(Rotas::$pag[1])) {

	/*Captura o valor que está lá, e coloque na variavel ID
	*/
	$id = (int) Rotas::$pag[1];

	/*Executa a query
	*/
	$pedidos->GetPedidosCliente($id);

/*Se não tiver id na url, mas por outro lado vier post com data inicio e data fim, faça a query de busa por data
 */
} elseif (isset($_POST['data_ini']) and isset($_POST['data_fim'])) {

	$pedidos->GetPedidosData($_POST['data_ini'], $_POST['data_fim']);

/*Se não tiver data nem id do pedido, verifica se tem POST com a referência, se tiver..
Converte pra STRING e faz a query de busca por referência
 */
} elseif (isset($_POST['txt_ref'])) {

	$ref = filter_var($_POST['txt_ref'], FILTER_SANITIZE_STRING);
	$pedidos->GetPedidosREF($ref);

/*Agr, se não tiver nenhum dos 3 acima, só faz a query de todos pedidos
 */
} else {
	$pedidos->GetPedidosCliente();
}

/*Criando as tag's
 */
$smarty->assign('PEDIDOS', $pedidos->GetItens());
$smarty->assign('PAG_ITENS', Rotas::pag_ItensADM());
$smarty->assign('PAGINAS', $pedidos->ShowPaginacao());

/*Se houver pedidos na tabela, mostra o display
 */
if ($pedidos->TotalDados() > 0) {
	$smarty->display('adm_pedidos.tpl');

/*Se não manda msg pro ADM
 */
} else {
	echo '<div class="alert alert-danger">Nenhum pedido encontrado!</div>';
}

?>