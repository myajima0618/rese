<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <!-- jQuery UIのCSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
    <!-- jQuery本体 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
                        <li class="gnav-menu__item"><a href="/register">Registration</a></li>
                        <li class="gnav-menu__item"><a href="/login">Login</a></li>
                        <form action="/logout" method="post" name="logout">
                            @csrf
                            <li class="gnav-menu__item"><a onclick="document.logout.submit();">Logout</a></li>
                        </form>
                    </ul>
                </div>
            </nav>

            <div class="header__title">
                <a href="/">Rese</a>
            </div>
            <div class="search__content">
                @isset($areas)
                <div class="search__area">
                    <select name="area" id="">
                        <option value="">All area</option>
                        @foreach($areas as $area)
                        <option value="{{ $area['id'] }}">{{ $area['area_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                @endisset
                @isset($categories)
                <div class="search__genre">
                    <select name="genre" id="">
                        <option value="">All genre</option>
                        @foreach($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['category_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                @endisset
                <div class="search__word">
                    <input type="text" name="keyword" placeholder="Search...">
                </div>
            </div>

        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>