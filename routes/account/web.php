<?php

use App\Livewire\Account;
use App\Livewire\Days\ListDays;
use App\Livewire\Logs\ListLogs;
use App\Livewire\MonitorScreen;
use App\Livewire\OverAllReport;
use App\Livewire\Cards\ListCard;
use App\Livewire\MonitorScreen2;
use App\Livewire\IndividualReport;
use App\Livewire\Records\ListRecords;
use Illuminate\Support\Facades\Route;
use App\Livewire\Accounts\EditAccount;
use App\Livewire\Accounts\CreateAccount;
use App\Livewire\Records\RealtimeListRecords;
use App\Livewire\Transactions\ListTransactions;

Route::get('/accounts', Account::class)->name('accounts');
Route::get('/cards', ListCard::class)->name('cards');
Route::get('/days', ListDays::class)->name('days');
Route::get('/records/{day}', ListRecords::class)->name('day-view-record');
Route::get('/logs', ListLogs::class)->name('logs');
Route::get('/transactions', ListTransactions::class)->name('transactions');
Route::get('/realtime-records', RealtimeListRecords::class)->name('realtime-records');
Route::get('/monitor', MonitorScreen::class)->name('monitor');
Route::get('/monitor2', MonitorScreen2::class)->name('monitor2');
Route::get('/individual-report', IndividualReport::class)->name('individual-report');
Route::get('/overall-report', OverAllReport::class)->name('overall-report');
// Route::get('/accounts/create', CreateAccount::class)->name('account.create');
// Route::get('/accounts/edit/{account}', EditAccount::class)->name('account.edit'); 