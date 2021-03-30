<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
     /**
     * The alert type.
     *
     * @var string
     */
    public $type;

    /**
     * The alert message.
     *
     * @var string
     */
    public $message;

    /**
     * The alert message.
     *
     * @var []
     */
    public $errors;

    /**
     * Create a new component instance.
     *
     * @param  array  $errors
     * @return void
     */
    public function __construct($errors)
    {
        if($errors->any()){
            $this->errors = $errors->all();
            $this->type = 'errors';
        }
        
        // $this->type = $type;
        // $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
