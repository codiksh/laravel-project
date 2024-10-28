<?php

namespace App\Overrides\CrudGenerator\Generators\Scaffold;

use Codiksh\Generator\Generators\ModelGenerator;

class RequestGenerator extends \Codiksh\Generator\Generators\Scaffold\RequestGenerator
{
    private string $masterFileName;

    private string $createFileName;

    private string $updateFileName;

    public function __construct()
    {
        parent::__construct();

        $this->path = $this->config->paths->request . $this->config->modelNames->name . "/";
        $this->masterFileName = 'MasterRequest.php';
        $this->createFileName = 'CreateRequest.php';
        $this->updateFileName = 'UpdateRequest.php';
    }

    public function generate()
    {
        $this->generateMasterRequest();
        $this->generateCreateRequest();
        $this->generateUpdateRequest();
    }

    protected function generateMasterRequest()
    {
        $templateData = view('laravel-generator::scaffold.request.master', $this->variables())->render();

        g_filesystem()->createFile($this->path.$this->masterFileName, $templateData);

        $this->config->commandComment(infy_nl().'Master Request created: ');
        $this->config->commandInfo($this->masterFileName);
    }

    protected function generateCreateRequest()
    {
        $templateData = view('laravel-generator::scaffold.request.create', $this->variables())->render();

        g_filesystem()->createFile($this->path.$this->createFileName, $templateData);

        $this->config->commandComment(infy_nl().'Create Request created: ');
        $this->config->commandInfo($this->createFileName);
    }

    protected function generateUpdateRequest()
    {
        $modelGenerator = new ModelGenerator();
        $rules = $modelGenerator->generateUniqueRules();

        $templateData = view('laravel-generator::scaffold.request.update', [
            'uniqueRules' => $rules,
        ])->render();

        g_filesystem()->createFile($this->path.$this->updateFileName, $templateData);

        $this->config->commandComment(infy_nl().'Update Request created: ');
        $this->config->commandInfo($this->updateFileName);
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->masterFileName)) {
            $this->config->commandComment('Master Request file deleted: '.$this->masterFileName);
        }

        if ($this->rollbackFile($this->path, $this->createFileName)) {
            $this->config->commandComment('Create Request file deleted: '.$this->createFileName);
        }

        if ($this->rollbackFile($this->path, $this->updateFileName)) {
            $this->config->commandComment('Update Request file deleted: '.$this->updateFileName);
        }
    }
}
