<?php
if( is_admin() ) {
	/**
	 * Create admin menu entry
	 */
	function premier_popups_options_menu() {
		add_menu_page(
			'Premier Popups Settings',
			'Premier Popups',
			'manage_options',
			'premier-popups',
			'premier_popups_options_page',
			'',
			'61.5'
		);
	}
	add_action( 'admin_menu', 'premier_popups_options_menu' );


	function premier_popups_options_page() {

	
		/**
		 * Update options if submitted
		 */
		if( $_POST['premier_popups_options_submitted'] ) {
			$popup_options['popup_ID']			= esc_html($_POST['select_popup']);
			$popup_options['popup_mobile']		= 0; //Do not display on mobile by default
			if(isset($_POST['popup_mobile'])) {
				$popup_options['popup_mobile']	= intval(esc_html($_POST['popup_mobile']));
			}
			$popup_options['popup_background']  = esc_html($_POST['popup_background']);
			$popup_options['popup_color'] 		= esc_html($_POST['popup_color']);
			if ( $_POST['popup_width'] != '') {
				$popup_options['popup_width'] 	= intval(esc_html($_POST['popup_width']));
			} else $popup_options['popup_width'] = '';
			if ( $_POST['popup_height'] != '') {
				$popup_options['popup_height'] 	= intval(esc_html($_POST['popup_height']));       
			} else $popup_options['popup_height'] = '';
			if ( $_POST['popup_padding'] != '') {
				$popup_options['popup_padding'] = esc_html($_POST['popup_padding']);       
			} else $popup_options['popup_padding'] = '';
            if( $_POST['popup_delay'] && $_POST['popup_delay'] != '' ) { 
                $popup_options['popup_delay']   = intval(esc_html($_POST['popup_delay']));
            }
			update_option('premier_popups', $popup_options);
		}
		
		/**
		 * Retrieve options from the options table
		 */
		$popup_options = get_option('premier_popups');
		global $popup_ID;
		if( $popup_options != '' ) {
			$popup_ID		  = $popup_options['popup_ID'];
			$popup_mobile	  = $popup_options['popup_mobile'];
			$popup_delay      = $popup_options['popup_delay'];
			$popup_background = $popup_options['popup_background'];
			$popup_color	  = $popup_options['popup_color'];
            $popup_width	  = $popup_options['popup_width'];
			$popup_height	  = $popup_options['popup_height'];
			$popup_padding	  = $popup_options['popup_padding'];
		}
		
		if($popup_mobile) {
			$mobile_yes = 'checked="checked"';
			$mobile_no = '';
		} else {
			$mobile_no = 'checked="checked"';
			$mobile_yes = '';
		}
		
		/**
		 * Create dropdown to choose popup
		 */
		function select_popup() {
			global $popup_ID;
			$popups = get_posts( array( 'post_type' => 'premier_popup' ) ); 
			foreach ( $popups as $popup ) {
				$option = '<option value="' . $popup->ID . '"';
				if ( $popup_ID == $popup->ID ) {
					$option .= ' selected="selected"';
				}
				$option .= '>';
				$option .= $popup->post_title;
				$option .= '</option>';
				echo $option;
			}
		}
	
		include_once('options-page.php');
	}
}
