<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Terrorwave-Web</title>
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    </head>
    <body class="bg-dark"
          _="on every htmx:beforeSend in <form/>
         tell it
             toggle [@@disabled] on the first <button[type='submit']/> in me until htmx:afterOnLoad">
    <div id="modal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content d-flex justify-content-center" style="min-height: 70px;">
                <svg id="spinner" class="htmx-indicator align-self-center" viewBox="0 0 50 50">
                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                </svg>
                <div id="output" class="modal-body d-flex justify-content-center align-items-start" style="z-index: 10;">
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <div class="row d-flex flex-column justify-content-center align-items-center">
            <div class="col-12 col-lg-8">
                <h2>Lufia 2 Terror Wave Randomizer</h2>
                <form id='form' hx-encoding='multipart/form-data' hx-post='/terrorwave' hx-target="#output" hx-indicator="#spinner"
                _="install validateForm">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="file" name='file' class="form-control" id="romfile" aria-label="ROM File" required="required">
                    </div>
                    <h5 class="mt-3">Seed:</h5>
                    <div class="input-group mb-3">
                        <input type="number" name='seed' id="seed" min="1" max="9999999999" maxlength="10" class="form-control" placeholder="Input a seed value here, or leave it blank if you don't care."
                        _="on input or change set val to my value then set max to my maxLength
                            if val is greater than max js(me,val,max) me.value = val.slice(0, max) end">
                        <button class="btn btn-light" type="button" id="button-seed"
                                _="on click js return Math.ceil(Math.random() * (9999999999 - 1111111111) + 1111111111) end set #seed's value to it"
                        >Random</button>
                    </div>
                    <h5>Presets:</h5>
                    <div class="d-flex flex-wrap gap-3">
                        <button type="button" class="btn btn-success col"
                                _="on click set the checked of .form-check-input to false
                                then set the checked of <#flag-s,#flag-t,#flag-w,#code-nocap/> to true
                                then set the value of <#mod-randomness/> to '0.5' then trigger update on <#mod-randomness/>
                                then set the value of <#mod-difficulty/> to '1.0' then trigger update on <#mod-difficulty/>">
                            Recommended
                        </button>
                        <button type="button" class="btn btn-danger col"
                                _="on click set the checked of .form-check-input to false
                                            then set the checked of <#flag-c,#flag-i,#flag-l,#flag-m,#flag-o,#flag-p,#flag-s,#flag-t,#flag-w,#code-monstermash,#code-scale,#code-nocap/> to true
                                then set the value of <#mod-randomness/> to '0.5' then trigger update on <#mod-randomness/>
                                then set the value of <#mod-difficulty/> to '1.0' then trigger update on <#mod-difficulty/>">
                            Full
                        </button>
                        <button type="button" class="btn btn-warning col"
                                _="on click set the checked of .form-check-input to false
                                then set the checked of <#flag-s,#flag-t,#flag-w,#code-fourkeys,#code-scale,#code-nocap/> to true
                                then set the value of <#mod-randomness/> to '0.5' then trigger update on <#mod-randomness/>
                                then set the value of <#mod-difficulty/> to '1.0' then trigger update on <#mod-difficulty/>">
                            FourKeys
                        </button>
                        <button type="button" class="btn btn-light col"
                                _="on click set the checked of .form-check-input to false
                                then set the checked of <#flag-s,#flag-t,#flag-w,#code-monstermash,#code-noscale,#code-nocap/> to true
                                then set the value of <#mod-randomness/> to '0.5' then trigger update on <#mod-randomness/>
                                then set the value of <#mod-difficulty/> to '1.0' then trigger update on <#mod-difficulty/>">
                            Standard Race
                        </button>
                        <button type="button" class="btn btn-outline-danger col"
                                _="on click set the checked of .form-check-input to false
                                then set the checked of <#flag-s,#flag-t,#flag-w,#code-scale,#code-monstermash,#code-bossy,#code-nocap/> to true
                                then set the value of <#mod-randomness/> to '0.6' then trigger update on <#mod-randomness/>
                                then set the value of <#mod-difficulty/> to '2.0' then trigger update on <#mod-difficulty/>">
                            Nightmare
                        </button>
                        <button type="button" class="btn btn-info col"
                                _="on click set the checked of .form-check-input to false
                                then set the value of <#mod-randomness/> to '0.5' then trigger update on <#mod-randomness/>
                                then set the value of <#mod-difficulty/> to '1.0' then trigger update on <#mod-difficulty/>">
                            Reset
                        </button>
                    </div>
                    <h5 class="mt-3">Flags:</h5>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flag-c" name="flag[]" value="c">
                                <label class="form-check-label" for="flag-c">Randomize characters</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flag-i" name="flag[]" value="i">
                                <label class="form-check-label" for="flag-i">Randomize items and equipment</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flag-l" name="flag[]" value="l">
                                <label class="form-check-label" for="flag-l">Randomize learnable spells</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flag-m" name="flag[]" value="m">
                                <label class="form-check-label" for="flag-m">Randomize monsters</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flag-o" name="flag[]" value="o">
                                <label class="form-check-label" for="flag-o">Randomize monster movements</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flag-p" name="flag[]" value="p">
                                <label class="form-check-label" for="flag-p">Randomize capsule monsters</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flag-s" name="flag[]" value="s">
                                <label class="form-check-label" for="flag-s">Randomize shops</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flag-t" name="flag[]" value="t">
                                <label class="form-check-label" for="flag-t">Randomize treasure chests</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flag-w" name="flag[]" value="w">
                                <label class="form-check-label" for="flag-w">Create an open-world seed</label>
                            </div>
                        </div>
                    </div>
                    <h5 class="mt-3">Secret Codes:</h5>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <h6 class="mt-3">OPEN WORLD RELATED</h6>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="code-airship" name="code[]" value="airship">
                                        <label class="form-check-label" for="code-airship">Start the game with the airship</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="code-bossy" name="code[]" value="bossy">
                                        <label class="form-check-label" for="code-bossy">Very random bosses (unbalanced even with scaling)</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="code-fourkeys" name="code[]" value="fourkeys">
                                        <label class="form-check-label" for="code-fourkeys">Open World, but there are only four keys</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <h6 class="mt-3">OPEN WORLD ENEMY SCALING</h6>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="code-scale" name="code[]" value="scale"
                                        _="on click set <#code-noscale/>'s checked to false">
                                        <label class="form-check-label" for="code-scale">Scale enemy status in open-world mode</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="code-noscale" name="code[]" value="noscale"
                                               _="on click set <#code-scale/>'s checked to false">
                                        <label class="form-check-label" for="code-noscale">Do not scale enemies in open-world mode</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <h6 class="mt-3">CHEATS</h6>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="code-easymodo" name="code[]" value="easymodo">
                                        <label class="form-check-label" for="code-easymodo">Every enemy dies in one hit</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="code-holiday" name="code[]" value="holiday">
                                        <label class="form-check-label" for="code-holiday">Enemies run from the player</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <h6 class="mt-3">OTHER</h6>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="code-monstermash" name="code[]" value="monstermash">
                                        <label class="form-check-label" for="code-monstermash">Randomize which monsters appear in dungeons</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="code-nothingpersonnelkid" name="code[]" value="nothingpersonnelkid">
                                        <label class="form-check-label" for="code-nothingpersonnelkid">Extremely aggressive enemies</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="code-anywhere" name="code[]" value="anywhere">
                                        <label class="form-check-label" for="code-anywhere">Equipment slots are randomized (breaks "Strongest")</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="code-nocap" name="code[]" value="nocap">
                                        <label class="form-check-label" for="code-nocap">Disable multiple capsule monsters being usable in a battle</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 position-relative">
                            <label for="mod-randomness" class="form-label position-absolute">Randomness</label>
                            <output id="output-randomness" class="d-block text-center">0.5</output>
                            <input type="range" class="form-range" id="mod-randomness" name="randomness" min="0.0" max="1.0" step="0.05" value="0.5"
                            _="on input or change trigger update end
                            on update put my value into #output-randomness"><br>
                            <small>This option controls how extreme the randomizations are. At 0.0, almost nothing will be randomized. At 1.0, enemies in the starting area will most likely have boss stats. Any open world setting squares the randomness (x^2).</small>
                        </div>
                    </div>
                    <div class="row mt-3 mb-5">
                        <div class="col-12 position-relative">
                            <label for="mod-difficulty" class="form-label position-absolute">Difficulty</label>
                            <output id="output-difficulty" class="d-block text-center">1.0</output>
                            <input type="range" class="form-range" id="mod-difficulty" name="difficulty" min="0.5" max="3.0" step="0.1" value="1.0"
                            _="on input or change trigger update end
                            on update put my value into #output-difficulty"><br>
                            <small>This option controls how extreme the difficulty modifier is. Any setting beyond 1.0 becomes unbalanced relatively quickly.</small>
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
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/htmx.min.js') }}"></script>

    <script src="{{ asset('assets/js/behaviors._hs') }}" type="text/hyperscript" ></script>


    <script src="{{ asset('assets/js/_hyperscript.min.js') }}"></script>
    </body>
</html>
