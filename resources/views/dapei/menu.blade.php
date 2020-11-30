


<header>
    <div class="tophead">
        <div class="logo"><a href="/">爱搭配</a>
            <span style="font-size: 12px;color: #de604f">2dapei.com.cn</span></div>
        <div id="mnav">
            <h2><span class="navicon"></span></h2>
            <ul>
                <li><a href="/">首页</a></li>
                @if($arrCate)
                    @foreach($arrCate as $c_name)
                        <li><a href="{{ route('dp.cname', ['name'=>$c_name]) }}">{{ $c_name }}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
        <nav class="topnav" id="topnav">
            <ul>
                <li><a href="/">首页</a></li>
                @if($arrCate)
                    @foreach($arrCate as $c_name)
                        <li><a href="{{ route('dp.cname', ['name'=>$c_name]) }}">{{ $c_name }}</a></li>
                    @endforeach
                @endif
            </ul>
        </nav>
    </div>
</header>
