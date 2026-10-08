<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:make-service-command')]
#[Description('Command description')]
class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name : The name of the service}';

    protected $description = 'Create a new service class';

    protected $type = 'Service';

    protected function getStub()
    {
        return __DIR__.'/stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Services';
    }
}
