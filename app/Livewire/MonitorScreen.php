<?php

namespace App\Livewire;

use App\Models\Log;
use App\Models\Card;
use Livewire\Component;
use App\Events\LogCreation;
use App\Models\Transaction;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class MonitorScreen extends Component
{



    public Transaction $ransaction;

    public function render()
    {

        // return view('livewire.monitor-screen', ['transaction' => Transaction::where('door_name','Door1')->whereDate('created_at', today())->latest()->first()]);
        //   return view('livewire.monitor-screen', ['transaction' => Transaction::where('door_name','Door1')->where('created_at', '>', now()->subMinutes(3))->latest()->first()]);

                return view('livewire.monitor-screen', [
                //     'transactions' => Transaction::whereIn('door_name', ['Door1', 'Door2', 'Door3'])
                //       ->whereIn('id', function ($query) {
                //         $query->select(DB::raw('MAX(id)'))
                //                 ->from('transactions')
                //                 ->groupBy('door_name');
                //       })
                //  ->latest()
                //     ->take(3)
                //     ->get()
                
                
                
                    'transactions' => Transaction::whereIn('door_name', ['Door1', 'Door2', 'Mobile'])
                    ->whereIn('id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                            ->from('transactions')
                            ->where('created_at', '>', now()->subSeconds(15))
                            ->groupBy('door_name');
                    })
                    ->latest()
                    ->take(3)
                    ->get()
                

                    // 'transactions' => Transaction::latest()->take(3)->get(),
                    // 'transaction' => Transaction::where('created_at', '>', now()->subSeconds(10))->latest()->first()
                    // 'transaction' => Transaction::where('door_name', 'Door1')->where('created_at', '>', now()->subSeconds(10))->latest()->first()
                ]);
                

    }
}
