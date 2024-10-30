<?php

function meow_role_checkbox( $cap, $role ) {
	$field_id   = "mc-" . $role->name . '-' . $cap;
	$field_name = "mc-main-settings[capabilities][" . $role->name . '][' . $cap . ']';
	ob_start();
	?>
    <input type="checkbox" id="<?php echo $field_id; ?>" name="<?php echo $field_name; ?>"
           class="custom-checkbox mcss-config-capa-cbx" value="1" <?php
	if ( $role->has_cap( $cap ) ) {
		echo 'checked';
	} ?>>
    <label for="<?php echo $field_id; ?>">&nbsp;</label>
	<?php
    return ob_get_clean();
}

?>

<h3 id="Global"><?php _e( 'Global settings', MEOW_CASTER_SLUG ); ?></h3>
<div class="mcss-global-container">
    
    <div class="mcss-license-container">
        <h4><?php _e( 'Capabilities', MEOW_CASTER_SLUG ); ?></h4>
        <p><?php _e( 'Who can use the functionnalities', MEOW_CASTER_SLUG ); ?></p>
		<?php $roles = wp_roles()->role_objects; ?>
        <div>
            <table class="mcss-config-table-capa">
                <thead>
                <tr>
                    <th><?php _e( 'Capabilities', MEOW_CASTER_SLUG ); ?></th>
					<?php foreach ( array_keys( $roles ) as $rolename ) {
						echo "<th><div>" . __( ucfirst( $rolename ) ) . '</div></th>';
					} ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>Manage Meow Settings</b>
                    <p class="mcss-hint">Authorize access to this page</p></td>
					<?php
					foreach ( $roles as $role ) {
						echo "<td><div>" . meow_role_checkbox( 'manage_meow_caster_settings', $role ) . "</div></td>";
					}
					?>
                </tr>
                <tr>
                    <td><b>Publish Videos</b>
                        <p class="mcss-hint">Who can publish videos</p></td></td>
	                <?php
	                foreach ( $roles as $role ) {
		                echo "<td><div>" . meow_role_checkbox( 'publish_meow_caster_videos', $role ) . "</div></td>";
	                }
	                ?>
                </tr>
                <tr>
                    <td><b>Publish Galleries</b>
                        <p class="mcss-hint">Who can publish galleries</p></td></td>
	                <?php
	                foreach ( $roles as $role ) {
		                echo "<td><div>" . meow_role_checkbox( 'publish_meow_caster_galleries', $role ) . "</div></td>";
	                }
	                ?>
                </tr>
                <tr>
                    <td><b>Import Meow Content</b>
                        <p class="mcss-hint">Who can import from YouTube</p>
                    </td>
	                <?php
	                foreach ( $roles as $role ) {
		                echo "<td><div>" . meow_role_checkbox( 'import_meow_caster_content', $role ) . "</div></td>";
	                }
	                ?>
                </tr>
                <tr>
                    <td><b>Edit Videos</b>
                        <p class="mcss-hint">Who can edit videos</p></td>
	                <?php
	                foreach ( $roles as $role ) {
		                echo "<td><div>" . meow_role_checkbox( 'edit_meow_caster_videos', $role ) . "</div></td>";
	                }
	                ?>
                </tr>
                <tr>
                    <td><b>Edit Galleries</b>
                        <p class="mcss-hint">Who can edit galleries</p></td>
	                <?php
	                foreach ( $roles as $role ) {
		                echo "<td><div>" . meow_role_checkbox( 'edit_meow_caster_galleries', $role ) . "</div></td>";
	                }
	                ?>
                </tr>
                <tr>
                    <td><b>Delete Videos</b>
                        <p class="mcss-hint">Who can delete video data</p></td>
	                <?php
	                foreach ( $roles as $role ) {
		                echo "<td><div>" . meow_role_checkbox( 'delete_meow_caster_videos', $role ) . "</div></td>";
	                }
	                ?>
                </tr>
                <tr>
                    <td><b>Delete Video Galleries</b>
                        <p class="mcss-hint">Who can delete galleries</p></td>
	                <?php
	                foreach ( $roles as $role ) {
		                echo "<td><div>" . meow_role_checkbox( 'delete_meow_caster_galleries', $role ) . "</div></td>";
	                }
	                ?>
                </tr>
                <tr>
                    <td><b>Read Private Videos</b>
                        <p class="mcss-hint">Who can read private videos </p></td>
	                <?php
	                foreach ( $roles as $role ) {
		                echo "<td><div>" . meow_role_checkbox( 'read_private_meow_caster_videos', $role ) . "</div></td>";
	                }
	                ?>
                </tr>
                <tr>
                    <td><b>Read Private Galleries</b>
                        <p class="mcss-hint">Who can read private galleries </p></td>
	                <?php
	                foreach ( $roles as $role ) {
		                echo "<td><div>" . meow_role_checkbox( 'read_private_meow_caster_galleries', $role ) . "</div></td>";
	                }
	                ?>
                </tr>
                <tr>
                    <td><b>Manage Meow Content Tags</b>
                        <p class="mcss-hint">Who can manage meow tags</p></td>
	                <?php
	                foreach ( $roles as $role ) {
		                echo "<td><div>" . meow_role_checkbox( 'manage_meow_caster_taxonomy', $role ) . "</div></td>";
	                }
	                ?>
                </tr>
                <tr>
                    <td><b>Embed</b>
                        <p class="mcss-hint">Who can embed videos or galleries on this site</p></td>
	                <?php
	                foreach ( $roles as $role ) {
		                echo "<td><div>" . meow_role_checkbox( 'embed_meow_caster_content', $role ) . "</div></td>";
	                }
	                ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
