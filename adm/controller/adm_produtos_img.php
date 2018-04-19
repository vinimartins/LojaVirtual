<!--Serve para controlar as imagens do perfil de ADM-->
<?php

$smarty = new Template();

/*Recebe o que vier via POST como ID, está como campo oculto no template
 */
$pro_id = (int) $_POST['pro_id'];

/*Vai verifica se existe POST de algum campo pro_ID, e pro_img com um nome
 */
if (isset($_POST['pro_id']) && isset($_FILES['pro_img']['name'])) {

	/*Se tiver arquivos, e tiver nome instancia o objeto upload*/
	$upload = new ImageUpload();

	/*Faz uma nova verificação se tem algum arquivo de imagem com nome
	*/
	if (!empty($_FILES['pro_img']['name'])) {

		/*Faz o upload da imagem
		*/
		$upload->Upload(900, 'pro_img');

		/*pro_img recebe o retorno*/
		$pro_img = $upload->retorno;

		/*Instancia o objeto gravar de ProdutosImages
		*/
		$gravar = new ProdutosImages();

		/*Executa a função INSERT, que como parâmetro é a lista de imagens do produtos, podendo ser um array. E o ID do produto

			Grava na tabela produtos, qndo for buscar, faz a consulta através das imagens relacionadas ao produto
		*/
		$gravar->Insert($pro_img, $pro_id);

	}
}

/*E se tiver algum post fotos_apagar, que é o botão de 'apagar marcadas', pra deletar as fotos extras dos produtos (que é um array) dá sequencia  no processo de exclusão
 */
if (isset($_POST['fotos_apagar'])) {

	/*Instanciando o objeto da produtoImagens*/
	$apagar = new ProdutosImages();

	/*Como pode ser várias fotos, pra cada POST vem apelidado como $foto manda o Delete
	*/
	foreach ($_POST['fotos_apagar'] as $foto) {
		$apagar->Deletar($foto);

		/*Atribuindo valor a filename do local da foto
		*/
		$filename = Rotas::get_SiteRAIZ() . '/' . Rotas::get_ImagePasta() . $foto;

		/*e por fim excluindo a foto do banco*/
		@unlink($filename);
	}

	/*Manda msg de sucesso
	*/
	echo '<div class="alert alert-success">Foto(s) apagada(s) com sucesso! </div>';
}

/*instanciando a img passando a id do produto
 */
$img = new ProdutosImages($pro_id);

/*Servirá para buscar as imagens de um produto especifico, passando id do produto, e virá todas imagens do tal produto
A id do produto virá via POST, quando der o enviar no template adm_produtos_img.tpl
 */
$img->GetImagesPRO($_POST['pro_id']);

/*Criando as TAGS do smarty para serem utilizados no template*/
$smarty->assign('IMAGES', $img->GetItens());
$smarty->assign('PRO', $pro_id);

/*Manda o template*/
$smarty->display('adm_produtos_img.tpl');

?>