<?php

namespace DNAFactory\Framework\Command\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

// TODO: create a generic Generator and extend it
class MakeCommandGeneratorCommand extends Command
{
    protected $signature = 'dna:make:command {moduleName} {className}';

    protected $description = 'Create a new command';

    protected $type = 'Command';

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

        $this->command($moduleName, $className);
    }

    protected function command($moduleName, $className)
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
            $this->getStub('command')
        );

        if (!file_exists(app_path($moduleName."/Command"))) {
            mkdir(app_path($moduleName."/Command"));
        }

        $filename = app_path($moduleName . "/Command/" . $className . ".php");
        if (!file_exists($filename)) {
            $this->output->success("Command creato con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Command già esistente");
        }
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . "/../../stubs/$type.stub");
    }
}
