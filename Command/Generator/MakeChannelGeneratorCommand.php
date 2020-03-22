<?php

namespace DNAFactory\Framework\Command\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

// TODO: create a generic Generator and extend it
class MakeChannelGeneratorCommand extends Command
{
    protected $signature = 'dna:make:channel {moduleName} {className}';

    protected $description = 'Create a new channel';

    protected $type = 'Channel';

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

        $this->channel($moduleName, $className);
    }

    protected function channel($moduleName, $className)
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
            $this->getStub('channel')
        );

        if (!file_exists(app_path($moduleName."/Channel"))) {
            mkdir(app_path($moduleName."/Channel"));
        }

        $filename = app_path($moduleName . "/Channel/" . $className . ".php");
        if (!file_exists($filename)) {
            $this->output->success("Channel creato con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Channel già esistente");
        }
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . "/../../stubs/$type.stub");
    }
}
