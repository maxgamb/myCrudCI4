<?php

namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class AutoCrudController extends BaseController
{
    public function generate(string $table)
    {
        try {
            $config = (new ConfigBuilder())->buildFromTable($table);
            $result = (new CrudGeneratorService())->generate($config, false);

            return view('mycrud/result', [
                'title'  => 'Generazione automatica',
                'table'  => $table,
                'result' => $result,
            ]);
        } catch (PageNotFoundException $e) {
            throw $e;
        } catch (Throwable $e) {
            log_message('error', '[myCrudGpt] {message}', ['message' => $e->getMessage()]);

            return redirect()
                ->to(site_url('mycrud'))
                ->with('error', $e->getMessage());
        }
    }
}
