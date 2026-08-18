<?php

declare(strict_types=1);

namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\AI\AiProjectContextGenerator;
use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\MyCrudVersion;
use Throwable;

/** Handles generation of the project map intended for AI agents. */
final class AiContextController extends BaseController
{
    public function index(): string
    {
        helper(['form', 'url']);

        return view('mycrud/ai_context', [
            'title' => 'Project AI context',
            'version' => MyCrudVersion::VERSION,
            'tables' => (new CrudConfigRepository())->tables(),
            'result' => null,
            'error' => null,
        ]);
    }

    public function generate(): string
    {
        helper(['form', 'url']);
        $repository = new CrudConfigRepository();
        $table = trim((string) $this->request->getPost('table'));

        try {
            $generator = new AiProjectContextGenerator();
            $result = $table === ''
                ? $generator->generateProject()
                : $generator->generateCrud($table);

            return view('mycrud/ai_context', [
                'title' => 'Project AI context',
                'version' => MyCrudVersion::VERSION,
                'tables' => $repository->tables(),
                'result' => $result,
                'error' => null,
            ]);
        } catch (Throwable $exception) {
            return view('mycrud/ai_context', [
                'title' => 'Project AI context',
                'version' => MyCrudVersion::VERSION,
                'tables' => $repository->tables(),
                'result' => null,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
