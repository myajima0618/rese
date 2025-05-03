<?php

namespace App\Console\Commands;

use App\Mail\ReminderMail;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Shop;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class RemindBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '予約情報のリマインダー';

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
        // 本日
        $today = new CarbonImmutable();
        $todayString = $today->toDateString();

        // 本日の予約情報取得
        $reservations = Reservation::where('date', $todayString)
                            ->with(['user', 'shop'])
                            ->get();

        // メール送信
        foreach($reservations as $reservation) {
            // ユーザーと店舗情報がロード済みなので直接アクセス
            if($reservation->user && $reservation->shop) {
                // メール送信
                Mail::to($reservation->user->email)->send(
                    new ReminderMail($reservation, $reservation->user, $reservation->shop)
                );
            }
        }

        $this->info('Reminder emails sent successfully.');
        return 0;
    }
}
