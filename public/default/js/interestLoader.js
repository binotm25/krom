// function fetchCreations(){
// 	var page = $('.interestAreaLists').data('next-page');
// 	console.log(page);
// 	if(page !== null && page !== ""){
		
// 		$("#pageLoaderAnimation").show();
// 		$.get(page, function(data){
// 			$("#pageLoaderAnimation").hide();
// 			$(data.posts).insertBefore("#show_more");
// 			$('.interestAreaLists').data('next-page',data.nextPage);
// 		});
		
// 	}
// }

$("#show_more").on("click", function(){
	$(".remaining-line-interests").toggle({});
	var text = $(this).text();
	if(text == "SHOW MORE"){
		$(this).text("SHOW LESS");
	}else{
		$(this).text("SHOW MORE");
	}
});