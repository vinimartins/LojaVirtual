<?php

//Como terá diversas páginas, esta classe serve para que toda página aberta seja chamada com este template. Toda vez que a Template é chamada, já carrega os componentes da SmartyBC
Class Template extends SmartyBC {

	//Para que toda vez que o Template seja chamado ele instancie a classe.
	function __construct() {
		parent::__construct();

		//Organizando o código para que o compliador não fique na index do projeto, colocando cada cada arquivo em sua respectiva pasta
		$this->setTemplateDir('view/');
		$this->setCompileDir('view/compile/');
		$this->setCacheDir('view/cache/');

	}
}

?>