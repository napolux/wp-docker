jQuery(function($) {
            var $container = $('.grid');
        $container.isotope({
            itemSelector: '.element-item',
        });
        $('.filter-button-group').on( 'click', 'a', function() {
            var filterValue = $( this ).attr('data-filter');
            $container.isotope({ filter: filterValue });
          });
          // change is-checked class on buttons
          $('.button-group').each( function( i, buttonGroup ) {
            var $buttonGroup = $( buttonGroup );
            $buttonGroup.on( 'click', 'a', function() {
              $buttonGroup.find('.is-checked').removeClass('is-checked');
              $( this ).addClass('is-checked');
            });
          });

          // add class on item below when hovering in item
          $(".element-item").each(function() {
            $(this)
              .mouseover(function() {
                $container.isotope();
              })
              .mouseleave(function() {
                $container.isotope();
              });
          })

        });