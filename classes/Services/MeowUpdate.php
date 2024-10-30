<?php

namespace MeowCaster\Services;

defined( 'ABSPATH' ) or die( 'Doh?!' );

/**
 * Class MeowUpdate
 *
 * Update Handler for Meow Plugins
 *
 * @package MeowCaster\Services
 * @since   1.1.0
 */
class MeowUpdate {

	/**
	 * @var string
	 */
	protected static $version = '1.1.2';

	/**
	 * Array of version who need a change of any type
	 * @var array
	 */
	protected static $change_need = [
		'1.1.0', '1.1.2'
	];

	public function setup_action() {
		add_action( 'upgrader_process_complete', [ $this, 'process_update' ], 10, 2 );
	}


	private function update_to(){
		$previous_version = get_option(MEOW_CASTER_SETTINGS.'_version', 'miaou');
		if( $previous_version === 'miaou'){
			$previous_version = '1.0.0';
		}
		$todo_update= [];
		foreach($this->change_need as $v){
			if( version_compare($previous_version, $v, '<') ) {
				$todo_update[]= $v;
			};
		}

		if( in_array('1.1.0', $todo_update) ) $this->to_1_1_0();
		if( in_array('1.1.2', $todo_update) ) $this->to_1_1_2();

	}
	public function process_update( $upgrader_object, $options ) {
		$current_plugin_path_name = plugin_basename( MEOW_CASTER_FILE );

		if ( $options['action'] == 'update'
		     && $options['type'] == 'plugin'
		     && in_array($current_plugin_path_name , $options['plugins']  )  ) {

			$this->update_to();
		}

		// Update the version in database
		update_option( MEOW_CASTER_SETTINGS.'_version', MEOW_CASTER_VERSION );
	}


	// Function to call for each update

	public function to_1_1_0(){
		// Stop double serialisation
		$base  = MEOW_CASTER_SETTINGS;
		$base_ = $base . '_';

		$all_options_before_1_1_0 = [
			$base,
			$base_ . 'version',
			$base_ . 'flush_request',
			$base_ . 'cpt_load',
			$base_ . 'sync',
			$base_ . 'youtube',
			$base_ . 'youtube_creds',
			$base_ . 'youtube_token',
			$base_ . 'youtube_etags',
			$base_ . 'base_settings',
			$base_ . 'youtube_player_settings'
		];
		// unserialize
		foreach($all_options_before_1_1_0 as $tmp_options){
			$tmp = maybe_unserialize( get_option($tmp_options, 'miaou') );

			update_option($tmp_options,$tmp);
		}

		// Add new elements in config default
		$opt_base = get_option($base);
		$opt_base['yts']['consent-status'] = 'off';
		$opt_base['yts']['consent-theme'] = 'dark';
		update_option($base,$opt_base);

		// FIX for Sync
		$sync_opt = get_option($base_ . 'sync', 'miaou');
		if( $sync_opt === 'miaou' || ! isset($sync_opt['method'] ) ){
			$sync_opt = ['method'=> 'all'];
			update_option($base_ . 'sync',$sync_opt);
		}
			// Add the version
		add_option( MEOW_CASTER_SETTINGS.'_version', '1.1.0' );
	}

	public function to_1_1_2(){
		$base  = MEOW_CASTER_SETTINGS;
		$base_ = $base . '_';

		// FIX for Sync
		$sync_opt = get_option($base_ . 'sync', 'miaou');
		if( $sync_opt === 'miaou' || ! isset($sync_opt['method'] ) ){
			$sync_opt = ['method'=> 'all'];
			update_option($base_ . 'sync',$sync_opt);
		}

		// Add the version
		add_option( MEOW_CASTER_SETTINGS.'_version', '1.1.2' );
	}
}