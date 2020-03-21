<?php

namespace DNAFactory\Framework\Command\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MakeTriadGenerator extends Command
{
    protected $signature = 'dna:make:triad {moduleName} {className} {tableName}';

    protected $description = 'Create a new triad';

    protected $type = 'Triad';

    public function handle()
    {
        $moduleName = 'Modules/' . $this->argument('moduleName');
        $className = $this->argument('className');
        $tableName = $this->argument('tableName');

        $filename = app_path($moduleName);
        if (!file_exists($filename)) {
            Artisan::call('dna:make:module', [
                'moduleName' => $this->argument('moduleName')
            ]);
        }

        $this->factory($moduleName, $className, $tableName);
        $this->factoryInterface($moduleName, $className, $tableName);

        $this->repository($moduleName, $className, $tableName);
        $this->repositoryInterface($moduleName, $className, $tableName);

        $this->model($moduleName, $className, $tableName);
        $this->modelInterface($moduleName, $className, $tableName);

        $this->migration($moduleName, $className, $tableName);

        $this->di($moduleName, $className, $tableName);
    }

    protected function migration($moduleName, $className, $tableName)
    {
        $template = str_replace(
            [
                'DummyModuleName',
                'DummyClass',
            ],
            [
                str_replace("/", "\\", $moduleName),
                $className,
            ],
            $this->getStub('migration')
        );

        if (!file_exists(app_path($moduleName."/migrations"))) {
            mkdir(app_path($moduleName."/migrations"));
        }

        $filename = app_path($moduleName . "/migrations/2000_01_01_999999_create_" . strtolower($className) . "_table.php");
        if (!file_exists($filename)) {
            $this->output->success("Migration creata con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Migration già esistente");
        }
    }

    protected function di($moduleName, $className, $tableName)
    {
        $template = str_replace(
            [
                'DummyModuleName',
                'DummyClass',
            ],
            [
                str_replace("/", "\\", $moduleName),
                $className,
            ],
            $this->getStub('di')
        );

        $this->getOutput()->writeln("Add to DI:");
        $this->getOutput()->writeln($template);
    }



    protected function repository($moduleName, $className, $tableName)
    {
        $template = str_replace(
            [
                'DummyModuleName',
                'DummyClass',
            ],
            [
                str_replace("/", "\\", $moduleName),
                $className,
            ],
            $this->getStub('repository')
        );

        if (!file_exists(app_path($moduleName."/Repository"))) {
            mkdir(app_path($moduleName."/Repository"));
        }

        $filename = app_path($moduleName . "/Repository/" . $className . "Repository.php");
        if (!file_exists($filename)) {
            $this->output->success("Repository creata con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Repository già esistente");
        }
    }

    protected function repositoryInterface($moduleName, $className, $tableName)
    {
        $template = str_replace(
            [
                'DummyModuleName',
                'DummyClass',
            ],
            [
                str_replace("/", "\\", $moduleName),
                $className,
            ],
            $this->getStub('repositoryinterface')
        );

        if (!file_exists(app_path($moduleName."/Api"))) {
            mkdir(app_path($moduleName."/Api"));
        }

        $filename = app_path($moduleName . "/Api/" . $className . "RepositoryInterface.php");
        if (!file_exists($filename)) {
            $this->output->success("Repository Interface creata con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Repository Interface già esistente");
        }
    }

    protected function factory($moduleName, $className, $tableName)
    {
        $template = str_replace(
            [
                'DummyModuleName',
                'DummyClass',
            ],
            [
                str_replace("/", "\\", $moduleName),
                $className,
            ],
            $this->getStub('factory')
        );

        if (!file_exists(app_path($moduleName."/Factory"))) {
            mkdir(app_path($moduleName."/Factory"));
        }

        $filename = app_path($moduleName . "/Factory/" . $className . "Factory.php");
        if (!file_exists($filename)) {
            $this->output->success("Factory creata con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Factory già esistente");
        }
    }

    protected function factoryInterface($moduleName, $className, $tableName)
    {
        $template = str_replace(
            [
                'DummyModuleName',
                'DummyClass',
            ],
            [
                str_replace("/", "\\", $moduleName),
                $className,
            ],
            $this->getStub('factoryinterface')
        );

        if (!file_exists(app_path($moduleName."/Api"))) {
            mkdir(app_path($moduleName."/Api"));
        }

        $filename = app_path($moduleName . "/Api/" . $className . "FactoryInterface.php");
        if (!file_exists($filename)) {
            $this->output->success("FactoryInterface creata con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("FactoryInterface già esistente");
        }
    }

    protected function model($moduleName, $className, $tableName)
    {
        $template = str_replace(
            [
                'DummyModuleName',
                'DummyClass',
                'DummyTableName'
            ],
            [
                str_replace("/", "\\", $moduleName),
                $className,
                $tableName
            ],
            $this->getStub('model')
        );

        if (!file_exists(app_path($moduleName."/Model"))) {
            mkdir(app_path($moduleName."/Model"));
        }

        $filename = app_path($moduleName . "/Model/" . $className . ".php");
        if (!file_exists($filename)) {
            $this->output->success("Model creata con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Model già esistente");
        }
    }

    protected function modelInterface($moduleName, $className, $tableName)
    {
        $template = str_replace(
            [
                'DummyModuleName',
                'DummyClass',
            ],
            [
                str_replace("/", "\\", $moduleName),
                $className,
            ],
            $this->getStub('modelinterface')
        );

        if (!file_exists(app_path($moduleName."/Api"))) {
            mkdir(app_path($moduleName."/Api"));
        }

        if (!file_exists(app_path($moduleName."/Api/Data"))) {
            mkdir(app_path($moduleName."/Api/Data"));
        }

        $filename = app_path($moduleName . "/Api/Data/" . $className . "Interface.php");
        if (!file_exists($filename)) {
            $this->output->success("ModelInterface creata con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("ModelInterface già esistente");
        }
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . "/../../stubs/$type.stub");
    }
}
