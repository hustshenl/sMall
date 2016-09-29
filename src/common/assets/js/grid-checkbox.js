/*!
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @version   3.0.1
 *
 * Client actions for yii2-grid CheckboxColumn
 * 
 * Author: Kartik Visweswaran
 * Copyright: 2015, Kartik Visweswaran, Krajee.com
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */
var kvSelectRow = function (gridId, css) {
    "use strict";
    (function ($) {
        var $grid = $('#' + gridId), $el;
        $grid.find(".kv-row-select input").on('change', function () {
            console.log("inputs change");
            $el = $(this);
            if ($el.is(':checked')) {
                $el.parents("tr:first").removeClass(css).addClass(css);
                $el.parent().addClass("checked");
            } else {
                $el.parents("tr:first").removeClass(css);
                $el.parent().removeClass("checked");
            }
            var all = $grid.find(".kv-row-select input").length == $grid.find(".kv-row-select input:checked").length;
            if(all) $grid.find(".kv-all-select input").parent().addClass("checked");
            else $grid.find(".kv-all-select input").parent().removeClass("checked");
        });
        $grid.find(".kv-all-select input").on('change', function () {
            console.log("all change");
            if ($(this).is(':checked')) {
                $grid.find(".kv-row-select").parents("tr").removeClass(css).addClass(css);
                $grid.find(".kv-row-select input").parent().addClass("checked");
            }
            else {
                $grid.find(".kv-row-select").parents("tr").removeClass(css);
                $grid.find(".kv-row-select input").parent().removeClass("checked");
            }
        });
    })(window.jQuery);
};