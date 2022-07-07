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
global $post;
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
		<h4>Licence</h4>
	<?php 
		$meta = get_post_meta( get_the_ID() ) ;
		$licence = $meta['licence'][0];
		//Default URL
		$licence_url = 'https://creativecommons.org/about/cclicenses/';
		//Default name
		$licence_name = 'unset';
		//Get licence name out of string
		if (preg_match('/"([^"]+)"/', $licence, $m)) {
			$licence_name = $m[1];
		}

		while( have_rows('licences', 'option') ) : the_row();
			$lic = get_sub_field('licence_name');
			if ( $lic == $licence_name ) {
				$licence_url = get_sub_field('licence_url');
			}
		endwhile;
		echo '<p><i>Licenced under <a href="'.$licence_url.'">'.$licence_name.'</a></i></p>';
		echo '<span class="screen-reader-text">Licenced under '.$licence_name.'</span>';
	?>
	</div>
</div>	

