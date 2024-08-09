$(document).ready(function() {


    $(window).on('scroll', function() {
        if ($(window).width() < 1200) {
            if ($(this).scrollTop() > 30) {
                $('.header').css('background-color', '#141429');
            } else {
                $('.header').css('background-color', '');
            }
        } else {
            $('.header').css('background-color', '');
        }
    });


    $('.burger-menu').on('click', function() {
        $(this).toggleClass('active');
        $('.nav').toggleClass('open');
        $('.burger-wrapper').toggleClass('active');
        $('.nav-burger').toggleClass('show');
    });
    //Поява хмаринки після затримки в 3 секунди
    setTimeout(function() {
        $('.speech-bubbles').css({
            'opacity': '1',
            'transform': 'scale(1)'
        });
    }, 3000);
    

    var swiper;
    function initializeSwiper() {
    swiper = new Swiper('.swiper-container', {
        direction: 'vertical',
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 1000,
        mousewheel: true,
        parallax: true,
        on: {
            slideChange: function() {
                if (swiper.activeIndex !== 0) {
                    app.stage.children.forEach(child => {
                        if (starPool.includes(child)) {
                            child.visible = false; // Приховуємо зірочки
                        }
                    });
                    $('.pixi-canvas').css('z-index', '2');
                } else {
                    app.stage.children.forEach(child => {
                        if (starPool.includes(child)) {
                            child.visible = true; // Показуємо зірочки
                        }
                    });
                    $('.pixi-canvas').css('z-index', '0');
                }
            },
        },
    });
}

    function destroySwiper() {
        if (swiper) {
            var backgroundImageStyle = $('.present').css('background-image');
            var backgroundFormStyle = $('.form').css('background-image');
            swiper.destroy(true, true);
            swiper = undefined;

            $('.present').css('background-image', backgroundImageStyle);
            $('.form').css('background-image', backgroundFormStyle);
        }
    }

    function updateSwiper() {
        if ($(window).width() >= 1200) {
            if (!swiper) {
                initializeSwiper();
            }
        } else {
            destroySwiper();
        }
    }
    function updateSnowflake() {
        let snowflakeParalax = -(window.innerHeight * 2 - 590);
        $('.snowflake-container').attr('data-swiper-parallax-y', snowflakeParalax);
    }

    updateSwiper();

    let previousWidth = $(window).width();
    $(window).on('resize', function() {
        let currentWidth = $(window).width();
        updateSwiper();
        if (previousWidth < 1200 && currentWidth >= 1200) {
            $('html, body').scrollTop(0);
        }

        previousWidth = currentWidth;
        updateSnowflake();
    });
    updateSnowflake();


    //pixi.js для зірочок та снігу
    const app = new PIXI.Application({
        width: window.innerWidth,
        height: window.innerHeight,
        backgroundAlpha: 0,
        view: document.createElement('canvas')
    });

    $('.pixi-canvas').append(app.view);

    // Пул об'єктів для зірочок
    const starPool = [];
    const maxStars = 50;

    // Пул об'єктів для частинок снігу
    const snowflakePool = [];
    const maxSnowflakes = 30; // Кількість частинок снігу у пулі

    // Функція для створення п'ятикутної зірочки
    function createStar(size, x, y) {
        const star = new PIXI.Graphics();
        const points = [];
        const radius = size / 2;
        const innerRadius = size / 4;

        for (let i = 0; i < 5; i++) {
            let angle = Math.PI / 2 + i * (2 * Math.PI / 5);
            points.push(radius * Math.cos(angle), radius * Math.sin(angle));
            angle += Math.PI / 5;
            points.push(innerRadius * Math.cos(angle), innerRadius * Math.sin(angle));
        }

        star.beginFill(0xFCF9BF, 0.8);
        star.drawPolygon(points);
        star.endFill();
        star.x = x;
        star.y = y;
        return star;
    }

    // Функція для створення частинки снігу
    function createSnowflake(x, y) {
        const snowflake = new PIXI.Graphics();
        snowflake.beginFill(0xFFFFFF, 0.8);
        snowflake.drawCircle(0, 0, 5); // Радіус кола 5 пікселів
        snowflake.endFill();
        snowflake.x = x;
        snowflake.y = y;

        // Додаємо індивідуальні параметри для анімації
        snowflake.speed = Math.random() * 2 + 1; // Швидкість падіння
        snowflake.amplitude = Math.random() + 5; // Амплітуда коливання
        snowflake.offset = Math.random() * 100; // Зсув для фазового зміщення

        return snowflake;
    }

    // Ініціалізуємо пул об'єктів для зірочок
    for (let i = 0; i < maxStars; i++) {
        let size = Math.random() > 0.5 ? 10 : 15; // Розміри зірочок
        let x = Math.random() * app.screen.width;
        let y = Math.random() * app.screen.height;

        let star = createStar(size, x, y);
        starPool.push(star);
        app.stage.addChild(star);
    }

    // Ініціалізуємо пул об'єктів для частинок снігу
    for (let i = 0; i < maxSnowflakes; i++) {
        let x = Math.random() * app.screen.width;
        let y = Math.random() * app.screen.height;

        let snowflake = createSnowflake(x, y);
        snowflakePool.push(snowflake);
        app.stage.addChild(snowflake);
    }
    // Функція для мерехтіння
    function animateStars() {
        starPool.forEach(star => {
            star.alpha = 0.5 + 0.5 * Math.sin(Date.now() * 0.005 + star.x * 0.01);
        });
    }

    // Функція для анімації частинок снігу
    function animateSnowflakes() {
        snowflakePool.forEach(snowflake => {
            snowflake.y += snowflake.speed; // Рух вниз
            snowflake.x += Math.sin(Date.now() * 0.01 + snowflake.offset) * snowflake.amplitude; // Коливання в сторони

            if (snowflake.y > app.screen.height) {
                snowflake.y = -10; // Перезапускаємо частинку зверху
                snowflake.x = Math.random() * app.screen.width; // Нове випадкове положення по x
            }
        });
    }

    // Анімація мерехтіння
    app.ticker.add(() => {
        animateStars();
        animateSnowflakes();
    });

    // Налаштування розміру канваса при зміні розміру вікна
    $(window).on('resize', function() {
        app.renderer.resize(window.innerWidth, window.innerHeight);
        animateStars();
        animateSnowflakes();
    });


    function updatePresentsContent(element) {
        var title = element.data('title');
        var description = element.data('description');
        var image = element.data('image');

        $('#present-title').text(title);
        $('#present-description').html(description.replace(/\n/g, '<br>'));
        $('#present-image').attr('src', image);
    }

    $('.item').on('click', function() {
        $('.item').removeClass('active');
        $(this).addClass('active');
        updatePresentsContent($(this));
    });

    var activeItem = $('.item.active');
    if (activeItem.length) {
        updatePresentsContent(activeItem);
    }


    function updateCheckmark() {
        $('.custom-checkbox').each(function() {
            var $checkbox = $(this).find('input[type="checkbox"]');
            var $checkmark = $(this).find('.checkmark');
            if ($checkbox.is(':checked')) {
                $checkmark.html('<div class="checkmark-icon"></div>');
            } else {
                $checkmark.empty();
            }
        });
    }

    // Initial checkmark update
    updateCheckmark();

    // Update checkmark on checkbox change
    $('.custom-checkbox').on('click', function() {
        var $checkbox = $(this).find('input[type="checkbox"]');
        $checkbox.prop('checked', !$checkbox.prop('checked')).trigger('change');
        updateCheckmark();
    });
});