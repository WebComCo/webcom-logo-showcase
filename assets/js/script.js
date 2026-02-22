jQuery(document).ready(function($) {
    $('.wls-logo-grid').each(function() {
        const $grid = $(this);
        const interval = parseInt($grid.data('interval')) || 3000;
        const changeCount = parseInt($grid.data('change-count')) || 1;

        let pool = JSON.parse($grid.find('.wls-hidden-pool').text());
        if (pool.length === 0) return;

        setInterval(function() {
            let $items = $grid.find('.wls-logo-item');

            // انتخاب چند خانه تصادفی برای تعویض
            let indices = Array.from({length: $items.length}, (_, i) => i)
                .sort(() => 0.5 - Math.random())
                .slice(0, changeCount);

            indices.forEach(index => {
                let $target = $items.eq(index);

                // شروع انیمیشن خروج
                $target.addClass('wls-fade-out');

                setTimeout(function() {
                    if (pool.length > 0) {
                        // لوگوی فعلی که دارد خارج می‌شود
                        let currentLogo = {
                            src: $target.find('img').attr('src'),
                            link: $target.find('a').attr('href'),
                            title: $target.find('img').attr('alt')
                        };

                        // برداشتن لوگوی جدید از اول صف
                        let nextLogo = pool.shift();

                        // جایگزینی محتوا
                        $target.find('img').attr('src', nextLogo.src).attr('alt', nextLogo.title);
                        $target.find('a').attr('href', nextLogo.link);

                        // فرستادن لوگوی قبلی به انتهای صف (چرخش عادلانه)
                        pool.push(currentLogo);
                    }

                    // انیمیشن ورود
                    $target.removeClass('wls-fade-out');
                }, 600);
            });
        }, interval);
    });
});