<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud;

/**
 * Versione unica del generatore myCrudGpt.
 *
 * Tutti i comandi e i metadati devono leggere questa costante, evitando
 * numeri di versione duplicati in più file.
 */
final class MyCrudVersion
{
    public const VERSION = '2.8.0-dev13';

    private function __construct()
    {
    }
}
