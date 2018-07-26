;
upload = {
    error:function (msg) {
        common_ops.alert(msg);
  },
    success:function (image_key) {
        //common_ops.alert(msg);
        var html = '<img src='+common_ops.buildPicUrl("brand",image_key)+'><span class="fa fa-times-circle del del_image" data='+image_key+'><i></i></span>';
        if($(".upload_pic_wrap .pic-each").size()>0){
            $(".upload_pic_wrap .pic-each").html(html);
        }else{
            $(".upload_pic_wrap").append('<span class="pic-each">'+html+'</span>');
        }

        brand_set_ops.delete_img();
    }
};

var brand_set_ops = {
    init:function () {
        this.eventBind();
        this.delete_img();
    },
    eventBind:function () {
        $(".wrap_brand_set .save").click(function () {
            var btn_target = $(this);
            if(btn_target.hasClass("disabled")) {
                common_ops.alert("正在处理，请不要重复提交");
                return;
            }
            //数据收集
            var name_target = $(".wrap_brand_set input[name=name]");
            var name = name_target.val();

            var image_key = $(".wrap_brand_set .pic-each .del_image").attr("data");

            var mobile_target = $(".wrap_brand_set input[name=mobile]");
            var mobile = mobile_target.val();

            var address_target = $(".wrap_brand_set input[name=address]");
            var address = address_target.val();

            var description_target = $(".wrap_brand_set textarea[name=description]");
            var description = description_target.val();
            //数据校验
            if (name.length <1 ) {
                common_ops.tip("请输入符合规范的品牌名称",name_target);
                return;
            }

            if ($(".wrap_brand_set .pic-each").size()<1) {
                common_ops.alert("请上传品牌Logo");
                return;
            }
            if (mobile.length <1 ) {
                common_ops.tip("请输入符合规范的手机号",mobile_target);
                return;
            }
            //TODO 提交后使提交按钮失效，直到后台返回信息时，再使之重新生效
            btn_target.addClass("disabled");

            var data = {
                name:name,
                image_key:image_key,
                mobile:mobile,
                address:address,
                description:description
            };

            $.ajax({
                url:common_ops.buildWebUrl("/brand/set"),
                type:'POST',
                data:data,
                dataType:'json',
                success:function (res) {
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if(res.code == 200){
                        callback = function () {
                            window.location.href = common_ops.buildWebUrl("/brand/info");
                        }
                    }

                    common_ops.alert(res.msg,callback);
                }
            });



        });
        $(".wrap_brand_set .upload_pic_wrap input[name=pic]").change(function () {
            $(".wrap_brand_set .upload_pic_wrap").submit();
        });
    },
    delete_img:function () {
        $(".wrap_brand_set .del_image").unbind().click(function () {
            $(this).parent().remove();
        });
    }
};
$(function () {
    brand_set_ops.init();
});
