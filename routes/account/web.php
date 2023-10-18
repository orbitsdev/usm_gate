<?php

use App\Livewire\Account;
use Illuminate\Support\Facades\Route;
use App\Livewire\Accounts\EditAccount;
use App\Livewire\Accounts\CreateAccount;
use App\Livewire\Cards\ListCard;
use App\Livewire\Days\ListDays;
use App\Livewire\Logs\ListLogs;
use App\Livewire\Records\ListRecords;
use App\Livewire\Transactions\ListTransactions;

Route::get('/accounts', Account::class)->name('accounts');
Route::get('/cards', ListCard::class)->name('cards');
Route::get('/days', ListDays::class)->name('days');
Route::get('/records/{day}', ListRecords::class)->name('day-view-record');
Route::get('/logs', ListLogs::class)->name('logs');
Route::get('/transactions', ListTransactions::class)->name('transactions');
// Route::get('/accounts/create', CreateAccount::class)->name('account.create');
// Route::get('/accounts/edit/{account}', EditAccount::class)->name('account.edit'); 