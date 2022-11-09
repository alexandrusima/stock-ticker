<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Communication\Sender\SenderInterface;

class GetCompaniesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'companies:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sender = app()->make(SenderInterface::class, [ 'key' => 'ticker']);
        $resp = array_keys($sender->get());
        

        var_dump($resp);

        $this->output->info("Success!");
        return Command::SUCCESS;
    }
}
