//case study carousel
$('.caseCarousel').owlCarousel({
    loop:true,
    margin:0,
    autoplay:true,
    autoplayTimeout:10000,
    dots:false,
    responsive:{
        0:{
            items:1,
        },
        700:{
            items:2,
        },
        970:{
            items:2,
            autoplay:false,
        }
    }
});

//case study carousel
$('.caseCarouselStudy').owlCarousel({
    loop:true,
    margin:10,
    autoplay:true,
    autoplayTimeout:10000,
    dots:false,
    responsive:{
        0:{
            items:1,
        },
        700:{
            items:2,
        },
        970:{
            items:3,
            autoplay:false,
        }
    }
});

var video = $('.video').width()
$('.modelText, packshot').css("max-width", video)