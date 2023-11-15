<?php

namespace App\View\Components;

use Closure;
use App\Models\Transaction;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class UserProfile extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Transaction $transaction)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-profile');
    }
}
