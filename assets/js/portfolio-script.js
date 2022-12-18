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
    1000);
	

    console.log("You Are In");
    $('div.portfolio-item').on('inview', function(event, isInView) {
        if (isInView) {
            console.log("It Is Visible");
        } else {
            console.log("It Is NOT Visible");
        }
      });

} )( jQuery );