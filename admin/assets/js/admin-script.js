jQuery(document).ready(function () {

});
function otherAction(state) {
	var data = {
        action:state,
    };
    jQuery.ajax({
        url: admin_ajaxurl+'others.php',
        type: 'POST',
        data: data,
        success: function(result) {
            if(result != 'false') {
                //jQuery('#content').html(result);
            }
        }
    });
}

function changeState(state,element) {
    jQuery('#controls button').removeClass('active');
    jQuery(element).addClass('active');
	var data = {
        action:state,
    };
    if(state=='category' || state=='start') {
        data['category'] = jQuery('#category option:selected').val();
    }
    jQuery.ajax({
        url: admin_ajaxurl,
        type: 'POST',
        data: data,
        success: function(result) {
            if(result != 'false') {
                //jQuery('#content').html(result);
            }
        }
    });
}