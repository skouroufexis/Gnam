<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class success extends Component
{
    /**
     * Create a new component instance.
     */

     public $successMessage;
     public $redirectUrl;


    public function __construct($successMessage,$redirectUrl)
    {
        //
        $this->successMessage=$successMessage;
        $this->redirectUrl=$redirectUrl;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.success');
    }
}
