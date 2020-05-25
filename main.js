$('.menuBtn').on('click', function(){
    $('.menu').toggleClass('menuOn');
});

//main carousel
$('.mainCarousel').owlCarousel({
    items:1,
    loop:true,
    margin:0,
    autoplay:true,
    autoplayTimeout:6000,
});

//news carousel
$('.newsFlexMin').owlCarousel({
    items:1,
    loop:true,
    margin:10,
    autoplay:true,
    dots:false,
    autoplayTimeout:10000,
});

//menu changing colours
$(document).on("scroll", function(){
    var topPX = $(window).scrollTop();
    if(topPX > 100){
        $('.nav').addClass('whiteNav');
        $('.nav').find(".menuBtn").find(".bars").css("color","black");
    }
    if(topPX < 100){
        $('.nav').removeClass('whiteNav');
        $('.nav').find(".menuBtn").find(".bars").css("color","white");
    }
});

//footer contact scroll
$('#contact').click(function(){ //scrolls to the about section
    $('html').animate({
        scrollTop: $("footer").offset().top //balances out the padding
    },10);
    $('.menu').removeClass('menuOn');
});
//scrolling behavirour
$('#mainBtn, #mainBtnMob').click(function(){ //scrolls to the about section
    $('html').animate({
        scrollTop: $("#about").offset().top - 45 //balances out the padding
    },10);
});

//modal funcitonalities
var modal = $('.modalMain');
var image = $('.actualImg');
var imageWrapper = $('.imgWrapper');
var imgItem = $('.pflItem');
var currentImg = null;

imgItem.click(function(){
    var src = $(this).attr('src').replace(/^url\(['"](.+)['"]\)/, '$1').replace('small','large');
    modal.show();
    image.attr('src', src);
    currentImg = $(this);
});

//zoom function
imageWrapper.click(function(){
    $(this).toggleClass('zoom');
    $('html').toggleClass('scrollFix');
});

//turn off modal{
    $('.exitBtn').click(function(){
        modal.hide();
        image.attr('src', '#');
        imgItem.removeClass('picked');
    });

//packshots carousel
$('.modellingImages').owlCarousel({
    loop:true,
    margin:0,
    autoplay:true,
    autoplayTimeout:5000,
    dots:true,
    items:1,
});

//mailing function
$(".contact_form").submit(function (event) {
    var email = $(".input-email").val();
    var message = $(".input-message").val();

    if (email && message) {
        $.ajax({
            url: "php.php",
            type: "POST",
            data:  "email=" + email + "&message=" + message,
            success: function () {
                
            },
            error: function () {

            },
            complete: function () {
                $('.calendar').hide();
                $('.successAlert').show();
                $('.contact_form').trigger("reset");
            }
        });
    }

    event.preventDefault();
    return false;
});


$('.okBtn').click(function(){
    $('.successAlert').hide();
    $('.calendar').show();
});

// waiting for loading page
$(window).on('load', function(){
    var totalWidth = $(window).innerWidth();
    if(totalWidth > 1600){
        $('.pictures').tjGallery({
            row_min_height: 380,
        });
    }
    if(totalWidth < 1600 && totalWidth > 1300){
        $('.pictures').tjGallery({
            row_min_height: 250,
        });
    }
    if(totalWidth < 1300){
        $('.pictures').tjGallery({
            row_min_height: 200,
        });
    }    
});

