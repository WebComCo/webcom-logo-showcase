jQuery(document).ready(function ($) {
    $('.wls-logo-grid').each(function () {
        const $grid = $(this);
        const interval = parseInt($grid.data('interval')) || 3000;
        const swapCount = parseInt($grid.data('count')) || 2;
        const duration = parseInt($grid.data('duration')) || 800;

        let pool = JSON.parse($grid.find('.wls-hidden-pool').text() || "[]");
        if (!pool.length) return;

        setInterval(() => {
            const $items = $grid.find('.wls-logo-item');
            let indices = Array.from({length: 8}, (_, i) => i).sort(() => 0.5 - Math.random()).slice(0, swapCount);

            indices.forEach(idx => {
                const $target = $items.eq(idx).find('.wls-logo-inner');
                const entranceAnimationName = $grid.data('entrance');
                const exitAnimationName = $grid.data('exit');

                // مرحله ۱: اجرای انیمیشن خروج

                $target.css('animation-duration', duration + 'ms');

// حذف کلاس‌های قبلی
                $target.removeClass(entranceAnimationName + ' ' + exitAnimationName);

// 👇 این خط خیلی مهمه (reflow اجباری)
                void $target[0].offsetWidth;

// حالا کلاس خروج رو اضافه کن
                $target.addClass('animated ' + exitAnimationName);

                // مرحله ۲: بعد از پایان exit
                setTimeout(() => {

                    // 🔥 عنصر رو مخفی نگه دار
                    $target.css({
                        'visibility': 'hidden',
                        /*'animation': 'none'*/
                    });

                    let next = pool.shift();
                    let current = {
                        src: $target.find('img').attr('src'),
                        link: $target.find('a').attr('href')
                    };

                    $target.find('img').attr('src', next.src);
                    $target.find('a').attr('href', next.link);
                    pool.push(current);

                    // 🔥 reflow اجباری
                    void $target[0].offsetWidth;

                    // آماده‌سازی برای ورود
                    $target.removeClass(exitAnimationName);

                    // دوباره visible کن
                    $target.css('visibility', 'visible');

                    // اجرای ورود
                    $target.addClass('animated ' + entranceAnimationName);

                    setTimeout(() => {
                        $target.removeClass(entranceAnimationName);
                        $target.removeClass('animated');
                    }, duration);

                }, duration);
            });

        }, interval);
    });
});