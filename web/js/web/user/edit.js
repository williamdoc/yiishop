;
var user_edit_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        $(".save").click(function () {
            var btn_target = $(this);//当前作用域

            if (btn_target.hasClass("disabled")) {
                alert("正在处理，请勿重复点击");
                return false;
            }
            var nickname = $(".user_edit_wrap input[name=nickname]").val();
            var email = $(".user_edit_wrap input[name=email]").val();

            if (nickname.length < 1) {
                common_ops.tip("请输入合法的姓名",$(".user_edit_wrap input[name=nickname]"));
                return false;
            }

            if (email.length < 1) {
                common_ops.tip("请输入合法的邮箱地址",$(".user_edit_wrap input[name=email]"));
                return false;
            }

            btn_target.addClass("disabled");

            $.ajax({
                url:common_ops.buildWebUrl('/user/edit'),
                type:'POST',
                data:{
                    nickname:nickname,
                    email:email
                },
                dataType:'json',
                success:function (res) {
                    btn_target.removeClass("disabled");
                    alert(res.msg);
                    if (res.code == 200) {
                        window.location.href = window.location.href;
                    }
                }
            });
        });
    }

};

$(document).ready(function () {
    user_edit_ops.init();
});