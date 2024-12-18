<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Ajax通信するためのmetaタグ -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <!-- Google icon -->
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <!-- jQuery UIのCSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
    <!-- jQuery本体 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/2bd9a63489.js" crossorigin="anonymous"></script>
    <!-- dayjs -->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.11.13/dayjs.min.js"></script>
</head>
<script>
    $(function() {
        $('.header__menu').on('click', function() {

            document.body.classList.add('fixed'); /* bodyのクラスfixedを付与 */
            $(this).toggleClass('active');
            $('.gnav').fadeToggle();
            return false;
        });
    });
</script>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__menu" id="menu-button">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav class="gnav">
                <div class="gnav__wrapper">
                    <ul class="gnav-menu">
                        <li class="gnav-menu__item"><a href="/">Home</a></li>
                        @if(Auth::check())
                        <form action="/logout" method="post" name="logout">
                            @csrf
                            <li class="gnav-menu__item"><a onclick="document.logout.submit();">Logout</a></li>
                        </form>
                        <li class="gnav-menu__item"><a href="/mypage">Mypage</a></li>
                        @else
                        <li class="gnav-menu__item"><a href="/register">Registration</a></li>
                        <li class="gnav-menu__item"><a href="/login">Login</a></li>
                        @endif
                    </ul>
                </div>
            </nav>

            <div class="header__title">
                <a href="/">Rese</a>
            </div>
            <div class="search__content">
                <form action="/" method="get" class="search-form">
                    @csrf
                    @isset($areas)
                    <div class="search__area">
                        <select name="area_id" id="" onchange="this.form.submit()">
                            <option value="">All area</option>
                            @foreach($areas as $area)
                            <option value="{{ $area['id'] }}" {{ $area['id']==$param['area_id'] ? 'selected' : '' }}>{{ $area['area_name'] }}</option>
                            @endforeach
                        </select>
                        <div class="polygon"></div>
                    </div>
                    @endisset
                    @isset($categories)
                    <div class="search__genre">
                        <select name="category_id" id="" onchange="this.form.submit()">
                            <option value="">All genre</option>
                            @foreach($categories as $category)
                            <option value="{{ $category['id'] }}" {{ $category['id']==$param['category_id'] ? 'selected' : '' }}>{{ $category['category_name'] }}</option>
                            @endforeach
                        </select>
                        <div class="polygon"></div>
                    </div>
                    @endisset
                    <div class="search__word">
                        <span class="material-icons-outlined">
                            search
                        </span>
                        <input type="text" name="keyword" placeholder="Search..." value="{{ isset($param['keyword']) ? $param['keyword'] : '' }}" onchange="this.form.submit()">
                    </div>
                </form>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>