<div class="col-12 col-lg-6">
    <h6 class="mt-3">{{$cLabel}}</h6>
    <div class="row">
        @foreach ($data['code'] as $code)
            @isset($code['behavior']['on']) @php($on = "#".implode(",#",$code['behavior']['on'])) @endisset
            @isset($code['behavior']['off']) @php($off = "#".implode(",#",$code['behavior']['off'])) @endisset
            @isset($code['behavior']['set']) @php($set = $code['behavior']['set']) @endisset
            @if($code['category'] === $cKey && $code['displayed'] === true)
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="code-{{$code['key']}}" name="code[]" value="{{$code['key']}}" @if($code['enabled'] === true) checked="checked" @endif
                        _="on click set foo to bar
                        @isset($code['behavior']['on']) then set the checked of <{{$on}}/> to true @endisset
                        @isset($code['behavior']['off']) then set the checked of <{{$off}}/> to false @endisset
                        @isset($set)
                            @foreach ($set as $mod => $modData)
                                then set the value of <#{{$mod}}/> to '{{$modData['value']}}' then trigger update on <#{{$mod}}/>
                            @endforeach
                        @endisset
                        ">
                        <label class="form-check-label" for="code-{{$code['key']}}">{!! $code['value'] !!}</label>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
