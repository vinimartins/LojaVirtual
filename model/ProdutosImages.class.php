<?php

Class ProdutosImages extends Conexao {

	/*Quando a função for chamada, vai passar o ID do produto, será utilizada na função "Mais imagens" dentro da página do produto
	*/
	function GetImagesPRO($pro) {

		/*seleciona todos itens da tabela imagens onde a ID da tabela seja igual ao ID do produto
		*/
		$query = "SELECT * FROM {$this->prefix}imagens WHERE img_pro_id = :pro";

/*Valor sendo passado pra variavel params
 */
		$params = array(':pro' => (int) $pro);

/*Execute SQL sendo passado com a query e o param
 */
		$this->ExecuteSQL($query, $params);

/*buscando as imagens
 */
		$this->GetLista();

	}

	private function GetLista() {
		$i = 1;
		while ($lista = $this->ListarDados()):
			$this->itens[$i] = array(
				'img_id' => $lista['img_id'],
				'img_nome' => Rotas::ImageLink($lista['img_nome'], 150, 150),
				'img_pro_id' => $lista['img_pro_id'],
				'img_link' => Rotas::ImageLink($lista['img_nome'], 500, 500),
				'img_arquivo' => $lista['img_nome'],

			);

			$i++;
		endwhile;
	}

/*Pede a img a ser inserida, e qual produ to que receberá a imagem*/
	public function Insert($img, $produto) {

		$query = "INSERT INTO {$this->prefix}imagens (img_nome,img_pro_id)";
		$query .= " VALUES (:img_nome,:img_pro_id) ";

		$params = array(':img_nome' => $img, ':img_pro_id' => (int) $produto);

		$this->ExecuteSQL($query, $params);

	}

	/*Deletando na tabela imagem, sendo utilizado no controller ADM_PRODUTOS_IMG
	*/
	public function Deletar($img_nome) {

		/*Marcando a tabela
		*/
		$query = " DELETE FROM {$this->prefix}imagens ";

		/*Falando onde
		*/
		$query .= " WHERE img_nome = :img_nome ";

		/*E atribuindo valor ao parâmetro
		*/
		$params = array(':img_nome' => $img_nome);

		/*Executa a query
		*/
		$this->ExecuteSQL($query, $params);

	}

}

?>