jQuery(function($){

	$(document).ready(function(){

		var $grid = $(".lemonbook-list-" + dynamicnumber + "");

		$(".lemonbook-shorting li").click(function(){
			$(".lemonbook-shorting li").removeClass("active");
			$(this).addClass("active");
		});
	});
	

	$('.lemonbook-shorting li').click(function(){

		var $grid = $(".lemonbook-list");
 
		//var filterbutton = $(this),
		var data = {
				'action': 'filter',
				'query': lemonbook_filter_params.posts,
				'page' : lemonbook_filter_params.current_page,
				'taxnam' : $(this).data('filter'),
			};
 
			console.log(data.taxnam);

			$.ajax({
				url : lemonbook_filter_params.ajaxurl, 
				data : data,
				type : 'POST',
				dataType: 'html',
				beforeSend : function ( xhr ) {
					//button.text('Loading...'); 
				},
				success : function( data ){
					if( data ) { 
						
						//button.text('Load More');
						
						// Add all new posts to your grid
						$(".book-list").html(data);
						
						/*$grid.imagesLoaded(function(){
							$grid.isotope('layout');
						});*/
						//console.log(data);
						//lemonbook_filter_params.current_page++;
						//console.log($data);
	
												
					} 
				}
			});

	});
});