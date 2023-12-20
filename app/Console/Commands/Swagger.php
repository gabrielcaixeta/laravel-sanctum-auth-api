<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Swagger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doc:swagger';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera a documentação da api via swagger';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $openapi = \OpenApi\Generator::scan([config('swagger.sources')]);
        file_put_contents("docs/swagger.json", $openapi->toJson());
        $this->info('Api documentation generated successfully!');
        return Command::SUCCESS;
    }
}
