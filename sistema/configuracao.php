<?php

use sistema\Nucleo\Helpers;

//Arquivo de configuração do sistema
//define o fuso horario
date_default_timezone_set('America/Sao_Paulo');

//informações do sistema
define('SITE_NOME', 'Storage System');
define('SITE_DESCRICAO', 'SS - Storage System');

//urls do sistema
define('URL_PRODUCAO', 'https://estoque.com.br');
define('URL_DESENVOLVIMENTO', 'http://localhost/estoque');

if (Helpers::localhost()) {
    //dados de acesso ao banco de dados em localhost
    define('DB_HOST', 'localhost');
    define('DB_PORTA', '3306');
    define('DB_NOME', 'estoque');
    define('DB_USUARIO', 'root');
    define('DB_SENHA', '');

    define('URL_SITE', 'estoque/');
    define('URL_ADMIN', 'estoque/admin/');
} else {
    //dados de acesso ao banco de dados na hospedagem
    define('DB_HOST', 'localhost');
    define('DB_PORTA', '3306');
    define('DB_NOME', '');
    define('DB_USUARIO', '');
    define('DB_SENHA', '');

    define('URL_SITE', '/');
    define('URL_ADMIN', '/admin/');
}
