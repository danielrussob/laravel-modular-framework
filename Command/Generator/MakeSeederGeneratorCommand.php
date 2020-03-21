<?php

namespace DNAFactory\Framework\Command\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

// TODO: create a generic Generator and extend it
class MakeSeederGeneratorCommand extends Command
{
    protected $signature = 'dna:make:seeder {moduleName} {className}';

    protected $description = 'Create a new seeder';

    protected $type = 'Seeder';

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

        $this->seeder($moduleName, $className);
    }

    protected function seeder($moduleName, $className)
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
            $this->getStub('seeder')
        );

        if (!file_exists(app_path($moduleName."/Seed"))) {
            mkdir(app_path($moduleName."/Seed"));
        }

        $filename = app_path($moduleName . "/Seed/" . $className . ".php");
        if (!file_exists($filename)) {
            $this->output->success("Seed creato con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Seed già esistente");
        }
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . "/../../stubs/$type.stub");
    }
}
