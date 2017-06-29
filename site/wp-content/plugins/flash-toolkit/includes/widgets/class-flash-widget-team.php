<?php
/**
 * Team Widget
 *
 * Displays team widget.
 *
 * @extends  FT_Widget
 * @version  1.0.0
 * @package  FlashToolkit/Widgets
 * @category Widgets
 * @author   ThemeGrill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FT_Widget_Team Class
 */
class FT_Widget_Team extends FT_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'tg-widget tg-single-team';
		$this->widget_description = __( 'Team Widget.', 'flash-toolkit' );
		$this->widget_id          = 'themegrill_flash_team';
		$this->widget_name        = __( 'FT: Team', 'flash-toolkit' );
		$this->control_ops        = array( 'width' => 400, 'height' => 350 );
		$this->settings           = apply_filters( 'flash_toolkit_widget_settings_' . $this->widget_id, array(
			'team-title'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Name', 'flash-toolkit' )
			),
			'image'  => array(
				'type'  => 'image',
				'std'   => '',
				'label' => __( 'Image', 'flash-toolkit' )
			),
			'text'  => array(
				'type'  => 'textarea',
				'std'   => '',
				'label' => __( 'Description', 'flash-toolkit' )
			),
			'designation'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Designation', 'flash-toolkit' )
			),
			'facebook'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Facebook Profile Link', 'flash-toolkit' )
			),
			'twitter' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Twitter Profile Link', 'flash-toolkit' )
			),
			'linkedin' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Linkedin Profile Link', 'flash-toolkit' )
			),
			'style' => array(
				'type'    => 'select',
				'std'     => 'tg-team-layout-1',
				'label'   => __( 'Widget Style', 'flash-toolkit' ),
				'options' => array(
					'tg-team-layout-1' => __( 'Style 1', 'flash-toolkit' ),
					'tg-team-layout-2' => __( 'Style 2', 'flash-toolkit' ),
					'tg-team-layout-3' => __( 'Style 3', 'flash-toolkit' )
				)
			),
		) );

		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		$this->widget_start( $args, $instance );

		flash_get_template( 'content-widget-team.php', array( 'args' => $args, 'instance' => $instance ) );

		$this->widget_end( $args );
	}
}
