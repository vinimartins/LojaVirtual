<?php

Class Rotas {
	/*Criando variáveis para referenciar as pastas VIEW e CONTROLLER e ADM
	 * */
	public static $pag;
	private static $pasta_controller = 'controller';
	private static $pasta_view = 'view';
	private static $pasta_ADM = 'adm';

	/*Dicionário, SELF e EXPLODE
		self:: é o mesmo que o this, informando que pertence a esta classe
		explode faz o tratamento dentro de uma string
	*/

	/*Capturar a pasta HOME
	 * */
	static function get_SiteHOME() {
		return Config::SITE_URL . '/' . Config::SITE_PASTA;
	}

	/*	Capturar a pasta RAIZ:[...]
		Utilização da variável global $_SERVER, para capturar o servidor onde está hospedado o site, em DOCUMENT_ROOT
	*/
	static function get_SiteRAIZ() {
		return $_SERVER['DOCUMENT_ROOT'] . '/' . Config::SITE_PASTA;
	}

	/*Chamando os temas
	 */
	static function get_SiteTEMA() {
		return self::get_SiteHOME() . '/' . self::$pasta_view;
	}

	static function pag_ClienteCadastro() {
		return self::get_SiteHOME() . '/cadastro';
	}

	static function pag_CLienteDados() {
		return self::get_SiteHOME() . '/clientes_dados';
	}

	static function pag_CLienteSenha() {
		return self::get_SiteHOME() . '/clientes_senha';
	}

	static function pag_ClienteRecovery() {
		return self::get_SiteHOME() . '/clientes_recovery';
	}

	static function pag_CLientePedidos() {
		return self::get_SiteHOME() . '/clientes_pedidos';
	}

	static function pag_ClienteItens() {
		return self::get_SiteHOME() . '/cliente_itens';
	}

	static function pag_Carrinho() {
		return self::get_SiteHOME() . '/carrinho';
	}

	static function pag_ClienteLogin() {
		return self::get_SiteHOME() . '/login';
	}

	static function pag_Logoff() {
		return self::get_SiteHOME() . '/logoff';
	}

	static function pag_CarrinhoAlterar() {
		return self::get_SiteHOME() . '/carrinho_alterar';
	}

	static function pag_Produtos() {
		return self::get_SiteHOME() . '/produtos';
	}

	static function pag_ProdutosInfo() {
		return self::get_SiteHOME() . '/produtos_info';
	}

	static function pag_Contato() {
		return self::get_SiteHOME() . '/contato';
	}

	static function pag_MinhaConta() {
		return self::get_SiteHOME() . '/minhaconta';
	}

	static function pag_ClienteConta() {
		return self::get_SiteHOME() . '/minhaconta';
	}

	static function pag_PedidoConfirmar() {
		return self::get_SiteHOME() . '/pedido_confirmar';
	}

	static function pag_PedidoFinalizar() {
		return self::get_SiteHOME() . '/pedido_finalizar';
	}

	static function pag_PedidoRetorno() {

		return self::get_SiteHOME() . '/pedido_retorno';
	}

	static function pag_PedidoRetornoERRO() {

		return self::get_SiteHOME() . '/pedido_retorno_erro';
	}

/*Imagens: Retornando o local pra onde será feito o upload da imagem
 */
	static function get_ImagePasta() {
		return 'media/images/';
	}

/*Quando chamar a get_ImageURL, localiza a HOME do site, e concatena a pasta de imagens [...]
Ex: http://localhost/loja/media/images/
 */
	static function get_ImageURL() {
		return self::get_SiteHOME() . '/' . self::get_ImagePasta();

	}

	//rotas para área administrativa

	static function get_SiteADM() {
		return self::get_SiteHOME() . '/' . self::$pasta_ADM;

	}

	static function pag_ProdutosADM() {
		return self::get_SiteADM() . '/adm_produtos';

	}

	static function pag_ProdutosNovoADM() {
		return self::get_SiteADM() . '/adm_produtos_novo';

	}

	static function pag_ProdutosEditarADM() {
		return self::get_SiteADM() . '/adm_produtos_editar';

	}

	static function pag_ProdutosDeletarADM() {
		return self::get_SiteADM() . '/adm_produtos_deletar';

	}

	static function pag_ProdutosImgADM() {
		return self::get_SiteADM() . '/adm_produtos_img';

	}

	static function pag_ClientesADM() {
		return self::get_SiteADM() . '/adm_clientes';

	}

	static function pag_ClientesEditarADM() {
		return self::get_SiteADM() . '/adm_clientes_editar';

	}

	static function pag_PedidosADM() {
		return self::get_SiteADM() . '/adm_pedidos';

	}

	static function pag_ItensADM() {
		return self::get_SiteADM() . '/adm_itens';

	}

	static function pag_CategoriasADM() {
		return self::get_SiteADM() . '/adm_categorias';

	}

	static function pag_LogoffADM() {
		return self::get_SiteADM() . '/adm_logoff';
	}

	/*	Função para configuração da imagem dentro da página[...]
		Uso do arquivo thumb para formatar a imagem;
		1º: src, especificando a imagem que será trabalhada
		2º: Largura da img
		3º: Altura da img
		4º: ZC, é o corte de transparencia da imagem. ignorando aquela parte inutil de uma imagem

		A função retorna a imagem já formatada
	*/
	static function ImageLink($img, $largura, $altura) {

		/*informando os parâmetros recebidas na URL,
		 */
		$imagem = self::get_ImageURL() . "thumb.php?src={$img}&w={$largura}&h={$altura}&zc=1";

		/*Retorna a variavel
		 * */
		return $imagem;

	}

	static function get_Pasta_Controller() {
		return self::$pasta_controller;
	}

	//MÉTODO PARA REDIRECIONAR
	static function Redirecionar($tempo, $pagina) {
		$url = '<meta http-equiv="refresh" content="' . $tempo . '; url=' . $pagina . '">';
		echo $url;
	}

	/*Função estática para ser chamada de qualquer classe[...]

		Se a variável "página", vier igual a categorias por exemplo, e existir dentro da pasta controller, quer dizer que a página é existente.
	*/
	static function get_Pagina() {
		/*Se existir, através do método GET a página chamada
		 */
		if (isset($_GET['pag'])) {

			$pagina = $_GET['pag'];

			self::$pag = explode('/', $pagina);

			//echo '<pre>';
			//var_dump(self::$pag);
			//echo '</pre>';

			$pagina = 'controller/' . self::$pag[0] . '.php';
			//$pagina = 'controller/' .$_GET['pag'] . '.php';

			if (file_exists($pagina)) {

				/*Inclui a página/faz a chamada da página
				 */
				include $pagina;
				/*Caso não exista através do método GET e ñ exista a página, vai p erro 404
				 */
			} else {
				include 'erro.php';
			}
			/*Caso não esteja passando nenhuma informação de página, vai pra home
			 */
		} else {
			include 'home.php';
		}
	} /*Fim do método get_Pagina
	 * */

}

?>