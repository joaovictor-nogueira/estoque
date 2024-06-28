<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Nucleo\Helpers;

try {
    //namespace dos controladores
    SimpleRouter::setDefaultNamespace('sistema\Controlador');
    
    //SITE
    SimpleRouter::get(URL_SITE, 'SiteControlador@index');
    SimpleRouter::get(URL_SITE . 'index.php', 'SiteControlador@index');
    
    
    //PAINEL
    SimpleRouter::post(URL_SITE . 'login', 'UsuarioControlador@login');
    SimpleRouter::get(URL_SITE . 'painel', 'PainelControlador@index');

    SimpleRouter::match(['get', 'post'], URL_SITE . 'dashboard', 'PainelDashboard@dashboard');
    SimpleRouter::get(URL_SITE . 'sair', 'PainelDashboard@sair');


    //USUARIOS
    SimpleRouter::get(URL_SITE . 'dashboard/usuarios/listar', 'PainelUsuarios@listar');
    SimpleRouter::match(['get', 'post'], URL_SITE . 'dashboard/usuarios/cadastrar', 'PainelUsuarios@cadastrar');
    SimpleRouter::match(['get', 'post'], URL_SITE . 'dashboard/usuarios/editar/{id}', 'PainelUsuarios@editar');
    SimpleRouter::get(URL_SITE . 'dashboard/usuarios/deletar/{id}', 'PainelUsuarios@deletar');

    //ESTOQUE
    SimpleRouter::match(['get', 'post'], URL_SITE . 'dashboard/itens/listar', 'PainelItens@listar');
    SimpleRouter::match(['get', 'post'], URL_SITE . 'dashboard/itens/cadastrar', 'PainelItens@cadastrar');
    SimpleRouter::match(['get', 'post'], URL_SITE . 'dashboard/itens/editar/{id}', 'PainelItens@editar');
    SimpleRouter::get(URL_SITE . 'dashboard/itens/deletar/{id}', 'PainelItens@deletar');


   
    SimpleRouter::get(URL_SITE . 'dashboard/item/{slug}', 'PainelMovimentacoes@menu');
    SimpleRouter::match(['get', 'post'], URL_SITE . 'dashboard/item/{id}/adicionar', 'PainelMovimentacoes@adicionar');
    SimpleRouter::match(['get', 'post'], URL_SITE . 'dashboard/item/{id}/remover', 'PainelMovimentacoes@remover');
    SimpleRouter::get(URL_SITE . 'dashboard/item/{slug}/movimentacoes', 'PainelMovimentacoes@movimentacoes');

    SimpleRouter::get(URL_SITE . 'dashboard/item/{slug}/movimentacoes/{id}', 'PainelMovimentacoes@detalhesMovimentacao');


    //MOVIMENTAÇÕES
    SimpleRouter::get(URL_SITE . 'dashboard/movimentacoes/listar', 'PainelMovimentacoes@listar');

    //COMPRAS
    SimpleRouter::get(URL_SITE . 'dashboard/compras', 'PainelCompras@menu');
    SimpleRouter::get(URL_SITE . 'dashboard/compras/acabando', 'PainelCompras@acabando');
    SimpleRouter::get(URL_SITE . 'dashboard/compras/esgotado', 'PainelCompras@esgotado');


    
    SimpleRouter::start();
} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
    if (Helpers::localhost()) {
        echo $ex->getMessage();
    } else {
        Helpers::redirecionar('404');
    }
}
