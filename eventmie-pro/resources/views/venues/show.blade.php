@extends('eventmie::layouts.app')

@section('title')
    {{ ucfirst($venue->title) }}
@endsection

<style>
#map_canvas {
    height: 100%;
    width: 100%;
    margin: 0px;
    padding: 0px
}
</style>

@section('content')
<main>
    <div class="lgx-post-wrapper">
         <section>
            <div class="container">
                <div class="row">
                   <div class="col-md-12">
                        @if(!empty($venue->images))
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                @foreach(json_decode($venue->images, true) as $key => $image)
                                <li data-target="#carousel-example-generic" data-slide-to="{{$key}}" class="{{$key == 0 ? 'active' : ''}}"></li>
                                @endforeach
                            </ol>
                        
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                @foreach(json_decode($venue->images, true) as $key => $image)
                                <div class="carousel-item item {{ $key == 0 ? 'active' : ''}}">
                                    <img class="img-fluid" src="{{asset('storage/'.$image)}}" alt="{{ $venue->title }}">
                                </div>
                                @endforeach
                            </div>
                        
                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="fas fa-arrow-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="fas fa-arrow-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                            </a>
                        </div>
                        
                        @else
                        <img src="{{ eventmie_asset('img/512x512.jpg') }}" class="card-img-top"  alt="{{ $venue->title }}" class="img-responsive img-rounded" />
                        @endif
                   </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-title">
                                <h5 class="card-title">{{ $venue->title }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-5">
                                    <div class="col-md-3">
                                        @lang('eventmie-pro::em.guests')
                                    </div>
                                    <div class="col-md-9">
                                        @lang('eventmie-pro::em.seated'): {{ $venue->seated_guestnumber }} - @lang('eventmie-pro::em.standing'): {{ $venue->standing_guestnumber }}
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-3">
                                        @lang('eventmie-pro::em.location')
                                    </div>
                                    <div class="col-md-9">
                                        <div id="map" style="width:100%;height:500px"></div>
                                        <table class="table table-condensed mt-5">
                                            <tr>
                                                <td>@lang('eventmie-pro::em.address')</td>
                                                <td>{{ $venue->address }}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang('eventmie-pro::em.neighborhoods')</td>
                                                <td>{{ $venue->neighborhoods }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-3">
                                        @lang('eventmie-pro::em.description')
                                    </div>
                                    <div class="col-md-9">
                                        <p class="card-text ">{!! $venue->description !!}</p>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-3">
                                        @lang('eventmie-pro::em.pricing')
                                    </div>
                                    <div class="col-md-9">
                                        <p class="card-text ">{!! $venue->pricing !!}</p>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-3">
                                        @lang('eventmie-pro::em.availability')
                                    </div>
                                    <div class="col-md-9">
                                        <p class="card-text ">{!! $venue->availability !!}</p>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-3">
                                        @lang('eventmie-pro::em.food')
                                    </div>
                                    <div class="col-md-9">
                                        <p class="card-text ">{!! $venue->food !!}</p>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-3">
                                        @lang('eventmie-pro::em.amenities')
                                    </div>
                                    <div class="col-md-9">
                                        <p class="card-text ">{!! $venue->amenities !!}</p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>

                @if($venue->show_quoteform)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-title">
                                <h5 class="card-title">@lang('eventmie-pro::em.request_a_quote')</h5>
                            </div>
                            <div class="card-body">
                                @if (\Session::has('msg'))
                                    <div class="alert alert-success">
                                        {{ \Session::get('msg') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" class="lgx-contactform" action="{{route('eventmie.request_quote')}}">
                                    @csrf
                                    @honeypot

                                    <input type="hidden" name="contact_email" value="{{ $venue->contact_email }}">
                                    
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" id="lgxname" placeholder="{{ __('eventmie-pro::em.name') }}" required="" aria-required="true">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" id="lgxemail" placeholder="{{ __('eventmie-pro::em.email') }}" required="" aria-required="true">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control" id="phone" placeholder="{{ __('eventmie-pro::em.phone') }}" required="" aria-required="true">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="guests" class="form-control lgxsubject" id="lgxsubject" placeholder="{{ __('eventmie-pro::em.number_of_guests') }}" aria-required="true">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control lgxmessage" name="message" id="lgxmessage" rows="5" placeholder="{{ __('eventmie-pro::em.mention_query') }}" required="" aria-required="true"></textarea>
                                    </div>
                                    <button type="submit" name="submit" value="contact-form" class="lgx-btn hvr-glow hvr-radial-out lgxsend lgx-send"><span>Send Massage</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </section>
    </div>
</main>

@endsection

@section('javascript')

<script type="text/javascript" src="{{ eventmie_asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ eventmie_asset('js/bootstrap.min.js') }}"></script>
    
<script>

var venue = {!! json_encode($venue, JSON_PRETTY_PRINT) !!}
console.log(venue);

function myMap() {
    
    
    if (navigator.geolocation) { //check if geolocation is available
        navigator.geolocation.getCurrentPosition(function(pos){  
            const lat = venue.glat;
            const lng = venue.glong;
            
            var myCenter = new google.maps.LatLng(lat,lng);
            var mapCanvas = document.getElementById("map");
            var mapOptions = {center: myCenter, zoom: 17,
            mapTypeId: google.maps.MapTypeId.TERRAIN
        }
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var marker = new google.maps.Marker({position:myCenter});
        marker.setMap(map);
        var infowindow = new google.maps.InfoWindow({
            content: venue.address
        });
        infowindow.open(map,marker);
        });   
    }
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{setting('apps.google_map_key')}}&amp;callback=myMap"></script>
    
@endsection