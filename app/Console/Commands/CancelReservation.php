<?php

namespace App\Console\Commands;

use App\Models\Passenger;
use App\repositories\PassengerRepository;
use Illuminate\Console\Command;
use App\repositories\ScheduleRepository;
use App\repositories\ReservationRepository;

class CancelReservation extends Command
{

    private $reservationRepository;
    private $scheduleRepository;
    private $passengerRepository;
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
    public function __construct(ReservationRepository $reservationRepository,
                                ScheduleRepository $scheduleRepository,
                                PassengerRepository $passengerRepository)

    {
        $this->reservationRepository = $reservationRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->passengerRepository = $passengerRepository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reserves = $this->reservationRepository->cancelReserve();

        foreach($reserves as $reserve){
            $reserve->status = 'canceled';
            $reserve->save();
            $passenger_id = $reserve->passenger_id;
            $schedule_id = $reserve->schedule_id;
            $reserve->delete();
            $this->scheduleRepository->incrementRemainingCapacity($schedule_id);
            $this->passengerRepository->delete($passenger_id);
        }
        return 0;
    }
}
