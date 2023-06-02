<?php

namespace App\Overrides\CrudGenerator\Common;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use InfyOm\Generator\DTOs\GeneratorNamespaces;
use InfyOm\Generator\DTOs\GeneratorOptions;
use InfyOm\Generator\DTOs\GeneratorPaths;
use InfyOm\Generator\DTOs\GeneratorPrefixes;
use InfyOm\Generator\DTOs\ModelNames;

class GeneratorConfig extends \InfyOm\Generator\Common\GeneratorConfig
{
    public function prepareTable()
    {
        if ($this->getOption('table')) {
            $this->tableName = $this->getOption('table');
        } else {
            $this->tableName = $this->modelNames->snakePlural;
        }

        if ($this->getOption('primary')) {
            $this->primaryName = $this->getOption('primary');
        } else {
            $this->primaryName = 'uuid';
        }

        if ($this->getOption('connection')) {
            $this->connection = $this->getOption('connection');
        }
    }
}
