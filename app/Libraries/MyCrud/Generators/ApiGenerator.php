<?php

namespace App\Libraries\MyCrud\Generators;

class ApiGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $api     = $config['classes']['api'];
        $service = $config['classes']['service'];
        $rules   = $config['classes']['rules'];
        $pk      = $config['primaryKey'];

        $content = <<<PHP
<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\\{$service};
use App\Validation\\{$rules};
use Throwable;

class {$api} extends BaseController
{
    private {$service} \$service;

    public function __construct()
    {
        \$this->service = new {$service}();
    }

    public function index()
    {
        return \$this->response->setJSON([
            'success' => true,
            'data'    => \$this->service->list(\$this->request->getGet()),
        ]);
    }

    public function show(int|string \$id)
    {
        try {
            return \$this->response->setJSON([
                'success' => true,
                'data'    => \$this->service->find(\$id),
            ]);
        } catch (Throwable \$e) {
            return \$this->response
                ->setStatusCode(404)
                ->setJSON(['success' => false, 'error' => \$e->getMessage()]);
        }
    }

    public function create()
    {
        \$data = \$this->request->getJSON(true) ?: \$this->request->getPost();

        if (!\$this->validateData(\$data, {$rules}::rules())) {
            return \$this->response
                ->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'errors'  => \$this->validator->getErrors(),
                ]);
        }

        try {
            \$id = \$this->service->create(\$data);

            return \$this->response
                ->setStatusCode(201)
                ->setJSON(['success' => true, '{$pk}' => \$id]);
        } catch (Throwable \$e) {
            return \$this->response
                ->setStatusCode(400)
                ->setJSON(['success' => false, 'error' => \$e->getMessage()]);
        }
    }

    public function update(int|string \$id)
    {
        \$data = \$this->request->getJSON(true) ?: \$this->request->getRawInput();

        if (!\$this->validateData(\$data, {$rules}::rules())) {
            return \$this->response
                ->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'errors'  => \$this->validator->getErrors(),
                ]);
        }

        try {
            \$this->service->update(\$id, \$data);

            return \$this->response->setJSON(['success' => true]);
        } catch (Throwable \$e) {
            return \$this->response
                ->setStatusCode(400)
                ->setJSON(['success' => false, 'error' => \$e->getMessage()]);
        }
    }

    public function delete(int|string \$id)
    {
        try {
            \$this->service->delete(\$id);

            return \$this->response->setJSON(['success' => true]);
        } catch (Throwable \$e) {
            return \$this->response
                ->setStatusCode(400)
                ->setJSON(['success' => false, 'error' => \$e->getMessage()]);
        }
    }
}

PHP;

        return $this->writeGenerated("Controllers/Api/{$api}.php", $content, $force);
    }
}
