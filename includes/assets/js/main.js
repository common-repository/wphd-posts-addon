class WPHDWidgetHandlerClass extends elementorModules.frontend.handlers.Base {
  getDefaultSettings() {
    return {
      selectors: {
        carousel: '.carousel',  
        wrapper: '.posts-wrapper',        
      },
    };
  }
   
  getDefaultElements() {
    const selectors = this.getSettings( 'selectors' );
        
    return {
      $carousel: this.$element.find( selectors.carousel ), 
      $slideToShow: this.$element.find( selectors.wrapper ),    
    };
    
  }  
 
  // Bind the reverse Rows method on the thead .day column. 
   bindEvents() { 
    if(this.elements.$slideToShow[0].getAttribute('data-dots') === 'true'){
      var dots = true;
    }else {
      var dots = false;
    }  
    if(this.elements.$slideToShow[0].getAttribute('data-arrows') === 'true'){
      var arrows = true;
    }else{
      var arrows = false;
    }
 
      function is_url(str)
      {             
        if(str.substring(0,4) === 'http'){
          return true;
        }else{
          return false;
        }
      }       
  if(!is_url(this.elements.$slideToShow[0].getAttribute('data-prev'))){
    var prevButton = "<button type='button' class='slick-prev'><i class='"+this.elements.$slideToShow[0].getAttribute('data-prev')+"' aria-hidden='true'></i></button>";
  }else {
    var prevButton = "<button type='button' class='slick-prev'><img src='"+this.elements.$slideToShow[0].getAttribute('data-prev')+"' alt='Prev' class='slick-image' /></button>";
  }

  if(!is_url(this.elements.$slideToShow[0].getAttribute('data-next'))){
    var nextButton = "<button type='button' class='slick-next'><i class='"+this.elements.$slideToShow[0].getAttribute('data-next')+"' aria-hidden='true'></i></button>";
  }else {
    var nextButton = "<button type='button' class='slick-next'><img src='"+this.elements.$slideToShow[0].getAttribute('data-next')+"' alt='Next' class='slick-image' /></button>";
  }
   this.elements.$carousel.slick({
       
      dots: dots,
      arrows:arrows ,
      infinite: true,
      slidesToShow: this.elements.$slideToShow[0].getAttribute('data-columns'),     
      speed: this.elements.$slideToShow[0].getAttribute('data-speed'), 
      prevArrow:prevButton,
      nextArrow:nextButton,
      autoplay: true,  
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: this.elements.$slideToShow[0].getAttribute('data-columns'),
            slidesToScroll: 3,
            infinite: true,
            
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            
          }
        }
      ]
    }); 
    
   }   
}
jQuery( window ).on( 'elementor/frontend/init', () => {
  const addHandler = ( $element ) => {
      elementorFrontend.elementsHandler.addHandler( WPHDWidgetHandlerClass, {
          $element,
      } );
  };

  elementorFrontend.hooks.addAction( 'frontend/element_ready/wphd-posts-addon.default', addHandler );
} );