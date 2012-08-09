<?php
// initialisation
global $mf_domain;


// class with static properties encapsulating functions for the field type

class timepicker_field extends mf_custom_fields {

  public $allow_multiple = TRUE;
  public $has_properties = TRUE;
  function get_properties() {
    return  array(
      'js'  => TRUE,
      'js_dependencies' => array(),
      'js_internal_dependencies' => array(
        'jquery',
        'jquery-ui-core',
      ),
      'js_internal' =>'ui.timepicker.js',
      'css' => FALSE,
      'css_internal' => 'ui.timepicker.css'
    );
  }
  
  public function _update_description(){
    global $mf_domain;
    $this->description = __('Simple timepicker field',$mf_domain);
  }
  
  public function _options(){
    global $mf_domain;
    
    $data = array(
	  'option' => array(
	   'format'  => array(
          'type'        => 'select',
          'id'          => 'time_format',
          'label'       => __('Format',$mf_domain),
          'name'        => 'mf_field[option][format]',
          'default'     => '',
          'options'     => array(
                                'H:i'       => '15:30',
                                'G:i'       => '9:30',
                                'h:i A'     => '03:30 PM',
                                'g:i A'     => '3:30 PM',
                            ),
          'add_empty'   => false,
          'description' => __( 'Format for date', $mf_domain ),
          'value'       => '',
          'div_class'   => '',
          'class'       => ''
        ),
        'step'  => array(
          'type'        => 'select',
          'id'          => 'time_step',
          'label'       => __('Step',$mf_domain),
          'name'        => 'mf_field[option][step]',
          'default'     => '',
          'options'     => array(
                                '5'  => '5 min',
                                '10' => '10 min',
                                '15' => '15 min',
                                '30' => '20 min',
                                '60' => '60 min'
                            ),
          'add_empty'   => false,
          'description' => __('Set varying levels of precision', $mf_domain ),
          'value'       => '',
          'div_class'   => '',
          'class'       => ''
        ),
	  	'set_duration' => array(
		  'type'		=> 'checkbox',
		  'id'			=> 'time_set_duration',
		  'label'		=> __('Set duration', $mf_domain ),
		  'name'        =>  'mf_field[option][set_duration]',
		  'default'		=> '',
		  'add_empty'   => false,
		  'description'	=> '',
		  'value'		=> '',
		  'div_class'	=> '',
		  'class'		=> ''
		)
	  )
    );
    
    return $data;
  }
  
  public function display_field( $field, $group_index = 1, $field_index = 1 ) {
  
  	$format      = $field['options']['format'];
  	$step        = $field['options']['step'];
  	$set_duration= $field['options']['set_duration'];
  	
  	$value_raw = '';
  	$value = $set_duration ? array('', '') : '';
  	
	if ($field['input_value']){
	   $value_raw = $field['input_value'];
	   if ($set_duration) {
	       $value_split = split('-', $value_raw);
	       $value = array(
	           date($format,strtotime($value_split[0])),
	           date($format,strtotime($value_split[1]))
	       );
	   } else {
    	   $value = date($format,strtotime($value_raw));
	   }
	}
	
	$output  = sprintf('<div id="format_time_field_%s" style="display:none;">%s</div>', $field['input_id'], $format);
	$output .= sprintf('<div id="step_time_field_%s" style="display:none;">%s</div>', $field['input_id'], $step);
	$output .= sprintf('<div id="set_duration_time_field_%s" style="display:none;">%s</div>', $field['input_id'], $step);
	
    $output .= '<div>';
    if ($set_duration) {
        $output .= sprintf('<input id="display_time_field_%s_start" value="%s" type="text" class="timepicker_mf" readonly="readonly" style="width:80px;display:inline;" />',$field['input_id'], $value[0]);
        $output .= ' - ';
        $output .= sprintf('<input id="display_time_field_%s_end" value="%s" type="text" class="timepicker_mf" readonly="readonly" style="width:80px;display:inline;" />',$field['input_id'], $value[1]);
        
    } else {
        $output .= sprintf('<input id="display_time_field_%s" value="%s" type="text" class="timepicker_mf" readonly="readonly" style="width:192px;"/>',$field['input_id'], $value);
    }
    $output .= '</div>';
    $output .= sprintf('<input id="time_field_%s" value="%s" name="%s" type="hidden" %s />',$field['input_id'],$value_raw,$field['input_name'],$field['input_validate']);
	$output .= sprintf('<input 	type="button" id="blank_%s"value="Blank" class="blankBotton_mf button"/>',$field['input_id']);
	
    return $output;
  }
}
