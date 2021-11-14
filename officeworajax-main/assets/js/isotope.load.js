(function ($) {
	"use strict";

    jQuery(document).ready(function($){

        //****************************
          // Isotope Load more button
          //****************************
/*          var initShow = 5; //number of items loaded on init & onclick load more button
          var counter = initShow; //counter for load more button
          var iso = $container.data('isotope'); // get Isotope instance
        
          loadMore(initShow); //execute function onload
        
          function loadMore(toShow) {
            $container.find(".hidden").removeClass("hidden");
        
            var hiddenElems = iso.filteredItems.slice(toShow, iso.filteredItems.length).map(function(item) {
              return item.element;
            });
            $(hiddenElems).addClass('hidden');
            $container.isotope('layout');
        
            //when no more to load, hide show more button
            if (hiddenElems.length == 0) {
              jQuery("#load-more").hide();
            } else {
              jQuery("#load-more").show();
            };
        
          }
        
          //append load more button
          $container.after('<button id="load-more"> Load More</button>');
        
          //when load more button clicked
          $("#load-more").click(function() {
            if ($('#filters').data('clicked')) {
              //when filter button clicked, set initial value for counter
              counter = initShow;
              $('#filters').data('clicked', false);
            } else {
              counter = counter;
            };
        
            counter = counter + initShow;
        
            loadMore(counter);
          });
          
          
          */
          
        /*$("#loadMore").click(function(){
          let pull_page = 1; let jsonFlag = true;
            if(jsonFlag){
            jsonFlag = false; pull_page++;
            $.getJSON("/wp-json/projects/all-posts?page=" + pull_page, function(data){
            	if(data.length){
            		var items = [];
            		$.each(data, function(key, val){
            			const arr = $.map(val, function(el) { return el });
            			const post_url = arr[1];
            			const post_title = arr[3];
            			const post_img = arr[4];
            			const post_featured = arr[5];
            			const post_cat = arr[6];
            			let featured = "";
            			if(post_featured){
            				featured = "featured";
            			}
            			let item_string = '<ul><li class="item">' + post_title + '</li></ul>'; 
            			items.push(item_string);
            		}); 
            		if(data.length >= 9){ 
            			$('li.loader').fadeOut(); 
            			$("#project-list").append(items);
            		}else{ 
            			$("#project-list").append(items); 
            			$('#project-loader').hide(); 
            			$('#ajax-no-posts').fadeIn(); 
            		} 
            	}else{ 
            		$('#project-loader').hide(); 
            		$('#ajax-no-posts').fadeIn(); 
            	} 
            }).done(function(data){ 
            	if(data.length){ jsonFlag = true; } 
            });}
        }); */  
  
    });


    jQuery(window).load(function(){

        
    });


}(jQuery));	