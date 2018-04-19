<?php

$smarty = new Template();
$gravar = new Produtos();

/*Se vem alguma informação via post do campo pro_apagar, pro_id_apagar e se o post for igual SIM(value) do TEMPLATE, segue o processo de apagar o produto
 */
if (isset($_POST['pro_apagar']) && isset($_POST['pro_id_apagar']) && $_POST['pro_apagar'] == 'SIM') {

	/*Passa-se a ID do produto que precisa ser apagado à função da classe Produtos, e lá ocorre um DELETE no BD.

		    Neste caso, não precisa colocar ==TRUE, pois a função já retorna TRUE or FALSE, e o if sempre verifica se é verdadeiro
	*/
	if ($gravar->Apagar($_POST['pro_id_apagar'])) {
		echo '<div class="alert alert-success">Produto excluído com sucesso+!!</div>';

		/*Unlink remove a imagem antiga do BD
        */
		@unlink($_POST['pro_img_arquivo']);

		/*Manda p pagina produtos do ADM, e sai do bloco p n ocorrer erro*/
		Rotas::Redirecionar(2, Rotas::pag_ProdutosADM());
		exit();

		/*Se por algum motivo não tenha sido excluido manda p tela a msg de DANGER
        */
	} else {
		echo '<div class="alert alert-danger">O produto não pode ser excluido!!</div>';
	}
}

/*Se existir nome e valor do produto, da-se valores aos campos
 */
if (isset($_POST['pro_nome']) && isset($_POST['pro_valor'])) {

	$pro_nome = $_POST['pro_nome'];
	$pro_categoria = $_POST['pro_categoria'];
	$pro_ativo = $_POST['pro_ativo'];
	$pro_modelo = $_POST['pro_modelo'];
	$pro_ref = $_POST['pro_ref'];
	$pro_valor = $_POST['pro_valor'];
	$pro_estoque = $_POST['pro_estoque'];
	$pro_peso = $_POST['pro_peso'];
	$pro_altura = $_POST['pro_altura'];
	$pro_largura = $_POST['pro_largura'];
	$pro_comprimento = $_POST['pro_comprimento'];

	$pro_img = $_FILES['pro_img']['name'];

	$pro_desc = $_POST['pro_desc'];
	$pro_slug = $_POST['pro_slug'];
	$pro_id = $_POST['pro_id'];

	/*Definindo para poder excluir a imagem
    */
	$pro_img_arquivo = $_POST['pro_img_arquivo'];

/*Se tiver arquivo de imagem, faz o upload / se tiver algo ali no campo.. manda p upload..
 */
	if (!empty($_FILES['pro_img']['name'])) {

/*Instancia o objeto
 */
		$upload = new ImageUpload();

		if ($upload->Upload(900, 'pro_img')) {
			$pro_img = $upload->retorno;

			/*Remover a imagem antiga da pasta,
				            'pro_img_arquivo' está em Produtos.class.php e recebe o que vem via POST do template(campo oculto no adm_produtos_editar.tpl)

				            Serve para limpar o BD para não ficar guardando imagens desnecessárias
			*/
			@unlink($pro_img_arquivo);

		} else {
			exit('Erro ao enviar a imagem');
		}

/*Se não for alterada a imagem, permanece a imagem atual*/
	} else {
		$pro_img = $_POST['pro_img_atual'];
	}

/*Prepara os dados para serem armazenados no BANCO
 */
	$gravar->Preparar($pro_nome, $pro_categoria, $pro_ativo, $pro_modelo, $pro_ref, $pro_valor, $pro_estoque, $pro_peso, $pro_altura, $pro_largura, $pro_comprimento, $pro_img, $pro_desc, $pro_slug);

	/*Se foi alterado, manda msg e redireciona pra lista de produtos
    */
	if ($gravar->Alterar($pro_id)) {
		echo '<div class="alert alert-success">Produto alterado com sucesso!</div>';
		Rotas::Redirecionar(2, Rotas::pag_ProdutosADM());

		/*Se não foi por algum motivo, manda a msg DANGER*/
	} else {
		echo '<div class="alert alert-danger">Produto não Editado!!';

		/*Volta a página
        */
		Sistema::VoltarPagina();
		echo '</div>';

		/*Sai do bloco
        */
		exit();
	}

}
/*Fim do IF geral*/

$categorias = new Categorias();
$categorias->GetCategorias();

/*Captura os ID vindo via POST do Template =  adm_produtos_editar.tpl
 */
$produtos = new Produtos();
$id = $_POST['pro_id'];
$produtos->GetProdutosID($id);

$smarty->assign('CATEGORIAS', $categorias->GetItens());
$smarty->assign('GET_TEMA', Rotas::get_SiteTEMA());
$smarty->assign('PRO', $produtos->GetItens());

$smarty->display('adm_produtos_editar.tpl');

?>