<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class Calendar implements Rule
{

    protected $inactiveDays;

    public function __construct($inactiveDays)
    {
        $this->inactiveDays = $inactiveDays;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $date = Carbon::parse($value);

        return !in_array($date->format('Y-m-d'), $this->inactiveDays);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La fecha elegida no está disponible';
    }
}
