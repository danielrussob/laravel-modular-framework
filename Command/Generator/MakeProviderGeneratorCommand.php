<?php

namespace DNAFactory\Framework\Command\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

// TODO: create a generic Generator and extend it
class MakeProviderGeneratorCommand extends Command
{
    protected $signature = 'dna:make:provider {moduleName} {className}';

    protected $description = 'Create a new service provider';

    protected $type = 'Provider';

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

        $this->provider($moduleName, $className);
    }

    protected function provider($moduleName, $className)
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
            $this->getStub('provider')
        );

        if (!file_exists(app_path($moduleName."/Provider"))) {
            mkdir(app_path($moduleName."/Provider"));
        }

        $filename = app_path($moduleName . "/Provider/" . $className . ".php");
        if (!file_exists($filename)) {
            $this->output->success("Provider creato con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Provider già esistente");
        }
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . "/../../stubs/$type.stub");
    }
}
