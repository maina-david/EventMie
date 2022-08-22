@extends('eventmie::events.show')

@section('javascript')

<script type="text/javascript">
    var is_tiny_pesa              = {!! json_encode( $extra['is_tiny_pesa']) !!};
    var customer                  = {!! json_encode( $extra['customer']) !!};

</script>


<script type="text/javascript" src="{{ asset('js/events_show_v1.8.js') }}"></script>

@stop