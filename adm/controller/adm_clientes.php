<?php
/*Chamando template*/
$smarty = new Template();
$clientes = new Clientes();

/*Buscando os clientes
 */
$clientes->GetClientes();

/*Criando as TAGS*/

/*GetItens está dentro da classe de conexão, e busca os itens retornados através do GetClientes*/
$smarty->assign('CLIENTES', $clientes->GetItens());

/*Permitindo que o ADM faça a edição*/
$smarty->assign('PAG_EDITAR', Rotas::pag_ClientesEditarADM());

$smarty->assign('PAG_PEDIDOS', Rotas::pag_PedidosADM());

/*Mostrando o display*/
$smarty->display('adm_clientes.tpl');

?>