@if($flag['displayed'] === true)
    @isset($flag['behavior']['on']) @php($on = "#".implode(",#",$flag['behavior']['on'])) @endisset
    @isset($flag['behavior']['off']) @php($off = "#".implode(",#",$flag['behavior']['off'])) @endisset
    @isset($flag['behavior']['set']) @php($set = $flag['behavior']['set']) @endisset
    <div class="col-12 col-lg-6">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="flag-{{$flag['key']}}" name="flag[]" value="{{$flag['key']}}" @if($flag['enabled'] === true) checked="checked" @endif
            _="on click set foo to bar
            @isset($flag['behavior']['on']) then set the checked of <{{$on}}/> to true @endisset
            @isset($flag['behavior']['off']) then set the checked of <{{$off}}/> to false @endisset
            @isset($set)
                @foreach ($set as $mod => $modData)
                    then set the value of <#{{$mod}}/> to '{{$modData['value']}}' then trigger update on <#{{$mod}}/>
                @endforeach
            @endisset
            ">
            <label class="form-check-label" for="flag-{{$flag['key']}}">{{$flag['value']}}</label>
        </div>
    </div>
@endif
