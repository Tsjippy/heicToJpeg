<?php
namespace SIM\HEICTOJPEG;
use SIM;

add_filter('sim_submenu_heictojpeg_options', __NAMESPACE__.'\addToSubmenu', 20, 2);
function addToSubmenu($optionsHtml, $settings){
	ob_start();
    ?>
    <br>
	<label>
		<input type='checkbox' name='convert-heic' value=1 <?php if(isset($settings['convert-heic'])){echo 'checked';}?>>
		Convert attached .heic files to jpeg
	</label>
    <?php

    return $optionsHtml.ob_get_clean();
}