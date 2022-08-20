<script type="text/javascript" src="{{ eventmie_asset('js/jquery.min.js') }}" ></script>

{{-- Load third party plugins in seperate file (node modules) --}}
<script type="text/javascript" src="{{ eventmie_asset('js/manifest.js') }}"></script>

{{-- localization --}}
<script type="text/javascript" src="{{ route('eventmie.eventmie_lang') }}"></script>

<script src="{{ asset('/sw.js') }}"></script>

{{-- VueJs Global Constants --}}
<script type="text/javascript">
    const my_lang = {!! json_encode(session('my_lang', \Config::get('app.locale'))) !!};

    
    const date_format = {
        vue_date_format: '{!! format_js_date() !!}',
        vue_time_format: '{!! format_js_time() !!}'
    };
</script>

{{-- Javascript Global Listener --}}
<script type="text/javascript">
/**
 * Header menu onscroll 
 */
var lastScrollTop = 0;
function handleScroll() {
    let el = document.getElementById('navbar_vue');
    let st = window.pageYOffset || document.documentElement.scrollTop;
    
    lastScrollTop = st <= 0 ? 0 : st; // For Mobile or negative scrolling
    if(window.scrollY > 1) {
        el.classList.add('menu-onscroll');
    } else {
        el.classList.remove('menu-onscroll');
      
        if(el.classList.contains('is-active')) {
            el.classList.add('is-mobile');
        }
    }
};

function scrollListener( obj, type, fn ) {
    if ( obj.attachEvent ) {
        obj['e'+type+fn] = fn;
        obj[type+fn] = function(){obj['e'+type+fn]( window.event );};
        obj.attachEvent( 'on'+type, obj[type+fn] );
    } else {
        obj.addEventListener( type, fn, false );
    }
}

scrollListener(window, 'scroll', function(e) {
    handleScroll();
});


// Copy to clipboard
function copyToClipboard() {
    var dummy = document.createElement('input'),
    text = window.location.href;

    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand('copy');
    document.body.removeChild(dummy);

    alert('Event URL Copied!')
}


// set local timezone 
var local_timezone = {!! json_encode(route('eventmie.local_timezone')) !!};

function setLocalTimezone() {
    
    $.ajax({
        url: local_timezone,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            local_timezone : Intl.DateTimeFormat().resolvedOptions().timeZone,
            
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
        },
        error: function (error) {
            console.log(`Error ${error}`);
        }
    });
}

setLocalTimezone();


if (!navigator.serviceWorker.controller) {
    navigator.serviceWorker.register("/sw.js").then(function (reg) {
        console.log("Service worker has been registered for scope: " + reg.scope);
    });
}
    

</script>