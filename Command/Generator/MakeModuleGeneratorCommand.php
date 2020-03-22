<?php

namespace DNAFactory\Framework\Command\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

// TODO: create a generic Generator and extend it
class MakeModuleGeneratorCommand extends Command
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
        $this->web($moduleName);
        $this->api($moduleName);
        $this->channels($moduleName);
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

    protected function web($moduleName)
    {
        $template = str_replace(
            [],
            [],
            $this->getStub('web')
        );

        if (!file_exists(app_path($moduleName."/routes"))) {
            mkdir(app_path($moduleName."/routes"));
        }

        $filename = app_path($moduleName . "/routes/web.php");
        if (!file_exists($filename)) {
            $this->output->success("Web creato con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Web già esistente");
        }
    }

    protected function api($moduleName)
    {
        $template = str_replace(
            [],
            [],
            $this->getStub('api')
        );

        if (!file_exists(app_path($moduleName."/routes"))) {
            mkdir(app_path($moduleName."/routes"));
        }

        $filename = app_path($moduleName . "/routes/api.php");
        if (!file_exists($filename)) {
            $this->output->success("Api creato con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Api già esistente");
        }
    }

    protected function channels($moduleName)
    {
        $template = str_replace(
            [],
            [],
            $this->getStub('channels')
        );

        if (!file_exists(app_path($moduleName."/routes"))) {
            mkdir(app_path($moduleName."/routes"));
        }

        $filename = app_path($moduleName . "/routes/channels.php");
        if (!file_exists($filename)) {
            $this->output->success("Channels creato con successo");
            file_put_contents($filename, $template);
        } else {
            $this->output->warning("Channels già esistente");
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
