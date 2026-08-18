<?php

declare(strict_types=1);

namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\MyCrudVersion;

/**
 * Documentation interna del generatore.
 *
 * La pagina è volutamente statica: descrive il comportamento della versione
 * installata senza introdurre dipendenze runtime o query aggiuntive al DB.
 */
final class DocsController extends BaseController
{
    public function index()
    {
        helper('url');

        return view('mycrud/docs', [
            'title'   => 'Documentation myCrudCI4',
            'version' => MyCrudVersion::VERSION,
        ]);
    }
}
