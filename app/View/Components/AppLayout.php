<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class AppLayout extends Component
{

    public $guest = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($guest = false)
    {
        $this->guest = $guest;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->guest) {
            return view('layouts.guest');
        }

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == "student") {
                return view('layouts.student');
            }
            if ($user->role == "preceptor") {
                return view("layouts.preceptor");
            }
            if ($user->role == "admin") {
                return view("layouts.admin");
            }
            if ($user->role == "affiliate") {
                return view("layouts.affilitate");
            }
        }

        return view('layouts.guest');
    }
}
