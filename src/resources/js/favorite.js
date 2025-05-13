window.addEventListener('DOMContentLoaded', function() {
    $(function() {
        let favoriteButtons = $('.shop__button-favorite'); // 複数のお気に入りボタンに対応

        favoriteButtons.on('click', function() {
            // ログインしていない場合はログイン画面へ遷移
            if (!($('#user_id').length)) {
                window.location.href = "/login";
                return; // 処理を中断
            }

            let $this = $(this);
            const shopId = $this.data('shop-id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/favorite',
                method: "POST",
                data: {
                    'shop_id': shopId,
                },
            })
            .done(function() {
                $this.toggleClass('change');
            })
            .fail(function(error) {
                console.error('お気に入り処理に失敗しました:', error);
            });
        });
    });
});