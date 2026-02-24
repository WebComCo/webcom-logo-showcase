jQuery(document).ready(function ($) {
    $('.wls-logo-grid').each(function () {
        const $grid = $(this);
        const interval = parseInt($grid.data('interval')) || 3000;
        const swapCount = parseInt($grid.data('count')) || 2;
        const duration = parseInt($grid.data('duration')) || 800;
        const staggerDelay = 250;

        let pool = JSON.parse($grid.find('.wls-hidden-pool').text() || "[]");
        if (!pool.length) return;

        setInterval(() => {
            const $items = $grid.find('.wls-logo-item');
            let indices = Array.from({length: 8}, (_, i) => i).sort(() => 0.5 - Math.random()).slice(0, swapCount);

            indices.forEach((idx, i) => {
                setTimeout(() => {
                    const $target = $items.eq(idx).find('.wls-logo-inner');
                    const entranceAnimationName = $grid.data('entrance');
                    const exitAnimationName = $grid.data('exit');

                    // مرحله ۱: آماده‌سازی و اجرای انیمیشن خروج
                    $target.css('animation-duration', duration + 'ms');

                    // پاکسازی کلاس‌های قبلی برای اطمینان
                    $target.removeClass('animated ' + entranceAnimationName + ' ' + exitAnimationName);

                    // Reflow اجباری برای اعمال مجدد انیمیشن
                    void $target[0].offsetWidth;

                    // افزودن کلاس خروج
                    $target.addClass('animated ' + exitAnimationName);

                    // مرحله ۲: تعویض محتوا دقیقا بعد از پایان انیمیشن خروج
                    setTimeout(() => {
                        // مخفی کردن موقت برای جلوگیری از پرش تصویر
                        $target.css('visibility', 'hidden');

                        let next = pool.shift();
                        let current = {
                            src: $target.find('img').attr('src'),
                            link: $target.find('a').attr('href')
                        };

                        // تعویض دیتا
                        $target.find('img').attr('src', next.src);
                        $target.find('a').attr('href', next.link);
                        pool.push(current);

                        // Reflow اجباری
                        void $target[0].offsetWidth;

                        // حذف کلاس خروج و بازگرداندن وضعیت نمایش
                        $target.removeClass(exitAnimationName);
                        $target.css('visibility', 'visible');

                        // مرحله ۳: اجرای انیمیشن ورود
                        $target.addClass(entranceAnimationName);

                        // مرحله ۴: پاکسازی نهایی کلاس‌ها بعد از اتمام انیمیشن ورود
                        setTimeout(() => {
                            $target.removeClass('animated ' + entranceAnimationName);
                        }, duration);

                    }, duration);

                }, i * staggerDelay);
            });

        }, interval);
    });
});