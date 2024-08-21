<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RadioGroup extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public array $options
    ) {
        //
    }
    // defining a method to manipulate array sent to the component class
    // this method can be used just as properties in blade
    public function optionsWithLabels(): array
    { //this method below checks if the array is list  or not, an array is considered if it is not assoc array
        return array_is_list($this->options) ?
            // takes in 2 array as paramater and combines them into assco array 1st will be key and 2nd will be array 
            array_combine($this->options, $this->options) : $this->options;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.radio-group');
    }
}
