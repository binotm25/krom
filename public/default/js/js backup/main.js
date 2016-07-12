
/* Sign Up Form Input Swap Script */
var pathArray = window.location.pathname.split( '/' );
var urlPath = location.origin+'/'+pathArray[1]+'/'+pathArray[2];
function validateForm(){
    var title = $("#title").val();
    var description = $("#description").val();
    var error = 0;
    if(title == ""){
        $("#title").css('border','1px solid #a94442');
        error = 1;
    }
    if(description == ""){
        $("#description").css('border','1px solid #a94442');
        error = error + 1;
    }

    if(error > 0){
        return false;
    }else{
        return true;
    }
}

$(document).ready(function(e) {

    $("body").tooltip({
        selector: '[data-toggle="tooltip"]'
    });

    $(document).on("click", '.tag-pic', function(){
        $(this).prev("a").fadeToggle(300);
    });
    
    /* Interest Page Image Select Toggle Script */

    $(".form-screen-1 .btn-next").click(function () {
        $(".form-screen-1").hide();
        $(".form-screen-2").fadeIn(1000);  
        return;
    }); 

    /* Edit Interest Page Image Select Toggle Script */

    $(document).on("click", ".img-check", function(){
        $(this).toggleClass("check");
    });

    /* My Profile Page Image Select Toggle Script */
    $(".img-check-2").click(function(){
        $(this).toggleClass("check-2");
    });

    $(".img-check-3").click(function(){
        $(this).toggleClass("check-3");
    });

    $("#email").blur(function(){
        $(".checkEmail").html("<img src='"+urlPath+"/default/images/icons/squares.gif'>");

        var email = $(this).val();
        $(this).next(".checkEmail").removeClass("hidden");
        if(!!email){
            $.ajax({
                url: urlPath+"/checkEmail",
                type: "POST",
                data:  {email:email},
                success:function(data){
                    $(".checkEmail").html("<p style='color:white;'>"+data+"</p>");
                },
                error:function(data){
                    var errorsHtml = "";
                    var errors = data.responseJSON;
                    $.each( errors , function( key, value ) {
                        errorsHtml += '<p>' + value[0] + '</p>'; //showing only the first error.
                    });
                    $(".checkEmail").html(errorsHtml);
                }
            });
        }else{
            $(".checkEmail").html("<p style='color:white;'>Please Enter an Email Address</p>");
        }
    });

    $(document).on("click", ".praised-more", function(){
        var val = $(this).attr('data-id');
        $(".uil-ring-css").html("<div></div>");
        $(".praise-more-get").remove();
        $("#praisePop").modal('show');
        $.ajax({
            url: urlPath+"/getPraise",
            type: "POST",
            data: {creationId:val},
            success:function(data){
                $(".uil-ring-css").empty();
                // data-toggle="tooltip" data-placement="right" title="{{ $praiseId->user->name }}"
                
                $("#praisePopBody").append(data);
            },
            error:function(data){
                $.each(data, function(index, element) {
                    console.log(element);
                });
            }
        });
    });

    //var top = $(".sidebar-navbar-collapse").offset().top;
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

function loadPic(changeArea, targeArea, targetParent){
    $(document).on("change",changeArea, function(evt){
        var target = $(this).prev(targeArea);
        var parent = target.parent(targetParent);
        var targetClass = (target.attr('class'));
        var files = evt.target.files;

        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
        if (/^image/.test(files[0].type)) { // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function() { // set image data as background of div
                for(var i = 0; i = files[i]; i++){
                }
                target.css("background-image", "url(" + this.result + ")");
            }
        }

    });
}

var percent = $("#percent"), status = $("#status"), UploadPercent = $("#UploadPercent");
function progress(e){

    if(e.lengthComputable){
        var max = e.total;
        var current = e.loaded;

        var Percentage = Math.round((current * 100)/max);
        UploadPercent.html(Percentage+"%");
        percent.css('width', Percentage + '%');


        if(Percentage >= 100)
        {
            UploadPercent.text('Uploaded!');
        }
    }  
}

$(function() {
    $(document).on("click", '.like', function(){
        var cls = $(this);
        var id = $(this).attr('data-id');
        var count = $(this).siblings('li.full-praise').find("span.data-praiseCount");
        var dataPraiseCount = count.text();
        if(!!id){
            $.ajax({
                url: urlPath+"/praise/"+id,
                type: "POST",
                data:  id,
                success:function(data){
                    if(data[0] == 0){
                        if(!!dataPraiseCount && dataPraiseCount > 1){ count.text(dataPraiseCount - 1); }
                        cls.children().attr('style','color:#c6c6c5;');
                        $('li[data-praise="'+data[1]+'"]').remove();

                    }else if(data[0] == 1){
                        if(data[1] == ""){
                            data[1] = "user.png";
                        }
                        var wathi = '<li class="if-praise" data-praise="'+data[3]+'">'+
                        '<a href="'+urlPath+'/'+data[2]+'/profile">'+
                            '<img src="'+urlPath+'/default/images/people/'+data[1]+'" width="29" height="29"></a></li>';
                        cls.children().attr('style','color:red');
                        $(wathi).insertAfter(cls);
                    }else{
                        $("#ImageUploadProgress").modal('show');
                    }
                },
                error:function(data){
                    alert(data);
                }
            });
        }
    });
});

var XHR = new window.XMLHttpRequest();

function ajaxImageUpload(e, id, imageType)
{   
    $("#saveUploadFile").text('Saved').hide();
    // $("#saveUploadFile").attr('data-dismiss','modal');
    $("#cancelUpload").show();
    $("#ImageUploadProgress").modal('show');
    e.preventDefault();
    var data = new FormData();
    data.append('userImage', $('#'+id).prop('files')[0]);
    $(".uil-ring-css").html("<div></div>");
    var AJAX = $.ajax({
        url: urlPath+"/profile",
        type: "POST",
        data:  data,
        xhr: function() {
            var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){
                myXhr.upload.addEventListener('progress',progress, false);
            }
            return myXhr;
        },
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
            $.post( urlPath+"/profilePic", { logic: 1, file: data, type: imageType }, function( res ) {
                if(res != 'error'){
                    $("#revertUploadFile, #cancelUpload").hide();
                    // $("#saveUploadFile").text('Saved');
                    if(imageType == 'profile'){
                        $(".profile-pic-2").attr("src", urlPath+"/"+res);
                        $(".user-icons-user img").attr("src", urlPath+"/"+res);
                    }else if(imageType == 'cover'){
                        $("img.cover-pic-2").attr("src", urlPath+"/"+res);
                    }
                    $("#ImageUploadProgress").modal('hide');
                    $(".uil-ring-css").remove();
                    // $("#saveUploadFile").show(200);
                }else{
                    $(".modal-body").html("<h2 class='text-center text-danger'>ERROR!!!</h2>");
                    $("#saveUploadFile").text('Close').show(200);
                }
            });
            // $("#revertUploadFile").click(function(){
            //     $.post( urlPath+"/profilePic", { logic: 0, file: data }, function( res ) {
            //         (".modal-body").html("<h2 class='text-center text-danger'>"+res+"</h2>");
            //     });
            // });
        },
        error: function(){}
    });
    $("#cancelUpload").on('click', function(e){  
        AJAX.abort();
        $("#ImageUploadProgress").modal('hide');
    });
}

$(function() {

    var percent = $('#percent');
    var status = $('#status');

    $( document ).on( 'click', '.imagePreview, .imagePreview-1', function() {
        var attr = $(this).attr('class');
        $(this).next('input').trigger('click');
        loadPic('.uploadFile', '.'+attr, '.creation-pic');
    });

    $('.camera-edit-1').click(function(evt){
        evt.stopPropagation();
        $("#media").trigger('click');        
    });

    $('.camera-edit-2').click(function(e){
        e.stopPropagation();
        $("#profilePic").trigger('click');
    });

    $("#profilePic").off('change').on("change", function(e) {
        var file = this.files[0];
        var fileType = file["type"];
        var ValidImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            $("#title-label").html('<span style="color:red;">Upload Failed!</span>');
            $(".reason").text("Selected File type is not an Image! Or its invalid!");
            $("#msgPopUp").modal('show');
        }else{
            ajaxImageUpload(e, "profilePic", "profile");
            file = "";
        }
    });

    $("#media").off('change').on("change", function(e) {
        var file = this.files[0];
        var fileType = file["type"];
        var ValidImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            $("#title-label").html('<span style="color:red;">Upload Failed!</span>');
            $(".reason").text("Selected File type is not an Image! Or its invalid!");
            $("#msgPopUp").modal('show');
        }else{
            ajaxImageUpload(e, "media", "cover");
            file = "";
        }
    });
});

function handleFileSelect(evt, id, count) {
    var files = evt.target.files; // FileList object
    var target = evt.target;
    if(count !== ""){
        if(files.length > 3 - count){
            $("#title-label").text('ERROR');
            $(".reason").text("Only "+ (3 - count) +" Images are allowed in the Featured Photos. Please Choose Again.");
            $("#msgPopUp").modal('show');
            return false;
        }
    }
    if(id == "wathi" && files.length > 0){
        $(".imagePreview").slice(1).remove();
        if(files.length > 3){
            $("#title-label").text('ERROR');
            $(".reason").text("Only 3 Images are allowed in the Featured Photos. Please Choose Again.");
            $("#msgPopUp").modal('show');
            return false;
        }
        var className = "imagePreview";
    }else if(id == "wathi1" && files.length > 0){
        $(".imagePreview-1").slice(1).remove();
        var className = "imagePreview-1";
    }else if(id == "editImage1" && files.length > 0){

        $(".imagePreview").slice(1).remove();
        var className = "imagePreview";

    }else if(id == "editImage2" && files.length > 0){

        $(".imagePreview-1").slice(1).remove();
        var className = "imagePreview-1";

    }
    // Loop through the FileList and render image files as thumbnails.
    for (var i = 1, f; f = files[i]; i++) {
        // Only process image files.
        if (!f.type.match('image.*')) {
            continue;
        }
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
            // Render thumbnail.
            var span = "<div class='"+className+"' style='background-image: url(" + this.result + ");'></div>";
            //var span = document.createElement('div');
            //span.innerHTML = ['<img class="thumb" src="', e.target.result,
            //                  '" title="', escape(theFile.name), '" width="32" height="32" />'].join('');
              
            $('#'+id).append(span, null);
        };

    })(f);
        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
        if(!!count){
            if(i > 1 - count){ return false; }
        }else{
            if(i > 1 && id == "wathi"){ return false; }
        }
        
    }
}
// Add Creation Featured Photos Section
$("#uploadFile").off('change').on('change', function(e){
    handleFileSelect(e, "wathi", "");
});

// Add Creation Other Photos Section
$("#uploadFile4").off('change').on('change', function(e){
    handleFileSelect(e, "wathi1", "");
});

// Edit Creation Add More Featured Photos Section
$(document).on("change", "#uploadFileEdit", function(e){
    var count = $(this).prev().find('img').data('count-images');
    handleFileSelect(e, "editImage1", count);
});

// Edit Creation Add More Other Photos Section
$("#uploadFileEdit1").off('change').on('change', function(e){
    handleFileSelect(e, "editImage2", "");
});


//document.getElementById('uploadFile').addEventListener('change', handleFileSelect, false);

$("#createSave").click(function(){
    var $fileUpload = $("input[type='file']");
    if (parseInt($fileUpload.get(0).files.length)>3){
        $("#title-label").text('ERROR');
        $(".reason").text("Only 3 Images are allowed in the Featured Photos.");
        $("#msgPopUp").modal('show');
        return false;
    }
});

function creationUpDel(data, thisClass){
    var type = data.type;
    var creationId = data.creationId;
    if(type == 1){
        var id = data.id;
        $("#cancelUpload").show();
        $("#ImageUploadProgress").modal('show');
        var data = new FormData();
        data.append('uploadFile', $('#'+id).prop('files')[0]);
        $(".uil-ring-css").html("<div></div>");
        var AJAX = $.ajax({
            url: urlPath+"/removeImageCreation/"+creationId,
            type: "POST",
            data:  data,
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',progress, false);
                }
                return myXhr;
            },
            contentType: false,
            cache: false,
            processData:false,
            success: function(res){
                $(".uil-ring-css").empty();
                if(res != 'error'){
                    thisClass.parent().parent().attr('style','background-image:url("'+urlPath+"/"+res+'")');
                    $("#ImageUploadProgress").modal('hide');
                }else{
                    $(".modal-body").html("<h2 class='text-center text-danger'>ERROR!!!</h2>");
                }
            },
            error: function(){}
        });
        $("#cancelUpload").on('click', function(e){  
            AJAX.abort();
            $("#ImageUploadProgress").modal('hide');
        });
    }else{
        $.ajax({
            url: urlPath+"/removeImageCreation/0",
            type: "POST",
            data: data,
            success:function(data){
                if(type == 0){
                    if(data == 1){
                        $("#deleteImage").hide(100);
                        $("#title-label").text("Your Image has been Deleted!");
                        $(thisClass).parent().parent().remove();
                        $("#msgPopUp").modal('hide');
                        return true;
                    }else{
                        $("#deleteImage").hide(100);
                        $("#title-label").text(data);
                    }
                }
            },
            error:function(data){
                alert(data);
            }
        });
    }
}

$(".edit-images img").click(function(e){
    e.stopPropagation();
    $("#addButton button").not(':last').remove();
    var val = $(this).attr('data-id');
    var thisClass = $(this);
    var className = $(this).attr('class');
    var parentClass = $(thisClass).parent().parent().attr('class');
    
    if(className == "clickForDelete"){
        if(parentClass === "imagePreview-3 "){

            var counterForFeaturedImages = $(".imagePreview-3").length;
            if(counterForFeaturedImages == 1){
                $("#title-label").addClass('text-center').text("This is the last Featured Photo and cannot be deleted. You need to have atleast one Featured Photo.");
                $("#msgPopUp").modal('show');
            }else{
                $("#title-label").text("Are You sure you want to delete this image?");
                var type = 0;
                $("#addButton").prepend('<button type="submit" id="deleteImage" class="btn btn-default btn-modal">Yes</button>');
                $("#msgPopUp").modal('show');
                $("#deleteImage").on('click', function(){
                    var data = {creationId:val, type:type};
                    creationUpDel(data, thisClass);
                    $("#msgPopUp").modal('hide');
                });
                var counter = ($("#topImagePreview").find('img').data('count-images'));
                var newCounter = counter - 1;
                $("#topImagePreview").find('img').data('count-images',newCounter);
            }
        }else{
            $("#title-label").text("Are You sure you want to delete this image?");
            var type = 0;
            $("#addButton").prepend('<button type="submit" id="deleteImage" class="btn btn-default btn-modal">Yes</button>');
            $("#msgPopUp").modal('show');
            $("#deleteImage").on('click', function(){
                var data = {creationId:val, type:type};
                creationUpDel(data, thisClass);
            });
        }
        
    }
    else if(className == "clickForUpload"){
        var type = 1;
        var id = thisClass.closest("div").parent().next('input').attr('id');
        thisClass.closest("div").parent().next('input').trigger('click');
        $("#"+id).off('change').on("change", function(e) {
            var file = this.files[0];
            var fileType = file["type"];
            var ValidImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
            if ($.inArray(fileType, ValidImageTypes) < 0) {
                $("#title-label").html('<span style="color:red;">Upload Failed!</span>');
                $(".reason").text("Selected File type is not an Image! Or its invalid!");
                $("#msgPopUp").modal('show');
            }else{
                var data = {creationId:val, type:type, id:id};
                creationUpDel(data, thisClass);
                file = "";
            }
        });
    }
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

$('#inputValidation').bind('keyup', function(e) {
    var enter = e.which;
    if(enter == 13){
        $("#search_things").click();
    }
});

$("#c_pwd").bind('keyup', function(){
    var n_pwd = $("#n_pwd").val();
    var c_pwd = $(this).val();
    if(c_pwd === ""){ console.log(c_pwd); }
    if(!!c_pwd){
        if(n_pwd !== c_pwd){
            $("#pwd_check").html("<h3 class='text-danger'>Your Password Dosen't Match</h3>");
        }else{
            $("#pwd_check").html("<h3 class='text-success'>Your Password are Matching</h3>");
        }
    }
});

/* Swap Home Page Logo */


/*$('.icon').click(function () {
    $('.search').toggleClass('expanded');
});*/

//Youtube Modal
autoPlayYouTubeModal();
  //FUNCTION TO GET AND AUTO PLAY YOUTUBE VIDEO FROM DATATAG
  function autoPlayYouTubeModal() {
      var trigger = $("body").find('[data-toggle="modal"]');
      trigger.click(function () {
          var theModal = $(this).data("target"),
              videoSRC = $(this).attr("data-theVideo"),
              videoSRCauto = videoSRC + "?autoplay=1";
          $(theModal + ' iframe').attr('src', videoSRCauto);
          $(theModal + ' button.close').click(function () {
              $(theModal + ' iframe').attr('src', videoSRC);
          });
      });
  }

//JavaScript to stop youtube video playing when clicked outside the modal
$(document).ready(function(){
    $('.modal').each(function(){
            var src = $(this).find('iframe').attr('src');

        $(this).on('click', function(){

            $(this).find('iframe').attr('src', '');
            $(this).find('iframe').attr('src', src);

        });
    });
});
