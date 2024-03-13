<?php

namespace App\View\Components;

use App\Services\ChartService;
use Illuminate\View\Component;

class ChannelTarget extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $channelTargets;
    public function __construct()
    {
        $this->channelTargets = ChartService::getIsTargetAchieved();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.channel-target');
    }
}
