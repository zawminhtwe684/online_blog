<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Test extends Component
{
    public $type;
    public function __construct($type="info")
    {
        $this->type = $type;
    }

    public function isClose(){
        return $this->type === "danger";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.test');
    }
}
