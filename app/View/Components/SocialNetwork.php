<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SocialNetwork extends Component
{
     /**
     * The wrapper class.
     *
     * @var string
     */
    public $mainClass;

    
     /**
     * The where from.
     *
     * @var boolean
     */
    public $isSignUp;

    /**
     * Create a new component instance.
     *
     * @param  string  $mainClass
     * @return void
     */
    public function __construct($mainClass, $isSignUp = false)
    {
        $this->mainClass = $mainClass;
        $this->isSignUp = $isSignUp;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.social-network');
    }
}
