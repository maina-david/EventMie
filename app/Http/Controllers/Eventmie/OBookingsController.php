<?php

namespace App\Http\Controllers\Eventmie;

use Classiebit\Eventmie\Http\Controllers\OBookingsController as BaseOBookingsController;
use App\Models\Event;
class OBookingsController extends BaseOBookingsController
{
    public function __construct()
    {
        parent::__construct();

        $this->event = new Event;
    }
}
