<?php

class Paginacao extends Conexao {

	public $limite, $inicio, $totalpags, $link = array();

	/*Função generica, para paginar qualquer item de qualquer tabela
	*/
	function GetPaginacao($campo, $tabela) {
		$query = "SELECT {$campo} FROM {$tabela}";
		$this->ExecuteSQL($query);

		/*Total guarda quantos itens foi foram localizados
		*/
		$total = $this->TotalDados();

/*Limitando quantos ítens serão buscados por página
 */
		$this->limite = Config::BD_LIMIT_POR_PAG;

		/*ceil — Arredonda frações para cima
		Este calculo arredonda a divisão de itens por página, pegando o total e dividindo pelo limite da página.. e guarda na variável páginas*/
		$paginas = ceil($total / $this->limite);
		$this->totalpags = $paginas;

		/*se existir um numero inteiro e vier via URL/metodo GET (valor de p, retorna o valor do p)*/
		$p = (int) isset($_GET['p']) ? $_GET['p'] : 1;

		if ($p > $paginas) {
			$p = $paginas;
		}

		//TESTAR NA PRÁTICA
		$this->inicio = ($p * $this->limite) - $this->limite;

		/*Tolerancia é quantos números aparecem abaixo da página (nos botões de paginação)*/
		$tolerancia = 4;
		$mostrar = $p + $tolerancia;
		if ($mostrar > $paginas) {
			$mostrar = $paginas;
		}

		for ($i = ($p - $tolerancia); $i <= $mostrar; $i++):
			if ($i < 1) {
				$i = 1;
			}
			array_push($this->link, $i);

		endfor;

	}
}

?>