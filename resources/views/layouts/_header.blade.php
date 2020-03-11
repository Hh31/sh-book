<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand " href="{{ url('/') }}">
            看对上眼就行
        </a>
        <div class="btn-group">
            <ul class="navbar-nav mr-auto">
                @foreach($categories as $category)
                    <li class="nav-item "><a class="nav-link" href="{{route('books.category',['category' => $category->id])}}">{{ $category->name }}</a></li>
                @endforeach
                <li class="nav-item "><a class="nav-link" href="{{route('info.index')}}">查看帮助</a></li>
            </ul>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">


            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">
                <!-- 登录注册链接开始 -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link mt-1 mr-3 font-weight-bold" href="{{ route('books.create') }}">
                            <span class="glyphicon glyphicon-plus">上传</span>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
                @else
                    <p>
                        <a class="nav-link mt-1 mr-3 font-weight-bold" href="{{ route('books.create') }}">
                            <span class="glyphicon glyphicon-plus"></span>上传
                        </a>
                    </p>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px" height="30px">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a href="{{ route('books.create', Auth::id()) }}" class="dropdown-item">我的收藏</a>
                            <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">个人中心</a>
                            <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">编辑资料</a>
                            <a class="dropdown-item" id="logout" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">注销</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endguest
                <!-- 登录注册链接结束 -->
            </ul>
        </div>
    </div>
</nav>
