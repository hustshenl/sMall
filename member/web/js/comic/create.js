/**
 * Created by Shen.L on 2015/10/29.
 */
var ComicCreate = function(){
    var handleImageAction = function () {
        var comicId = jQuery("#comic-cover").data("key");
        jQuery(".apply-cover").click(function () {
            var that = jQuery(this);
            var parent = that.parents(".history-image");
            var key = parent.data("key");
            jQuery.post("/comic/apply-cover?id="+comicId,{image_id: key}, function (res) {
                if(res.status == 0){
                    Notify.notify(res.data);
                    //标记当前图片已经使用
                    parent.addClass("active").siblings().removeClass("active");
                    var cover = jQuery("#current-cover");
                    var src = parent.find("img").attr("src");
                    cover.children("img").attr('src',parent.find("img").attr("src")).show();
                    cover.parent().find("button").show();
                    //更新封面图片
                }else{
                    Notify.notify({type:"error",title:res.data});
                }
            },'json');
        });
        /*jQuery(".approve-cover").click(function () {
            var that = jQuery(this);
            var parent = that.parents(".history-image");
            var key = parent.data("key");
            jQuery.post("/comic/approve-cover?id="+comicId,{image_id: key}, function (res) {
                if(res.status == 0){
                    Notify.notify(res.data);
                    that.removeClass("btn-primary").addClass("btn-success");
                }else{
                    Notify.notify({type:"error",title:res.data});
                }
            },'json');
        });*/
        jQuery(".remove-image").click(function () {
            var parent = jQuery(this).parents(".history-image");
            var key = parent.data("key");
            jQuery.post("/comic/remove-image?id="+comicId,{image_id: key}, function (res) {
                if(res.status == 0){
                    Notify.notify(res.data);
                    parent.hide();
                }else{
                    Notify.notify({type:"error",title:res.data});
                }
            },'json');
        });
        jQuery(".remove-cover").click(function () {
            var that = jQuery(this);
            var cover = jQuery("#current-cover");
            jQuery.post("/comic/remove-cover?id="+comicId,{}, function (res) {
                if(res.status == 0){
                    Notify.notify(res.data);
                    cover.children("img").hide();
                    that.hide();
                }else{
                    Notify.notify({type:"error",title:res.data});
                }
            },'json');
        });
    };

    return {
        init: function () {
            handleImageAction();
        }
    }

}();