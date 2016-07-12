

/* Sign Up Form Input Swap Script */

$(document).ready(function() {
 $(".form-screen-1 .btn-next").click(function () {
    $(".form-screen-1").hide();
     $(".form-screen-2").fadeIn(1000);  
    return;
}); 
});

/* Interest Page Image Select Toggle Script */

$(document).ready(function(e){
    		$(".img-check").click(function(){
				$(this).toggleClass("check");
			});
	});


/* Edit Interest Page Image Select Toggle Script */

$(document).ready(function(e){
    		$(".img-check-2").click(function(){
				$(this).toggleClass("check-2");
			});
	});

/* My Profile Page Image Select Toggle Script */

$(document).ready(function(e){
    		$(".img-check-3").click(function(){
				$(this).toggleClass("check-3");
			});
	});



/*$(document).ready(function(e){
    		$(".img-check").click(function(){
				$(".overlay-2").toggleClass("overlayy");
                $(".overlay-2").toggleClass("overlay-1");
			});
	});

$(document).ready(function(e){
    		$(".overlay-2").click(function(){
				$(".overlay-2").toggleClass("overlayy");
                $(".overlay-2").toggleClass("overlay-1");
			});
	});*/


/* Upload Image Script */

$(function() {
  $(".uploadFile").on("change", function() {
    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

    if (/^image/.test(files[0].type)) { // only image file
      var reader = new FileReader(); // instance of the FileReader
      reader.readAsDataURL(files[0]); // read the local file

      reader.onloadend = function() { // set image data as background of div
        $(this).closest(".imagePreview").css("background-image", "url(" + this.result + ")");
      }
    }
  });

  $('.imagePreview').click(function(){
    alert($(this).closest('input').attr('class'));
    //$(this).closest('.uploadFile').trigger('click');
  });
});


$(function() {
  $("#uploadFile-2").on("change", function() {
    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

    if (/^image/.test(files[0].type)) { // only image file
      var reader = new FileReader(); // instance of the FileReader
      reader.readAsDataURL(files[0]); // read the local file

      reader.onloadend = function() { // set image data as background of div
        $("#imagePreview-2").css("background-image", "url(" + this.result + ")");
      }
    }
  });
  $('#imagePreview-2').click(function() {
    $('#uploadFile-2').trigger('click');
  });
});


/* Text Limit Counter */

maxCharacters = 60;

$('#count').text(maxCharacters);

$('#title').bind('keyup keydown', function() {
    var count = $('#count');
    var characters = $(this).val().length;
    
    if (characters > maxCharacters) {
        count.addClass('over');
    } else {
        count.removeClass('over');
    }
    
    count.text(maxCharacters - characters);
});

$('#inputValidation').bind('keydown', function(e) {
    console.log(e.which);
});

/* Swap Home Page Logo */


/*$('.icon').click(function () {
    $('.search').toggleClass('expanded');
});*/