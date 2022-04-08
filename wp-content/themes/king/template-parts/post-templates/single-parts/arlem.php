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
	<br>
	<h4>Files</h4>	
	<span class="arlem-link">

	<?php 
	
	$download_link = get_field( 'arlem_upload', get_the_ID() ) ;
	$url = 	$download_link['url'];
	echo '<a class="download-arlem-link" href="'.esc_attr( $url ).'">Download Files</a>';
	echo '<span class="screen-reader-text">Download Files</span>';
	?>
	</span>
	<br>
	<div class="licence-info">
		<h4>Licensing</h4>
	<?php $licence = get_field( 'licence', get_the_ID() ) ;
	echo '<p><i>Licenced under <a href="https://creativecommons.org/about/cclicenses/">'.$licence.'</a></i></p>';
	echo '<span class="screen-reader-text">Licenced under '.$licence.'</span>';
	?>
	</div>
</div>	

