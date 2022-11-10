<?php

namespace App\Console\Commands;

use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\Communication\Receivers\CompaniesReceiverInterface;

class InsertCompaniesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'companies:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected ?CompaniesReceiverInterface $receiver;

    public  function __construct(CompaniesReceiverInterface $receiver)
    {
        parent::__construct();
        $this->receiver = $receiver;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $resp = $this->receiver->fetch();
        $table = [];

        try {
            DB::beginTransaction();

            foreach ($resp as $compAttrs) {

                $company = new Company($compAttrs);
                $company->save();

                $table[] = [
                    'symbol' => $company->symbol ?? '-',
                    'name' => $company->name
                ];
            }

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollback();
        }

        $this->output->table(['Symbol', 'Name'], $table);

        $this->output->info("Success!");
        return Command::SUCCESS;
    }
}
