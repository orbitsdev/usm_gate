<?php

use App\Livewire\Account;
use App\Livewire\Dashboard;
use App\Exports\AccountExport;
use App\Livewire\Days\ListDays;
use App\Livewire\Logs\ListLogs;
use App\Livewire\MonitorScreen;
use App\Livewire\OverAllReport;
use App\Livewire\ProfileScreen;
use App\Livewire\Cards\EditCard;
use App\Livewire\Cards\ListCard;
use App\Livewire\MonitorScreen2;
use App\Livewire\Cards\CreateCard;
use App\Livewire\IndividualReport;
use Maatwebsite\Excel\Facades\Excel;
use App\Livewire\Records\ListRecords;
use Illuminate\Support\Facades\Route;
use App\Livewire\Accounts\EditAccount;
use App\Livewire\Accounts\CreateAccount;
use App\Http\Controllers\DownloadController;
use App\Livewire\Records\RealtimeListRecords;
use App\Livewire\Transactions\ListTransactions;
use App\Livewire\Users\ListUsers;

Route::get('/account/profile', ProfileScreen::class)->name('account.profile');
Route::get('/usm/dashboard', Dashboard::class)->name('usm.dashboard');
Route::get('/accounts', Account::class)->name('accounts');
Route::get('/create/card', CreateCard::class)->name('create.card');
Route::get('/edit/card/{card}', EditCard::class)->name('edit.card');
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

Route::get('/users-management', ListUsers::class)->name('user-management')->middleware('can:developer');


// Route::prefix('download')->name('download.')->group(function(){
//     Route::get('/total-accounts', [DownloadController::class ,'totalAccount'])->name('total-account');
// });

Route::prefix('download')->name('download.')->controller(DownloadController::class)->group(function () {
    Route::get('/total-accounts', 'totalAccounts')->name('total-account');
    Route::get('/total-accounts-no-card', 'totalAccountsNoCard')->name('total-account-no-card');
    Route::get('/total-teachers-accounts', 'totalTeachers')->name('total-teachers');
    Route::get('/total-students-accounts', 'totalStudents')->name('total-students');
    Route::get('/total-staffs-accounts', 'totalStaffs')->name('total-staffs');
    Route::get('/total-guest-accounts', 'totalGuests')->name('total-guests');
    Route::get('/total-cards', 'totalCards')->name('total-cards');
    Route::get('/total-acive-cards', 'totalActiveCards')->name('total-active-cards');
    Route::get('/total-inacive-cards', 'totalInactiveCards')->name('total-inactive-cards');
    Route::get('/total-expired-cards', 'totalExpiredCards')->name('total-expired-cards');
    Route::get('/total-blocked-cards', 'totalBlockedCards')->name('total-blocked-cards');
    Route::get('/total-no-account-cards', 'totalNoAccountCards')->name('total-no-account-cards');
    Route::get('/qrcode/{idNumber}','qrCode')->name('qrcode');
});

// Route::get('/accounts/create', CreateAccount::class)->name('account.create');
// Route::get('/accounts/edit/{account}', EditAccount::class)->name('account.edit'); 