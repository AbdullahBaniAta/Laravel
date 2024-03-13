<?php


namespace App\View\Components;

use Illuminate\View\Component;

class DatePicker extends Component
{
    public $id;
    public $chartId;

    public $jsFunction;
    public $chartTitle;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $chartId, $jsFunction, $chartTitle)
    {
        $this->id = $id;
        $this->chartId = $chartId;
        $this->jsFunction = $jsFunction;
        $this->chartTitle = $chartTitle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.date-picker');
    }
}
