<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AccountExport;
use App\Exports\TotalCardExport;
use App\Exports\TotalGuestExport;
use App\Exports\TotalStaffExport;
use App\Exports\TotalStudentExport;
use App\Exports\TotalTeacherExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TotalActiveCardExport;
use App\Exports\TotalBlockedCardExport;
use App\Exports\TotalExpiredCardExport;
use App\Exports\TotalInactiveCardExport;
use App\Exports\TotalAccountNoCardExport;
use App\Exports\TotalNoAccountCardExport;

class DownloadController extends Controller
{
    

    public function totalAccounts(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new AccountExport, $filename.'-ACCOUNTS.xlsx');
    }
    public function totalAccountsNoCard(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new TotalAccountNoCardExport, $filename.'-NO-CARD-ACCOUNTS.xlsx');
    }
    public function totalTeachers(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new TotalTeacherExport, $filename.'-TEACHERS-ACCOUNTS.xlsx');
    }
    public function totalStudents(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new TotalStudentExport, $filename.'-Students-ACCOUNTS.xlsx');
    }
    public function totalGuests(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new TotalGuestExport, $filename.'-Guests-ACCOUNTS.xlsx');
    }
    public function totalStaffs(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new TotalStaffExport, $filename.'-staffs-ACCOUNTS.xlsx');
    }
    public function totalCards(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new TotalCardExport, $filename.'-CARDS.xlsx');
    }
    public function totalActiveCards(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new TotalActiveCardExport, $filename.'-ACTIVE-CARDS.xlsx');
    }
    public function totalInactiveCards(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new TotalInactiveCardExport, $filename.'-INACTIVE-CARDS.xlsx');
    }

    public function totalExpiredCards(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new TotalExpiredCardExport, $filename.'-EXPIRED-CARDS.xlsx');
    }

    public function totalBlockedCards(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new TotalBlockedCardExport, $filename.'-BLOCKED-CARDS.xlsx');
    }
    
    public function totalNoAccountCards(){
        $filename = now()->format('Y-m-d');
        return Excel::download(new TotalNoAccountCardExport, $filename.'-NO-ACCOUNT-CARDS.xlsx');
    }
   



}
