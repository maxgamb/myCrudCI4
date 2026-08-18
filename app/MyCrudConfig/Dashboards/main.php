<?php

declare(strict_types=1);

/** myCrudCI4 persistent Dashboard configuration. */
return array (
  'name' => 'main',
  'title' => 'Application Dashboard',
  'route' => 'dashboard',
  'globalDateFilter' => 
  array (
    'enabled' => false,
    'label' => 'Period',
  ),
  'globalFilters' => 
  array (
  ),
  'widgets' => 
  array (
    0 => 
    array (
      'id' => 'widget_msyfe6h8_wbnso',
      'type' => 'kpi_count',
      'title' => '',
      'table' => 'film',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => '',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'recentFields' => 
      array (
        0 => 'film_id',
        1 => 'title',
        2 => 'description',
        3 => 'release_year',
        4 => 'language_id',
        5 => 'original_language_id',
      ),
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filterField' => '',
      'filterOperator' => 'eq',
      'filterValue' => '',
      'globalDateField' => '',
      'globalFilterFields' => 
      array (
      ),
      'limit' => 5,
      'width' => 3,
    ),
    1 => 
    array (
      'id' => 'widget_msyfeaqr_xr89o',
      'type' => 'kpi_aggregate',
      'title' => '',
      'table' => 'film',
      'operation' => 'COUNT',
      'valueField' => 'rental_duration',
      'groupField' => '',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'recentFields' => 
      array (
        0 => 'film_id',
        1 => 'title',
        2 => 'description',
        3 => 'release_year',
        4 => 'language_id',
        5 => 'original_language_id',
      ),
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filterField' => '',
      'filterOperator' => 'eq',
      'filterValue' => '',
      'globalDateField' => '',
      'globalFilterFields' => 
      array (
      ),
      'limit' => 5,
      'width' => 3,
    ),
    2 => 
    array (
      'id' => 'widget_msyfeee6_t2yy9',
      'type' => 'quick_link',
      'title' => '',
      'table' => 'film',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => '',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'recentFields' => 
      array (
        0 => 'film_id',
        1 => 'title',
        2 => 'description',
        3 => 'release_year',
        4 => 'language_id',
        5 => 'original_language_id',
      ),
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filterField' => '',
      'filterOperator' => 'eq',
      'filterValue' => '',
      'globalDateField' => '',
      'globalFilterFields' => 
      array (
      ),
      'limit' => 5,
      'width' => 3,
    ),
    3 => 
    array (
      'id' => 'widget_msyfzl9f_bff96',
      'type' => 'kpi_count',
      'title' => '',
      'table' => 'country',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => '',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'recentFields' => 
      array (
        0 => 'country_id',
        1 => 'country',
        2 => 'last_update',
      ),
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filterField' => '',
      'filterOperator' => 'eq',
      'filterValue' => '',
      'globalDateField' => '',
      'globalFilterFields' => 
      array (
      ),
      'limit' => 5,
      'width' => 3,
    ),
    4 => 
    array (
      'id' => 'widget_msyfecza_fah6g',
      'type' => 'grouped_chart',
      'title' => '',
      'table' => 'film',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => 'rating',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'recentFields' => 
      array (
        0 => 'film_id',
        1 => 'title',
        2 => 'description',
        3 => 'release_year',
        4 => 'language_id',
        5 => 'original_language_id',
      ),
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filterField' => '',
      'filterOperator' => 'eq',
      'filterValue' => '',
      'globalDateField' => '',
      'globalFilterFields' => 
      array (
      ),
      'limit' => 5,
      'width' => 4,
    ),
    5 => 
    array (
      'id' => 'widget_msyfedu3_7x619',
      'type' => 'recent',
      'title' => '',
      'table' => 'film',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => '',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'recentFields' => 
      array (
        0 => 'film_id',
        1 => 'title',
        2 => 'description',
        3 => 'release_year',
        4 => 'language_id',
        5 => 'original_language_id',
      ),
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filterField' => '',
      'filterOperator' => 'eq',
      'filterValue' => '',
      'globalDateField' => '',
      'globalFilterFields' => 
      array (
      ),
      'limit' => 5,
      'width' => 4,
    ),
    6 => 
    array (
      'id' => 'widget_msyfsgxx_kjwr0',
      'type' => 'grouped_chart',
      'title' => '',
      'table' => 'actor',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => 'first_name',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'recentFields' => 
      array (
        0 => 'actor_id',
        1 => 'first_name',
        2 => 'last_name',
        3 => 'last_update',
      ),
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filterField' => '',
      'filterOperator' => 'eq',
      'filterValue' => '',
      'globalDateField' => '',
      'globalFilterFields' => 
      array (
      ),
      'limit' => 5,
      'width' => 4,
    ),
  ),
);
