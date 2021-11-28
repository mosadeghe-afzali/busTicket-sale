<?php

namespace App\Console\Commands;

use App\Models\Passenger;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:pending-reserves';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command cancel pending reservations';

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
        $reserves = Reservation::query()->where('status', 'pending')
            ->where('reserve_date', '<' , Carbon::now()->subMinutes(15))->get();

        foreach($reserves as $reserve){
            $reserve->status = 'canceled';
            $reserve->save();
//            $passenger_id = $reserve->passenger_id;
            $reserve->delete();
//            Passenger::query()->findOrFail($passenger_id)->delete();
        }
        return 0;
    }
}
