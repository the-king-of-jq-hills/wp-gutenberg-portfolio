( function( $ ) {

    var $container = $('.wpg-portfolio-front');
    
    $container.masonry({
        itemSelector: '.portfolio-item'
    });
    
    /**/
    setTimeout(
        function() 
        {
            $container.masonry('reloadItems').masonry();
            $container.imagesLoaded( function() {
                $container.masonry();
            });
        }, 
    600);

    $(function() {

        var swiper = new Swiper(".mySwiper", {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            effect: 'slide', 
            //effect: 'fade', 
            //effect: 'cube', 
            //effect: 'coverflow', 
            //effect: 'flip', 
            //effect: 'creative',
            //effect: 'cards',
        });	

    });
	

} )( jQuery );
