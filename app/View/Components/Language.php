<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Language extends Component
{
    /**
     * The alert message.
     *
     * @var []
     */
    public $languages;

    /**
     * The alert message.
     *
     * @var []
     */
    public $active;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->languages = \Config::get('app.locales');
        foreach ($this->languages as $language) {
            if ($language === \App::getLocale()) {
                $this->active = $language;
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.language');
    }
}
