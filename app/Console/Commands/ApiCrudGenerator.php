<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CrudGeneratorService\CrudGeneratorService;
class ApiCrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:generate {name : Class (Singular), e.g User, Place, Car}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all Crud operations with a single command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        CrudGeneratorService::MakeController($name);
        CrudGeneratorService::MakeModel($name);
        CrudGeneratorService::MakeMigration($name);
        CrudGeneratorService::MakeRoute($name);
        CrudGeneratorService::MakeProcessor($name);
        CrudGeneratorService::MakeTransformer($name);

        $this->info('Api Crud for '. $name. ' created successfully');
    }
}
