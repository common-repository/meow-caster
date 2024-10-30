<?php
/**
 * Trigger on uninstall plugin MeowCaster
 *
 * @package MeowCaster
 */


if ( ! current_user_can( 'activate_plugins' ) || ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

//nothing for now
