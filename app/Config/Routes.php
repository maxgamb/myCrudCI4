<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');


/** @var RouteCollection $routes */

$routes->group(
    'mycrud',
    ['namespace' => 'App\Controllers\MyCrud'],
    static function (RouteCollection $routes): void {
        $routes->get('/', 'BuilderController::index');

        $routes->get('quick', 'AutoCrudController::index');
        $routes->post('quick/generate', 'AutoCrudController::generateAll');
        $routes->get('quick/report/(:segment)', 'AutoCrudController::report/$1');

        $routes->get('builder', 'BuilderController::index');
        $routes->get('builder/configure/(:segment)', 'BuilderController::configure/$1');
        $routes->post('builder/save', 'BuilderController::save');
        $routes->post('builder/generate', 'BuilderController::generate');

        $routes->get('tools/routes', 'ToolsController::routes');
        $routes->get('tools/fields', 'ToolsController::fields');
        $routes->get('tools/schema', 'ToolsController::schema');
        $routes->get('tools/schema/(:segment)', 'ToolsController::schema/$1');
    }
);


$routes->group('adebiti', static function (RouteCollection $routes): void {
    $routes->get('/', 'AdebitusController::index');
    $routes->post('datatable', 'AdebitusController::datatable');
    $routes->get('view/(:segment)', 'AdebitusController::view/$1');
    $routes->get('create', 'AdebitusController::create');
    $routes->post('store', 'AdebitusController::store');
    $routes->get('edit/(:segment)', 'AdebitusController::edit/$1');
    $routes->post('update/(:segment)', 'AdebitusController::update/$1');
    $routes->post('delete/(:segment)', 'AdebitusController::delete/$1');
});

$routes->group('agenda', static function (RouteCollection $routes): void {
    $routes->get('/', 'AgendaController::index');
    $routes->post('datatable', 'AgendaController::datatable');
    $routes->get('view/(:segment)', 'AgendaController::view/$1');
    $routes->get('create', 'AgendaController::create');
    $routes->post('store', 'AgendaController::store');
    $routes->get('edit/(:segment)', 'AgendaController::edit/$1');
    $routes->post('update/(:segment)', 'AgendaController::update/$1');
    $routes->post('delete/(:segment)', 'AgendaController::delete/$1');
});

$routes->group('agenzia_listini', static function (RouteCollection $routes): void {
    $routes->get('/', 'AgenziaListiniController::index');
    $routes->post('datatable', 'AgenziaListiniController::datatable');
    $routes->get('view/(:segment)', 'AgenziaListiniController::view/$1');
    $routes->get('create', 'AgenziaListiniController::create');
    $routes->post('store', 'AgenziaListiniController::store');
    $routes->get('edit/(:segment)', 'AgenziaListiniController::edit/$1');
    $routes->post('update/(:segment)', 'AgenziaListiniController::update/$1');
    $routes->post('delete/(:segment)', 'AgenziaListiniController::delete/$1');
});

$routes->group('agenzia_prezzi', static function (RouteCollection $routes): void {
    $routes->get('/', 'AgenziaPrezziController::index');
    $routes->post('datatable', 'AgenziaPrezziController::datatable');
    $routes->get('view/(:segment)', 'AgenziaPrezziController::view/$1');
    $routes->get('create', 'AgenziaPrezziController::create');
    $routes->post('store', 'AgenziaPrezziController::store');
    $routes->get('edit/(:segment)', 'AgenziaPrezziController::edit/$1');
    $routes->post('update/(:segment)', 'AgenziaPrezziController::update/$1');
    $routes->post('delete/(:segment)', 'AgenziaPrezziController::delete/$1');
});

$routes->group('agenzie', static function (RouteCollection $routes): void {
    $routes->get('/', 'AgenzieController::index');
    $routes->post('datatable', 'AgenzieController::datatable');
    $routes->get('view/(:segment)', 'AgenzieController::view/$1');
    $routes->get('create', 'AgenzieController::create');
    $routes->post('store', 'AgenzieController::store');
    $routes->get('edit/(:segment)', 'AgenzieController::edit/$1');
    $routes->post('update/(:segment)', 'AgenzieController::update/$1');
    $routes->post('delete/(:segment)', 'AgenzieController::delete/$1');
});

$routes->group('app_ip', static function (RouteCollection $routes): void {
    $routes->get('/', 'AppIpController::index');
    $routes->post('datatable', 'AppIpController::datatable');
    $routes->get('view/(:segment)', 'AppIpController::view/$1');
    $routes->get('create', 'AppIpController::create');
    $routes->post('store', 'AppIpController::store');
    $routes->get('edit/(:segment)', 'AppIpController::edit/$1');
    $routes->post('update/(:segment)', 'AppIpController::update/$1');
    $routes->post('delete/(:segment)', 'AppIpController::delete/$1');
});

$routes->group('banca_hotel', static function (RouteCollection $routes): void {
    $routes->get('/', 'BancaHotelController::index');
    $routes->post('datatable', 'BancaHotelController::datatable');
    $routes->get('view/(:segment)', 'BancaHotelController::view/$1');
    $routes->get('create', 'BancaHotelController::create');
    $routes->post('store', 'BancaHotelController::store');
    $routes->get('edit/(:segment)', 'BancaHotelController::edit/$1');
    $routes->post('update/(:segment)', 'BancaHotelController::update/$1');
    $routes->post('delete/(:segment)', 'BancaHotelController::delete/$1');
});

$routes->group('black_list', static function (RouteCollection $routes): void {
    $routes->get('/', 'BlackListController::index');
    $routes->post('datatable', 'BlackListController::datatable');
    $routes->get('view/(:segment)', 'BlackListController::view/$1');
    $routes->get('create', 'BlackListController::create');
    $routes->post('store', 'BlackListController::store');
    $routes->get('edit/(:segment)', 'BlackListController::edit/$1');
    $routes->post('update/(:segment)', 'BlackListController::update/$1');
    $routes->post('delete/(:segment)', 'BlackListController::delete/$1');
});

$routes->group('camere', static function (RouteCollection $routes): void {
    $routes->get('/', 'CamereController::index');
    $routes->post('datatable', 'CamereController::datatable');
    $routes->get('view/(:segment)', 'CamereController::view/$1');
    $routes->get('create', 'CamereController::create');
    $routes->post('store', 'CamereController::store');
    $routes->get('edit/(:segment)', 'CamereController::edit/$1');
    $routes->post('update/(:segment)', 'CamereController::update/$1');
    $routes->post('delete/(:segment)', 'CamereController::delete/$1');
});

$routes->group('camere_nesting', static function (RouteCollection $routes): void {
    $routes->get('/', 'CamereNestingController::index');
    $routes->post('datatable', 'CamereNestingController::datatable');
    $routes->get('view/(:segment)', 'CamereNestingController::view/$1');
    $routes->get('create', 'CamereNestingController::create');
    $routes->post('store', 'CamereNestingController::store');
    $routes->get('edit/(:segment)', 'CamereNestingController::edit/$1');
    $routes->post('update/(:segment)', 'CamereNestingController::update/$1');
    $routes->post('delete/(:segment)', 'CamereNestingController::delete/$1');
});

$routes->group('cassa', static function (RouteCollection $routes): void {
    $routes->get('/', 'CassaController::index');
    $routes->post('datatable', 'CassaController::datatable');
    $routes->get('view/(:segment)', 'CassaController::view/$1');
    $routes->get('create', 'CassaController::create');
    $routes->post('store', 'CassaController::store');
    $routes->get('edit/(:segment)', 'CassaController::edit/$1');
    $routes->post('update/(:segment)', 'CassaController::update/$1');
    $routes->post('delete/(:segment)', 'CassaController::delete/$1');
});

$routes->group('cax_motivo', static function (RouteCollection $routes): void {
    $routes->get('/', 'CaxMotivoController::index');
    $routes->post('datatable', 'CaxMotivoController::datatable');
    $routes->get('view/(:segment)', 'CaxMotivoController::view/$1');
    $routes->get('create', 'CaxMotivoController::create');
    $routes->post('store', 'CaxMotivoController::store');
    $routes->get('edit/(:segment)', 'CaxMotivoController::edit/$1');
    $routes->post('update/(:segment)', 'CaxMotivoController::update/$1');
    $routes->post('delete/(:segment)', 'CaxMotivoController::delete/$1');
});

$routes->group('checklist_preno', static function (RouteCollection $routes): void {
    $routes->get('/', 'ChecklistPrenoController::index');
    $routes->post('datatable', 'ChecklistPrenoController::datatable');
    $routes->get('view/(:segment)', 'ChecklistPrenoController::view/$1');
    $routes->get('create', 'ChecklistPrenoController::create');
    $routes->post('store', 'ChecklistPrenoController::store');
    $routes->get('edit/(:segment)', 'ChecklistPrenoController::edit/$1');
    $routes->post('update/(:segment)', 'ChecklistPrenoController::update/$1');
    $routes->post('delete/(:segment)', 'ChecklistPrenoController::delete/$1');
});

$routes->group('ci_sessions', static function (RouteCollection $routes): void {
    $routes->get('/', 'CiSessionController::index');
    $routes->post('datatable', 'CiSessionController::datatable');
    $routes->get('view/(:segment)', 'CiSessionController::view/$1');
    $routes->get('create', 'CiSessionController::create');
    $routes->post('store', 'CiSessionController::store');
    $routes->get('edit/(:segment)', 'CiSessionController::edit/$1');
    $routes->post('update/(:segment)', 'CiSessionController::update/$1');
    $routes->post('delete/(:segment)', 'CiSessionController::delete/$1');
});

$routes->group('clienti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ClientusController::index');
    $routes->post('datatable', 'ClientusController::datatable');
    $routes->get('view/(:segment)', 'ClientusController::view/$1');
    $routes->get('create', 'ClientusController::create');
    $routes->post('store', 'ClientusController::store');
    $routes->get('edit/(:segment)', 'ClientusController::edit/$1');
    $routes->post('update/(:segment)', 'ClientusController::update/$1');
    $routes->post('delete/(:segment)', 'ClientusController::delete/$1');
});

$routes->group('codici_stato', static function (RouteCollection $routes): void {
    $routes->get('/', 'CodiciStatoController::index');
    $routes->post('datatable', 'CodiciStatoController::datatable');
    $routes->get('view/(:segment)', 'CodiciStatoController::view/$1');
    $routes->get('create', 'CodiciStatoController::create');
    $routes->post('store', 'CodiciStatoController::store');
    $routes->get('edit/(:segment)', 'CodiciStatoController::edit/$1');
    $routes->post('update/(:segment)', 'CodiciStatoController::update/$1');
    $routes->post('delete/(:segment)', 'CodiciStatoController::delete/$1');
});

$routes->group('colori', static function (RouteCollection $routes): void {
    $routes->get('/', 'ColorusController::index');
    $routes->post('datatable', 'ColorusController::datatable');
    $routes->get('view/(:segment)', 'ColorusController::view/$1');
    $routes->get('create', 'ColorusController::create');
    $routes->post('store', 'ColorusController::store');
    $routes->get('edit/(:segment)', 'ColorusController::edit/$1');
    $routes->post('update/(:segment)', 'ColorusController::update/$1');
    $routes->post('delete/(:segment)', 'ColorusController::delete/$1');
});

$routes->group('competitori', static function (RouteCollection $routes): void {
    $routes->get('/', 'CompetitorusController::index');
    $routes->post('datatable', 'CompetitorusController::datatable');
    $routes->get('view/(:segment)', 'CompetitorusController::view/$1');
    $routes->get('create', 'CompetitorusController::create');
    $routes->post('store', 'CompetitorusController::store');
    $routes->get('edit/(:segment)', 'CompetitorusController::edit/$1');
    $routes->post('update/(:segment)', 'CompetitorusController::update/$1');
    $routes->post('delete/(:segment)', 'CompetitorusController::delete/$1');
});

$routes->group('comuni', static function (RouteCollection $routes): void {
    $routes->get('/', 'ComuniController::index');
    $routes->post('datatable', 'ComuniController::datatable');
    $routes->get('view/(:segment)', 'ComuniController::view/$1');
    $routes->get('create', 'ComuniController::create');
    $routes->post('store', 'ComuniController::store');
    $routes->get('edit/(:segment)', 'ComuniController::edit/$1');
    $routes->post('update/(:segment)', 'ComuniController::update/$1');
    $routes->post('delete/(:segment)', 'ComuniController::delete/$1');
});

$routes->group('conti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ContusController::index');
    $routes->post('datatable', 'ContusController::datatable');
    $routes->get('view/(:segment)', 'ContusController::view/$1');
    $routes->get('create', 'ContusController::create');
    $routes->post('store', 'ContusController::store');
    $routes->get('edit/(:segment)', 'ContusController::edit/$1');
    $routes->post('update/(:segment)', 'ContusController::update/$1');
    $routes->post('delete/(:segment)', 'ContusController::delete/$1');
});

$routes->group('conti_note', static function (RouteCollection $routes): void {
    $routes->get('/', 'ContiNoteController::index');
    $routes->post('datatable', 'ContiNoteController::datatable');
    $routes->get('view/(:segment)', 'ContiNoteController::view/$1');
    $routes->get('create', 'ContiNoteController::create');
    $routes->post('store', 'ContiNoteController::store');
    $routes->get('edit/(:segment)', 'ContiNoteController::edit/$1');
    $routes->post('update/(:segment)', 'ContiNoteController::update/$1');
    $routes->post('delete/(:segment)', 'ContiNoteController::delete/$1');
});

$routes->group('conti_trasferisci', static function (RouteCollection $routes): void {
    $routes->get('/', 'ContiTrasferiscusController::index');
    $routes->post('datatable', 'ContiTrasferiscusController::datatable');
    $routes->get('view/(:segment)', 'ContiTrasferiscusController::view/$1');
    $routes->get('create', 'ContiTrasferiscusController::create');
    $routes->post('store', 'ContiTrasferiscusController::store');
    $routes->get('edit/(:segment)', 'ContiTrasferiscusController::edit/$1');
    $routes->post('update/(:segment)', 'ContiTrasferiscusController::update/$1');
    $routes->post('delete/(:segment)', 'ContiTrasferiscusController::delete/$1');
});

$routes->group('costi_area', static function (RouteCollection $routes): void {
    $routes->get('/', 'CostiAreaController::index');
    $routes->post('datatable', 'CostiAreaController::datatable');
    $routes->get('view/(:segment)', 'CostiAreaController::view/$1');
    $routes->get('create', 'CostiAreaController::create');
    $routes->post('store', 'CostiAreaController::store');
    $routes->get('edit/(:segment)', 'CostiAreaController::edit/$1');
    $routes->post('update/(:segment)', 'CostiAreaController::update/$1');
    $routes->post('delete/(:segment)', 'CostiAreaController::delete/$1');
});

$routes->group('costi_var', static function (RouteCollection $routes): void {
    $routes->get('/', 'CostiVarController::index');
    $routes->post('datatable', 'CostiVarController::datatable');
    $routes->get('view/(:segment)', 'CostiVarController::view/$1');
    $routes->get('create', 'CostiVarController::create');
    $routes->post('store', 'CostiVarController::store');
    $routes->get('edit/(:segment)', 'CostiVarController::edit/$1');
    $routes->post('update/(:segment)', 'CostiVarController::update/$1');
    $routes->post('delete/(:segment)', 'CostiVarController::delete/$1');
});

$routes->group('doc_file', static function (RouteCollection $routes): void {
    $routes->get('/', 'DocFileController::index');
    $routes->post('datatable', 'DocFileController::datatable');
    $routes->get('view/(:segment)', 'DocFileController::view/$1');
    $routes->get('create', 'DocFileController::create');
    $routes->post('store', 'DocFileController::store');
    $routes->get('edit/(:segment)', 'DocFileController::edit/$1');
    $routes->post('update/(:segment)', 'DocFileController::update/$1');
    $routes->post('delete/(:segment)', 'DocFileController::delete/$1');
});

$routes->group('ef_price_table', static function (RouteCollection $routes): void {
    $routes->get('/', 'EfPriceTableController::index');
    $routes->post('datatable', 'EfPriceTableController::datatable');
    $routes->get('view/(:segment)', 'EfPriceTableController::view/$1');
    $routes->get('create', 'EfPriceTableController::create');
    $routes->post('store', 'EfPriceTableController::store');
    $routes->get('edit/(:segment)', 'EfPriceTableController::edit/$1');
    $routes->post('update/(:segment)', 'EfPriceTableController::update/$1');
    $routes->post('delete/(:segment)', 'EfPriceTableController::delete/$1');
});

$routes->group('ef_tipologia', static function (RouteCollection $routes): void {
    $routes->get('/', 'EfTipologiumController::index');
    $routes->post('datatable', 'EfTipologiumController::datatable');
    $routes->get('view/(:segment)', 'EfTipologiumController::view/$1');
    $routes->get('create', 'EfTipologiumController::create');
    $routes->post('store', 'EfTipologiumController::store');
    $routes->get('edit/(:segment)', 'EfTipologiumController::edit/$1');
    $routes->post('update/(:segment)', 'EfTipologiumController::update/$1');
    $routes->post('delete/(:segment)', 'EfTipologiumController::delete/$1');
});

$routes->group('email_ai_history', static function (RouteCollection $routes): void {
    $routes->get('/', 'EmailAiHistoryController::index');
    $routes->post('datatable', 'EmailAiHistoryController::datatable');
    $routes->get('view/(:segment)', 'EmailAiHistoryController::view/$1');
    $routes->get('create', 'EmailAiHistoryController::create');
    $routes->post('store', 'EmailAiHistoryController::store');
    $routes->get('edit/(:segment)', 'EmailAiHistoryController::edit/$1');
    $routes->post('update/(:segment)', 'EmailAiHistoryController::update/$1');
    $routes->post('delete/(:segment)', 'EmailAiHistoryController::delete/$1');
});

$routes->group('emails', static function (RouteCollection $routes): void {
    $routes->get('/', 'EmailController::index');
    $routes->post('datatable', 'EmailController::datatable');
    $routes->get('view/(:segment)', 'EmailController::view/$1');
    $routes->get('create', 'EmailController::create');
    $routes->post('store', 'EmailController::store');
    $routes->get('edit/(:segment)', 'EmailController::edit/$1');
    $routes->post('update/(:segment)', 'EmailController::update/$1');
    $routes->post('delete/(:segment)', 'EmailController::delete/$1');
});

$routes->group('foglio_giorno', static function (RouteCollection $routes): void {
    $routes->get('/', 'FoglioGiornoController::index');
    $routes->post('datatable', 'FoglioGiornoController::datatable');
    $routes->get('view/(:segment)', 'FoglioGiornoController::view/$1');
    $routes->get('create', 'FoglioGiornoController::create');
    $routes->post('store', 'FoglioGiornoController::store');
    $routes->get('edit/(:segment)', 'FoglioGiornoController::edit/$1');
    $routes->post('update/(:segment)', 'FoglioGiornoController::update/$1');
    $routes->post('delete/(:segment)', 'FoglioGiornoController::delete/$1');
});

$routes->group('guasti', static function (RouteCollection $routes): void {
    $routes->get('/', 'GuastusController::index');
    $routes->post('datatable', 'GuastusController::datatable');
    $routes->get('view/(:segment)', 'GuastusController::view/$1');
    $routes->get('create', 'GuastusController::create');
    $routes->post('store', 'GuastusController::store');
    $routes->get('edit/(:segment)', 'GuastusController::edit/$1');
    $routes->post('update/(:segment)', 'GuastusController::update/$1');
    $routes->post('delete/(:segment)', 'GuastusController::delete/$1');
});

$routes->group('hotels', static function (RouteCollection $routes): void {
    $routes->get('/', 'HotelController::index');
    $routes->post('datatable', 'HotelController::datatable');
    $routes->get('view/(:segment)', 'HotelController::view/$1');
    $routes->get('create', 'HotelController::create');
    $routes->post('store', 'HotelController::store');
    $routes->get('edit/(:segment)', 'HotelController::edit/$1');
    $routes->post('update/(:segment)', 'HotelController::update/$1');
    $routes->post('delete/(:segment)', 'HotelController::delete/$1');
});

$routes->group('images', static function (RouteCollection $routes): void {
    $routes->get('/', 'ImageController::index');
    $routes->post('datatable', 'ImageController::datatable');
    $routes->get('view/(:segment)', 'ImageController::view/$1');
    $routes->get('create', 'ImageController::create');
    $routes->post('store', 'ImageController::store');
    $routes->get('edit/(:segment)', 'ImageController::edit/$1');
    $routes->post('update/(:segment)', 'ImageController::update/$1');
    $routes->post('delete/(:segment)', 'ImageController::delete/$1');
});

$routes->group('lettere', static function (RouteCollection $routes): void {
    $routes->get('/', 'LettereController::index');
    $routes->post('datatable', 'LettereController::datatable');
    $routes->get('view/(:segment)', 'LettereController::view/$1');
    $routes->get('create', 'LettereController::create');
    $routes->post('store', 'LettereController::store');
    $routes->get('edit/(:segment)', 'LettereController::edit/$1');
    $routes->post('update/(:segment)', 'LettereController::update/$1');
    $routes->post('delete/(:segment)', 'LettereController::delete/$1');
});

$routes->group('listino_nome_obmp', static function (RouteCollection $routes): void {
    $routes->get('/', 'ListinoNomeObmpController::index');
    $routes->post('datatable', 'ListinoNomeObmpController::datatable');
    $routes->get('view/(:segment)', 'ListinoNomeObmpController::view/$1');
    $routes->get('create', 'ListinoNomeObmpController::create');
    $routes->post('store', 'ListinoNomeObmpController::store');
    $routes->get('edit/(:segment)', 'ListinoNomeObmpController::edit/$1');
    $routes->post('update/(:segment)', 'ListinoNomeObmpController::update/$1');
    $routes->post('delete/(:segment)', 'ListinoNomeObmpController::delete/$1');
});

$routes->group('listino_obmp', static function (RouteCollection $routes): void {
    $routes->get('/', 'ListinoObmpController::index');
    $routes->post('datatable', 'ListinoObmpController::datatable');
    $routes->get('view/(:segment)', 'ListinoObmpController::view/$1');
    $routes->get('create', 'ListinoObmpController::create');
    $routes->post('store', 'ListinoObmpController::store');
    $routes->get('edit/(:segment)', 'ListinoObmpController::edit/$1');
    $routes->post('update/(:segment)', 'ListinoObmpController::update/$1');
    $routes->post('delete/(:segment)', 'ListinoObmpController::delete/$1');
});

$routes->group('listino_periodi_obmp', static function (RouteCollection $routes): void {
    $routes->get('/', 'ListinoPeriodiObmpController::index');
    $routes->post('datatable', 'ListinoPeriodiObmpController::datatable');
    $routes->get('view/(:segment)', 'ListinoPeriodiObmpController::view/$1');
    $routes->get('create', 'ListinoPeriodiObmpController::create');
    $routes->post('store', 'ListinoPeriodiObmpController::store');
    $routes->get('edit/(:segment)', 'ListinoPeriodiObmpController::edit/$1');
    $routes->post('update/(:segment)', 'ListinoPeriodiObmpController::update/$1');
    $routes->post('delete/(:segment)', 'ListinoPeriodiObmpController::delete/$1');
});

$routes->group('log_in', static function (RouteCollection $routes): void {
    $routes->get('/', 'LogInController::index');
    $routes->post('datatable', 'LogInController::datatable');
    $routes->get('view/(:segment)', 'LogInController::view/$1');
    $routes->get('create', 'LogInController::create');
    $routes->post('store', 'LogInController::store');
    $routes->get('edit/(:segment)', 'LogInController::edit/$1');
    $routes->post('update/(:segment)', 'LogInController::update/$1');
    $routes->post('delete/(:segment)', 'LogInController::delete/$1');
});

$routes->group('log_obmp', static function (RouteCollection $routes): void {
    $routes->get('/', 'LogObmpController::index');
    $routes->post('datatable', 'LogObmpController::datatable');
    $routes->get('view/(:segment)', 'LogObmpController::view/$1');
    $routes->get('create', 'LogObmpController::create');
    $routes->post('store', 'LogObmpController::store');
    $routes->get('edit/(:segment)', 'LogObmpController::edit/$1');
    $routes->post('update/(:segment)', 'LogObmpController::update/$1');
    $routes->post('delete/(:segment)', 'LogObmpController::delete/$1');
});

$routes->group('log_obmp_full', static function (RouteCollection $routes): void {
    $routes->get('/', 'LogObmpFullController::index');
    $routes->post('datatable', 'LogObmpFullController::datatable');
    $routes->get('view/(:segment)', 'LogObmpFullController::view/$1');
    $routes->get('create', 'LogObmpFullController::create');
    $routes->post('store', 'LogObmpFullController::store');
    $routes->get('edit/(:segment)', 'LogObmpFullController::edit/$1');
    $routes->post('update/(:segment)', 'LogObmpFullController::update/$1');
    $routes->post('delete/(:segment)', 'LogObmpFullController::delete/$1');
});

$routes->group('log_richieste', static function (RouteCollection $routes): void {
    $routes->get('/', 'LogRichiesteController::index');
    $routes->post('datatable', 'LogRichiesteController::datatable');
    $routes->get('view/(:segment)', 'LogRichiesteController::view/$1');
    $routes->get('create', 'LogRichiesteController::create');
    $routes->post('store', 'LogRichiesteController::store');
    $routes->get('edit/(:segment)', 'LogRichiesteController::edit/$1');
    $routes->post('update/(:segment)', 'LogRichiesteController::update/$1');
    $routes->post('delete/(:segment)', 'LogRichiesteController::delete/$1');
});

$routes->group('manutenzioni', static function (RouteCollection $routes): void {
    $routes->get('/', 'ManutenzioniController::index');
    $routes->post('datatable', 'ManutenzioniController::datatable');
    $routes->get('view/(:segment)', 'ManutenzioniController::view/$1');
    $routes->get('create', 'ManutenzioniController::create');
    $routes->post('store', 'ManutenzioniController::store');
    $routes->get('edit/(:segment)', 'ManutenzioniController::edit/$1');
    $routes->post('update/(:segment)', 'ManutenzioniController::update/$1');
    $routes->post('delete/(:segment)', 'ManutenzioniController::delete/$1');
});

$routes->group('modifica_agenda', static function (RouteCollection $routes): void {
    $routes->get('/', 'ModificaAgendaController::index');
    $routes->post('datatable', 'ModificaAgendaController::datatable');
    $routes->get('view/(:segment)', 'ModificaAgendaController::view/$1');
    $routes->get('create', 'ModificaAgendaController::create');
    $routes->post('store', 'ModificaAgendaController::store');
    $routes->get('edit/(:segment)', 'ModificaAgendaController::edit/$1');
    $routes->post('update/(:segment)', 'ModificaAgendaController::update/$1');
    $routes->post('delete/(:segment)', 'ModificaAgendaController::delete/$1');
});

$routes->group('modifica_conti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ModificaContusController::index');
    $routes->post('datatable', 'ModificaContusController::datatable');
    $routes->get('view/(:segment)', 'ModificaContusController::view/$1');
    $routes->get('create', 'ModificaContusController::create');
    $routes->post('store', 'ModificaContusController::store');
    $routes->get('edit/(:segment)', 'ModificaContusController::edit/$1');
    $routes->post('update/(:segment)', 'ModificaContusController::update/$1');
    $routes->post('delete/(:segment)', 'ModificaContusController::delete/$1');
});

$routes->group('nazioni', static function (RouteCollection $routes): void {
    $routes->get('/', 'NazioniController::index');
    $routes->post('datatable', 'NazioniController::datatable');
    $routes->get('view/(:segment)', 'NazioniController::view/$1');
    $routes->get('create', 'NazioniController::create');
    $routes->post('store', 'NazioniController::store');
    $routes->get('edit/(:segment)', 'NazioniController::edit/$1');
    $routes->post('update/(:segment)', 'NazioniController::update/$1');
    $routes->post('delete/(:segment)', 'NazioniController::delete/$1');
});

$routes->group('nazioni_bandiera', static function (RouteCollection $routes): void {
    $routes->get('/', 'NazioniBandieraController::index');
    $routes->post('datatable', 'NazioniBandieraController::datatable');
    $routes->get('view/(:segment)', 'NazioniBandieraController::view/$1');
    $routes->get('create', 'NazioniBandieraController::create');
    $routes->post('store', 'NazioniBandieraController::store');
    $routes->get('edit/(:segment)', 'NazioniBandieraController::edit/$1');
    $routes->post('update/(:segment)', 'NazioniBandieraController::update/$1');
    $routes->post('delete/(:segment)', 'NazioniBandieraController::delete/$1');
});

$routes->group('nazioni_linque', static function (RouteCollection $routes): void {
    $routes->get('/', 'NazioniLinqueController::index');
    $routes->post('datatable', 'NazioniLinqueController::datatable');
    $routes->get('view/(:segment)', 'NazioniLinqueController::view/$1');
    $routes->get('create', 'NazioniLinqueController::create');
    $routes->post('store', 'NazioniLinqueController::store');
    $routes->get('edit/(:segment)', 'NazioniLinqueController::edit/$1');
    $routes->post('update/(:segment)', 'NazioniLinqueController::update/$1');
    $routes->post('delete/(:segment)', 'NazioniLinqueController::delete/$1');
});

$routes->group('note_utente', static function (RouteCollection $routes): void {
    $routes->get('/', 'NoteUtenteController::index');
    $routes->post('datatable', 'NoteUtenteController::datatable');
    $routes->get('view/(:segment)', 'NoteUtenteController::view/$1');
    $routes->get('create', 'NoteUtenteController::create');
    $routes->post('store', 'NoteUtenteController::store');
    $routes->get('edit/(:segment)', 'NoteUtenteController::edit/$1');
    $routes->post('update/(:segment)', 'NoteUtenteController::update/$1');
    $routes->post('delete/(:segment)', 'NoteUtenteController::delete/$1');
});

$routes->group('obmp_affiliati', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpAffiliatusController::index');
    $routes->post('datatable', 'ObmpAffiliatusController::datatable');
    $routes->get('view/(:segment)', 'ObmpAffiliatusController::view/$1');
    $routes->get('create', 'ObmpAffiliatusController::create');
    $routes->post('store', 'ObmpAffiliatusController::store');
    $routes->get('edit/(:segment)', 'ObmpAffiliatusController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpAffiliatusController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpAffiliatusController::delete/$1');
});

$routes->group('obmp_board', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpBoardController::index');
    $routes->post('datatable', 'ObmpBoardController::datatable');
    $routes->get('view/(:segment)', 'ObmpBoardController::view/$1');
    $routes->get('create', 'ObmpBoardController::create');
    $routes->post('store', 'ObmpBoardController::store');
    $routes->get('edit/(:segment)', 'ObmpBoardController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpBoardController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpBoardController::delete/$1');
});

$routes->group('obmp_cancellations', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCancellationController::index');
    $routes->post('datatable', 'ObmpCancellationController::datatable');
    $routes->get('view/(:segment)', 'ObmpCancellationController::view/$1');
    $routes->get('create', 'ObmpCancellationController::create');
    $routes->post('store', 'ObmpCancellationController::store');
    $routes->get('edit/(:segment)', 'ObmpCancellationController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpCancellationController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpCancellationController::delete/$1');
});

$routes->group('obmp_clienti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpClientusController::index');
    $routes->post('datatable', 'ObmpClientusController::datatable');
    $routes->get('view/(:segment)', 'ObmpClientusController::view/$1');
    $routes->get('create', 'ObmpClientusController::create');
    $routes->post('store', 'ObmpClientusController::store');
    $routes->get('edit/(:segment)', 'ObmpClientusController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpClientusController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpClientusController::delete/$1');
});

$routes->group('obmp_cm', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCmController::index');
    $routes->post('datatable', 'ObmpCmController::datatable');
    $routes->get('view/(:segment)', 'ObmpCmController::view/$1');
    $routes->get('create', 'ObmpCmController::create');
    $routes->post('store', 'ObmpCmController::store');
    $routes->get('edit/(:segment)', 'ObmpCmController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpCmController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpCmController::delete/$1');
});

$routes->group('obmp_cm_lingue', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCmLingueController::index');
    $routes->post('datatable', 'ObmpCmLingueController::datatable');
    $routes->get('view/(:segment)', 'ObmpCmLingueController::view/$1');
    $routes->get('create', 'ObmpCmLingueController::create');
    $routes->post('store', 'ObmpCmLingueController::store');
    $routes->get('edit/(:segment)', 'ObmpCmLingueController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpCmLingueController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpCmLingueController::delete/$1');
});

$routes->group('obmp_cm_rooms', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCmRoomController::index');
    $routes->post('datatable', 'ObmpCmRoomController::datatable');
    $routes->get('view/(:segment)', 'ObmpCmRoomController::view/$1');
    $routes->get('create', 'ObmpCmRoomController::create');
    $routes->post('store', 'ObmpCmRoomController::store');
    $routes->get('edit/(:segment)', 'ObmpCmRoomController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpCmRoomController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpCmRoomController::delete/$1');
});

$routes->group('obmp_payments', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpPaymentController::index');
    $routes->post('datatable', 'ObmpPaymentController::datatable');
    $routes->get('view/(:segment)', 'ObmpPaymentController::view/$1');
    $routes->get('create', 'ObmpPaymentController::create');
    $routes->post('store', 'ObmpPaymentController::store');
    $routes->get('edit/(:segment)', 'ObmpPaymentController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpPaymentController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpPaymentController::delete/$1');
});

$routes->group('obmp_quote', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpQuoteController::index');
    $routes->post('datatable', 'ObmpQuoteController::datatable');
    $routes->get('view/(:segment)', 'ObmpQuoteController::view/$1');
    $routes->get('create', 'ObmpQuoteController::create');
    $routes->post('store', 'ObmpQuoteController::store');
    $routes->get('edit/(:segment)', 'ObmpQuoteController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpQuoteController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpQuoteController::delete/$1');
});

$routes->group('obmp_quote_sub', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpQuoteSubController::index');
    $routes->post('datatable', 'ObmpQuoteSubController::datatable');
    $routes->get('view/(:segment)', 'ObmpQuoteSubController::view/$1');
    $routes->get('create', 'ObmpQuoteSubController::create');
    $routes->post('store', 'ObmpQuoteSubController::store');
    $routes->get('edit/(:segment)', 'ObmpQuoteSubController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpQuoteSubController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpQuoteSubController::delete/$1');
});

$routes->group('obmp_rates', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRateController::index');
    $routes->post('datatable', 'ObmpRateController::datatable');
    $routes->get('view/(:segment)', 'ObmpRateController::view/$1');
    $routes->get('create', 'ObmpRateController::create');
    $routes->post('store', 'ObmpRateController::store');
    $routes->get('edit/(:segment)', 'ObmpRateController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpRateController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpRateController::delete/$1');
});

$routes->group('obmp_ref_event', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRefEventController::index');
    $routes->post('datatable', 'ObmpRefEventController::datatable');
    $routes->get('view/(:segment)', 'ObmpRefEventController::view/$1');
    $routes->get('create', 'ObmpRefEventController::create');
    $routes->post('store', 'ObmpRefEventController::store');
    $routes->get('edit/(:segment)', 'ObmpRefEventController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpRefEventController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpRefEventController::delete/$1');
});

$routes->group('obmp_ref_site', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRefSiteController::index');
    $routes->post('datatable', 'ObmpRefSiteController::datatable');
    $routes->get('view/(:segment)', 'ObmpRefSiteController::view/$1');
    $routes->get('create', 'ObmpRefSiteController::create');
    $routes->post('store', 'ObmpRefSiteController::store');
    $routes->get('edit/(:segment)', 'ObmpRefSiteController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpRefSiteController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpRefSiteController::delete/$1');
});

$routes->group('obmp_restrictions', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRestrictionController::index');
    $routes->post('datatable', 'ObmpRestrictionController::datatable');
    $routes->get('view/(:segment)', 'ObmpRestrictionController::view/$1');
    $routes->get('create', 'ObmpRestrictionController::create');
    $routes->post('store', 'ObmpRestrictionController::store');
    $routes->get('edit/(:segment)', 'ObmpRestrictionController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpRestrictionController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpRestrictionController::delete/$1');
});

$routes->group('obmp_review', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpReviewController::index');
    $routes->post('datatable', 'ObmpReviewController::datatable');
    $routes->get('view/(:segment)', 'ObmpReviewController::view/$1');
    $routes->get('create', 'ObmpReviewController::create');
    $routes->post('store', 'ObmpReviewController::store');
    $routes->get('edit/(:segment)', 'ObmpReviewController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpReviewController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpReviewController::delete/$1');
});

$routes->group('pagamenti_sospesi', static function (RouteCollection $routes): void {
    $routes->get('/', 'PagamentiSospesiController::index');
    $routes->post('datatable', 'PagamentiSospesiController::datatable');
    $routes->get('view/(:segment)', 'PagamentiSospesiController::view/$1');
    $routes->get('create', 'PagamentiSospesiController::create');
    $routes->post('store', 'PagamentiSospesiController::store');
    $routes->get('edit/(:segment)', 'PagamentiSospesiController::edit/$1');
    $routes->post('update/(:segment)', 'PagamentiSospesiController::update/$1');
    $routes->post('delete/(:segment)', 'PagamentiSospesiController::delete/$1');
});

$routes->group('parsed_emails', static function (RouteCollection $routes): void {
    $routes->get('/', 'ParsedEmailController::index');
    $routes->post('datatable', 'ParsedEmailController::datatable');
    $routes->get('view/(:segment)', 'ParsedEmailController::view/$1');
    $routes->get('create', 'ParsedEmailController::create');
    $routes->post('store', 'ParsedEmailController::store');
    $routes->get('edit/(:segment)', 'ParsedEmailController::edit/$1');
    $routes->post('update/(:segment)', 'ParsedEmailController::update/$1');
    $routes->post('delete/(:segment)', 'ParsedEmailController::delete/$1');
});

$routes->group('pratiche', static function (RouteCollection $routes): void {
    $routes->get('/', 'PraticheController::index');
    $routes->post('datatable', 'PraticheController::datatable');
    $routes->get('view/(:segment)', 'PraticheController::view/$1');
    $routes->get('create', 'PraticheController::create');
    $routes->post('store', 'PraticheController::store');
    $routes->get('edit/(:segment)', 'PraticheController::edit/$1');
    $routes->post('update/(:segment)', 'PraticheController::update/$1');
    $routes->post('delete/(:segment)', 'PraticheController::delete/$1');
});

$routes->group('pratiche_rif', static function (RouteCollection $routes): void {
    $routes->get('/', 'PraticheRifController::index');
    $routes->post('datatable', 'PraticheRifController::datatable');
    $routes->get('view/(:segment)', 'PraticheRifController::view/$1');
    $routes->get('create', 'PraticheRifController::create');
    $routes->post('store', 'PraticheRifController::store');
    $routes->get('edit/(:segment)', 'PraticheRifController::edit/$1');
    $routes->post('update/(:segment)', 'PraticheRifController::update/$1');
    $routes->post('delete/(:segment)', 'PraticheRifController::delete/$1');
});

$routes->group('prezzi', static function (RouteCollection $routes): void {
    $routes->get('/', 'PrezziController::index');
    $routes->post('datatable', 'PrezziController::datatable');
    $routes->get('view/(:segment)', 'PrezziController::view/$1');
    $routes->get('create', 'PrezziController::create');
    $routes->post('store', 'PrezziController::store');
    $routes->get('edit/(:segment)', 'PrezziController::edit/$1');
    $routes->post('update/(:segment)', 'PrezziController::update/$1');
    $routes->post('delete/(:segment)', 'PrezziController::delete/$1');
});

$routes->group('prezzi_competitori', static function (RouteCollection $routes): void {
    $routes->get('/', 'PrezziCompetitorusController::index');
    $routes->post('datatable', 'PrezziCompetitorusController::datatable');
    $routes->get('view/(:segment)', 'PrezziCompetitorusController::view/$1');
    $routes->get('create', 'PrezziCompetitorusController::create');
    $routes->post('store', 'PrezziCompetitorusController::store');
    $routes->get('edit/(:segment)', 'PrezziCompetitorusController::edit/$1');
    $routes->post('update/(:segment)', 'PrezziCompetitorusController::update/$1');
    $routes->post('delete/(:segment)', 'PrezziCompetitorusController::delete/$1');
});

$routes->group('prodotti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ProdottusController::index');
    $routes->post('datatable', 'ProdottusController::datatable');
    $routes->get('view/(:segment)', 'ProdottusController::view/$1');
    $routes->get('create', 'ProdottusController::create');
    $routes->post('store', 'ProdottusController::store');
    $routes->get('edit/(:segment)', 'ProdottusController::edit/$1');
    $routes->post('update/(:segment)', 'ProdottusController::update/$1');
    $routes->post('delete/(:segment)', 'ProdottusController::delete/$1');
});

$routes->group('prodotti_lista', static function (RouteCollection $routes): void {
    $routes->get('/', 'ProdottiListumController::index');
    $routes->post('datatable', 'ProdottiListumController::datatable');
    $routes->get('view/(:segment)', 'ProdottiListumController::view/$1');
    $routes->get('create', 'ProdottiListumController::create');
    $routes->post('store', 'ProdottiListumController::store');
    $routes->get('edit/(:segment)', 'ProdottiListumController::edit/$1');
    $routes->post('update/(:segment)', 'ProdottiListumController::update/$1');
    $routes->post('delete/(:segment)', 'ProdottiListumController::delete/$1');
});

$routes->group('products', static function (RouteCollection $routes): void {
    $routes->get('/', 'ProductController::index');
    $routes->post('datatable', 'ProductController::datatable');
    $routes->get('view/(:segment)', 'ProductController::view/$1');
    $routes->get('create', 'ProductController::create');
    $routes->post('store', 'ProductController::store');
    $routes->get('edit/(:segment)', 'ProductController::edit/$1');
    $routes->post('update/(:segment)', 'ProductController::update/$1');
    $routes->post('delete/(:segment)', 'ProductController::delete/$1');
});

$routes->group('province', static function (RouteCollection $routes): void {
    $routes->get('/', 'ProvinceController::index');
    $routes->post('datatable', 'ProvinceController::datatable');
    $routes->get('view/(:segment)', 'ProvinceController::view/$1');
    $routes->get('create', 'ProvinceController::create');
    $routes->post('store', 'ProvinceController::store');
    $routes->get('edit/(:segment)', 'ProvinceController::edit/$1');
    $routes->post('update/(:segment)', 'ProvinceController::update/$1');
    $routes->post('delete/(:segment)', 'ProvinceController::delete/$1');
});

$routes->group('pulizia', static function (RouteCollection $routes): void {
    $routes->get('/', 'PuliziumController::index');
    $routes->post('datatable', 'PuliziumController::datatable');
    $routes->get('view/(:segment)', 'PuliziumController::view/$1');
    $routes->get('create', 'PuliziumController::create');
    $routes->post('store', 'PuliziumController::store');
    $routes->get('edit/(:segment)', 'PuliziumController::edit/$1');
    $routes->post('update/(:segment)', 'PuliziumController::update/$1');
    $routes->post('delete/(:segment)', 'PuliziumController::delete/$1');
});

$routes->group('punti_spesi', static function (RouteCollection $routes): void {
    $routes->get('/', 'PuntiSpesiController::index');
    $routes->post('datatable', 'PuntiSpesiController::datatable');
    $routes->get('view/(:segment)', 'PuntiSpesiController::view/$1');
    $routes->get('create', 'PuntiSpesiController::create');
    $routes->post('store', 'PuntiSpesiController::store');
    $routes->get('edit/(:segment)', 'PuntiSpesiController::edit/$1');
    $routes->post('update/(:segment)', 'PuntiSpesiController::update/$1');
    $routes->post('delete/(:segment)', 'PuntiSpesiController::delete/$1');
});

$routes->group('question', static function (RouteCollection $routes): void {
    $routes->get('/', 'QuestionController::index');
    $routes->post('datatable', 'QuestionController::datatable');
    $routes->get('view/(:segment)', 'QuestionController::view/$1');
    $routes->get('create', 'QuestionController::create');
    $routes->post('store', 'QuestionController::store');
    $routes->get('edit/(:segment)', 'QuestionController::edit/$1');
    $routes->post('update/(:segment)', 'QuestionController::update/$1');
    $routes->post('delete/(:segment)', 'QuestionController::delete/$1');
});

$routes->group('question_rew', static function (RouteCollection $routes): void {
    $routes->get('/', 'QuestionRewController::index');
    $routes->post('datatable', 'QuestionRewController::datatable');
    $routes->get('view/(:segment)', 'QuestionRewController::view/$1');
    $routes->get('create', 'QuestionRewController::create');
    $routes->post('store', 'QuestionRewController::store');
    $routes->get('edit/(:segment)', 'QuestionRewController::edit/$1');
    $routes->post('update/(:segment)', 'QuestionRewController::update/$1');
    $routes->post('delete/(:segment)', 'QuestionRewController::delete/$1');
});

$routes->group('ref_agenda_clienti', static function (RouteCollection $routes): void {
    $routes->get('/', 'RefAgendaClientusController::index');
    $routes->post('datatable', 'RefAgendaClientusController::datatable');
    $routes->get('view/(:segment)', 'RefAgendaClientusController::view/$1');
    $routes->get('create', 'RefAgendaClientusController::create');
    $routes->post('store', 'RefAgendaClientusController::store');
    $routes->get('edit/(:segment)', 'RefAgendaClientusController::edit/$1');
    $routes->post('update/(:segment)', 'RefAgendaClientusController::update/$1');
    $routes->post('delete/(:segment)', 'RefAgendaClientusController::delete/$1');
});

$routes->group('ref_agenzia_listini', static function (RouteCollection $routes): void {
    $routes->get('/', 'RefAgenziaListiniController::index');
    $routes->post('datatable', 'RefAgenziaListiniController::datatable');
    $routes->get('view/(:segment)', 'RefAgenziaListiniController::view/$1');
    $routes->get('create', 'RefAgenziaListiniController::create');
    $routes->post('store', 'RefAgenziaListiniController::store');
    $routes->get('edit/(:segment)', 'RefAgenziaListiniController::edit/$1');
    $routes->post('update/(:segment)', 'RefAgenziaListiniController::update/$1');
    $routes->post('delete/(:segment)', 'RefAgenziaListiniController::delete/$1');
});

$routes->group('ref_agenzia_preno', static function (RouteCollection $routes): void {
    $routes->get('/', 'RefAgenziaPrenoController::index');
    $routes->post('datatable', 'RefAgenziaPrenoController::datatable');
    $routes->get('view/(:segment)', 'RefAgenziaPrenoController::view/$1');
    $routes->get('create', 'RefAgenziaPrenoController::create');
    $routes->post('store', 'RefAgenziaPrenoController::store');
    $routes->get('edit/(:segment)', 'RefAgenziaPrenoController::edit/$1');
    $routes->post('update/(:segment)', 'RefAgenziaPrenoController::update/$1');
    $routes->post('delete/(:segment)', 'RefAgenziaPrenoController::delete/$1');
});

$routes->group('ref_costi_tipologia', static function (RouteCollection $routes): void {
    $routes->get('/', 'RefCostiTipologiumController::index');
    $routes->post('datatable', 'RefCostiTipologiumController::datatable');
    $routes->get('view/(:segment)', 'RefCostiTipologiumController::view/$1');
    $routes->get('create', 'RefCostiTipologiumController::create');
    $routes->post('store', 'RefCostiTipologiumController::store');
    $routes->get('edit/(:segment)', 'RefCostiTipologiumController::edit/$1');
    $routes->post('update/(:segment)', 'RefCostiTipologiumController::update/$1');
    $routes->post('delete/(:segment)', 'RefCostiTipologiumController::delete/$1');
});

$routes->group('ref_obmp_booking', static function (RouteCollection $routes): void {
    $routes->get('/', 'RefObmpBookingController::index');
    $routes->post('datatable', 'RefObmpBookingController::datatable');
    $routes->get('view/(:segment)', 'RefObmpBookingController::view/$1');
    $routes->get('create', 'RefObmpBookingController::create');
    $routes->post('store', 'RefObmpBookingController::store');
    $routes->get('edit/(:segment)', 'RefObmpBookingController::edit/$1');
    $routes->post('update/(:segment)', 'RefObmpBookingController::update/$1');
    $routes->post('delete/(:segment)', 'RefObmpBookingController::delete/$1');
});

$routes->group('refer_clienti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ReferClientusController::index');
    $routes->post('datatable', 'ReferClientusController::datatable');
    $routes->get('view/(:segment)', 'ReferClientusController::view/$1');
    $routes->get('create', 'ReferClientusController::create');
    $routes->post('store', 'ReferClientusController::store');
    $routes->get('edit/(:segment)', 'ReferClientusController::edit/$1');
    $routes->post('update/(:segment)', 'ReferClientusController::update/$1');
    $routes->post('delete/(:segment)', 'ReferClientusController::delete/$1');
});

$routes->group('regioni', static function (RouteCollection $routes): void {
    $routes->get('/', 'RegioniController::index');
    $routes->post('datatable', 'RegioniController::datatable');
    $routes->get('view/(:segment)', 'RegioniController::view/$1');
    $routes->get('create', 'RegioniController::create');
    $routes->post('store', 'RegioniController::store');
    $routes->get('edit/(:segment)', 'RegioniController::edit/$1');
    $routes->post('update/(:segment)', 'RegioniController::update/$1');
    $routes->post('delete/(:segment)', 'RegioniController::delete/$1');
});

$routes->group('registro_ps', static function (RouteCollection $routes): void {
    $routes->get('/', 'RegistroPController::index');
    $routes->post('datatable', 'RegistroPController::datatable');
    $routes->get('view/(:segment)', 'RegistroPController::view/$1');
    $routes->get('create', 'RegistroPController::create');
    $routes->post('store', 'RegistroPController::store');
    $routes->get('edit/(:segment)', 'RegistroPController::edit/$1');
    $routes->post('update/(:segment)', 'RegistroPController::update/$1');
    $routes->post('delete/(:segment)', 'RegistroPController::delete/$1');
});

$routes->group('shifts', static function (RouteCollection $routes): void {
    $routes->get('/', 'ShiftController::index');
    $routes->post('datatable', 'ShiftController::datatable');
    $routes->get('view/(:segment)', 'ShiftController::view/$1');
    $routes->get('create', 'ShiftController::create');
    $routes->post('store', 'ShiftController::store');
    $routes->get('edit/(:segment)', 'ShiftController::edit/$1');
    $routes->post('update/(:segment)', 'ShiftController::update/$1');
    $routes->post('delete/(:segment)', 'ShiftController::delete/$1');
});

$routes->group('sidae', static function (RouteCollection $routes): void {
    $routes->get('/', 'SidaeController::index');
    $routes->post('datatable', 'SidaeController::datatable');
    $routes->get('view/(:segment)', 'SidaeController::view/$1');
    $routes->get('create', 'SidaeController::create');
    $routes->post('store', 'SidaeController::store');
    $routes->get('edit/(:segment)', 'SidaeController::edit/$1');
    $routes->post('update/(:segment)', 'SidaeController::update/$1');
    $routes->post('delete/(:segment)', 'SidaeController::delete/$1');
});

$routes->group('sospesi', static function (RouteCollection $routes): void {
    $routes->get('/', 'SospesiController::index');
    $routes->post('datatable', 'SospesiController::datatable');
    $routes->get('view/(:segment)', 'SospesiController::view/$1');
    $routes->get('create', 'SospesiController::create');
    $routes->post('store', 'SospesiController::store');
    $routes->get('edit/(:segment)', 'SospesiController::edit/$1');
    $routes->post('update/(:segment)', 'SospesiController::update/$1');
    $routes->post('delete/(:segment)', 'SospesiController::delete/$1');
});

$routes->group('staff', static function (RouteCollection $routes): void {
    $routes->get('/', 'StaffController::index');
    $routes->post('datatable', 'StaffController::datatable');
    $routes->get('view/(:segment)', 'StaffController::view/$1');
    $routes->get('create', 'StaffController::create');
    $routes->post('store', 'StaffController::store');
    $routes->get('edit/(:segment)', 'StaffController::edit/$1');
    $routes->post('update/(:segment)', 'StaffController::update/$1');
    $routes->post('delete/(:segment)', 'StaffController::delete/$1');
});

$routes->group('tax_pagamento', static function (RouteCollection $routes): void {
    $routes->get('/', 'TaxPagamentoController::index');
    $routes->post('datatable', 'TaxPagamentoController::datatable');
    $routes->get('view/(:segment)', 'TaxPagamentoController::view/$1');
    $routes->get('create', 'TaxPagamentoController::create');
    $routes->post('store', 'TaxPagamentoController::store');
    $routes->get('edit/(:segment)', 'TaxPagamentoController::edit/$1');
    $routes->post('update/(:segment)', 'TaxPagamentoController::update/$1');
    $routes->post('delete/(:segment)', 'TaxPagamentoController::delete/$1');
});

$routes->group('tex_lingue', static function (RouteCollection $routes): void {
    $routes->get('/', 'TexLingueController::index');
    $routes->post('datatable', 'TexLingueController::datatable');
    $routes->get('view/(:segment)', 'TexLingueController::view/$1');
    $routes->get('create', 'TexLingueController::create');
    $routes->post('store', 'TexLingueController::store');
    $routes->get('edit/(:segment)', 'TexLingueController::edit/$1');
    $routes->post('update/(:segment)', 'TexLingueController::update/$1');
    $routes->post('delete/(:segment)', 'TexLingueController::delete/$1');
});

$routes->group('tip_doc', static function (RouteCollection $routes): void {
    $routes->get('/', 'TipDocController::index');
    $routes->post('datatable', 'TipDocController::datatable');
    $routes->get('view/(:segment)', 'TipDocController::view/$1');
    $routes->get('create', 'TipDocController::create');
    $routes->post('store', 'TipDocController::store');
    $routes->get('edit/(:segment)', 'TipDocController::edit/$1');
    $routes->post('update/(:segment)', 'TipDocController::update/$1');
    $routes->post('delete/(:segment)', 'TipDocController::delete/$1');
});

$routes->group('tipoallogiati', static function (RouteCollection $routes): void {
    $routes->get('/', 'TipoallogiatusController::index');
    $routes->post('datatable', 'TipoallogiatusController::datatable');
    $routes->get('view/(:segment)', 'TipoallogiatusController::view/$1');
    $routes->get('create', 'TipoallogiatusController::create');
    $routes->post('store', 'TipoallogiatusController::store');
    $routes->get('edit/(:segment)', 'TipoallogiatusController::edit/$1');
    $routes->post('update/(:segment)', 'TipoallogiatusController::update/$1');
    $routes->post('delete/(:segment)', 'TipoallogiatusController::delete/$1');
});

$routes->group('tipologia_camera', static function (RouteCollection $routes): void {
    $routes->get('/', 'TipologiaCameraController::index');
    $routes->post('datatable', 'TipologiaCameraController::datatable');
    $routes->get('view/(:segment)', 'TipologiaCameraController::view/$1');
    $routes->get('create', 'TipologiaCameraController::create');
    $routes->post('store', 'TipologiaCameraController::store');
    $routes->get('edit/(:segment)', 'TipologiaCameraController::edit/$1');
    $routes->post('update/(:segment)', 'TipologiaCameraController::update/$1');
    $routes->post('delete/(:segment)', 'TipologiaCameraController::delete/$1');
});

$routes->group('token', static function (RouteCollection $routes): void {
    $routes->get('/', 'TokenController::index');
    $routes->post('datatable', 'TokenController::datatable');
    $routes->get('view/(:segment)', 'TokenController::view/$1');
    $routes->get('create', 'TokenController::create');
    $routes->post('store', 'TokenController::store');
    $routes->get('edit/(:segment)', 'TokenController::edit/$1');
    $routes->post('update/(:segment)', 'TokenController::update/$1');
    $routes->post('delete/(:segment)', 'TokenController::delete/$1');
});

$routes->group('utenti', static function (RouteCollection $routes): void {
    $routes->get('/', 'UtentusController::index');
    $routes->post('datatable', 'UtentusController::datatable');
    $routes->get('view/(:segment)', 'UtentusController::view/$1');
    $routes->get('create', 'UtentusController::create');
    $routes->post('store', 'UtentusController::store');
    $routes->get('edit/(:segment)', 'UtentusController::edit/$1');
    $routes->post('update/(:segment)', 'UtentusController::update/$1');
    $routes->post('delete/(:segment)', 'UtentusController::delete/$1');
});

$routes->group('win_booking', static function (RouteCollection $routes): void {
    $routes->get('/', 'WinBookingController::index');
    $routes->post('datatable', 'WinBookingController::datatable');
    $routes->get('view/(:segment)', 'WinBookingController::view/$1');
    $routes->get('create', 'WinBookingController::create');
    $routes->post('store', 'WinBookingController::store');
    $routes->get('edit/(:segment)', 'WinBookingController::edit/$1');
    $routes->post('update/(:segment)', 'WinBookingController::update/$1');
    $routes->post('delete/(:segment)', 'WinBookingController::delete/$1');
});

$routes->group('woucher', static function (RouteCollection $routes): void {
    $routes->get('/', 'WoucherController::index');
    $routes->post('datatable', 'WoucherController::datatable');
    $routes->get('view/(:segment)', 'WoucherController::view/$1');
    $routes->get('create', 'WoucherController::create');
    $routes->post('store', 'WoucherController::store');
    $routes->get('edit/(:segment)', 'WoucherController::edit/$1');
    $routes->post('update/(:segment)', 'WoucherController::update/$1');
    $routes->post('delete/(:segment)', 'WoucherController::delete/$1');
});

$routes->group('wreh_order_details', static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehOrderDetailController::index');
    $routes->post('datatable', 'WrehOrderDetailController::datatable');
    $routes->get('view/(:segment)', 'WrehOrderDetailController::view/$1');
    $routes->get('create', 'WrehOrderDetailController::create');
    $routes->post('store', 'WrehOrderDetailController::store');
    $routes->get('edit/(:segment)', 'WrehOrderDetailController::edit/$1');
    $routes->post('update/(:segment)', 'WrehOrderDetailController::update/$1');
    $routes->post('delete/(:segment)', 'WrehOrderDetailController::delete/$1');
});

$routes->group('wreh_orders', static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehOrderController::index');
    $routes->post('datatable', 'WrehOrderController::datatable');
    $routes->get('view/(:segment)', 'WrehOrderController::view/$1');
    $routes->get('create', 'WrehOrderController::create');
    $routes->post('store', 'WrehOrderController::store');
    $routes->get('edit/(:segment)', 'WrehOrderController::edit/$1');
    $routes->post('update/(:segment)', 'WrehOrderController::update/$1');
    $routes->post('delete/(:segment)', 'WrehOrderController::delete/$1');
});

$routes->group('wreh_products', static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehProductController::index');
    $routes->post('datatable', 'WrehProductController::datatable');
    $routes->get('view/(:segment)', 'WrehProductController::view/$1');
    $routes->get('create', 'WrehProductController::create');
    $routes->post('store', 'WrehProductController::store');
    $routes->get('edit/(:segment)', 'WrehProductController::edit/$1');
    $routes->post('update/(:segment)', 'WrehProductController::update/$1');
    $routes->post('delete/(:segment)', 'WrehProductController::delete/$1');
});

$routes->group('wreh_suppliers', static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehSupplierController::index');
    $routes->post('datatable', 'WrehSupplierController::datatable');
    $routes->get('view/(:segment)', 'WrehSupplierController::view/$1');
    $routes->get('create', 'WrehSupplierController::create');
    $routes->post('store', 'WrehSupplierController::store');
    $routes->get('edit/(:segment)', 'WrehSupplierController::edit/$1');
    $routes->post('update/(:segment)', 'WrehSupplierController::update/$1');
    $routes->post('delete/(:segment)', 'WrehSupplierController::delete/$1');
});

require APPPATH . 'Config/MyCrudRoutes.php';
