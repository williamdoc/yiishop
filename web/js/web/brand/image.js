;
var upload = {
    error:function (msg) {
        common_ops.alert(msg);
    },
    success:function (file_key,type) {
        if(!file_key){
            return ;
        }

        var html = '<img src='+common_ops.buildPicUrl("brand",file_key)+'><span class="fa fa-times-circle del del_image" data='+file_key+'><i></i></span>';;
        if($(".upload_pic_wrap .pic-each").size()>0){
            $(".upload_pic_wrap .pic-each").html(html);
        }else{
            $(".upload_pic_wrap").append('<span class="pic-each">'+html+'</span>')
        }
    }
};
var brand_image_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        $(".set_pic").click(function () {
            $("#brand_image_wrap").modal('show');
        });

        $("#brand_image_wrap .upload_pic_wrap input[name=pic]").change(function () {
            $("#brand_image_wrap .upload_pic_wrap").submit();
        });
    }
};

$(function () {
    brand_image_ops.init();
});