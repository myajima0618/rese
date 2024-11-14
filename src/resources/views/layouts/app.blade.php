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
                        <li class="gnav-menu__item"><a href="">Home</a></li>
                        <li class="gnav-menu__item"><a href="">Registration</a></li>
                        <li class="gnav-menu__item"><a href="">Login</a></li>
                    </ul>
                </div>
            </nav>

            <div class="header__title">
                <a href="/">Rese</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>