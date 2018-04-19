<?php

$smarty = new Template();
$categorias = new Categorias();

$categorias->GetCategorias();

/*Se existir algum POST do formulário do template, para adicionar categoria, dá sequência na função
 */
if (isset($_POST['cate_nova'])) {

	/*o nome da categoria recebe o campo
	*/
	$cate_nome = $_POST['cate_nome'];

	/*Se retornar true da função inserir, não precisa validar no if porque o if sempre valida se é verdadeiro
	*/
	if ($categorias->Inserir($cate_nome)) {

		/*Se der certo, manda msg de Sucesso e redireciona para mesma página com 0 segundos afim de dar um refresh na página
		*/
		echo '<div class="alert alert-success"> Categoria Inserida com sucesso!! </div>';
		Rotas::Redirecionar(0, Rotas::pag_CategoriasADM());
	}
}

/*Função editar é parecida com a de inserir
 */
if (isset($_POST['cate_editar'])) {

	/*Capturando a ID da categoria e o nome via POST
	*/
	$cate_id = $_POST['cate_id'];
	$cate_nome = $_POST['cate_nome'];

	/*Manda pra função editar
	*/
	if ($categorias->Editar($cate_id, $cate_nome)) {

		/*Manda msg de Sucesso e redireciona pra mesma página em 0 segundos
		*/
		echo '<div class="alert alert-success"> Categoria Editada com sucesso!! </div>';
		Rotas::Redirecionar(0, Rotas::pag_CategoriasADM());
	} else {
		echo '<div class="alert alert-danger">Erro ao apagar categoria, verifique se não há mais usuários de ADM utilizando o sistema! </div>';
		Rotas::Redirecionar(0, Rotas::pag_CategoriasADM());
	}
}

/*Apagar a categoria
 */
if (isset($_POST['cate_apagar'])) {

	/*Captura a id da categoria
	*/
	$cate_id = $_POST['cate_id'];

	/*Manda apagar na tabela
	*/
	if ($categorias->Apagar($cate_id)) {
		echo '<div class="alert alert-success"> Categoria Apagada com sucesso!! </div>';
		Rotas::Redirecionar(2, Rotas::pag_CategoriasADM());
	} else {
		echo '<div class="alert alert-danger">Ops..Erro, favor revisar o processo! </div>';
		Rotas::Redirecionar(5, Rotas::pag_CategoriasADM());
	}
}

/*Cria a TAG para o template
 */
$smarty->assign('CATEGORIAS', $categorias->GetItens());

$smarty->display('adm_categorias.tpl');

?>