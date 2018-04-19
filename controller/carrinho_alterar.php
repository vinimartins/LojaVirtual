<!--Toda vez que o carrinho for alterado, é chamado este controller-->

<?php

/*
Se existir alguma ID de produto <1 atraves do metodo post quer dizer que há algum produto incorreto.

Ex: Produto fora de estoque, no momento que o adm esteja inativando o produto ou alterando no modo ADM.
 */
if (!isset($_POST['pro_id']) or $_POST['pro_id'] < 1) {

	echo '<h4 class="alert alert-danger"> Erro na operação! </h4>';
	Rotas::Redirecionar(1, Rotas::pag_Carrinho());
	exit();
}

/*Recebendo a id do Produto*/
$id = (int) $_POST['pro_id'];

/*Instanciando o objeto na memória*/
$carrinho = new Carrinho();

/*Tenta adicionar se der algum erro manda msg na tela*/
try {
	$carrinho->CarrinhoADD($id);
} catch (Exception $e) {
	echo '<h4 class="alert alert-danger"> Erro na operação! </h4>';
}

Rotas::Redirecionar(1, Rotas::pag_Carrinho());

?>