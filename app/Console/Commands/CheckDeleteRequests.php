<?php

namespace App\Console\Commands;

use App\Models\Favorite;
use App\Models\Rate;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckDeleteRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check users delete requests';

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
        $days = (int) getSetting('delete_period');

        $users = User::query()
            ->where('user_type', 2)
            ->whereNotNull('delete_request_at')
            ->where('delete_request_at', '>=', Carbon::now()->addDays($days)->toDateTimeString())
            ->get();

        foreach ($users as $user){
            \DB::table('deleted_users')->insert($user->toArray());

            Rate::where('user_id', $user->id)->forceDelete();
            Favorite::where('user_id', $user->id)->forceDelete();
            Ticket::where('user_id', $user->id)->forceDelete();

            $user->forceDelete();
        }

        return 1;
    }
}
