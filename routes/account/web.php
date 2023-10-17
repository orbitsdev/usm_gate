<?php

use App\Livewire\Account;
use Illuminate\Support\Facades\Route;
use App\Livewire\Accounts\EditAccount;
use App\Livewire\Accounts\CreateAccount;
use App\Livewire\Cards\ListCard;

Route::get('/accounts', Account::class)->name('accounts');
Route::get('/cards', ListCard::class)->name('cards');
// Route::get('/accounts/create', CreateAccount::class)->name('account.create');
// Route::get('/accounts/edit/{account}', EditAccount::class)->name('account.edit');