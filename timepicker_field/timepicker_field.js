jQuery(document).ready(function($){
    jQuery('.timepicker_mf').live('click',function(){
        the_id = jQuery(this).attr('id');
        
        
        suffix = the_id.replace(/display_time_field_/, '');
        suffix = suffix.replace(/_start|_end/, '');
	    console.log(suffix);	    
        format       = jQuery('#format_time_field_' + suffix).text();
        step         = jQuery('#step_time_field_' + suffix).text();
        set_duration = !!jQuery('#set_duration_time_field_' + suffix).text();
        
        jQuery('#' + the_id).timepicker({
            'timeFormat'        : format,
            'scrollDefaultNow'  : true,
            'step'              : step
        }).bind('changeTime', function() {
            if (set_duration)
                jQuery('#time_field_' + suffix).val(
                    jQuery('#display_time_field_' + suffix + '_start').val() +
                    '-' + 
                    jQuery('#display_time_field_' + suffix + '_end').val()
                );
            else
                jQuery('#time_field_' + suffix).val(jQuery('#' + the_id).val());
        }).focus();
        
    });
    
    //BLANK Botton
	jQuery('.blankBotton_mf').live('click',function(){
	    the_id = jQuery(this).attr('id');
	    suffix = the_id.replace(/blank_/,'');
	    console.log(suffix);	    
        jQuery('#display_time_field_' + suffix).val('');
	    jQuery('#time_field_' + suffix).val('');
	});
});