@php($pal = $preset['palette'])
@isset($preset['behavior']['on']) @php($on = "#".implode(",#",$preset['behavior']['on'])) @endisset
@isset($preset['behavior']['off']) @php($off = "#".implode(",#",$preset['behavior']['off'])) @endisset
@isset($preset['behavior']['set']) @php($set = $preset['behavior']['set']) @endisset
<button type="button" class="btn col"
        style="background-color: {{$pal['background-color']}}!important; border-color: {{$pal['border-color']}}!important; color: {{$pal['color']}}!important;"
        _="on click set the checked of .form-check-input to false
        @isset($preset['behavior']['on']) then set the checked of <{{$on}}/> to true @endisset
        @isset($preset['behavior']['off']) then set the checked of <{{$off}}/> to false @endisset
        @isset($set)
            @foreach ($set as $mod => $modData)
                then set the value of <#{{$mod}}/> to '{{$modData['value']}}' then trigger update on <#{{$mod}}/>
            @endforeach
        @endisset
        ">
    {{$preset['label']}}
</button>
