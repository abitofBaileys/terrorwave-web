<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lufia 2 Terrorwave Randomizer Web GUI</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body class="bg-dark"
      _="init if no localStorage.hideIntro remove .d-none from <.intro/> end
      on every htmx:beforeSend in <form/>
         tell it
             toggle [@@disabled] on the first <button[type='submit']/> in me until htmx:afterOnLoad">
<div id="modal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content d-flex justify-content-center" style="min-height: 70px;">
            <svg id="spinner" class="htmx-indicator align-self-center" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>
            <div id="output" class="modal-body d-flex flex-column justify-content-center align-items-center" style="z-index: 10;">
            </div>
        </div>
    </div>
</div>
<div class="container mb-5">
    @yield('content', 'Template not found')
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/htmx.min.js') }}"></script>

<script src="{{ asset('assets/js/behaviors._hs') }}" type="text/hyperscript" ></script>


<script src="{{ asset('assets/js/_hyperscript.min.js') }}"></script>
</body>
</html>
