$(".cate-row li").on("click", function(){
	var interestId = $(this).data("interest-key");
	if(interestId !== undefined){
		$(".cate-row li").each(function(event) {
		    if($(this).data("interest-key") != interestId && $(this).data("interest-key") != undefined) {
		      	$(this).hide();
		    }else{
		    	$(this).show(100);
		    }
		});
		$(".search-timeline-details").each(function(event) {
		    if($(this).data("interest-key") != interestId && $(this).data("interest-key") != undefined) {
		      	$(this).hide();
		    }else{
		    	$(this).show(100);
		    }
		});
		$("#sel-int").val(interestId);
	}
});

$(".cate-row li img").on("click", function(e){
	e.stopPropagation();
	var interestId = $(this).closest("li").data("interest-key");
	console.log(interestId);
	if(interestId !== undefined ){

		var count = ($('.cate-row li').filter(function() {
		    return $(this).css('display') !== 'none';
		}).length);

		if(count > 3){
			$(this).closest("li").hide();
			$(".search-timeline-details").each(function(event) {
			    if($(this).data("interest-key") == interestId && $(this).data("interest-key") != undefined) {
			      	$(this).hide();
			    }
			});
		}
	}else{
		var id = $(this).attr('id');
		if(id="show_all"){
			$("#sel-int").val("");

			$(".cate-row li").each(function(event) { $(this).show(100); });
			$(".search-timeline-details").each(function(event) { $(this).show(100); });
		}
	}
});

$("#sel-int").on("change", function(e){
	var interestId = $(this).val();
	if(!!interestId){
		$(".cate-row li").each(function(event) {
		    if($(this).data("interest-key") != interestId && $(this).data("interest-key") != undefined) {
		      	$(this).hide();
		    }else{
		    	$(this).show(100);
		    }
		});
		$(".search-timeline-details").each(function(event) {
		    if($(this).data("interest-key") != interestId && $(this).data("interest-key") != undefined) {
		      	$(this).hide();
		    }else{
		    	$(this).show(100);
		    }
		});
	}else{
		$(".cate-row li").each(function(event) { $(this).show(100); });
		$(".search-timeline-details").each(function(event) { $(this).show(100); });
	}
	
});