<?php

namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\Schema\DbSchema;

class SchemaController extends BaseController
{
    public function index(?string $table = null)
    {
        return $this->response->setJSON(
            (new DbSchema())->getSchemaInfo($table)
        );
    }
}
