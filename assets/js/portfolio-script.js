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
	

} )( jQuery );