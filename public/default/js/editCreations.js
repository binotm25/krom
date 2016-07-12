function addNewFilesEdit(data, featuredImage, otherImage){
    var type = data.type;
    var creationId = data.creationId;
    var data = new FormData();
    if(featuredImage > 0){
        $.each($('#uploadFileEdit')[0].files, function(i, file) {
            data.append('uploadFileFeatured[]', file);
        });
    }
    if(otherImage > 0){
        $.each($('#uploadFileEdit1')[0].files, function(i, file) {
            data.append('uploadFileOther[]', file);
        });
    }else if(otherImage < 0 && featuredImage < 0){
        return false;
    }

    $("#cancelUpload").show();
    $("#ImageUploadProgress").modal('show');
    $(".uil-ring-css").html("<div></div>");
    var AJAX = $.ajax({
        url: urlPath+"/addImageEdit/"+creationId,
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
            if(res == 1){
                $(".modal-body").html("<h4 class='text-center' style='color:#2bbdc9'>Image Added</h4>");
            }else{
                $(".modal-body").html("<h4 class='text-center' style='color:#2bbdc9'>"+res+"</h4>");
            }
            
        },
        error: function(){

        }
    });
    $("#cancelUpload").on('click', function(e){  
        AJAX.abort();
        $("#ImageUploadProgress").modal('hide');
    });
}

$("#createSave").click(function(e){

    var featuredFile, otherFile = 0;
    featuredFile = $("#uploadFileEdit").get(0).files.length; var creationId = $("#uploadFileEdit").data('creation-id');
    otherFile = $("#uploadFileEdit1").get(0).files.length;
    
    if(featuredFile > 0 || otherFile > 0){
        if(featuredFile > 0 && $(".imagePreview-3 ").length == 3){
            $("#ImageUploadProgress").modal('show');
            $(".modal-body").html("<h4 class='text-center' style='color:#2bbdc9'>Cannot Add More than 3 Featured Photos.</h4>");
            return false;
        }
        var data = {creationId:creationId, type:"creation"};
        addNewFilesEdit(data, featuredFile, otherFile);
    }else{
        return true;
    }
    
});