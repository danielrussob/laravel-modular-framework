<?php

namespace DNAFactory\Framework\Command\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeModuleGenerator extends Command
{
    protected $signature = 'dna:make:module {moduleName}';

    protected $description = 'Create a new module';

    protected $type = 'Module';

    public function handle()
    {
        $moduleName = 'Modules/' . $this->argument('moduleName');

        $filename = app_path($moduleName);
        if (!file_exists($filename)) {
            mkdir($filename);
        }

        $this->helpers($moduleName);
        $this->routes($moduleName);
        $this->commands($moduleName);
        $this->di($moduleName);
        $this->providers($moduleName);
    }

    protected function helpers($moduleName)
    {
        $template = str_replace(
            [],
            [],
            $this->getStub('helpers')
        );

        $filename = app_path($moduleName . "/helpers.php");
        if (!file_exists($filename)) {
            $this->output->success("Helpers creato con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Helpers già esistente");
        }
    }

    protected function routes($moduleName)
    {
        $template = str_replace(
            [],
            [],
            $this->getStub('routes')
        );

        $filename = app_path($moduleName . "/routes.php");
        if (!file_exists($filename)) {
            $this->output->success("Routes creato con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Routes già esistente");
        }
    }

    protected function commands($moduleName)
    {
        $template = str_replace(
            [],
            [],
            $this->getStub('commands')
        );

        if (!file_exists(app_path($moduleName."/etc"))) {
            mkdir(app_path($moduleName."/etc"));
        }

        $filename = app_path($moduleName . "/etc/commands.php");
        if (!file_exists($filename)) {
            $this->output->success("Commands creata con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Commands già esistente");
        }
    }

    protected function di($moduleName)
    {
        $template = str_replace(
            [],
            [],
            $this->getStub('dis')
        );

        if (!file_exists(app_path($moduleName."/etc"))) {
            mkdir(app_path($moduleName."/etc"));
        }

        $filename = app_path($moduleName . "/etc/di.php");
        if (!file_exists($filename)) {
            $this->output->success("DI creata con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("DI già esistente");
        }
    }

    protected function providers($moduleName)
    {
        $template = str_replace(
            [],
            [],
            $this->getStub('providers')
        );

        if (!file_exists(app_path($moduleName."/etc"))) {
            mkdir(app_path($moduleName."/etc"));
        }

        $filename = app_path($moduleName . "/etc/providers.php");
        if (!file_exists($filename)) {
            $this->output->success("Providers creata con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Providers già esistente");
        }
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . "/../../stubs/$type.stub");
    }
}
