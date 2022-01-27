<?php
/**
 * Bookmark modal content.
 *
 * This is the header template part.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="king-modal-login modal" id="rlatermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="king-modal-content">
		<button type="button" class="king-modal-close" data-dismiss="modal" aria-label="Close"><i class="icon fa fa-fw fa-times"></i></button>
		<h3><i class="fas fa-bookmark"></i> <?php echo esc_html_e( 'My Bookmarks', 'king' ); ?></h3>
		<ul id="king-rlater-inside"><span class="king-rlater-center"><div class="loader"></div></span></ul>
	</div>
</div>
