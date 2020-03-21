<?php

namespace DNAFactory\Framework\Command\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

// TODO: create a generic Generator and extend it
class MakeControllerGeneratorCommand extends Command
{
    protected $signature = 'dna:make:controller {moduleName} {className}';

    protected $description = 'Create a new controller';

    protected $type = 'Controller';

    public function handle()
    {
        $moduleName = 'Modules/' . $this->argument('moduleName');
        $className = $this->argument('className');

        $filename = app_path($moduleName);
        if (!file_exists($filename)) {
            Artisan::call('dna:make:module', [
                'moduleName' => $this->argument('moduleName')
            ]);
        }

        $this->controller($moduleName, $className);
    }

    protected function controller($moduleName, $className)
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
            $this->getStub('controller')
        );

        if (!file_exists(app_path($moduleName."/Controller"))) {
            mkdir(app_path($moduleName."/Controller"));
        }

        $filename = app_path($moduleName . "/Controller/" . $className . ".php");
        if (!file_exists($filename)) {
            $this->output->success("Controller creato con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Controller già esistente");
        }
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . "/../../stubs/$type.stub");
    }
}
