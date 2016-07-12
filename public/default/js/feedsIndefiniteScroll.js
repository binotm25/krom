$(window).scroll(fetchCreations);

function fetchCreations(){
	var page = $('.feeds-posts-endless-paginate').data('next-page');
	if(page !== null && page !== ""){
		clearTimeout($.data(this, "scrollCheck"));
		$.data(this, "scrollCheck", setTimeout(function(){
			var scroll_position = $(window).height() + $(window).scrollTop() + 10;
			if(scroll_position >= $(document).height()){
				$("#pageLoaderAnimation").show();
				$.get(page, function(data){
					$("#pageLoaderAnimation").hide();
					$('.feeds-posts-endless-paginate').append(data.posts);
					$('.feeds-posts-endless-paginate').data('next-page',data.nextPage);
				});
			}
		}, 350));
	}
}