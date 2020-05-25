$('.menuBtn').on('click', function(){
    $('.menu').toggleClass('menuOn');
});

//footer contact scroll
$('#contact').click(function(){ //scrolls to the about section
    $('html').animate({
        scrollTop: $("footer").offset().top //balances out the padding
    },10);
    $('.menu').removeClass('menuOn');
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