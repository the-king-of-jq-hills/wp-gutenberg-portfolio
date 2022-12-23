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

        var swiper = new Swiper(".wpgp-single-swiper", {
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


        var archiveImages = document.getElementsByClassName('wpgp-archive-images');
        if (archiveImages.length > 0) {
            var swiper = new Swiper(".wpgp-archive-images", {
                  // Optional parameters
                    direction: 'vertical',
                    loop: true,
                    autoplay: {
                        delay: 3000,
                    },
                    effect: 'creative',
                    creativeEffect: {
                      prev: {
                        // will set `translateZ(-400px)` on previous slides
                        translate: [0, 0, -400],
                      },
                      next: {
                        // will set `translateX(100%)` on next slides
                        translate: ['100%', 0, 0],
                      },
                    },                 
            });	
        }


    });
	

} )( jQuery );
