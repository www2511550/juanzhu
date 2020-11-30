<ul>

@if($common)
    @foreach($common as $vo)
    <li>
        <b><a href="{{ route('b.detail', ['id'=>$vo->id]) }}" target="_blank">{{ $vo->title }}</a></b>
        <p>
            <i>
               @if($vo->cover) <img src="{{$vo->cover}}" alt="{{$vo->title}}"> @endif
            </i>
            {{$vo->intro}}
        </p>
    </li>
    @endforeach
@endif

</ul>