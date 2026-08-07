<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configurazione del menu applicativo generata da myCrudGpt.
 *
 * Questo file appartiene al sito finale e non dipende dal generatore.
 * Puoi cambiare liberamente tipo, gruppi, etichette, icone, route e ordine.
 */
final class Menu extends BaseConfig
{
    /** Renderer predefinito: vertical oppure horizontal. */
    public string $type = 'vertical';

    /** @var list<array<string, mixed>> */
    public array $groups = array (
  0 => 
  array (
    'label' => 'Prodotti',
    'icon' => 'bi-folder2-open',
    'order' => 10,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Adebiti',
        'route' => 'adebiti',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'adebiti',
      ),
      1 => 
      array (
        'label' => 'Prodotti',
        'route' => 'prodotti',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'prodotti',
      ),
      2 => 
      array (
        'label' => 'Prodotti Lista',
        'route' => 'prodotti_lista',
        'icon' => 'bi-table',
        'order' => 30,
        'table' => 'prodotti_lista',
      ),
    ),
  ),
  1 => 
  array (
    'label' => 'Agenzie',
    'icon' => 'bi-folder2-open',
    'order' => 20,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Agenda',
        'route' => 'agenda',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'agenda',
      ),
      1 => 
      array (
        'label' => 'Agenzie',
        'route' => 'agenzie',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'agenzie',
      ),
      2 => 
      array (
        'label' => 'Obmp Cm',
        'route' => 'obmp_cm',
        'icon' => 'bi-table',
        'order' => 30,
        'table' => 'obmp_cm',
      ),
      3 => 
      array (
        'label' => 'Obmp Ref Event',
        'route' => 'obmp_ref_event',
        'icon' => 'bi-table',
        'order' => 40,
        'table' => 'obmp_ref_event',
      ),
      4 => 
      array (
        'label' => 'Pratiche',
        'route' => 'pratiche',
        'icon' => 'bi-table',
        'order' => 50,
        'table' => 'pratiche',
      ),
      5 => 
      array (
        'label' => 'Sospesi',
        'route' => 'sospesi',
        'icon' => 'bi-table',
        'order' => 60,
        'table' => 'sospesi',
      ),
    ),
  ),
  2 => 
  array (
    'label' => 'Agenzia Listini',
    'icon' => 'bi-folder2-open',
    'order' => 30,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Agenzia Listini',
        'route' => 'agenzia_listini',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'agenzia_listini',
      ),
      1 => 
      array (
        'label' => 'Agenzia Prezzi',
        'route' => 'agenzia_prezzi',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'agenzia_prezzi',
      ),
      2 => 
      array (
        'label' => 'Ref Agenzia Listini',
        'route' => 'ref_agenzia_listini',
        'icon' => 'bi-table',
        'order' => 30,
        'table' => 'ref_agenzia_listini',
      ),
    ),
  ),
  3 => 
  array (
    'label' => 'Principale',
    'icon' => 'bi-folder2-open',
    'order' => 40,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'App Ip',
        'route' => 'app_ip',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'app_ip',
      ),
      1 => 
      array (
        'label' => 'Banca Hotel',
        'route' => 'banca_hotel',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'banca_hotel',
      ),
      2 => 
      array (
        'label' => 'Black List',
        'route' => 'black_list',
        'icon' => 'bi-table',
        'order' => 30,
        'table' => 'black_list',
      ),
      3 => 
      array (
        'label' => 'Camere Nesting',
        'route' => 'camere_nesting',
        'icon' => 'bi-table',
        'order' => 40,
        'table' => 'camere_nesting',
      ),
      4 => 
      array (
        'label' => 'Cax Motivo',
        'route' => 'cax_motivo',
        'icon' => 'bi-table',
        'order' => 50,
        'table' => 'cax_motivo',
      ),
      5 => 
      array (
        'label' => 'Checklist Preno',
        'route' => 'checklist_preno',
        'icon' => 'bi-table',
        'order' => 60,
        'table' => 'checklist_preno',
      ),
      6 => 
      array (
        'label' => 'Ci Sessions',
        'route' => 'ci_sessions',
        'icon' => 'bi-table',
        'order' => 70,
        'table' => 'ci_sessions',
      ),
      7 => 
      array (
        'label' => 'Codici Stato',
        'route' => 'codici_stato',
        'icon' => 'bi-table',
        'order' => 80,
        'table' => 'codici_stato',
      ),
      8 => 
      array (
        'label' => 'Competitori',
        'route' => 'competitori',
        'icon' => 'bi-table',
        'order' => 90,
        'table' => 'competitori',
      ),
      9 => 
      array (
        'label' => 'Comuni',
        'route' => 'comuni',
        'icon' => 'bi-table',
        'order' => 100,
        'table' => 'comuni',
      ),
      10 => 
      array (
        'label' => 'Ef Price Table',
        'route' => 'ef_price_table',
        'icon' => 'bi-table',
        'order' => 110,
        'table' => 'ef_price_table',
      ),
      11 => 
      array (
        'label' => 'Ef Tipologia',
        'route' => 'ef_tipologia',
        'icon' => 'bi-table',
        'order' => 120,
        'table' => 'ef_tipologia',
      ),
      12 => 
      array (
        'label' => 'Email Ai History',
        'route' => 'email_ai_history',
        'icon' => 'bi-table',
        'order' => 130,
        'table' => 'email_ai_history',
      ),
      13 => 
      array (
        'label' => 'Emails',
        'route' => 'emails',
        'icon' => 'bi-table',
        'order' => 140,
        'table' => 'emails',
      ),
      14 => 
      array (
        'label' => 'Lettere',
        'route' => 'lettere',
        'icon' => 'bi-table',
        'order' => 150,
        'table' => 'lettere',
      ),
      15 => 
      array (
        'label' => 'Log In',
        'route' => 'log_in',
        'icon' => 'bi-table',
        'order' => 160,
        'table' => 'log_in',
      ),
      16 => 
      array (
        'label' => 'Log Obmp',
        'route' => 'log_obmp',
        'icon' => 'bi-table',
        'order' => 170,
        'table' => 'log_obmp',
      ),
      17 => 
      array (
        'label' => 'Log Obmp Full',
        'route' => 'log_obmp_full',
        'icon' => 'bi-table',
        'order' => 180,
        'table' => 'log_obmp_full',
      ),
      18 => 
      array (
        'label' => 'Log Richieste',
        'route' => 'log_richieste',
        'icon' => 'bi-table',
        'order' => 190,
        'table' => 'log_richieste',
      ),
      19 => 
      array (
        'label' => 'Manutenzioni',
        'route' => 'manutenzioni',
        'icon' => 'bi-table',
        'order' => 200,
        'table' => 'manutenzioni',
      ),
      20 => 
      array (
        'label' => 'Nazioni',
        'route' => 'nazioni',
        'icon' => 'bi-table',
        'order' => 210,
        'table' => 'nazioni',
      ),
      21 => 
      array (
        'label' => 'Nazioni Bandiera',
        'route' => 'nazioni_bandiera',
        'icon' => 'bi-table',
        'order' => 220,
        'table' => 'nazioni_bandiera',
      ),
      22 => 
      array (
        'label' => 'Nazioni Linque',
        'route' => 'nazioni_linque',
        'icon' => 'bi-table',
        'order' => 230,
        'table' => 'nazioni_linque',
      ),
      23 => 
      array (
        'label' => 'Obmp Affiliati',
        'route' => 'obmp_affiliati',
        'icon' => 'bi-table',
        'order' => 240,
        'table' => 'obmp_affiliati',
      ),
      24 => 
      array (
        'label' => 'Parsed Emails',
        'route' => 'parsed_emails',
        'icon' => 'bi-table',
        'order' => 250,
        'table' => 'parsed_emails',
      ),
      25 => 
      array (
        'label' => 'Prezzi',
        'route' => 'prezzi',
        'icon' => 'bi-table',
        'order' => 260,
        'table' => 'prezzi',
      ),
      26 => 
      array (
        'label' => 'Prezzi Competitori',
        'route' => 'prezzi_competitori',
        'icon' => 'bi-table',
        'order' => 270,
        'table' => 'prezzi_competitori',
      ),
      27 => 
      array (
        'label' => 'Products',
        'route' => 'products',
        'icon' => 'bi-table',
        'order' => 280,
        'table' => 'products',
      ),
      28 => 
      array (
        'label' => 'Province',
        'route' => 'province',
        'icon' => 'bi-table',
        'order' => 290,
        'table' => 'province',
      ),
      29 => 
      array (
        'label' => 'Regioni',
        'route' => 'regioni',
        'icon' => 'bi-table',
        'order' => 300,
        'table' => 'regioni',
      ),
      30 => 
      array (
        'label' => 'Registro Ps',
        'route' => 'registro_ps',
        'icon' => 'bi-table',
        'order' => 310,
        'table' => 'registro_ps',
      ),
      31 => 
      array (
        'label' => 'Tex Lingue',
        'route' => 'tex_lingue',
        'icon' => 'bi-table',
        'order' => 320,
        'table' => 'tex_lingue',
      ),
      32 => 
      array (
        'label' => 'Tip Doc',
        'route' => 'tip_doc',
        'icon' => 'bi-table',
        'order' => 330,
        'table' => 'tip_doc',
      ),
      33 => 
      array (
        'label' => 'Tipoallogiati',
        'route' => 'tipoallogiati',
        'icon' => 'bi-table',
        'order' => 340,
        'table' => 'tipoallogiati',
      ),
      34 => 
      array (
        'label' => 'Token',
        'route' => 'token',
        'icon' => 'bi-table',
        'order' => 350,
        'table' => 'token',
      ),
      35 => 
      array (
        'label' => 'Win Booking',
        'route' => 'win_booking',
        'icon' => 'bi-table',
        'order' => 360,
        'table' => 'win_booking',
      ),
      36 => 
      array (
        'label' => 'Woucher',
        'route' => 'woucher',
        'icon' => 'bi-table',
        'order' => 370,
        'table' => 'woucher',
      ),
    ),
  ),
  4 => 
  array (
    'label' => 'Tipologia Camera',
    'icon' => 'bi-folder2-open',
    'order' => 50,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Camere',
        'route' => 'camere',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'camere',
      ),
      1 => 
      array (
        'label' => 'Tipologia Camera',
        'route' => 'tipologia_camera',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'tipologia_camera',
      ),
    ),
  ),
  5 => 
  array (
    'label' => 'Agenda',
    'icon' => 'bi-folder2-open',
    'order' => 60,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Cassa',
        'route' => 'cassa',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'cassa',
      ),
      1 => 
      array (
        'label' => 'Colori',
        'route' => 'colori',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'colori',
      ),
      2 => 
      array (
        'label' => 'Foglio Giorno',
        'route' => 'foglio_giorno',
        'icon' => 'bi-table',
        'order' => 30,
        'table' => 'foglio_giorno',
      ),
      3 => 
      array (
        'label' => 'Modifica Agenda',
        'route' => 'modifica_agenda',
        'icon' => 'bi-table',
        'order' => 40,
        'table' => 'modifica_agenda',
      ),
      4 => 
      array (
        'label' => 'Ref Agenda Clienti',
        'route' => 'ref_agenda_clienti',
        'icon' => 'bi-table',
        'order' => 50,
        'table' => 'ref_agenda_clienti',
      ),
      5 => 
      array (
        'label' => 'Ref Agenzia Preno',
        'route' => 'ref_agenzia_preno',
        'icon' => 'bi-table',
        'order' => 60,
        'table' => 'ref_agenzia_preno',
      ),
      6 => 
      array (
        'label' => 'Ref Obmp Booking',
        'route' => 'ref_obmp_booking',
        'icon' => 'bi-table',
        'order' => 70,
        'table' => 'ref_obmp_booking',
      ),
    ),
  ),
  6 => 
  array (
    'label' => 'Refer Clienti',
    'icon' => 'bi-folder2-open',
    'order' => 70,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Clienti',
        'route' => 'clienti',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'clienti',
      ),
    ),
  ),
  7 => 
  array (
    'label' => 'Camere',
    'icon' => 'bi-folder2-open',
    'order' => 80,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Conti',
        'route' => 'conti',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'conti',
      ),
      1 => 
      array (
        'label' => 'Guasti',
        'route' => 'guasti',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'guasti',
      ),
    ),
  ),
  8 => 
  array (
    'label' => 'Conti',
    'icon' => 'bi-folder2-open',
    'order' => 90,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Conti Note',
        'route' => 'conti_note',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'conti_note',
      ),
      1 => 
      array (
        'label' => 'Modifica Conti',
        'route' => 'modifica_conti',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'modifica_conti',
      ),
      2 => 
      array (
        'label' => 'Obmp Review',
        'route' => 'obmp_review',
        'icon' => 'bi-table',
        'order' => 30,
        'table' => 'obmp_review',
      ),
      3 => 
      array (
        'label' => 'Pulizia',
        'route' => 'pulizia',
        'icon' => 'bi-table',
        'order' => 40,
        'table' => 'pulizia',
      ),
      4 => 
      array (
        'label' => 'Refer Clienti',
        'route' => 'refer_clienti',
        'icon' => 'bi-table',
        'order' => 50,
        'table' => 'refer_clienti',
      ),
      5 => 
      array (
        'label' => 'Sidae',
        'route' => 'sidae',
        'icon' => 'bi-table',
        'order' => 60,
        'table' => 'sidae',
      ),
      6 => 
      array (
        'label' => 'Tax Pagamento',
        'route' => 'tax_pagamento',
        'icon' => 'bi-table',
        'order' => 70,
        'table' => 'tax_pagamento',
      ),
    ),
  ),
  9 => 
  array (
    'label' => 'Adebiti',
    'icon' => 'bi-folder2-open',
    'order' => 100,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Conti Trasferisci',
        'route' => 'conti_trasferisci',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'conti_trasferisci',
      ),
    ),
  ),
  10 => 
  array (
    'label' => 'Costi Area',
    'icon' => 'bi-folder2-open',
    'order' => 110,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Costi Area',
        'route' => 'costi_area',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'costi_area',
      ),
      1 => 
      array (
        'label' => 'Costi Var',
        'route' => 'costi_var',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'costi_var',
      ),
      2 => 
      array (
        'label' => 'Wreh Products',
        'route' => 'wreh_products',
        'icon' => 'bi-table',
        'order' => 30,
        'table' => 'wreh_products',
      ),
    ),
  ),
  11 => 
  array (
    'label' => 'Hotels',
    'icon' => 'bi-folder2-open',
    'order' => 120,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Doc File',
        'route' => 'doc_file',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'doc_file',
      ),
      1 => 
      array (
        'label' => 'Hotels',
        'route' => 'hotels',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'hotels',
      ),
    ),
  ),
  12 => 
  array (
    'label' => 'Obmp Cm Rooms',
    'icon' => 'bi-folder2-open',
    'order' => 130,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Images',
        'route' => 'images',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'images',
      ),
      1 => 
      array (
        'label' => 'Obmp Cm Lingue',
        'route' => 'obmp_cm_lingue',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'obmp_cm_lingue',
      ),
    ),
  ),
  13 => 
  array (
    'label' => 'Listino Nome Obmp',
    'icon' => 'bi-folder2-open',
    'order' => 140,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Listino Nome Obmp',
        'route' => 'listino_nome_obmp',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'listino_nome_obmp',
      ),
      1 => 
      array (
        'label' => 'Listino Obmp',
        'route' => 'listino_obmp',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'listino_obmp',
      ),
      2 => 
      array (
        'label' => 'Listino Periodi Obmp',
        'route' => 'listino_periodi_obmp',
        'icon' => 'bi-table',
        'order' => 30,
        'table' => 'listino_periodi_obmp',
      ),
    ),
  ),
  14 => 
  array (
    'label' => 'Utenti',
    'icon' => 'bi-folder2-open',
    'order' => 150,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Note Utente',
        'route' => 'note_utente',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'note_utente',
      ),
    ),
  ),
  15 => 
  array (
    'label' => 'Obmp Board',
    'icon' => 'bi-folder2-open',
    'order' => 160,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Obmp Board',
        'route' => 'obmp_board',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'obmp_board',
      ),
      1 => 
      array (
        'label' => 'Obmp Rates',
        'route' => 'obmp_rates',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'obmp_rates',
      ),
    ),
  ),
  16 => 
  array (
    'label' => 'Obmp Cancellations',
    'icon' => 'bi-folder2-open',
    'order' => 170,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Obmp Cancellations',
        'route' => 'obmp_cancellations',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'obmp_cancellations',
      ),
    ),
  ),
  17 => 
  array (
    'label' => 'Obmp Clienti',
    'icon' => 'bi-folder2-open',
    'order' => 180,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Obmp Clienti',
        'route' => 'obmp_clienti',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'obmp_clienti',
      ),
    ),
  ),
  18 => 
  array (
    'label' => 'Obmp Cm',
    'icon' => 'bi-folder2-open',
    'order' => 190,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Obmp Cm Rooms',
        'route' => 'obmp_cm_rooms',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'obmp_cm_rooms',
      ),
    ),
  ),
  19 => 
  array (
    'label' => 'Obmp Payments',
    'icon' => 'bi-folder2-open',
    'order' => 200,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Obmp Payments',
        'route' => 'obmp_payments',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'obmp_payments',
      ),
    ),
  ),
  20 => 
  array (
    'label' => 'Obmp Quote',
    'icon' => 'bi-folder2-open',
    'order' => 210,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Obmp Quote',
        'route' => 'obmp_quote',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'obmp_quote',
      ),
      1 => 
      array (
        'label' => 'Obmp Quote Sub',
        'route' => 'obmp_quote_sub',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'obmp_quote_sub',
      ),
    ),
  ),
  21 => 
  array (
    'label' => 'Obmp Ref Site',
    'icon' => 'bi-folder2-open',
    'order' => 220,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Obmp Ref Site',
        'route' => 'obmp_ref_site',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'obmp_ref_site',
      ),
    ),
  ),
  22 => 
  array (
    'label' => 'Obmp Restrictions',
    'icon' => 'bi-folder2-open',
    'order' => 230,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Obmp Restrictions',
        'route' => 'obmp_restrictions',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'obmp_restrictions',
      ),
    ),
  ),
  23 => 
  array (
    'label' => 'Sospesi',
    'icon' => 'bi-folder2-open',
    'order' => 240,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Pagamenti Sospesi',
        'route' => 'pagamenti_sospesi',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'pagamenti_sospesi',
      ),
    ),
  ),
  24 => 
  array (
    'label' => 'Pratiche',
    'icon' => 'bi-folder2-open',
    'order' => 250,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Pratiche Rif',
        'route' => 'pratiche_rif',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'pratiche_rif',
      ),
    ),
  ),
  25 => 
  array (
    'label' => 'Clienti',
    'icon' => 'bi-folder2-open',
    'order' => 260,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Punti Spesi',
        'route' => 'punti_spesi',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'punti_spesi',
      ),
    ),
  ),
  26 => 
  array (
    'label' => 'Question',
    'icon' => 'bi-folder2-open',
    'order' => 270,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Question',
        'route' => 'question',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'question',
      ),
      1 => 
      array (
        'label' => 'Question Rew',
        'route' => 'question_rew',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'question_rew',
      ),
    ),
  ),
  27 => 
  array (
    'label' => 'Costi Var',
    'icon' => 'bi-folder2-open',
    'order' => 280,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Ref Costi Tipologia',
        'route' => 'ref_costi_tipologia',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'ref_costi_tipologia',
      ),
    ),
  ),
  28 => 
  array (
    'label' => 'Staff',
    'icon' => 'bi-folder2-open',
    'order' => 290,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Shifts',
        'route' => 'shifts',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'shifts',
      ),
      1 => 
      array (
        'label' => 'Staff',
        'route' => 'staff',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'staff',
      ),
      2 => 
      array (
        'label' => 'Utenti',
        'route' => 'utenti',
        'icon' => 'bi-table',
        'order' => 30,
        'table' => 'utenti',
      ),
    ),
  ),
  29 => 
  array (
    'label' => 'Wreh Orders',
    'icon' => 'bi-folder2-open',
    'order' => 300,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Wreh Order Details',
        'route' => 'wreh_order_details',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'wreh_order_details',
      ),
      1 => 
      array (
        'label' => 'Wreh Orders',
        'route' => 'wreh_orders',
        'icon' => 'bi-table',
        'order' => 20,
        'table' => 'wreh_orders',
      ),
    ),
  ),
  30 => 
  array (
    'label' => 'Wreh Suppliers',
    'icon' => 'bi-folder2-open',
    'order' => 310,
    'items' => 
    array (
      0 => 
      array (
        'label' => 'Wreh Suppliers',
        'route' => 'wreh_suppliers',
        'icon' => 'bi-table',
        'order' => 10,
        'table' => 'wreh_suppliers',
      ),
    ),
  ),
);
}