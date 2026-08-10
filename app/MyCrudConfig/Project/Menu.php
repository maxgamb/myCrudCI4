<?php

declare(strict_types=1);

/**
 * Configurazione persistente del Menu Builder myCrudGpt.
 * Il file descrive la navigazione scelta dallo sviluppatore.
 */
return array (
  'type' => 'vertical',
  'search' => true,
  'favorites' => true,
  'groups' => 
  array (
    0 => 
    array (
      'label' => 'Store',
      'icon' => 'bi-folder2-open',
      'order' => 10,
      'items' => 
      array (
        0 => 
        array (
          'label' => 'Store',
          'route' => 'store',
          'icon' => 'bi-table',
          'order' => 10,
          'favorite' => false,
          'table' => 'store',
        ),
      ),
      'subgroups' => 
      array (
        0 => 
        array (
          'label' => 'inventory',
          'order' => 10,
          'items' => 
          array (
            0 => 
            array (
              'label' => 'Inventory',
              'route' => 'inventory',
              'icon' => 'bi-table',
              'order' => 10,
              'favorite' => false,
              'table' => 'inventory',
            ),
          ),
        ),
      ),
    ),
    1 => 
    array (
      'label' => 'Customer',
      'icon' => 'bi-folder2-open',
      'order' => 20,
      'items' => 
      array (
        0 => 
        array (
          'label' => 'Customer',
          'route' => 'customer',
          'icon' => 'bi-table',
          'order' => 10,
          'favorite' => false,
          'table' => 'customer',
        ),
      ),
      'subgroups' => 
      array (
      ),
    ),
    2 => 
    array (
      'label' => 'Staff',
      'icon' => 'bi-folder2-open',
      'order' => 30,
      'items' => 
      array (
        0 => 
        array (
          'label' => 'Staff',
          'route' => 'staff',
          'icon' => 'bi-person-badge',
          'order' => 10,
          'favorite' => false,
          'table' => 'staff',
        ),
      ),
      'subgroups' => 
      array (
      ),
    ),
    3 => 
    array (
      'label' => 'Actor',
      'icon' => 'bi-folder2-open',
      'order' => 40,
      'items' => 
      array (
        0 => 
        array (
          'label' => 'Actor',
          'route' => 'actor',
          'icon' => 'bi-table',
          'order' => 10,
          'favorite' => false,
          'table' => 'actor',
        ),
        1 => 
        array (
          'label' => 'Actor Info',
          'route' => 'actor_info',
          'icon' => 'bi-table',
          'order' => 20,
          'favorite' => false,
          'table' => 'actor_info',
        ),
      ),
      'subgroups' => 
      array (
      ),
    ),
    4 => 
    array (
      'label' => 'Films',
      'icon' => 'bi-folder2-open',
      'order' => 50,
      'items' => 
      array (
        0 => 
        array (
          'label' => 'Film',
          'route' => 'film',
          'icon' => 'bi-table',
          'order' => 10,
          'favorite' => false,
          'table' => 'film',
        ),
        1 => 
        array (
          'label' => 'Category',
          'route' => 'category',
          'icon' => 'bi-table',
          'order' => 20,
          'favorite' => false,
          'table' => 'category',
        ),
        2 => 
        array (
          'label' => 'Language',
          'route' => 'language',
          'icon' => 'bi-table',
          'order' => 30,
          'favorite' => false,
          'table' => 'language',
        ),
      ),
      'subgroups' => 
      array (
      ),
    ),
    5 => 
    array (
      'label' => 'Rental',
      'icon' => 'bi-folder2-open',
      'order' => 60,
      'items' => 
      array (
        0 => 
        array (
          'label' => 'Rental',
          'route' => 'rental',
          'icon' => 'bi-table',
          'order' => 10,
          'favorite' => false,
          'table' => 'rental',
        ),
      ),
      'subgroups' => 
      array (
      ),
    ),
    6 => 
    array (
      'label' => 'Payment',
      'icon' => 'bi-folder2-open',
      'order' => 70,
      'items' => 
      array (
        0 => 
        array (
          'label' => 'Payment',
          'route' => 'payment',
          'icon' => 'bi-credit-card',
          'order' => 10,
          'favorite' => false,
          'table' => 'payment',
        ),
      ),
      'subgroups' => 
      array (
      ),
    ),
    7 => 
    array (
      'label' => 'Address',
      'icon' => 'bi-folder2-open',
      'order' => 80,
      'items' => 
      array (
        0 => 
        array (
          'label' => 'Address',
          'route' => 'address',
          'icon' => 'bi-table',
          'order' => 10,
          'favorite' => false,
          'table' => 'address',
        ),
        1 => 
        array (
          'label' => 'Country',
          'route' => 'country',
          'icon' => 'bi-table',
          'order' => 20,
          'favorite' => false,
          'table' => 'country',
        ),
        2 => 
        array (
          'label' => 'City',
          'route' => 'city',
          'icon' => 'bi-table',
          'order' => 30,
          'favorite' => false,
          'table' => 'city',
        ),
      ),
      'subgroups' => 
      array (
      ),
    ),
    8 => 
    array (
      'label' => 'pivot',
      'icon' => 'bi-folder2-open',
      'order' => 90,
      'items' => 
      array (
        0 => 
        array (
          'label' => 'Film Actor',
          'route' => 'film_actor',
          'icon' => 'bi-table',
          'order' => 10,
          'favorite' => false,
          'table' => 'film_actor',
        ),
        1 => 
        array (
          'label' => 'Film List',
          'route' => 'film_list',
          'icon' => 'bi-table',
          'order' => 20,
          'favorite' => false,
          'table' => 'film_list',
        ),
        2 => 
        array (
          'label' => 'Sales By Store',
          'route' => 'sales_by_store',
          'icon' => 'bi-table',
          'order' => 30,
          'favorite' => false,
          'table' => 'sales_by_store',
        ),
      ),
      'subgroups' => 
      array (
      ),
    ),
  ),
  '_meta' => 
  array (
    'generatorVersion' => '2.8.0-dev26',
    'savedAt' => '2026-08-09T17:24:22+00:00',
  ),
);
