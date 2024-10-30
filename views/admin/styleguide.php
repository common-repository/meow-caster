<?php
/**
 * View for plugin config
 */

use MeowCasterPremium\Contents\MeowVideoGallery;
use function MeowCaster\meow_look;

?>
<div class="mcss-wrapper mcss-form mcss-csp-config">
    <main><?php
	$meow_page_title = __( 'Styleguide', MEOW_CASTER_SLUG );
	include 'header.php';
	?>
        <div class="mcss-help">
            <h3><?php _e( 'Help :', MEOW_CASTER_SLUG ); ?></h3>
            <p>lorem ipsum </p>
            <p>
            <ul class="help-list">
                <li><b>elem1</b> legend elem 1</li>
                <li><b>elem2</b> legend elem 2</li>
                <li><b>elem3</b> legend elem 3</li>
            </ul>
            </p>
        </div>
        <div class="mcss-test-divers">
<?php
    // Zone de Test divers et variés!
    $mc_update = new \MeowCaster\Services\MeowUpdate();
    $mc_update->to_1_1_0();
    echo 'hello';


?>
        </div>
        <div class="mcss-config-container">
            <div class="mcss-tabs">
                <div class="mcss-tabs-side">
                    <ul>
                        <li><a href="#PanelCheckbox"><?php _e( 'Checkbox', MEOW_CASTER_SLUG ); ?></a></li>
                        <li><a href="#PanelRadio"><?php _e( 'Radio', MEOW_CASTER_SLUG ); ?></a></li>
                        <li><a href="#PanelOthers"><?php _e( 'Others Fields', MEOW_CASTER_SLUG ); ?></a></li>
                        <li><a href="#livepreviousplayer"><?php _e( 'Live Preview Player', MEOW_CASTER_SLUG ); ?></a>
                        </li>
                        <li><a href="#progressbar"><?php _e( 'Progress Bar', MEOW_CASTER_SLUG ); ?></a></li>
                        <li><a href="#buttonJS"><?php _e( 'Buttons', MEOW_CASTER_SLUG ); ?></a></li>
                        <li><a href="#ConsentPrivacy"><?php _e('Privacy Consent', MEOW_CASTER_SLUG);?></a></li>
                    </ul>
                </div>
                <div>
                    <section class="mcss-config-section">
                        <h3 id="PanelCheckbox"> Forms </h3>

                        <h4>Basics checkbox</h4>
                        <div> <input type="checkbox" id="cbx1" name="" class="custom-checkbox test" value="" <?php
if( false === ''){ echo 'checked'; }?>>
<label for="cbx1"><?php _e('Checkbox 1', MEOW_CASTER_SLUG ); ?></label>
                        </div>
                        <div>
                            <input type="checkbox" id="cbx2" class="custom-checkbox">
                            <label for="cbx2">checkbox 2</label>
                        </div>
                        <div>
                            <input type="checkbox" id="cbx3" class="custom-checkbox" disabled>
                            <label for="cbx3">checkbox 3 disabled</label>
                        </div>
                        <div>
                            <input type="checkbox" id="cbx4" class="custom-checkbox" checked>
                            <label for="cbx4">checkbox 4 checked</label>
                        </div>

                        <h4>Toggle Checkbox</h4>
                        <div class="can-toggle can-toggle--size-small">
                            <input id="cbx5" type="checkbox">
                            <label for="cbx5">
                                <div class="can-toggle__switch" data-checked="On" data-unchecked="Off"></div>
                                <div class="can-toggle__label-text">Checkbox</div>
                            </label>
                        </div>

                        <div class="can-toggle can-toggle--size-small">
                            <input id="cbx6" type="checkbox" checked>
                            <label for="cbx6">
                                <div class="can-toggle__switch" data-checked="On" data-unchecked="Off"></div>
                                <div class="can-toggle__label-text">Checkbox already check</div>
                            </label>
                        </div>

                        <div class="can-toggle can-toggle--size-small">
                            <input id="cbx7" type="checkbox" disabled>
                            <label for="cbx7">
                                <div class="can-toggle__switch" data-checked="On" data-unchecked="Off"></div>
                                <div class="can-toggle__label-text">Checkbox disabled</div>
                            </label>
                        </div>

                    </section>
                </div>
                <div>
                    <section class="mcss-config-section">
                        <h3 id="PanelRadio"> Forms Radio</h3>

                        <h4>Basic Radio</h4>

                        <div>
                            <input type="radio" id="rad1" name="radio" class="custom-radio">
                            <label for="rad1">radio 1</label>
                        </div>
                        <div>
                            <input type="radio" id="rad2" name="radio" class="custom-radio">
                            <label for="rad2">radio 2</label>
                        </div>
                        <div>
                            <input type="radio" id="rad3" name="radio" class="custom-radio" disabled>
                            <label for="rad3">radio 3 disabled</label>
                        </div>
                        <div>
                            <input type="radio" id="rad4" name="radio" class="custom-radio" checked>
                            <label for="rad4">radio 4 checked</label></div>
                    </section>
                </div>
                <div>
                    <section class="mcss-config-section">
                        <h3 id="PanelOthers"> Other field </h3>
                        <div class="mcss-config-choice mcss-config-choice-txt">
                            <label for="mcss_field_text" class="mcss-label-text">Text Field Label</label>
                            <input id="mcss_field_text" name="mcss_fields_text"
                                   class="mcss-input-text custom-input-text" placeholder="Placeholder" value=""
                                   type="text">
                        </div>
                        <div class="custom-select">
                            <select>
                                <option>Aw yeah.</option>
                                <option>You should pick me instead.</option>
                                <option>I think I'm the better option!</option>
                            </select>
                        </div>
                        <div class="custom-colorpicker">
                            <input type="text" class="mcss-color-picker">
                        </div>

                    </section>
                </div>
                <div>
                    <section class="mcss-config-section">
                        <h3 id="livepreviousplayer"><?php _e( 'Live Preview Player', MEOW_CASTER_SLUG ); ?></h3>
	                    <?php include 'form-settings-youtube-livepreview.php'; ?>
                    </section>
                </div>
                <div>
                    <section class="mcss-config-section">
                        <h3 id="progressbar"><?php _e( 'Progress Bar', MEOW_CASTER_SLUG ); ?></h3>

                        <div class="mcss-progressbar">
                            <div id="mcss-progressbar1" class="mcss-bar" data-max=500 data-actual=1>1</div>
                        </div>
                        <p>
                            <button onclick="styleguide_move()">Click</button>
                        </p>
                    </section>
                    <!-- JS EXAMPLE -->
                    <script>
                        function styleguide_move() {
                            var elem = document.getElementById("mcss-progressbar1");
                            var width = Math.floor(parseInt(elem.dataset.actual) / parseInt(elem.dataset.max));
                            var id = setInterval(styleguide_frame, 10);

                            function styleguide_frame() {
                                if (parseInt(width) >= 100 || parseInt(elem.dataset.actual) >= parseInt(elem.dataset.max)) {
                                    clearInterval(id);
                                } else {
                                    add = Math.floor((Math.random() * 20) + 1);
                                    console.log(add);
                                    elem.dataset.actual = add + parseInt(elem.dataset.actual);
                                    width = Math.floor(parseInt(elem.dataset.actual) / parseInt(elem.dataset.max) * 100);

                                    if (parseInt(width) >= 100) {
                                        width = 100;
                                    }
                                    if (parseInt(elem.dataset.actual) >= parseInt(elem.dataset.max)) {
                                        elem.dataset.actual = elem.dataset.max;
                                    }
                                    elem.style.width = width + '%';
                                    console.log("Style add : " + elem.style.width);
                                    elem.innerHTML = elem.dataset.actual + '/' + elem.dataset.max;
                                }
                            }
                        }
                    </script>
                </div>
                <div>
                    <section class="mcss-config-section">
                        <h3 id="buttonJS"><?php _e( 'Button JS', MEOW_CASTER_SLUG ); ?></h3>

                        <p>
                            <button class="mcss-btn-multi">
                                <span class="base"><?php _e( 'Import', MEOW_CASTER_SLUG ); ?></span>
                                <span class="error"><?php _e( 'Import fail', MEOW_CASTER_SLUG ); ?></span>
                                <span class="wait"><?php _e( 'in progress', MEOW_CASTER_SLUG ); ?></span>
                                <span class="ok"><?php _e( 'Imported', MEOW_CASTER_SLUG ); ?></span>

                            </button>
                        </p>
                        <p>
                            <button class="mcss-btn-multi mcss-btn-error" disabled>
                                <span class="base"><?php _e( 'Import', MEOW_CASTER_SLUG ); ?></span>
                                <span class="error"><?php _e( 'Import fail', MEOW_CASTER_SLUG ); ?></span>
                                <span class="wait"><?php _e( 'in progress', MEOW_CASTER_SLUG ); ?></span>
                                <span class="ok"><?php _e( 'Imported', MEOW_CASTER_SLUG ); ?></span>
                            </button>
                        </p>
                        <p>
                            <button class="mcss-btn-multi mcss-btn-wait" disabled>
                                <span class="base"><?php _e( 'Import', MEOW_CASTER_SLUG ); ?></span>
                                <span class="error"><?php _e( 'Import fail', MEOW_CASTER_SLUG ); ?></span>
                                <span class="wait"><?php _e( 'in progress', MEOW_CASTER_SLUG ); ?></span>
                                <span class="ok"><?php _e( 'Imported', MEOW_CASTER_SLUG ); ?></span>

                            </button>
                        </p>
                        <p>
                            <button class="mcss-btn-multi mcss-btn-ok" disabled>
                                <span class="base"><?php _e( 'Import', MEOW_CASTER_SLUG ); ?></span>
                                <span class="error"><?php _e( 'Import fail', MEOW_CASTER_SLUG ); ?></span>
                                <span class="wait"><?php _e( 'in progress', MEOW_CASTER_SLUG ); ?></span>
                                <span class="ok"><?php _e( 'Imported', MEOW_CASTER_SLUG ); ?></span>

                            </button>
                        </p>
                        <p>Default&nbsp;:
                            <input type="submit" class="mcss-button">
                            <button class="mcss-button">Default btn</button>
                        </p>
                        <p>
                            Good&nbsp;:
                            <input type="submit" class="mcss-button-good">
                            <button class="mcss-button-good">Good&nbsp;!</button>
                            <button class="mcss-button-good mcss-button-validation">Validation Full</button>
                        </p>
                        <p>Bad&nbsp;:
                            <input type="submit" class="mcss-button-bad">
                            <button class="mcss-button-bad">Bad button</button>
                        </p>
                        <p>Alert&nbsp;:
                            <input type="submit" class="mcss-button-alert">
                            <button class="mcss-button-alert">Alert button!</button>
                        </p>
                        <div>Button Icon line&nbsp;:</div>
                        <p class="mcss-btn-line">
                            <button class="mcss-btn-sync mcss-btn-sync-from mcss-btn-multi mcss-button-icon"
                                    title="<?php _e( 'Sync In', MEOW_CASTER_SLUG ); ?>"
                            ></button>
                            <button class="mcss-btn-sync mcss-btn-sync-to mcss-btn-multi mcss-button-icon"
                                    title="<?php _e( 'Sync Out', MEOW_CASTER_SLUG ); ?>"
                            ></button>
                            <button class="mcss-btn-sync mcss-btn-sync-both mcss-btn-multi mcss-button-icon"

                                    title="<?php _e( 'Sync In/Out', MEOW_CASTER_SLUG ); ?>"
                            ></button>
                        </p>
                    </section>
                </div>
                <div>
                    <?php
                    // Consent theming
                    $consent_theme = [ 'dark', 'light', 'blue'];
                    $consent_duration = 3;
                    ?>
                    <section class="mcss-config-section">
                        <h3 id="ConsentPrivacy"><?php _e( 'Privacy consent', MEOW_CASTER_SLUG ); ?></h3>
                        <?php foreach( $consent_theme as $theme ):?>
                            <div class="mcss-player-consent-container <?php echo 'mcss-player-consent-theme-'.$theme ;?>"
                                 data-widget="1"
                                 data-id="123"
                                 data-type="player"
                                 data-url="#">
                                <div class="mcss-player-consent-message">
                                    <p><?php _e( 'For watching this video, you have to accept to send information to ', MEOW_CASTER_SLUG ); ?>
                                        <b>Youtube</b>&nbsp;(<a
                                                href="https://policies.google.com/privacy"
                                                target="_blank"><?php _e( 'YouTube privacy policy', MEOW_CASTER_SLUG ); ?></a>)</p>

                                        <p><?php _e( 'You can access to <b>Youtube</b> with or without cookie as you pleased', MEOW_CASTER_SLUG ); ?></p>

                                    <p><?php echo sprintf(
					                        _n( 'Your consent will be store in a cookie for this unique purpose for  %s day',
						                        'Your consent will be store in a cookie for this unique purpose for %s days', $consent_duration, MEOW_CASTER_SLUG )
					                        , $consent_duration );
				                        ?>
                                    </p>
                                </div>
                                <div class="mcss-player-consent-btn-container">
                                        <button value="with-cookie" data-duration="<?php echo $consent_duration; ?>">Accept with cookie</button>
                                        <button value="without-cookie" data-duration="<?php echo $consent_duration; ?>">Accept without cookie
                                        </button>
                                </div>

                            </div>
                        <?php endforeach;?>
                    </section>
                </div>

            </div>


        </div>

    </main>
</div>
