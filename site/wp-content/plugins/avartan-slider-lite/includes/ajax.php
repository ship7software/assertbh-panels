<?php
if( !defined( 'ABSPATH') ) exit();

/********************/
/** AJAX CALLBACKS **/
/********************/

/**
 * Add slider
 * 
 * @param array $_POST['datas'] which contain the slider name,alias and slider setting options
 * 
 * @return array/boolean/duplicate word last inserted slider id or status of insert/select operation or data is duplicate
*/
add_action('wp_ajax_avartanslider_addSlider', 'avartanslider_addSlider_callback');
if(!function_exists('avartanslider_addSlider_callback'))
{
    function avartanslider_addSlider_callback() {

        global $wpdb;

        $options = $_POST['datas'];
        $nonce = $_POST['nonce'];
        $table_name = $wpdb->prefix . 'avartan_sliders';
        $output = true;

        //verify the nonce
        $isVerified = wp_verify_nonce($nonce, "avartanslider_csrf");

        if($isVerified == false)
        {
            $output = false;
        }        
        else {
            foreach ($options as $option) {

                //Get slider information which are already exists
                $slider_detail = $wpdb->get_results("SELECT * FROM $table_name where alias = '".trim($option['alias'])."'", ARRAY_A);
                if($slider_detail){

                    $rowcount = $wpdb->num_rows;
                    //Check slider already exists
                    if($rowcount > 0){
                        $output = 'duplicate';
                    }
                }
                else
                {
                    //insert slider
                    $slider_option = json_decode(stripslashes($option['slider_option']));
                    $slider_option = maybe_serialize($slider_option);
                    $output = $wpdb->insert(
                        $table_name,
                        array(
                            'name' => trim($option['name']),
                            'alias' => $option['alias'],
                            'slider_option' => $slider_option,
                        )
                    );
                    if($output === false){
                        $output = false;
                    }
                    else
                    {
                        $output = $wpdb->insert_id;
                    }
                }
            }
        }

        // Returning
        $output = json_encode($output);
        if(is_array($output))
            print_r($output);
        else 
            echo $output;

        die();
    }
}
/**
 * Edit slider
 * 
 * @param array $_POST['datas'] which contain the slider name,alias and slider setting options
 * 
 * @return array/boolean status of update operation
*/
add_action('wp_ajax_avartanslider_editSlider', 'avartanslider_editSlider_callback');
if(!function_exists('avartanslider_editSlider_callback'))
{
    function avartanslider_editSlider_callback() {

        global $wpdb;

        $options = $_POST['datas'];
        $nonce = $_POST['nonce'];
        $table_name = $wpdb->prefix . 'avartan_sliders';
        $output = true;

        //verify the nonce
        $isVerified = wp_verify_nonce($nonce, "avartanslider_csrf");

        if($isVerified == false)
        {
            $output = false;
        }        
        else {

            foreach ($options as $option) {

                //Get slider information which are already exists
                $slider_detail = $wpdb->get_results("SELECT * FROM $table_name where alias = '".trim($option['alias'])."' AND id <> ".$option['id'], ARRAY_A);

                if($slider_detail){
                    $rowcount = $wpdb->num_rows;

                    //check slider already exists
                    if($rowcount > 0){
                        $output = 'duplicate';
                    }
                } 
                else
                {
                    //update slider
                    $slider_option = json_decode(stripslashes($option['slider_option']));
                    $slider_option = maybe_serialize($slider_option);
                    $output = $wpdb->update(
                        $table_name,
                        array(
                            'name' => trim($option['name']),
                            'alias' => $option['alias'],
                            'slider_option' => $slider_option,
                        ),
                        array('id' => $option['id'])
                    );
                    if($output === false){
                        $output = false;
                    }
                    else
                    {
                        $output = sanitize_text_field($option['name']);
                    }
                }
            }
        }

        // Returning
        $output = json_encode($output);
        if(is_array($output))
            print_r($output);
        else
            echo $output;

        die();
    }
}

/**
 * Add/Edit slides and elements
 * 
 * @param array $_POST['datas'] which contain the slide's information and element setting
 * 
 * @return array/boolean status of insert/update operation
*/
add_action('wp_ajax_avartanslider_editSlide', 'avartanslider_editSlide_callback');
if(!function_exists('avartanslider_editSlide_callback'))
{
    function avartanslider_editSlide_callback() {

        global $wpdb;

        $options = $_POST['datas'];
        $nonce = $_POST['nonce'];
        $table_name = $wpdb->prefix . 'avartan_slides';
        $output = true;

        //verify the nonce
        $isVerified = wp_verify_nonce($nonce, "avartanslider_csrf");

        if($isVerified == false)
        {
            $output = false;
        }        
        else {
            // It's impossible to have 0 slides (jQuery checks it)
            // Insert row per row
            foreach($options as $option) {

                $slide_id = $option['slide_id'];
                $params = maybe_serialize($option['slide']);

                $layers = '';
                if(isset($option['layers'])){
                    $layers = json_decode(stripslashes($option['layers']));
                    $layers = maybe_serialize($layers);
                }

                if($slide_id == 0){
                    $output = $wpdb->insert(
                        $table_name,
                        array(
                            'slider_parent' => $option['slider_parent'],
                            'position' => $option['position'],
                            'params' => $params,
                            'layers' => $layers
                        )
                    );
                    if($output === false){
                        $output = false;
                    }
                    else
                    {
                        $output = $wpdb->insert_id;
                    }
                }
                else
                {
                    $output = $wpdb->update(
                        $table_name,
                        array(
                            'slider_parent' => $option['slider_parent'],
                            'position' => $option['position'],
                            'params' => $params,
                            'layers' => $layers
                        ),
                        array('id' => $slide_id)
                    );
                    if($output === false){
                        $output = false;
                    }
                    else {
                        $output = 'update';    
                    }
                }
            }
        }

        // Returning
        $output = json_encode($output);
        if(is_array($output))
            print_r($output);
        else
            echo $output;

        die();
    }
}
/**
 * Delete slide
 * 
 * @param array $_POST['datas'] which contain the slides id
 * 
 * @return array/boolean status of delete operation
*/
add_action('wp_ajax_avartanslider_deleteSlide', 'avartanslider_deleteSlide_callback');
if(!function_exists('avartanslider_deleteSlide_callback'))
{
    function avartanslider_deleteSlide_callback() {
            global $wpdb;
            $options = $_POST['datas'];
            $nonce = $_POST['nonce'];

            $table_name = $wpdb->prefix . 'avartan_slides';

            $output = true;

            //verify the nonce
            $isVerified = wp_verify_nonce($nonce, "avartanslider_csrf");

            if($isVerified == false)
            {
                $output = false;
            }        
            else {

                $slides_detail = $wpdb->get_results("SELECT id FROM $table_name where id = ".$options['id'], ARRAY_A);
                if ($slides_detail) {
                    $output = $wpdb->delete($table_name, array('id' => $options['id']), array('%d'));
                    if($output === false) {
                            $output = false;
                    }
                }
                else
                {
                    $output = false;
                }
            }
            // Returning
            $output = json_encode($output);
            if(is_array($output)) print_r($output);
            else echo $output;

            die();
    }
}
/**
 * Update slides position
 * 
 * @param array $_POST['slide_pos_datas'] which contain the slides id
 * 
 * @return array/boolean status of update operation
*/
add_action('wp_ajax_avartanslider_updateSlidePos', 'avartanslider_updateSlidePos_callback');
if(!function_exists('avartanslider_updateSlidePos_callback'))
{
    function avartanslider_updateSlidePos_callback() {

        global $wpdb;

        $postion_options = $_POST['slide_pos_datas'];
        $postion_options = is_array($postion_options) ? $postion_options : array($postion_options);
        $nonce = $_POST['nonce'];
        $table_name = $wpdb->prefix . 'avartan_slides';
        $output = true;

        //verify the nonce
        $isVerified = wp_verify_nonce($nonce, "avartanslider_csrf");

        if($isVerified == false)
        {
            $output = false;
        }        
        else {
            //if all operation completed then update slides position
            if(count($postion_options) > 0){
                foreach($postion_options as $pos_option) {
                    if(isset($pos_option['position_pos'])){
                        $output = $wpdb->update(
                                $table_name,
                                array(
                                        'position' => $pos_option['position_pos'],
                                ),
                            array('id' => $pos_option['slide_id_pos'])
                        );
                        if($output === false) {
                            $output = false;
                        }
                        else
                        {
                            $output = true;
                        }
                    }
                }
            }
        }

        // Returning
        $output = json_encode($output);
        if(is_array($output))
            print_r($output);
        else
            echo $output;

        die();
    }
}
/**
 * Delete slider, releated slides and elements
 * 
 * @param array $_POST['datas'] which contain the slider id
 * 
 * @return array/boolean status of delete operation
*/
if(!function_exists('avartanslider_deleteSlider_callback'))
{
    function avartanslider_deleteSlider_callback() {
            global $wpdb;
            $options = $_POST['datas'];
            $nonce = $_POST['nonce'];

            $output = true;

            //verify the nonce
            $isVerified = wp_verify_nonce($nonce, "avartanslider_csrf");

            if($isVerified == false)
            {
                $output = false;
            }        
            else {

                // Delete slider
                $table_name = $wpdb->prefix . 'avartan_sliders';		
                $slider_detail = $wpdb->get_results("SELECT id FROM $table_name where id = ".$options['id'], ARRAY_A);
                if ($slider_detail) {
                    $output = $wpdb->delete($table_name, array('id' => $options['id']), array('%d'));
                    if($output === false) {
                            $output = false;
                    }
                    else
                    {
                        //Get slide information of the particular slider
                        $table_name = $wpdb->prefix . 'avartan_slides';
                        $slides_detail = $wpdb->get_results("SELECT id FROM $table_name where slider_parent = ".$options['id'], ARRAY_A);
                        if ($slides_detail) {
                            // Delete slides
                            $output = $wpdb->delete($table_name, array('slider_parent' => $options['id']), array('%d'));
                            if($output === false) {
                                    $output = false;
                            }
                        }
                    }
                }
            }    

            // Returning
            $output = json_encode($output);
            if(is_array($output)) print_r($output);
            else echo $output;

            die();
    }
}
add_action('wp_ajax_avartanslider_getSlidePreview', 'avartanslider_getSlidePreview_callback');
if(!function_exists('avartanslider_getSlidePreview_callback'))
{
    function avartanslider_getSlidePreview_callback() {
            global $wpdb, $loadFontArr;
            $options = $_POST['datas'];
            $nonce = $_POST['nonce'];
            

            $output = true;

            //verify the nonce
            $isVerified = wp_verify_nonce($nonce, "avartanslider_csrf");

            if($isVerified == false)
            {
                $output = false;
            }        
            else {
                foreach ($options as $option) {
                        
                        $layers = '';
                        
                        //Make HTML for Preview Slide
                        $output = '';

                        $output .= '<ul style="display:none;">' . "\n";

                            //Get slide setting and set the property
                            $params = maybe_unserialize( maybe_serialize($option['slide']) );
                            $elements = array();
                             //Get Elements of particular slide
                            if(isset($option['layers'])){
                                $layers = json_decode(stripslashes($option['layers']));
                                $elements = maybe_unserialize(maybe_serialize($layers));
                            }
                            
                            $output .= AvartanlitesliderShortcode::avartansliderSlideDetail($params,$elements);
                            
                            $output .= AvartanlitesliderShortcode::avartansliderSlideDetail($params,$elements);
                        
                        $output .= '</ul>' . "\n";
                }
            }
        // Returning
        $output = json_encode($output);
        if(is_array($output)) print_r($output);
        else echo $output;

        die();
    }
}
?>