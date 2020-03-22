<?php

namespace DNAFactory\Framework\Command\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

// TODO: create a generic Generator and extend it
class MakeEventBroadcastGeneratorCommand extends Command
{
    protected $signature = 'dna:make:event-broadcast {moduleName} {className}';

    protected $description = 'Create a new broadcast event';

    protected $type = 'Event';

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

        $this->event($moduleName, $className);
    }

    protected function event($moduleName, $className)
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
            $this->getStub('eventbroadcast')
        );

        if (!file_exists(app_path($moduleName."/Event"))) {
            mkdir(app_path($moduleName."/Event"));
        }

        $filename = app_path($moduleName . "/Event/" . $className . ".php");
        if (!file_exists($filename)) {
            $this->output->success("Event creato con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Event già esistente");
        }
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . "/../../stubs/$type.stub");
    }
}
