<?php
/**
 * Get Video Thumbs
 *
 * @link https://jetpack.com/
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Get source url of video.
 *
 * @param [type] $video_url video url.
 */
function king_source( $video_url ) {
	$parsed = wp_parse_url( $video_url );
	return str_replace( 'www.', '', strtolower( $parsed['host'] ) );
}

/**
 * Get video thumbnail.
 *
 * @param [type] $video_url video url.
 */
function king_get_thumb( $video_url ) {
	$res  = wp_remote_get( $video_url );
	$res2 = wp_remote_retrieve_body( $res );
	preg_match( '/property="og:image" content="(.*?)"/', $res2, $output );
	return ( $output[1] ) ? $output[1] : false;
}

/**
 * Gets the vimeo thumb.
 *
 * @param      <type>  $vimeo_url  The vimeo url
 *
 * @return     bool    The vimeo.
 */
function king_get_vimeo($vimeo_url)
{
	if ( ! $vimeo_url ) {
		return false;
	}
	$data = json_decode( file_get_contents( 'http://vimeo.com/api/oembed.json?url=' . $vimeo_url ) );
	if ( ! $data ) {
		return false;
	}
	return $data->thumbnail_url;
}
/**
 * Get soundcloud video thumbnail.
 *
 * @param [type] $video_url video url.
 */
function king_soundcloud( $video_url ) {

	$url                 = 'https://api.soundcloud.com/resolve.json?url=' . $video_url . '&client_id=KqmJoxaVYyE4XT0XQqFUUQ';
	$track_json          = wp_remote_get( $url );
	$track_json2         = wp_remote_retrieve_body( $track_json );
	$track               = json_decode( $track_json2 );
	$video_thumbnail_url = str_replace( 'large', 'crop', $track->artwork_url );
	return $video_thumbnail_url;
}

/**
 * Get youtube video thumbnail.
 *
 * @param [type] $video_url video url.
 */
function king_youtube( $video_url ) {
	$queryString = wp_parse_url( $video_url, PHP_URL_QUERY );
	wp_parse_str( $queryString, $params) ;
	if ( isset( $params['v'] ) ) {
		return "https://i3.ytimg.com/vi/" . trim( $params['v'] ) . "/hqdefault.jpg";
	}
	return true;
}

/**
 * Get facebook video thumbnail.
 *
 * @param [type] $video_url video url.
 * @return mixed
 */
function king_facebook( $video_url ) {
	$facebook_access_token = get_field( 'facebook_user_access_token', 'option' );
	$paths                 = explode( '/', $video_url );
	$num                   = count( $paths );
	for ( $i = $num -1; $i > 0; $i-- ) {
		if ( '' !== $paths[ $i ] ) {
			$video_id = $paths[ $i ];
			break;
		}
	}
	$url          = 'https://graph.facebook.com/' . $video_id . '/thumbnails?access_token=' . $facebook_access_token;
	$track_json   = wp_remote_get( $url );
	$track_json2  = wp_remote_retrieve_body( $track_json );
	$result       = json_decode( $track_json2 );
	return $large = $result->data[0]->uri;
}

/**
 * Upload thumbnail.
 *
 * @param [type] $image_url array.
 * @param [type] $post_id post id.
 * @param [type] $filename filename.
 * @param [type] $post_data post data.
 */
function king_upload_user_file_video( $image_url = array(), $post_id = null, $post_data = array() ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	if ( ! $image_url || ! $post_id ) {
		return new WP_Error( 'missing', 'Need a valid URL and post ID...' );
	}
	preg_match( '/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG|image)/', $image_url, $matches );
	$url_filename = basename( $matches[0] );
	$url_type     = wp_check_filetype( $url_filename );
	if ( empty( $url_type['ext'] ) ) {
		$url_filename = $image_url . '.jpg';
	}

	$tmp = download_url( $image_url );
	if ( is_wp_error( $tmp ) ) {
		@unlink( $file_array['tmp_name'] );
		$file_array['tmp_name'] = '';
		return $tmp;
	}
	$file_array['tmp_name'] = $tmp;
	$file_array['name']     = $url_filename;
	if ( empty( $post_data['post_title'] ) ) {
		$post_data['post_title'] = basename( $url_filename, '.' . $url_type['ext'] );
	}

	if ( empty( $post_data['post_parent'] ) ) {
		$post_data['post_parent'] = $post_id;
	}
	$att_id = media_handle_sideload( $file_array, $post_id, null, $post_data );
	if ( is_wp_error( $att_id ) ) {
		@unlink( $file_array['tmp_name'] );
		return $att_id;
	}
	return $att_id;
}

