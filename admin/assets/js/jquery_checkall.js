﻿$(document).ready(
    function() {
        //clicking the parent checkbox should check or uncheck all child checkboxes
        $(".parentCheckBox").click(
            function() {
                $(this).parents('table:eq(0)').find('.childCheckBox').attr('checked', this.checked);
            }
        );
        //clicking the last unchecked or checked checkbox should check or uncheck the parent checkbox
        $('.childCheckBox').click(
            function() {
                if ($(this).parents('table:eq(0)').find('.parentCheckBox').attr('checked') == true && this.checked == false)
                    $(this).parents('table:eq(0)').find('.parentCheckBox').attr('checked', false);
                if (this.checked == true) {
                    var flag = true;
                    $(this).parents('table:eq(0)').find('.childCheckBox').each(
	                    function() {
	                        if (this.checked == false)
	                            flag = false;
	                    }
                    );
                    $(this).parents('table:eq(0)').find('.parentCheckBox').attr('checked', flag);
                }
            }
        );
    }
);