<?php

$roar = \MeowCaster\Services\MeowRoar::getInstance();

?>
<header>
    <div class="mcss-action-bar">
        <h1><?php echo MEOW_CASTER_NAME; ?></h1>
        <h2><?php echo $meow_page_title; ?></h2>
    </div>
	<?php if ( $roar->hasError() ): ?>
        <div class="mcss-err">
			<?php foreach ( $roar->getError() as $code => $error ): ?>
                <div class="mcss-err-<?php echo $error['type']; ?> mcss-err-<?php echo $error['code']; ?>">
                    <span class="mcss-err-code"><?php echo sprintf( __( 'Error %s : ', MEOW_CASTER_SLUG ), $error['code'] ); ?></span>
					<?php echo $error['message']; ?>
                </div>
			<?php endforeach; ?>
        </div>
	<?php endif; ?>
	<?php if ( $roar->hasNotification() ): ?>
        <div class="mcss-notif-container">
			<?php foreach ( $roar->getNotification() as $notification ): ?>
                <div class="mcss-notif mcss-notif-<?php echo $notification['type']; ?>">
					<?php echo $notification['message']; ?>
                </div>
			<?php endforeach; ?>
        </div>
	<?php endif; ?>
	<?php if ( $mc_debug != false ): ?>
        <div class="debug">
            <pre><?php echo print_r( $mc_debug, true ); ?></pre>
        </div>
	<?php endif; ?>
	<?php if ( $mc_debug_i18n != false ): ?>
        <div class="debug_i18n">
            <pre><?php debug_i18n_csp( $trad, $mc_template_info ); ?></pre>
        </div>
	<?php endif; ?>

</header>