<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;

class PipelineCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:pipeline {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new pipeline';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $stub = File::get(resource_path('stubs/PipelineStub.stub'));

        $result = str_replace('{{name}}',$name,$stub);

        $pipelinePath = app_path("Http/Pipelines/$name/{$name}Pipeline.php");
        File::makeDirectory(app_path("Http/Pipelines/$name"));
        File::makeDirectory(app_path("Http/Pipelines/$name/Filters"));
        File::put($pipelinePath,$result);

        $this->info("Pipeline $name has been created.");
    }

}
