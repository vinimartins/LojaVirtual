<?php
class Itens extends Conexao {

	private $total_valor;

	function __construct() {
		parent::__construct();
	}

	/*Vai ser necessário a ID do pedido, cliente pode ser NULL*/
	function GetItensPedido($pedido, $cliente = null) {

		/*Seleciona todos dados que estão em pedidos, itens dos pedidos e produtos
        */
		$query = "SELECT * FROM {$this->prefix}pedidos p, {$this->prefix}pedidos_itens i, {$this->prefix}produtos d";

		/*Filtrando qual item é de qual pedido e qual produto é de qual item pedido*/
		$query .= " WHERE p.ped_cod = i.item_ped_cod AND i.item_produto = d.pro_id";

		/*filtrando o parâmetro da função(codigo do pedido) p evitar SQLINJECTION*/
		$query .= " AND p.ped_cod = :pedido";

/*Se houver cliente*/
		if ($cliente != null) {

/*faz a verificação da ID do cliente para o pedido*/
			$query .= " AND p.ped_cliente = {:cliente}";

			$params[':cliente'] = (int) $cliente;
		}

		$params[':pedido'] = (int) $pedido;

		$this->ExecuteSQL($query, $params);
		$this->GetLista();
	}

	private function GetLista() {

		$i = 1;
		$sub = 0;
		while ($lista = $this->ListarDados()):

			// subtotal de cada item
			$sub = $lista['item_valor'] * $lista['item_qtd'];
			$this->total_valor += $sub;

			$this->itens[$i] = array(
				'ped_id' => $lista['ped_id'],
				'ped_data' => Sistema::Fdata($lista['ped_data']),
				'ped_data_us' => $lista['ped_data'],
				'ped_hora' => $lista['ped_hora'],
				'ped_cliente' => $lista['ped_cliente'],
				'ped_cod' => $lista['ped_cod'],
				'ped_ref' => $lista['ped_ref'],
				'ped_pag_status' => $lista['ped_pag_status'],
				'ped_pag_forma' => $lista['ped_pag_forma'],
				'ped_pag_tipo' => $lista['ped_pag_tipo'],
				'ped_pag_codigo' => $lista['ped_pag_codigo'],
				'ped_frete_valor' => $lista['ped_frete_valor'],
				'ped_frete_tipo' => $lista['ped_frete_tipo'],
				'item_id' => $lista['item_id'],
				'item_nome' => $lista['pro_nome'],
				'item_valor' => Sistema::MoedaBR($lista['item_valor']),
				'item_valor_us' => $lista['item_valor'],
				'item_qtd' => $lista['item_qtd'],
				'item_img' => Rotas::ImageLink($lista['pro_img'], 60, 60),
				'item_sub' => Sistema::MoedaBR($sub),
				'item_sub_us' => $sub,

			);

			$i++;

		endwhile;

	}
/*Get total para saber o valor total dos Itens*/
	function GetTotal() {
		return $this->total_valor;
	}

}

?>

