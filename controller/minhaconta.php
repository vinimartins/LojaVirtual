<?php

/*Puxando o template
 */
$smarty = new Template();

/*Chama o login do cliente (função estática)
 */
Login::MenuCliente();

/*Chamando display minha_conta.tpl
 */
$smarty->display('minha_conta.tpl');

?>