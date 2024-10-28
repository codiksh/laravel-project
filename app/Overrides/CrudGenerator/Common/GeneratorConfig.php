<?php

namespace App\Overrides\CrudGenerator\Common;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Codiksh\Generator\DTOs\GeneratorNamespaces;
use Codiksh\Generator\DTOs\GeneratorOptions;
use Codiksh\Generator\DTOs\GeneratorPaths;
use Codiksh\Generator\DTOs\GeneratorPrefixes;
use Codiksh\Generator\DTOs\ModelNames;

class GeneratorConfig extends \Codiksh\Generator\Common\GeneratorConfig
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
