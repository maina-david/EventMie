@extends('eventmie::layouts.app')

{{-- Page title --}}
@section('title')
    @lang('eventmie-pro::em.manage_venues')
@endsection

    
@section('content')



<main>
    <div class="lgx-post-wrapper">
        <section>
            <router-view
                :organiser_id="{{ $organiser_id }}"
            ></router-view> 
        </section>
    </div>
</main>

@endsection

@section('javascript')


<script>    
    var path = {!! json_encode($path, JSON_HEX_TAG) !!};
</script>
<script  src="https://maps.googleapis.com/maps/api/js?key={{setting('apps.google_map_key')}}&libraries=places"></script>
<script type="text/javascript" src="{{ eventmie_asset('js/venues_manage_v1.8.js') }}"></script>
@stop
