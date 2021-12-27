<?php

namespace App\Console\Commands;

use App\Models\Target;
use Illuminate\Console\Command;

class PendingTargetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'targets:pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        foreach (Target::query()->where('status', 'pending')->get() as $target)
        {
            $response = (shell_exec("docker exec -it kali whatweb ".$target->domain." -v -q"));

            echo $target->domain.PHP_EOL;

            if (!$response) {
                continue;
            }

            if (str_contains($response, "ERROR Opening")) {
                $target->status = "archived";
            } else {
                $target->status = "active";
            }

            $target->information = $response;

            $target->save();
        }

        return Command::SUCCESS;
    }
}
