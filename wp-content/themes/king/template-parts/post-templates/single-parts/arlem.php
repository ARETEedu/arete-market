<?php
/**
 * KB WIP The singe post part - arlem. 
 *
 * This is a content template part.
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
<div class="post-arlem">	
	<?php $download_link = get_field( 'arlem_upload', get_the_ID() ) ;
	$url = 	$download_link['url'];
	
	?>
	<div class="arlem-download">
		<a href=<?php echo esc_attr( $url );?>>Download Files</a>
		<span class="screen-reader-text">"Download Files"</span>
	</div>
	
</div>	

