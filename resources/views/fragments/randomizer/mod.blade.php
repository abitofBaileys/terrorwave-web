@if($mod['displayed'] === true)
    <div class="row mt-3">
        <div class="col-12 position-relative">
            <label for="mod-{{$mod['key']}}" class="form-label position-absolute">{{$mod['label']}}</label>
            <output id="output-{{$mod['key']}}" class="d-block text-center">{{$mod['value']}}</output>
            <input type="range" class="form-range" id="mod-{{$mod['key']}}" name="{{$mod['key']}}" min="{{$mod['min']}}" max="{{$mod['max']}}" step="{{$mod['step']}}" value="{{$mod['value']}}"
                   _="on input or change trigger update end
                                on update put my value into #output-{{$mod['key']}}"><br>
            <small>{{$mod['description']}}</small>
        </div>
    </div>
@endif
