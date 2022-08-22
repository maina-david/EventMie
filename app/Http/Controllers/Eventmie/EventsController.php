<?php

namespace App\Http\Controllers\Eventmie;

use Classiebit\Eventmie\Http\Controllers\EventsController as BaseEventsController;
use App\Models\Event;
use App\Models\User;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use App\Charts\ReviewChart;

use App\Models\Category;
use App\Models\Currency;
use Illuminate\Support\Facades\Http;


class EventsController extends BaseEventsController
{
    /**
     * Show single event
     *
     * @return array
     */
    public function show(\Classiebit\Eventmie\Models\Event $event, $view = 'vendor.eventmie-pro.events.show', $extra = [])
    {
        $extra['is_tiny_pesa']     = 0; 
        
        if(!empty(setting('apps.tinypesa_apikey')))
            $extra['is_tiny_pesa']     = true; 
        
        return parent::show($event, $view, $extra);
    }
}
