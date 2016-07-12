$("#uploadForm").on('submit',(function(e){
    e.preventDefault();
    console.log(new FormData(this));
    $.ajax({
        url: "http://localhost/kritish-admin/public/profile",
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
        $("#targetLayer").html(data);
        },
        error: function(){}           
    });
}));
// targets the id - uploadForm and in the php side the name in the input type will be use to get the datas.
// And please note that this will only work for form div.
// without te form you have do another one!