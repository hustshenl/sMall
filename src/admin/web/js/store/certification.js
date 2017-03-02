/**
 * Created by Shen.L on 2016/10/12.
 */

sMall.storeCertification = function ($) {
    var $itemAdd;
    var $itemContainer;
    var $itemForm;
    function addItem() {
        console.log('假装添加了一个项目');
        console.log($itemForm.serialize());
        return;
        // 包含数据类型type，名称name，标签label，选项items，必须require，说明notice，操作action
        var entity = $('<div class="row item-row"></div>').data('key',getItemId());
        console.log(entity.data('key'));
        createType(2).appendTo(entity);
        createAction(1).appendTo(entity);
        $itemContainer.append(entity);
    }
    function getItemId()
    {
        var id = parseInt($itemContainer.data('key'));
        id +=1;
        $itemContainer.data('key',id);
        return id;
    }
    function createCol(col) {
        return $('<div></div>').addClass('col-md-'+col);
    }
    function createAction(col) {
        return createCol(col).html('<button type="button" class="btn btn-danger item-delete">删除</button>');
    }
    function createType(col) {
        return createCol(col).html('<select name="type"> <option value="20" selected="">20</option> <option value="50">50</option> </select>');
    }
    function deleteItem(e) {
        var row = $(this).parents('.item-row');
        row.remove();
    }
    var pub = {
        init: function () {
            console.log('storeCertification init');
            $itemAdd = $('#item-add');
            $itemContainer = $('#item-container');
            $itemForm = $('#item-form');
            $itemAdd.click(addItem);
            $itemContainer.on('click','.item-delete',deleteItem);
        },
    };
    return pub;

}(jQuery);