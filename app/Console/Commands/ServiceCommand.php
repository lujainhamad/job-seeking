<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;

class ServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new service ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $model = $this->option('model');
        $pipeline = $this->option('pipeline');
        
        
        $stub = File::get(resource_path("stubs/ServiceStub.stub"));

        
        $serviceStub = str_replace('{{ServiceName}}', $name, $stub);
        
        if(isset($model)) {
            if(!File::exists(app_path("Models/$model.php"))){
                $this->error("model $model is not exist");
                return;
            }
            $serviceStub = str_replace('{{model}}', "\$this->model = $model::class;", $serviceStub);
            $serviceStub = str_replace('{{modelUse}}', "use App\Models\\$model;", $serviceStub);
        }else{
            $serviceStub = str_replace('{{model}}', "", $serviceStub);
            $serviceStub = str_replace('{{modelUse}}', "", $serviceStub);
        }
        if(isset($pipeline)) {
            if(!File::exists(app_path("Http/Pipelines/$pipeline/$pipeline"."Pipeline.php"))){
                $this->error("pipeline $pipeline is not exist");
                return;
            }
            $serviceStub = str_replace('{{pipeline}}', "\$this->pipeline = $pipeline"."Pipeline::class;", $serviceStub);
            $serviceStub = str_replace('{{pipelineUse}}', "use App\Http\Pipelines\\$pipeline\\$pipeline"."Pipeline;", $serviceStub);
        }else{
            $serviceStub = str_replace('{{pipeline}}', "", $serviceStub);
            $serviceStub = str_replace('{{pipelineUse}}', "", $serviceStub);
        }        

        
        $servicePath = app_path("Services/$name.php");

        

        if (File::exists($servicePath)) {
            $this->error("$name already exists!");
        }
        else {
            File::put($servicePath, $serviceStub);
            $this->info("Service $name has been created.");
        }
    }

    protected function configure()
    {
        $this->addOption('model','model',InputOption::VALUE_OPTIONAL);
        $this->addOption('pipeline','pipeline',InputOption::VALUE_OPTIONAL);
    }
}
