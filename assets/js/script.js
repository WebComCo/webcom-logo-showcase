jQuery(document).ready(function($) {
    $('.wls-logo-grid').each(function() {
        const $grid = $(this);
        const interval = parseInt($grid.data('interval')) || 3000;
        const swapCount = parseInt($grid.data('count')) || 1;

        let pool = JSON.parse($grid.find('.wls-hidden-pool').text() || "[]");
        if (!pool.length) return;

        setInterval(() => {
            let $items = $grid.find('.wls-logo-item');

            let allIndices = Array.from({length: 8}, (_, i) => i);
            let selectedIndices = allIndices.sort(() => 0.5 - Math.random()).slice(0, swapCount);

            selectedIndices.forEach(idx => {
                let $target = $items.eq(idx).find('.wls-logo-inner');

                $target.addClass('wls-fade-out');

                setTimeout(() => {
                    let next = pool.shift();
                    let current = {
                        src: $target.find('img').attr('src'),
                        link: $target.find('a').attr('href'),
                        title: $target.find('img').attr('alt')
                    };

                    $target.find('img').attr('src', next.src).attr('alt', next.title);
                    $target.find('a').attr('href', next.link);

                    pool.push(current);
                    $target.removeClass('wls-fade-out');
                }, 600);
            });

        }, interval);
    });
});