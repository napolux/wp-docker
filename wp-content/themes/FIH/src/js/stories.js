jQuery(function($) {
            var $container = $('.grid');
        $container.isotope({
            itemSelector: '.element-item',
        });
        $('.filter-button-group').on( 'click', 'button', function() {
            var filterValue = $( this ).attr('data-filter');
            console.log(filterValue)
            $container.isotope({ filter: filterValue });
          });
          // change is-checked class on buttons
          $('.button-group').each( function( i, buttonGroup ) {
            var $buttonGroup = $( buttonGroup );
            $buttonGroup.on( 'click', 'button', function() {
              $buttonGroup.find('.is-checked').removeClass('is-checked');
              $( this ).addClass('is-checked');
            });
          });
        });