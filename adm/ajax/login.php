<?php

if (!isset($_POST['usuario'], $_POST['senha']))
	exit;

require_once '../../assets/include/config.php';

$autenticacao = new autenticacao();
echo $autenticacao->cria_sessao($_POST['usuario'], $_POST['senha']);
