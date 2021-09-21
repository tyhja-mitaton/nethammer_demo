$(document).ready(function () {
    $('.case-more a').on('click', function (e) {
        e.preventDefault();
        $(this).closest('.case').find('.case-text').toggleClass('full');
        $(this).find('span').toggle();
    });

    $(document).on('click', '.case-slider.slick-initialized .slick-slide .item__img-wrapper', function (e) {
        console.log(111111111);


        const $link = $(this);
        const $slider = $link.parents('.case-slider');

        const index = $link.data('index');
        const images = $slider.find('.item.slick-slide:not(.slick-cloned) .item__img-wrapper').map(function () {
            return {
                src: $(this).data('src'),
            };
        });

        const options = {
            index: index,
            type: 'image',
            arrows: true,
            infobar: false,
            buttons: ["slideShow", "fullScreen", "zoom", "arrowLeft", "arrowRight", "close"],
        };

        $.fancybox.open(images, options);
    });
});

function initCasesSlider($element) {
    // $element.find('.item__img-wrapper img').each(function () {
    //     this.src = $(this).attr('lazy-img');
    // });

    $element.on('init', function(event, slick) {
        slick.setPosition();
        slick.slickGoTo(0);
    });

    $element.slick({
        centerMode: true,
        dots: true,
        variableWidth: true,
        infinite: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 10000,
        slidesToScroll: 1,
        speed: 1000,
        touch: false,
        backFocus : false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    centerMode: false,
                    slidesToScroll: 1,
                    variableWidth: false,
                    adaptiveHeight: true,
                },
            },
        ],
    });
}

document.addEventListener("DOMContentLoaded", function() {
     var layloadSliders;

     if ("IntersectionObserver" in window) {
         layloadSliders = document.querySelectorAll(".case-slider");
         const slidersObserver = new IntersectionObserver(function (entries, observer) {
             entries.forEach(function (entry) {
                 if (entry.isIntersecting) {
                     const target = entry.target;
                     initCasesSlider($(target));
                     slidersObserver.unobserve(target);
                 }
             });
         });

         layloadSliders.forEach(function (slider) {
             slidersObserver.observe(slider);
         });
     } else {
         var lazyloadThrottleTimeout;
         layloadSliders = document.querySelectorAll(".case-slider");

         function lazyload() {
             if (lazyloadThrottleTimeout) {
                 clearTimeout(lazyloadThrottleTimeout);
             }

             lazyloadThrottleTimeout = setTimeout(function () {
                 var scrollTop = window.pageYOffset;
                 layloadSliders.forEach(function (target) {
                     if (target.offsetTop < (window.innerHeight + scrollTop)) {
                         initCasesSlider($(target));
                     }
                 });

                 if (layloadSliders.length === 0) {
                     document.removeEventListener("scroll", lazyload);
                     window.removeEventListener("resize", lazyload);
                     window.removeEventListener("orientationChange", lazyload);
                 }
             }, 20);
         }

         document.addEventListener("scroll", lazyload);
         window.addEventListener("resize", lazyload);
         window.addEventListener("orientationChange", lazyload);
     }
 });
