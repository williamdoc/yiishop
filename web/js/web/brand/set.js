;
upload = {
    error:function (msg) {
        common_ops.alert(msg);
  },
    success:function (msg) {
        common_ops.alert(msg);
    }
};

var brand_set_ops = {
    init:function () {
        this.eventBind();
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

            if (mobile.length <1 ) {
                common_ops.tip("请输入符合规范的手机号",mobile_target);
                return;
            }
            //TODO 提交后使提交按钮失效，直到后台返回信息时，再使之重新生效
            btn_target.addClass("disabled");

            var data = {
                name:name,
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
    }
};
$(function () {
    brand_set_ops.init();
});
