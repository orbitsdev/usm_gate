<?php

namespace App\Providers;

use App\Models\Day;
use App\Models\Card;
use App\Events\Scanned;
use App\Models\Account;
use App\Events\LogCreation;
use App\Observers\DayObserver;
use App\Observers\CardObserver;
use App\Observers\AccountObsever;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\CardScanningDetection;
use App\Listeners\LogCreationWhenApiTrigger;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LogCreation::class=> [
            LogCreationWhenApiTrigger::class,
        ],
        Scanned::class =>[
            CardScanningDetection::class,
        ]
        ,
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Account::observe(AccountObsever::class);
        Day::observe(DayObserver::class);
        Card::observe(CardObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
