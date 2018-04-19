<?php

Class Config {

	/*
		//INFORMÃÇÕES BÁSICAS DO SITE
		const SITE_URL = "http://localhost:8080";
		const SITE_PASTA = "loja";
		const SITE_NOME = "T12 - STORE";
		const SITE_EMAIL_ADM = "virtual.t12store@gmail.com";
		const BD_LIMIT_POR_PAG = 6;
		const SITE_CEP = '';

		//INFORMAÇÕES DO BANCO DE DADOS
		const BD_HOST = "localhost:8080",
		BD_USER = "root",
		BD_SENHA = "",
		BD_BANCO = "loja_t12",
		BD_PREFIX = "TBL_";
	*/

	///*
	//INFORMÃÇÕES BÁSICAS DO SITE HOSPEDADO
	const SITE_URL = "https://www.t12store.com.br";
	const SITE_PASTA = "";
	const SITE_NOME = "T12 STORE";
	const SITE_EMAIL_ADM = "virtual.t12store@gmail.com";
	const BD_LIMIT_POR_PAG = 6;
	const SITE_CEP = '';

	//INFORMAÇÕES DO BANCO DE DADOS HOSPEDADO
	const BD_HOST = "",
	BD_USER = "",
	BD_SENHA = "",
	BD_BANCO = "",
	BD_PREFIX = "TBL_";

	//*/

	//INFORMAÇÕES PARA PHP MAILLER
	const EMAIL_HOST = "";
	const EMAIL_USER = "nao-responda@t12store.com.br";
	const EMAIL_CONTATO = "contato@t12store.com.br";
	const EMAIL_COPIA = "virtual.t12store@gmail.com";
	const EMAIL_NOME = "Contato T12 - STORE";
	const EMAIL_SENHA = "";
	const EMAIL_PORTA = 587;
	const EMAIL_SMTPAUTH = true;
	const EMAIL_SMTPSECURE = "tls";

	//CONSTANTES PARA O PAGSEGURO
	const PS_EMAIL = ""; // email pagseguro
	const PS_TOKEN = ""; // token produção = venda
	const PS_TOKEN_SBX = ""; // token do sandbox = teste

	const PS_AMBIENTE = "production"; // production somente p transação   /  sandbox p teste

}
?>

