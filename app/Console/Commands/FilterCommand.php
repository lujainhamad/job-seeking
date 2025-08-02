<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;

class FilterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:filter {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $pipe = $this->option('pipeline');

        if(!File::exists(app_path("Http/Pipelines/$pipe/{$pipe}Pipeline.php"))){
            $this->error('pipeline is not exist.');
            return;
        }
        $stub = File::get(resource_path('stubs/FilterStub.stub'));

        $result = str_replace('{{FilterName}}',$name,$stub);
        $result = str_replace('{{Pipeline}}',$pipe,$result);

        $filterPath = app_path("Http/Pipelines/$pipe/Filters/$name.php");

        File::put($filterPath,$result);

        $this->info("Filter $name has been created.");
    }

    protected function configure()
    {
        $this->addOption('pipeline','pipeline',InputOption::VALUE_REQUIRED);
    }
}
