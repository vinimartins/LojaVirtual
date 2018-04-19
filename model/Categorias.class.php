<?php

Class Categorias extends Conexao {

	private $cate_id, $cate_nome, $cate_slug;

	function __construct() {
		parent::__construct();
	}

	function GetCategorias() {
		//query para buscar os produtos de uma categoria especifica.
		$query = "SELECT * FROM {$this->prefix}categorias";

		$this->ExecuteSQL($query);

		$this->GetLista();

	}

	private function GetLista() {
		$i = 1;
		while ($lista = $this->ListarDados()):
			$this->itens[$i] = array(
				'cate_id' => $lista['cate_id'],
				'cate_nome' => $lista['cate_nome'],
				'cate_slug' => $lista['cate_slug'],
				'cate_link' => Rotas::pag_Produtos() . '/' . $lista['cate_id'] . '/' . $lista['cate_slug'],

				/*Mostrando os produtos na pág de ADM
                */
				'cate_link_adm' => Rotas::pag_ProdutosADM() . '/' . $lista['cate_id'] . '/' . $lista['cate_slug'],
			);

			$i++;
		endwhile;
	}

	/*Inserir Categoria, precisando do campo via POST com o nome da categoria lá do Template
    */
	function Inserir($cate_nome) {

		/*Tratar os campos*/
		$this->setCate_nome($cate_nome);

		/*'Sapato Social' ele transforma em 'sapato-social'
        */
		$this->setCate_slug($cate_nome);

		// monto a SQL
		$query = " INSERT INTO {$this->prefix}categorias (cate_nome, cate_slug )";
		$query .= " VALUES (:cate_nome, :cate_slug )";
		// passo so parametros
		$params = array(':cate_nome' => $this->getCate_nome(),
			':cate_slug' => $this->getCate_slug(),

		);

		/*executo a minha SQL
		*/
		if ($this->ExecuteSQL($query, $params)):
			return TRUE;

		else:
			return FALSE;

		endif;

	}

	function Editar($cate_id, $cate_nome) {

		// trato os campos
		$this->setCate_nome($cate_nome);
		$this->setCate_slug($cate_nome);

		// monto a SQL
		$query = " UPDATE {$this->prefix}categorias ";
		$query .= " SET cate_nome = :cate_nome, cate_slug = :cate_slug ";
		$query .= " WHERE cate_id = :cate_id ";
		// passo so parametros
		$params = array(':cate_nome' => $this->getCate_nome(),
			':cate_slug' => $this->getCate_slug(),
			':cate_id' => (int) $cate_id,
		);
		// executo a minha SQL
		if ($this->ExecuteSQL($query, $params)):
			return TRUE;

		else:
			return FALSE;

		endif;

	}

	function Apagar($cate_id) {

		// verifico se  tenho itens antes de apagar a categoria
		$pro = new Produtos();

		/*Trazer todos produtos associados a esta cadegoria
        */
		$pro->GetProdutosCateID($cate_id);

		/*Se tiver túplas no banco de dados maiores que zero
        */
		if ($pro->TotalDados() > 0):
			echo '<div class="alert alert-danger" > Esta categoria tem: ';

			/*Mostra o total de produtos naquela categoria
        */
			echo $pro->TotalDados();
			echo ' produtos. Não pode ser apagada, para apagar precisa primeiro apagar os produtos dela </div>';

			/* Se não houver produtos associados a categoria em questão, é realizada a exclusão da categoria
	*/
		else:

			// monto a SQL
			$query = " DELETE FROM {$this->prefix}categorias";
			$query .= " WHERE cate_id = :id";

			// passo os parametros
			$params = array(':id' => (int) $cate_id);

			// Se executar, volta true or falses
			if ($this->ExecuteSQL($query, $params)):
				return TRUE;

			else:
				return FALSE;

			endif;

		endif;

	}

	/*Getters
	*/
	function getCate_nome() {
		return $this->cate_nome;
	}

	function getCate_slug() {
		return $this->cate_slug;
	}

	/*Setters
	*/
	function setCate_nome($cate_nome) {

		/*cate_nome recebe um valor filtrado para que possa somente ser lançado STRING*/
		$this->cate_nome = filter_var($cate_nome, FILTER_SANITIZE_STRING);
	}

	function setCate_slug($cate_slug) {
		/*Captura o texto digitado e converte tudo para minúsculo, e se tiver espaçamento substitui pelo hífen. Exemplo:
			        Camiseta Social = camiseta-social
		*/
		$this->cate_slug = Sistema::GetSlug($cate_slug);
	}

}

?>