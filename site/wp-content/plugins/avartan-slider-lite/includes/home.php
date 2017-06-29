<?php
if( !defined( 'ABSPATH') ) exit();
global $wpdb;

//Get the slider information
$sliders = $wpdb->get_results('SELECT aslider.id, aslider.name, aslider.alias, count(aslide.id) AS totalSlide FROM ' . $wpdb->prefix . 'avartan_sliders AS aslider LEFT JOIN ' . $wpdb->prefix . 'avartan_slides AS aslide ON aslider.id = aslide.slider_parent GROUP BY aslider.id');
?>
<!-- Display slider on home page -->
<div class="as-sliders-list">
    <div class="as-slider-list-header">
        <h4><strong><?php _e( 'Avartan Slider List', AVARTANLITESLIDER_TEXTDOMAIN ); ?></strong></h4>
        <a title="<?php _e( 'Import Slider', AVARTANLITESLIDER_TEXTDOMAIN ); ?>" class="as-button as-is-success as-call-import-slider as-right as-is-temp-disabled as-pro-version" href="javascript:void(0);" data-toggle="modal" data-target="#importSliderModal"><span class="dashicons dashicons-download mr5"></span><?php _e( 'Import Slider', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
        <a title="<?php _e( 'Create New Slider', AVARTANLITESLIDER_TEXTDOMAIN ); ?>" class="as-button as-is-primary as-add-slider as-right mr5" href="?page=avartanslider&view=add"><span class="dashicons dashicons-plus mr5"></span><?php _e( 'Create New Slider', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
    </div>
    <div class="as-slider-list-body col-sm-12">
        <ul>
        <?php
        if (!$sliders) {
            echo '';
            echo '<li><center>';
            _e( 'No Sliders found. Please add a new one.', AVARTANLITESLIDER_TEXTDOMAIN );
            echo '</center></li>';
        } else {
            $slider_cnt = 0;
            foreach ($sliders as $slider) {
                $slider_cnt++;
                ?>
                <li>
                    
                    <span class="as-list-row col-sm-3 col-xs-12 as-list-name">
                        <span class="as-list-srno"><?php echo "#".$slider_cnt ?></span>
                        <a href="?page=avartanslider&view=edit&id=<?php echo $slider->id ?>"><?php echo $slider->name ?></a>
                    </span>
                    <span class="as-list-row col-sm-2 col-xs-12 as-list-shortcode"><input class="as-slider-list-shortcode" type="text" value="[avartanslider alias='<?php echo $slider->alias; ?>']" onclick="this.select();" readonly="readonly"></span>
                    <span class="as-list-row col-sm-1 col-xs-12 as-list-slides"><?php _e( 'Slides', AVARTANLITESLIDER_TEXTDOMAIN ); echo " (".$slider->totalSlide.")"; ?></span>
                    <span class="as-list-row col-sm-6 col-xs-12 as-list-actions text-right">
                        <a class="as-edit-slider as-button as-is-success" href="?page=avartanslider&view=edit&id=<?php echo $slider->id ; ?>" title="<?php _e( 'Settings', AVARTANLITESLIDER_TEXTDOMAIN ) ; ?>"><span class="dashicons dashicons-admin-generic"></span></a>
                        <a class="as-edit-slider as-button as-is-primary" href="?page=avartanslider&view=edit&id=<?php echo $slider->id ; ?>#as-slides" title="<?php _e( 'Edit Slides', AVARTANLITESLIDER_TEXTDOMAIN ) ; ?>"><span class="dashicons dashicons-edit"></span></a>
                        <a class="as-export-slider as-button as-is-inverse as-is-temp-disabled as-pro-version" href="javascript:void(0);" title="<?php _e( 'Export Slider', AVARTANLITESLIDER_TEXTDOMAIN ) ; ?>"><span class="dashicons dashicons-share-alt2"></span></a>
                        <a class="as-delete-slider as-button as-is-danger" href="javascript:void(0)" data-delete="<?php echo $slider->id ; ?>" title=" <?php _e( 'Delete Slider', AVARTANLITESLIDER_TEXTDOMAIN ) ; ?>"><span class="dashicons dashicons-trash"></span></a>
                        <a class="as-duplicate-slider as-button as-is-secondary" href="javascript:void(0)" data-duplicate="<?php echo $slider->id ; ?>" title=" <?php _e( 'Duplicate Slider', AVARTANLITESLIDER_TEXTDOMAIN ) ; ?>"><span class="dashicons dashicons-format-gallery"></span></a>
                        <a class="as-preivew-slider as-button as-is-success as-is-temp-disabled as-pro-version" href="javascript:void(0)" title=" <?php _e( 'Preview Slider', AVARTANLITESLIDER_TEXTDOMAIN ) ; ?>"><span class="dashicons dashicons-search"></span></a>
                        <a class="as-import-slide as-button as-is-orange as-is-temp-disabled as-pro-version" href="javascript:void(0);" title=" <?php _e( 'Import Single Slide', AVARTANLITESLIDER_TEXTDOMAIN ) ; ?>"><span class="dashicons dashicons-download"></span></a>
                    </span>
                </li>
                <?php
            }
        }
        ?>
        </ul>
    </div>
</div>