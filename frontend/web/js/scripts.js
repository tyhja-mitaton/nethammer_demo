$('.product-slider').owlCarousel({
    navSpeed:1500,
    dragEndSpeed:1500,
    margin:30,
    responsive:{
        0:{
            items:2
        },
        768:{
            items:3
        }
    }
});

$('.reviews-slider').owlCarousel({
    dotsSpeed:1200,
    dragEndSpeed:1200,
    margin:30,
    center: true,
    loop: true,
    startPosition: 1,
    responsive:{
        0:{
            items:1
        },
        768:{
            items:3,
            autoWidth: true
        }
    }
});

$('.case-slider').owlCarousel({
    dotsSpeed:1200,
    dragEndSpeed:1200,
    margin:30,
    center: true,
    loop: true,
    startPosition: 1,
    responsive:{
        0:{
            items:1
        },
        768:{
            items:3,
            autoWidth: true
        }
    }
});

$('.home-slider').owlCarousel({
    dotsSpeed:1200,
    dragEndSpeed:1200,
    items:1
});