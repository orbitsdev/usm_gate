<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
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
use Illuminate\Support\Facades\Storage;
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
    

    public function qrCode($idNumber){


           
            $card = Card::where('id_number', (int)$idNumber)->first();
         
            if ($card) {
                // Create an instance of DNS2D
                $qrCode = new DNS2D();

                // Generate the QR code data
                $qrCodeData = $qrCode->getBarcodePNG(strval($card->id_number), 'QRCODE');

                // $qrCodeData = $qrCode->getBarcodePNG(strval($student->id_number), 'QRCODE');

                // Generate a filename based on student information
                // Generate a filename based on student information
                if ($card->account) {
                    $lastName = $card->account->last_name ?? '';
                    $firstName = $card->account->first_name ?? 'NO-ACCOUNT';
                } else {
                    // Handle the case where account is null
                    $lastName = '';
                    $firstName = 'NO-ACCOUNT';
                }

                $filename = strtoupper($lastName . '-' . $firstName . '-' . $card->id_number . '.png');

                // Define the path where the QR code image will be saved temporarily
                $filePath = 'temp/' . $filename;

                // Save the QR code image temporarily to the public disk
                Storage::disk('public')->put($filePath, base64_decode($qrCodeData));

                // Create a response to trigger the download using the Storage::download() method
                return Storage::disk('public')->download($filePath, $filename);
        }

        // If the student is not found, you might want to return a response indicating that.
        return response('Student not found', 404);
    }



}
