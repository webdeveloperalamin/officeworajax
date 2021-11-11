jQuery(function($){

	$(document).ready(function(){

		var $grid = $(".lemonbook-list-" + dynamicnumber + "");

		$(".lemonbook-shorting li").click(function(){
			$(".lemonbook-shorting li").removeClass("active");
			$(this).addClass("active");
		
			/*var selector = $(this).attr("data-filter");
			$grid.isotope({
				filter: selector,
			});*/
		});
		
		$grid.isotope({
			itemSelector: '.single-book-list',			
		});
	});
	var $grid = $(".lemonbook-list-" + dynamicnumber + "");
	$grid.isotope({
		// options
		itemSelector: '.single-book-list',
		percentPosition: true,
		layoutMode: 'fitRows',
	  });

	$('#loadmoreBtn').click(function(){

		var $grid = $(".lemonbook-list-" + dynamicnumber + "");
 
		var button = $(this),
		    data = {
			'action': 'loadmore',
			'query': lemonbook_loadmore_params.posts,
			'page' : lemonbook_loadmore_params.current_page,
			'taxnam' : $(this).data('filter'),
		};
 
		$.ajax({
			url : lemonbook_loadmore_params.ajaxurl, 
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text('Loading...'); 
			},
			success : function( data ){
				if( data != '' ) { 
					
					button.text('Load More');

					var $data = $(data);

					// Add all new posts to your grid
					$grid.append($data)
					.isotope('appended', $data);
					
					$grid.imagesLoaded(function(){
						$grid.isotope('layout');
					});

					lemonbook_loadmore_params.current_page++;
					//console.log(data);
 
					if ( lemonbook_loadmore_params.current_page == lemonbook_loadmore_params.max_page ){
						button.remove();						
					}						
				} else {
					button.remove();
				}
			}
		});

	});
});