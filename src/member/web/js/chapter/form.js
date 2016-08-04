/**
 * Created by Shen.L on 2015/10/29.
 */
var ChapterForm = function () {
    var sortable = false;
    var imageData = {
        items: [],
        moves: [],
        removes: []
    };
    var chapterImages = $('#chapter-file');

    var handleImageAction = function () {
        chapterImages.on('fileloaded', function (event, file, previewId, index, reader) {
            setSortable();
        });
        chapterImages.on('fileuploaded', function (event, data, previewId, index) {
            var elem = $(document).find("#" + previewId);
            var res = data.response;
            if (res.status == 0 && res.data.filename) {
                elem.data("filename", res.data.filename);
            }
            //updateImageData();
        });
        //初始化的图片被删除
        chapterImages.on('filedeleted', function (event, key, jqXHR) {
            //console.log(elem.data("filename"));
            removeItem(key);
        });
        //上传的图片被删除
        chapterImages.on('filesuccessremove', function (event, id) {
            //console.log('filesuccessremove');
            //var elem = $(document).find("#"+id);
            //removeTempItem(elem.data("filename"));
            //console.log(elem.data("filename"));
        });
        chapterImages.on('filecleared', function (event) {
            //clearTemp();
        });
        $("#chapter-form").submit(function (e) {
            return ChapterForm.updateImageData();
        });
        setSortable();

    };
    var setSortable = function () {
        if (sortable == false || sortable.length == 0) {
            sortable = $(document).find(".file-preview-thumbnails");
            sortable.sortable({
                revert: true,
                /**
                 * 排序动作结束时且元素坐标已经发生改变
                 * @param e
                 * @param ui
                 */
                update: function (e, ui) {
                    //此时发生调整结果页面
                    updateImageData();
                },
            });
        }
    };
    var updateImageData = function () {
        imageData.items = [];
        sortable.children().each(function (i, item) {
            var filename = false;
            if (filename = $(this).data("filename")) {
                imageData.items.push(filename);
            }

        });
        //更新items对象
    };
    var removeTempItem = function (filename) {
        updateImageData();
    };
    var clearTemp = function () {
        updateImageData();
    };
    var removeItem = function (filename) {
        imageData.removes.push(filename);
        updateImageData();
    };

    var handleEvents = function (dest) {
        bindEvents('#chapter-linkstatus',"#link-warp","#upload-file");
        bindEvents('#chapter-is_end',false,"#end-warp");
    };
    
    var bindEvents = function (dest,on,off) {
        var destElem = jQuery(dest);
        var onElem = on?jQuery(on):false;
        var offElem = off?jQuery(off):false;
        destElem.on('init.bootstrapSwitch', function (e,state) {
            handleDisplay($(this).prop('checked'),onElem,offElem);
        });destElem.on('switchChange.bootstrapSwitch', function (e,state) {
            handleDisplay(state,onElem,offElem);
        });
    };

    var handleDisplay = function (flag, on, off) {
        var show = flag ? on : off;
        var hide = flag ? off : on;
        show&&show.show();
        hide&&hide.hide();
    };

    return {
        init: function () {
            handleImageAction();
        },
        updateImageData: function () {
            imageData.items = [];
            imageData.moves = [];
            sortable.children().each(function (i, item) {
                var that = $(this);
                var filename = false;
                if (filename = that.data("filename")) {
                    imageData.items.push(filename);
                    if (!that.data("initial-image")) {
                        imageData.moves.push(filename)
                    }
                }else{
                }
            });
            //chapterImages.val(imageData.items.join(','));
            $("input[name='remove_images']").val(imageData.removes);
            $("input[name='move_images']").val(imageData.moves);
            $("input[name='images']").val(imageData.items);
            return true;
            //console.log(chapterImages.val());
            //console.log($("input[name='remove_images']").val());
        },
        initEvents: function () {
            handleEvents();
        }
    }

}();