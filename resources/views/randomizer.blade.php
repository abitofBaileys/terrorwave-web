@extends('app')

@section('content')
    <div class="row d-flex flex-column justify-content-center align-items-center">
        <div class="col-12 col-lg-8 mt-3">
            <h2 class="text-center">Lufia 2 Terrorwave Randomizer Web GUI</h2>
            <div class="alert alert-primary alert-dismissible intro d-none overflow-hidden" role="alert">
                For more complex randomization like custom randomness for each flag or individual scaling for bosses and monsters, <a href="https://github.com/abyssonym/terrorwave" target="_blank">please use abyssonym's randomizer yourself</a>. ( Star it while you're at it! )<br>
                <span class="text-reset fw-semibold">This page is not meant to replace or take the credit for abyssonym's amazing work! ❤️</span>
                <button type="button" class="btn-close" aria-label="Close"
                        _="on click set localStorage.hideIntro to 'true' then transition .intro's height to 0 opacity to 0 padding to '0 var(--bs-alert-padding-x)' margin to 0 then add .d-none to .intro"></button>
            </div>
            <form id='form' hx-encoding='multipart/form-data' hx-post='/terrorwave' hx-target="#output" hx-indicator="#spinner"
                  _="install validateForm">
                @csrf
                <h5 class="mt-3">Rom File:</h5>
                <div class="input-group mb-3">
                    <input type="file" name='file' class="form-control" id="romfile" aria-label="ROM File" required="required">
                </div>
                <h5 class="mt-3">Seed:</h5>
                <div class="input-group mb-3">
                    @php($seedLength = strlen($data['seed']['max']))
                    <input type="text" name='seed' id="seed" pattern="[0-9]{ {{$seedLength}} }" maxlength="{{$seedLength}}" class="form-control" placeholder="Seed value (optional)">
                    <button class="btn btn-light" type="button" id="button-seed"
                            _="on click set #seed's value to Math.floor((Math.random() * (({{$data['seed']['max']}} - {{$data['seed']['min']}}) + 1)) + {{$data['seed']['min']}})"
                    >Random</button>
                </div>
                <h5>Presets:</h5>
                <div class="d-flex flex-wrap gap-3">
                    @foreach ($data['preset'] as $preset)
                        @include('fragments.randomizer.preset')
                    @endforeach
                </div>
                <h5 class="mt-3">Flags:</h5>
                <div class="row">
                    @foreach ($data['flag'] as $flag)
                        @include('fragments.randomizer.flag')
                    @endforeach
                </div>
                <h5 class="mt-3">Secret Codes:</h5>
                <div class="row">
                    @foreach ($data['categories'] as $cKey => $cLabel)
                        @include('fragments.randomizer.code')
                    @endforeach
                </div>
                @foreach ($data['mod'] as $mod)
                    @include('fragments.randomizer.mod')
                @endforeach
                <h5 class="mt-3">Links:</h5>
                <div class="row mt-3">
                    <div class="col-12 d-flex flex-wrap justify-content-center">
                        <a href="https://github.com/abyssonym/terrorwave" target="_blank" style="text-decoration: none;">
                            <span class="badge bg-success text-light">abyssonym's Lufia 2 Terrorwave Randomizer</span>
                        </a>
                        &nbsp;
                        <a href="https://github.com/HolySmith24/Lufia_2Tracker/" target="_blank" style="text-decoration: none;">
                            <span class="badge bg-success text-light">HolySmith24's Lufia 2 EmoTracker Pack</span>
                        </a>
                        &nbsp;
                        <a href="https://github.com/tethtoril" target="_blank" style="text-decoration: none;">
                            <span class="badge bg-success text-light">Meats</span>
                        </a>
                        &nbsp;
                        <a href="https://discord.gg/96Uswexh9q" target="_blank" style="text-decoration: none;">
                            <span class="badge bg-success text-light">Ancient Cave Discord</span>
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-center">
                        <a href="https://github.com/abitofBaileys/terrorwave-web" target="_blank" style="text-decoration: none;">
                            <span class="badge bg-light text-dark">GitHub</span>
                        </a>
                    </div>
                </div>
                <div class="row mt-3 mb-5 justify-content-center">
                    Powered by
                    <div class="col-12 d-flex justify-content-center">
                        <a href="https://htmx.org/" target="_blank" style="text-decoration: none;">
                            <span class="badge bg-light text-dark">&lt;/&gt; htmx</span>
                        </a>
                        &nbsp;
                        <a href="https://hyperscript.org/" target="_blank" style="text-decoration: none;">
                            <span class="badge bg-light text-dark">///_hyperscript</span>
                        </a>
                    </div>
                </div>
                <div class="position-fixed position-lg-relative bottom-0 py-3 start-0 end-0 container d-flex flex-column justify-content-center align-items-center">
                    <div class="col-12 col-lg-8">
                        <button type="submit" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#modal" disabled="disabled"
                                _="on click set <#output/>'s innerHTML to ''">Randomize</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
