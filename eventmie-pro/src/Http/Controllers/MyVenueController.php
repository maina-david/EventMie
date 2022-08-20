<?php

namespace Classiebit\Eventmie\Http\Controllers;

use App\Http\Controllers\Controller; 
use Facades\Classiebit\Eventmie\Eventmie;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Classiebit\Eventmie\Models\Venue;
use Classiebit\Eventmie\Models\Event;
use  Classiebit\Eventmie\Models\User;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;
use File;
use Illuminate\Validation\Rule;
use Auth;

class MyVenueController extends Controller
{

    public function __construct()
    {
        $this->middleware('common');
    
        $this->middleware(['organiser']);
        $this->venue        = new Venue;
        $this->event        = new Event;
        $this->user         = new User;
        $this->organiser_id = null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = null, $view = 'eventmie::venues.form', $extra = [])
    {
        // get prifex from eventmie config
        $path = false;
        if(!empty(config('eventmie.route.prefix')))
            $path = config('eventmie.route.prefix');

        $id     = (int) $id;
        $event  = [];
        
        $organiser_id    = Auth::id();

        
        
        if($request->wantsJson()) {
            return $this->venues($request);
        }

        return Eventmie::view($view, compact('organiser_id', 'path', 'extra'));
    }

    // get venues for particular organiser
    public function venues(Request $request)
    {
        // if logged in user is admin
        $this->is_admin($request);

        $params    = [
            'organizer_id' => $this->organiser_id,
        ];
        
        $venues  = $this->user->get_venues($params);

        if(empty($venues))
        {
            return response()->json(['status' => false]);    
        }

        return response()->json(['status' => true, 'venues' => $venues->jsonSerialize() ]);
    }

    protected function is_admin(Request $request)
    {
        // if login user is Organiser then 
        // organiser id = Auth::id();
        $this->organiser_id = Auth::id();

        // if admin is creating event
        // then user Auth::id() as $organiser_id
        // and organiser id will be the id selected from Vue dropdown
        if(Auth::user()->hasRole('admin'))
        {
            $request->validate([
                'organiser_id'       => 'required|numeric|min:1|regex:^[1-9][0-9]*$^',
            ]);
            
            $this->organiser_id = $request->organiser_id;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // if logged in user is admin
        $this->is_admin($request);
        
        // validate
        $request->validate([
            'organiser_id'          => 'required|numeric|gt:0',
            'title'                 => 'required|max:256',
            'slug'                  => 'required|max:256|'.Rule::unique('venues', 'slug')->ignore($request->venue_id),
            'description'           => 'string|nullable',
            'venue_type'            => 'string|max:256|nullable',
            'amenities'             => 'string|nullable',
            'neighborhoods'         => 'string|nullable',
            'seated_guestnumber'    => 'nullable|numeric|gt:0',
            'standing_guestnumber'  => 'nullable|numeric|gt:0',
            'standing_guestnumber'  => 'nullable|numeric|gt:0',
            'neighborhoods'         => 'string|nullable',
            'pricing'               => 'string|nullable',
            'availability'          => 'string|nullable',
            'food'                  => 'string|nullable',
            'contact_email'         => 'email|max:256|nullable',
            'address'               => 'string|max:256|nullable',
            'state'                  => 'string|max:256|nullable',
            'city'                  => 'string|max:256|nullable',
            'zipcode'               => 'string|max:256|nullable',
            'glat'                  => 'string|max:256|nullable',
            'glong'                 => 'string|max:256|nullable',
            'country_id'            => 'numeric|min:0',

        ]);

        
        $params = [
            "title"                 => $request->title,
            "slug"                 => $request->slug,
            "description"           => $request->description,
            "venue_type"            => $request->venue_type,
            "amenities"             => $request->amenities,
            "seated_guestnumber"    => $request->seated_guestnumber,
            "standing_guestnumber"  => $request->standing_guestnumber,
            "neighborhoods"         => $request->neighborhoods,
            "pricing"               => $request->pricing,
            "availability"          => $request->availability,
            "food"                  => $request->food,
            "address"               => $request->address,
            "city"                  => $request->city,
            "state"                 => $request->state,
            "zipcode"               => $request->zipcode,
            "glat"                  => $request->glat,
            "glong"                 => $request->glong,
            "organizer_id"          => $this->organiser_id,
            "status"                => 1,
            "country_id"            => $request->country_id,
            "show_quoteform"            => (int) $request->show_quoteform,
            "contact_email"            => $request->contact_email,
            
        ];

        $images  = [];

        $path = '/venues/'.Carbon::now()->format('FY').'/';

        // for image
        if($request->hasfile('images')) 
        { 
            // if have  image and database have images no images this event then apply this rule 
            $request->validate([
                'images'        => 'required',
                'images.*'      => 'mimes:jpeg,png,jpg,gif,svg',
            ]); 
        
            $files = $request->file('images');
            foreach($files as  $key => $file)
            {
                $extension       = $file->getClientOriginalExtension(); // getting image extension
                $image[$key]     = time().rand(1,988).'.'.$extension;
                $file->storeAs('public/'.$path, $image[$key]);
                
                $images[$key]    = $path.$image[$key];
            }
        }

        // get venue if exist
        $result    = Venue::whereId($request->venue_id)->first();

        // if images uploaded
        if(!empty($images))
        {
            if(!empty($result))
            {
                if(!empty($result->images))
                {
                    $exiting_images = json_decode($result->images, true);

                    $images = array_merge($images, $exiting_images);
                }
            }

            $params["images"] = json_encode(array_values($images));

        }   
        else
        {
            $params["images"] = !empty($result) ?  $result->images : json_encode([]);
        }

        
        $venue = Venue::updateOrCreate(
           
            ['id' => $request->venue_id],
            $params
        );

        return response()->json(['status' => true]);
    }

    public function delete_venueimage(Venue $venue, Request $request)
    {
        // if logged in user is admin
        $this->is_admin($request);
        
        // 1. validate data
        $request->validate([
            'image'                => 'required|string',
        ]);

        $images     = json_decode($venue->images);
    
        $filtered_images = [];
        foreach($images as $key => $val)
        {
            if($val != $request->image)
                $filtered_images[$key] = $val;
        }
        
        
        $venue->images =  !empty($filtered_images) ? json_encode(array_values($filtered_images)) : null;
        
        $venue->save();

        // get media  related event_id who have created now
        return response()->json(['venue' => $venue, 'status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venue = Venue::whereId($id)->firstOrFail();

        return view('eventmie::venues.show', compact('venue'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
    
        $venue = Venue::where(['id' => $id, 'organizer_id' => $request->organiser_id])->firstOrFail();
        
        $venue->delete();

        return response()->json(['status' => true]);
    }


    //get selected venues from event_venues table when organiser editing his event
    public function selected_event_venues(Request $request)
    {
         // if logged in user is admin
        $this->is_admin($request);
         
           // 1. validate data
        $request->validate([
            'event_id'   => 'required|numeric|min:1|regex:^[1-9][0-9]*$^',
        ]);

        // check event is valid or not
        $check_event    = $this->event->get_user_event($request->event_id, $this->organiser_id);

        // if event not found then access denie!
        if(empty($check_event))
        {
            return error('access denied!', Response::HTTP_BAD_REQUEST );
        }

        $event = Event::where('id', $request->event_id)->first();
        
        if($event->venues->isEmpty())
        {
            return response()->json(['status' => false, 'selected_event_venues'=> $event->venues], 200);
        }

        return response()->json(['status' => true, 'selected_event_venues'=> $event->venues], 200);
    }

   

    /**
     *  search tage
     */

    public function search_venues(Request $request)
    {
         // if logged in user is admin
        $this->is_admin($request);
         
        if(!empty($request->search))
        {
            // 1. validate data
            $request->validate([
                'search'   => 'max:255',
            ]);
        }    

        $params    = [
            'organizer_id' => $this->organiser_id,
            'search'       => $request->search
        ];

        $venues  = $this->user->search_venues($params);

        if($venues->isEmpty())
            return response()->json(['status' => false, 'venues'=> []], 200);

        return response()->json(['status' => true, 'venues'=> $venues], 200);    

    }
}
