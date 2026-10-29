<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class header extends Component
{
    public $user;
    public $appID;
    public $appKEY;

    
    /**
     * Create a new component instance.
     */
    public function __construct($user)
    {
        
        $this->user=$user;        
        $this->appID = env('EDAMAM_ID');
        $this->appKEY = env('EDAMAM_KEY');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}
