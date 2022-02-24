<?php
/**
 * Theme options.
 *
 * @package King.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! function_exists( 'king_posttypes' ) ) :
	/**
	 * Post Types.
	 */
	function king_posttypes() {
		register_post_type(
			'list',
			array(
				'labels'        => array(
					'name'          => __( 'Lists' ),
					'singular_name' => __( 'List' ),
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => 'list' ),
				'menu_position' => 5,
				'supports'      => array( 'title', 'editor', 'comments', 'thumbnail' ),
				'taxonomies'    => array( 'post_tag', 'category' ),
				'menu_icon'     => 'dashicons-editor-ul',
			)
		);
		register_post_type(
			'poll',
			array(
				'labels'        => array(
					'name'          => __( 'Polls' ),
					'singular_name' => __( 'Poll' ),
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => 'poll' ),
				'menu_position' => 5,
				'supports'      => array( 'title', 'editor', 'comments', 'thumbnail' ),
				'taxonomies'    => array( 'post_tag', 'category' ),
				'menu_icon'     => 'dashicons-chart-bar',
			)
		);
		//KB CHANGES
		register_post_type(
			'arlem',
			array(
				'labels'        => array(
					'name'          => __( 'ARLEM' ),
					'singular_name' => __( 'ARLEM' ),
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => 'arlem' ),
				'menu_position' => 5,
				'supports'      => array( 'title', 'editor', 'comments', 'thumbnail' ),
				'taxonomies'    => array( 'post_tag', 'category' ),
				'menu_icon'     => 'dashicons-welcome-learn-more',
			)
		);
		register_post_type(
			'trivia',
			array(
				'labels'        => array(
					'name'          => __( 'Trivia Quiz' ),
					'singular_name' => __( 'Quiz' ),
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => 'trivia' ),
				'menu_position' => 5,
				'supports'      => array( 'title', 'editor', 'comments', 'thumbnail' ),
				'taxonomies'    => array( 'post_tag', 'category' ),
				'menu_icon'     => 'dashicons-forms',
			)
		);
		register_post_type(
			'stories',
			array(
				'labels'        => array(
					'name'          => __( 'Stories' ),
					'singular_name' => __( 'Story' ),
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => 'stories' ),
				'menu_position' => 5,
				'supports'      => array( 'title', 'thumbnail' ),
				'menu_icon'     => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyMy4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAyMCAyMCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjAgMjAiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHBhdGggZmlsbD0iI0E3QUFBRCIgZD0iTTEwLDAuNWMtNS4zLDAtOS41LDQuMy05LjUsOS41czQuMyw5LjUsOS41LDkuNXM5LjUtNC4zLDkuNS05LjVTMTUuMywwLjUsMTAsMC41eiBNNS41LDE0LjFINC4yDQoJQzMuNSwxNC4xLDMsMTMuNiwzLDEzVjdjMC0wLjYsMC41LTEuMSwxLjEtMS4xaDEuM1YxNC4xeiBNMTMuMiwxMy45YzAsMC44LTAuNywxLjUtMS41LDEuNUg4LjNjLTAuOCwwLTEuNS0wLjctMS41LTEuNVY2LjENCgljMC0wLjgsMC43LTEuNSwxLjUtMS41aDMuNWMwLjgsMCwxLjUsMC43LDEuNSwxLjVWMTMuOXogTTE2LDE0LjFoLTEuM1Y1LjlIMTZjMC42LDAsMS4yLDAuNSwxLjIsMS4xVjEzDQoJQzE3LjEsMTMuNiwxNi42LDE0LjEsMTYsMTQuMXoiLz4NCjxsaW5lIGZpbGw9Im5vbmUiIHgxPSIxMyIgeTE9IjE2LjUiIHgyPSIxMyIgeTI9IjE1LjQiLz4NCjxsaW5lIGZpbGw9Im5vbmUiIHgxPSIxMyIgeTE9IjQuNiIgeDI9IjEzIiB5Mj0iMy4xIi8+DQo8L3N2Zz4NCg==',
			)
		);
	}
	add_action( 'init', 'king_posttypes' );
endif;
if ( ! function_exists( 'add_my_post_types_to_query' ) ) :
	/**
	 * Add Post types to home page and search result.
	 *
	 * @param <type> $query  The query.
	 *
	 * @return <type> ( description_of_the_return_value ).
	 */
	function add_my_post_types_to_query( $query ) {
		if ( is_home() && $query->is_main_query() || $query->is_search || $query->is_category || $query->is_tag ) {
			$query->set( 'post_type', array( 'post', 'list', 'poll', 'trivia', 'arlem' ) ); //KB add arlem post type
		}
		return $query;
	}
	add_action( 'pre_get_posts', 'add_my_post_types_to_query' );
endif;
if ( ! function_exists( 'king_post_types' ) ) :
	/**
	 * Post Types.
	 *
	 * @return     array  ( description_of_the_return_value )
	 */
	function king_post_types() {
		$ptype = array( 'post', 'list', 'poll', 'trivia', 'arlem' ); //KB change
		return $ptype;
	}
endif;
if ( king_plugin_active( 'ACF' ) ) :
	if ( ! function_exists( 'king_excerpt_length' ) ) :
		/**
		 * Length of post content in homepage.
		 *
		 * @param <type> $length The length.
		 *
		 * @return int ( description_of_the_return_value )
		 */
		function king_excerpt_length( $length ) {
			return 10;
		}
		add_filter( 'excerpt_length', 'king_excerpt_length' );
	endif;
	if ( ! function_exists( 'king_gifs' ) && get_field( 'enable_gifs_comments', 'options' ) ) :
		/**
		 * Search Gifs.
		 */
		function king_gifs() {
			$keyword = sanitize_text_field( wp_unslash( $_POST['keyword'] ) );
			$api_key = get_field( 'giphy_api_key', 'options' );
			if ( $keyword ) {
				$url = 'http://api.giphy.com/v1/gifs/search?q=' . $keyword . '&api_key=' . $api_key . '&limit=15';
			} else {
				$url = 'https://api.giphy.com/v1/gifs/trending?api_key=' . $api_key . '&limit=15';
			}
			$access   = wp_remote_get( $url );
			$response = json_decode( $access['body'], true );
			$results  = $response['data'];
			foreach ( $results as $result ) {
				echo '<div class="king-gif" data-embed="' . esc_attr( $result['embed_url'] ) . '"><img src="https://i.giphy.com/media/' . esc_attr( $result['id'] ) . '/200.webp" /></div>';
			}
			die();
		}
		add_action( 'wp_ajax_king_gifs', 'king_gifs' );
		add_action( 'wp_ajax_nopriv_king_gifs', 'king_gifs' );
	endif;
	if ( ! function_exists( 'king_replace_gifs' ) ) :
		/**
		 * Replace gif link to video.
		 *
		 * @param <type> $comment_text The comment text.
		 * @param <type> $comment The comment.
		 * @param <type> $args The arguments.
		 *
		 * @return     <type>  ( description_of_the_return_value )
		 */
		function king_replace_gifs( $comment_text, $comment, $args ) {
			if ( preg_match_all( '/<a href="https:\/\/giphy\.com\/embed\/([^"]+)"[^>]+>[^<]+<\/a>/', $comment_text, $output ) ) {
				$div  = '<div class="kinggif">';
				$div .= '<video preload="none" autoplay muted loop playsinline>';
				$div .= '<source src="https://media1.giphy.com/media/%s/giphy.mp4" type="video/mp4">';
				$div .= '</video>';
				$div .= '<span>' . esc_html__( 'by Giphy', 'king' ) . '</span>';
				$div .= '</div>';
				$urls = $output[0];
				$ids  = $output[1];
				foreach ( $urls as $index => $url ) {
					$video        = sprintf( $div, $ids[ $index ] );
					$comment_text = str_replace( $url, $video, $comment_text );
				}
			}
			return $comment_text;
		}
		add_filter( 'comment_text', 'king_replace_gifs', 10, 3 );
	endif;
	if ( ! function_exists( 'king_submit_ajax_comment' ) ) :
		/**
		 * Comment submit ajax.
		 */
		function king_submit_ajax_comment() {
			$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
			if ( is_wp_error( $comment ) ) {
				$error_data = intval( $comment->get_error_data() );
				if ( ! empty( $error_data ) ) {
					wp_die( '' . $comment->get_error_message() . '', esc_html__( 'Comment Submission Failure', 'king' ), array( 'response' => $error_data, 'back_link' => true ) );
				} else {
					wp_die( 'Unknown error' );
				}
			}

			$user = wp_get_current_user();
			do_action( 'set_comment_cookies', $comment, $user );
			$comment_depth  = 1;
			$comment_parent = $comment->comment_parent;
			while ( $comment_parent ) {
				$comment_depth++;
				$parent_comment = get_comment( $comment_parent );
				$comment_parent = $parent_comment->comment_parent;
			}
			$GLOBALS['comment']       = $comment;
			$GLOBALS['comment_depth'] = $comment_depth;
			$comment_html             = king_comment( $comment, null, $comment_depth );
			echo $comment_html;
			die();
		}
		add_action( 'wp_ajax_king_submit_ajax_comment', 'king_submit_ajax_comment' );
		add_action( 'wp_ajax_nopriv_king_submit_ajax_comment', 'king_submit_ajax_comment' );
	endif;

	if ( ! function_exists( 'king_modify_comment_fields' ) ) :
		/**
		 * Modify Default Comments.
		 *
		 * @param <type> $fields  The fields.
		 *
		 * @return <type> ( description_of_the_return_value )
		 */
		function king_modify_comment_fields( $fields ) {

			$gifhtml = '<div class="king-comment-extra">';
			if ( get_field( 'enable_gifs_comments', 'options' ) ) :
				$gifhtml .= '<div class="king-gif-toggle" data-toggle="dropdown" data-target=".king-gifs" aria-expanded="true">GIF</div>';
				$gifhtml .= '<div class="king-gifs">
							<div class="king-gif-search">
								<input type="search" id="king-gifs" placeholder="' . esc_html__( 'Search', 'king' ) . '"  autocomplete="off" />
							</div>
							<div id="kingif-results"></div>
						</div>';
			endif;
			if ( get_field( 'enable_emoji_comments', 'options' ) ) :
				$gifhtml .= '<div class="king-emj-toggle" data-toggle="dropdown" data-target=".king-emj" aria-expanded="true"><i class="far fa-smile-wink"></i></div>';
				$gifhtml .= '<div class="king-emj"></div>';
			endif;
			$gifhtml .= '</div>';

			if ( get_field( 'author_image', 'user_' . get_current_user_id() ) ) :
				$image  = get_field( 'author_image', 'user_' . get_current_user_id() );
				$avatar = '<div class="user-cfrom-avatar" style="background-image:url(' . esc_url( $image['sizes']['thumbnail'] ) . ');" ></div>';
			else :
				$avatar = '<div class="user-cfrom-avatar"></div>';
			endif;

			$fields['comment_field']      = '<div class="show-gif"></div><div class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true" placeholder="' . esc_html__( 'Comment*', 'king' ) . '" ></textarea>' . $gifhtml . '</div>';
			$fields['title_reply']        = $avatar;
			$fields['title_reply_before'] = '';
			$fields['cancel_reply_link']  = '<i class="fas fa-times"></i>';
			$fields['logged_in_as']       = '';
			return $fields;

		}
		add_filter( 'comment_form_defaults', 'king_modify_comment_fields' );
	endif;

	if ( ! function_exists( 'king_emoji' ) && get_field( 'enable_emoji_comments', 'options' ) ) :
		/**
		 * King Emoji for comments.
		 */
		function king_emoji() {
			$output = '<div class="kingemj-smileys">';
			if ( ! get_field( 'hide_default_emojis', 'options' ) ) :
				$output .= '<span class="emojis" data-emj="🙂">🙂</span>
				<span class="emojis" data-emj="😊">😊</span>
				<span class="emojis" data-emj="😃">😃</span>
				<span class="emojis" data-emj="😅">😅</span>
				<span class="emojis" data-emj="🤣">🤣</span>
				<span class="emojis" data-emj="😊">😊</span>
				<span class="emojis" data-emj="😇">😇</span>
				<span class="emojis" data-emj="🙃">🙃</span>
				<span class="emojis" data-emj="😍">😍</span>
				<span class="emojis" data-emj="🥰">🥰</span>
				<span class="emojis" data-emj="😘">😘</span>
				<span class="emojis" data-emj="😝">😝</span>
				<span class="emojis" data-emj="😎">😎</span>
				<span class="emojis" data-emj="☹️">☹️</span>
				<span class="emojis" data-emj="😢">😢</span>
				<span class="emojis" data-emj="😡">😡</span>
				<span class="emojis" data-emj="😱">😱</span>
				<span class="emojis" data-emj="🤭">🤭</span>
				<span class="emojis" data-emj="🙄">🙄</span>
				<span class="emojis" data-emj="😬">😬</span>
				<span class="emojis" data-emj="😈">😈</span>
				<span class="emojis" data-emj="🥴">🥴</span>
				<span class="emojis" data-emj="🤕">🤕</span>
				<span class="emojis" data-emj="💩">💩</span>';
				$output .= '<span class="emojis" data-emj="👋">👋</span>
				<span class="emojis" data-emj="🤚">🤚</span>
				<span class="emojis" data-emj="👌">👌</span>
				<span class="emojis" data-emj="🤞">🤞</span>
				<span class="emojis" data-emj="🤟">🤟</span>
				<span class="emojis" data-emj="🖕">🖕</span>
				<span class="emojis" data-emj="👍">👍</span>
				<span class="emojis" data-emj="👊">👊</span>
				<span class="emojis" data-emj="👏">👏</span>
				<span class="emojis" data-emj="🙏">🙏</span>
				<span class="emojis" data-emj="💋">💋</span>
				<span class="emojis" data-emj="👅">👅</span>
				<span class="emojis" data-emj="🐶">🐶</span>
				<span class="emojis" data-emj="🙈">🙈</span>
				<span class="emojis" data-emj="🙉">🙉</span>
				<span class="emojis" data-emj="🙊">🙊</span>
				<span class="emojis" data-emj="🐥">🐥</span>
				<span class="emojis" data-emj="❤️">❤️</span>
				<span class="emojis" data-emj="🔞">🔞</span>
				<span class="emojis" data-emj="💯">💯</span>
				<span class="emojis" data-emj="🤑">🤑</span>
				<span class="emojis" data-emj="👹">👹</span>
				<span class="emojis" data-emj="🧠">🧠</span>
				<span class="emojis" data-emj="🎅">🎅</span>';
			endif;
			$emojis = get_field( 'add_new_emoji', 'option' );
			if ( $emojis ) :
				foreach ( $emojis as $emoji ) :
					$emo = $emoji['emoji'];
					$output .= '<span class="emojis" data-emj="' . esc_attr( $emo ) . '">' . esc_attr( $emo ) . '</span>';
				endforeach;
			endif;
			$output .= '</div>';
			echo $output;
			die();
		}
		add_action( 'wp_ajax_king_emoji', 'king_emoji' );
		add_action( 'wp_ajax_nopriv_king_emoji', 'king_emoji' );
	endif;
	if ( ! function_exists( 'king_vote' ) ) :
		/**
		 * Vote Function.
		 *
		 * @param <type> $post_id  The post identifier.
		 * @param <type> $format The format.
		 *
		 * @return string ( description_of_the_return_value )
		 */
		function king_vote( $post_id, $format = null, $down = false ) {
			$nonce   = wp_create_nonce( 'king_vote_nonce' );
			$user_id = get_current_user_id();
			if ( 'c' === $format ) {
				$like    = get_comment_meta( $post_id, 'king_vote_likes' );
				$dislike = get_comment_meta( $post_id, 'king_vote_dislikes' );
				$lcount  = get_comment_meta( $post_id, 'king_like_count', true );
				$dcount  = get_comment_meta( $post_id, 'king_dislike_count', true );
			} elseif ( 'p' === $format ) {
				$like    = get_post_meta( $post_id, 'king_vote_likes' );
				$dislike = get_post_meta( $post_id, 'king_vote_dislikes' );
				$lcount  = get_post_meta( $post_id, 'king_like_count', true );
				$dcount  = get_post_meta( $post_id, 'king_dislike_count', true );
			}
			$voted   = '';
			$active  = '';
			$active2 = '';
			if ( is_array( $like['0'] ) && in_array( $user_id, $like['0'] ) ) {
				$voted  = ' voted';
				$active = ' active';
			} elseif ( is_array( $dislike['0'] ) && in_array( $user_id, $dislike['0'] ) ) {
				$voted   = ' voted';
				$active2 = ' active';
			}
			if ( !is_user_logged_in() ) {
				$nlog = ' data-target="#myModal" data-toggle="modal"';
			} else {
				$nlog = '';
			}
			$iconup   = get_field( 'up_vote_custom_icon', 'options' ) ? get_field( 'up_vote_custom_icon', 'options' ) : '<i class="fas fa-chevron-up"></i>';
			$icondown = get_field( 'down_vote_custom_icon', 'options' ) ? get_field( 'down_vote_custom_icon', 'options' ) : '<i class="fas fa-chevron-down"></i>';
			$count    = king_vote_count( $post_id, $format );

			$output  = '<div class="king-vote' . esc_attr( $voted ) . '" data-id="' . esc_attr( $post_id ) . '" data-nonce="' . esc_attr( $nonce ) . '" data-number="' . esc_attr( $count['number'] ) . '" data-format="' . esc_attr( $format ) . '">';
			$output .= '<span class="king-vote-icon king-vote-like' . esc_attr( $active ) . '" data-action="like" ' . wp_kses_post( $nlog ) . '>' . wp_kses_post( $iconup ) . '</span>';
			$output .= '<span class="king-vote-count">' . esc_attr( $count['sl'] ) . '</span>';
			if ( false === $down ) {
				$output .= '<span class="king-vote-icon king-vote-dislike' . esc_attr( $active2 ) . '" data-action="dislike" ' . wp_kses_post( $nlog ) . '>' . wp_kses_post( $icondown ) . '</span>';
			}
			$output .= '</div>';
			return $output;
		}
	endif;
	if ( ! function_exists( 'king_vote_ajax' ) ) :
		/**
		 * Vote Ajax Calls.
		 */
		function king_vote_ajax() {
			$user_id          = get_current_user_id();
			$post_id          = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
			$type             = sanitize_text_field( wp_unslash( $_POST['type'] ) );
			$format           = sanitize_text_field( wp_unslash( $_POST['format'] ) );
			$nonce            = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			$response['done'] = false;
			if ( ! wp_verify_nonce( $nonce, 'king_vote_nonce' ) ) {
				die( '-1' );
			} elseif ( ! is_user_logged_in() ) {
				die( '-1' );
			} elseif ( empty( $post_id ) ) {
				die( '-1' );
			}
			if ( 'c' === $format ) {
				$like    = get_comment_meta( $post_id, 'king_vote_likes' );
				$dislike = get_comment_meta( $post_id, 'king_vote_dislikes' );
			} elseif ( 'p' === $format ) {
				$like    = get_post_meta( $post_id, 'king_vote_likes' );
				$dislike = get_post_meta( $post_id, 'king_vote_dislikes' );
			}

			if ( 'like' === $type ) {
				$likes    = $like;
				$cantlike = $dislike[0];
			} elseif ( 'dislike' === $type ) {
				$likes    = $dislike;
				$cantlike = $like[0];
			}
			$likess = $likes[0];
			if ( is_array( $likess ) && in_array( $user_id, $likess ) ) {
				$likes = check_array( $user_id, $likes );
				if ( $likes ) {
					$uid_key = array_search( $user_id, $likes );
					unset( $likes[ $uid_key ] );
					if ( 'c' === $format ) {
						if ( 'like' === $type ) {
							update_comment_meta( $post_id, 'king_vote_likes', $likes );
							$count = get_comment_meta( $post_id, 'king_like_count', true );
							$total = (int) $count - 1;
							update_comment_meta( $post_id, 'king_like_count', $total );
						} elseif ( 'dislike' === $type ) {
							update_comment_meta( $post_id, 'king_vote_dislikes', $likes );
							$count = get_comment_meta( $post_id, 'king_dislike_count', true );
							$total = (int) $count - 1;
							update_comment_meta( $post_id, 'king_dislike_count', $total );
						}
					} elseif ( 'p' === $format ) {
						if ( 'like' === $type ) {
							update_post_meta( $post_id, 'king_vote_likes', $likes );
							$count = get_post_meta( $post_id, 'king_like_count', true );
							$total = (int) $count - 1;
							update_post_meta( $post_id, 'king_like_count', $total );
						} elseif ( 'dislike' === $type ) {
							update_post_meta( $post_id, 'king_vote_dislikes', $likes );
							$count = get_post_meta( $post_id, 'king_dislike_count', true );
							$total = (int) $count - 1;
							update_post_meta( $post_id, 'king_dislike_count', $total );
						}
					}

					$response['status'] = 'unvoted';
					$response['done']   = true;
				}
			} elseif ( ! in_array( $user_id, $cantlike ) ) {
				$likes = check_array( $user_id, $likes );
				if ( 'c' === $format ) {
					if ( 'like' === $type ) {
						update_comment_meta( $post_id, 'king_vote_likes', $likes );
						$count = get_comment_meta( $post_id, 'king_like_count', true );
						$total = (int) $count + 1;
						update_comment_meta( $post_id, 'king_like_count', $total );
						if ( get_field( 'enable_notification', 'options' ) ) {
							king_create_notify( $post_id, 'clike', 'c' );
						}
					} elseif ( 'dislike' === $type ) {
						update_comment_meta( $post_id, 'king_vote_dislikes', $likes );
						$count = get_comment_meta( $post_id, 'king_dislike_count', true );
						$total = (int) $count + 1;
						update_comment_meta( $post_id, 'king_dislike_count', $total );
						if ( get_field( 'enable_notification', 'options' ) ) {
							king_create_notify( $post_id, 'cdislike', 'c' );
						}
					}
				} elseif ( 'p' === $format ) {
					if ( 'like' === $type ) {
						update_post_meta( $post_id, 'king_vote_likes', $likes );
						$count = get_post_meta( $post_id, 'king_like_count', true );
						$total = (int) $count + 1;
						update_post_meta( $post_id, 'king_like_count', $total );
						if ( get_field( 'enable_notification', 'options' ) ) {
								king_create_notify( $post_id, 'like' );
						}
					} elseif ( 'dislike' === $type ) {
						update_post_meta( $post_id, 'king_vote_dislikes', $likes );
						$count = get_post_meta( $post_id, 'king_dislike_count', true );
						$total = (int) $count + 1;
						update_post_meta( $post_id, 'king_dislike_count', $total );
						if ( get_field( 'enable_notification', 'options' ) ) {
							king_create_notify( $post_id, 'dislike' );
						}
					}
				}
				$response['status'] = 'voted';
				$response['done']   = true;
			}
			wp_send_json( $response );
			die();
		}
		add_action( 'wp_ajax_nopriv_king_vote_ajax', 'king_vote_ajax' );
		add_action( 'wp_ajax_king_vote_ajax', 'king_vote_ajax' );
	endif;

	if ( ! function_exists( 'king_poll_answer' ) ) :
		/**
		 * Comment submit ajax.
		 */
		function king_poll_answer() {
			if ( is_user_logged_in() ) {
				$user_id = get_current_user_id();
			} else {
				$user_id = king_get_the_user_ip();
			}
			$post_id = sanitize_text_field( wp_unslash( $_POST['postid'] ) );
			$nonce   = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			$parent  = sanitize_text_field( wp_unslash( $_POST['parent'] ) );
			$child   = sanitize_text_field( wp_unslash( $_POST['child'] ) );
			if ( ! wp_verify_nonce( $nonce, 'king_poll_nonce' ) ) {
				die( '-1' );
			} elseif ( empty( $user_id ) ) {
				die( '-1' );
			} elseif ( empty( $post_id ) ) {
				die( '-1' );
			}

			$value = get_post_meta( $post_id, 'king_poll_' . ( $parent - 1 ) . '_poll_results', true );
			if ( count( $value ) !== 0 ) {
				$king_results = maybe_unserialize( $value );
			}
			if ( ! is_array( $king_results ) ) {
				$king_results = array();
			}
			if ( ! array_key_exists( $user_id, $king_results ) ) {
				$king_results[ $user_id ] = $child;
				$king_result              = maybe_serialize( $king_results );
				update_sub_field( array( 'king_poll', $parent, 'poll_results' ), $king_result, $post_id );
				wp_send_json_success();
				die();
			} else {
				wp_send_json_error();
				die();
			}
		}
		add_action( 'wp_ajax_king_poll_answer', 'king_poll_answer' );
		add_action( 'wp_ajax_nopriv_king_poll_answer', 'king_poll_answer' );
	endif;

	if ( ! function_exists( 'king_quiz_answer' ) ) :
		/**
		 * Comment submit ajax.
		 */
		function king_quiz_answer() {

			$post_id = sanitize_text_field( wp_unslash( $_POST['postid'] ) );
			$nonce   = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			$total   = sanitize_text_field( wp_unslash( $_POST['total'] ) );
			$correct = sanitize_text_field( wp_unslash( $_POST['correct'] ) );
			$rate    = round( 100 * $correct / $total );
			$rotate  = round( ( $correct * 100 ) / ( $total ) );
			$title   = get_the_title( $post_id ) . ' - ' . sprintf( __( 'I got %1$d out of %2$d right! Do you wanna try ?', 'king' ), absint( $correct ), absint( $total ) );
			$output  = '';
			if ( have_rows( 'quiz_results', $post_id ) ) :
				while ( have_rows( 'quiz_results', $post_id ) ) :
					the_row();
					$rdesc  = get_sub_field( 'quiz_result_description' );
					$rimage = get_sub_field( 'quiz_result_image' );
					$rtitle = get_sub_field( 'quiz_result' );
					$high   = get_sub_field( 'result_range_high' );
					$low    = get_sub_field( 'result_range_low' );
					if ( $rate >= $low && $rate <= $high ) :
						$output .= '<div class="quiz-result">';

						$output .= '<div class="result-circle">
							<svg class="circle" viewbox="0 0 40 40">
								<circle class="circle-back" fill="none" cx="20" cy="20" r="15.9"/>
								<circle class="circle-chart" stroke-dasharray="' . esc_attr( $rotate ) . ',100" stroke-linecap="round" fill="none" cx="20" cy="20" r="15.9"/>
							</svg>
							<div class="result-circle-in">' . esc_attr( $correct . ' / ' . $total ) . '</div>
						</div>';

						$output .= '<h3>' . $rtitle . '</h3>';
						if ( $rimage ) :
							$output .= '<img src="' . esc_url( $rimage['sizes']['medium_large'] ) . '" alt="' . esc_attr( $rimage['alt'] ) . '" />';
						endif;
						$output .= '<span class="qresult-desc">' . $rdesc . '</span>';
						$output .= '<div class="quiz-share">';
						$output .= '<h5>' . esc_html__( 'Share Your Result :', 'king' ) . '</h5>';
						$output .= '<span class="qresult-share">' . king_ft_share( $post_id, $title ) . '</span>';
						$output .= '</div>';
						$output .= '</div>';
						break;
					endif;
				endwhile;
			endif;
			$ext['cont'] = $output;
			$ext['rate'] = $rotate;

			echo wp_send_json( $ext );
			die();
		}
		add_action( 'wp_ajax_king_quiz_answer', 'king_quiz_answer' );
		add_action( 'wp_ajax_nopriv_king_quiz_answer', 'king_quiz_answer' );
	endif;




	if ( ! function_exists( 'king_get_fb_access_token' ) ) :
		/**
		 * Facebook access token.
		 *
		 * @return     string  ( description_of_the_return_value )
		 */
		function king_get_fb_access_token() {
			$apsc_id       = get_field( 'facebook_share_app_id', 'option' );
			$apsc_secret   = get_field( 'facebook_share_secret_key', 'option' );
			$api_url       = 'https://graph.facebook.com/';
			$url           = sprintf(
				'%soauth/access_token?client_id=%s&client_secret=%s&grant_type=client_credentials',
				$api_url,
				$apsc_id,
				$apsc_secret
			);
			$access        = wp_remote_get( $url, array( 'timeout' => 60 ) );
			$access_body   = wp_remote_retrieve_body( $access );
			$access_result = json_decode( $access_body );
			if ( is_wp_error( $access_result ) || ( ! isset( $access_result->access_token ) ) ) {
				return '';
			} else {
				update_field( 'field_5945ad8eec21b', $access_result->access_token, 'option' );
			}
		}
		add_action( 'acf/save_post', 'king_get_fb_access_token' );
	endif;

	if ( ! function_exists( 'king_flag_button' ) ) :
		/**
		 * Flag button.
		 *
		 * @param <type> $post_id  The post identifier.
		 * @param <type> $ptype    The ptype.
		 *
		 * @return     string  ( description_of_the_return_value )
		 */
		function king_flag_button( $post_id, $ptype ) {
			$nonce   = wp_create_nonce( 'king_flag_nonce' );
			$user_id = get_current_user_id();
			if ( 'p' === $ptype ) {
				$flag = get_post_meta( $post_id, 'king_flags' );
			} else {
				$flag = get_comment_meta( $post_id, 'king_flags' );
			}
			$ftitle = __( 'Flag', 'king' );
			if ( is_array( $flag['0'] ) && is_super_admin() ) {
				$flaged = ' flagged';
				$fdism  = '1';
				$ftitle = __( 'Dismiss Flags', 'king' );
			} elseif ( is_array( $flag['0'] ) && in_array( $user_id, $flag['0'] ) ) {
				$flaged = ' flagged';
				$ftitle = __( 'Unflag', 'king' );
				$fdism  = '0';
			} else {
				$flaged = '';
				$fdism  = '0';
			}
			if ( is_user_logged_in() ) {
				$output  = '<div class="king-flag' . esc_attr( $flaged ) . '" data-id="' . esc_attr( $post_id ) . '" data-type="' . esc_attr( $ptype ) . '" data-nonce="' . esc_attr( $nonce ) . '" data-toggle="tooltip" data-placement="bottom" title="' . esc_attr( $ftitle ) . '" data-ds="' . esc_attr( $fdism ) . '"><i class="far fa-flag"></i></div>';
			} else {
				$output = '<div class="king-flag" data-toggle="dropdown" data-target=".king-alert-like" aria-expanded="false" role="link"><i class="far fa-flag"></i></div>';
			}
			return $output;
		}
	endif;
	if ( ! function_exists( 'king_flag_ajax' ) ) :
		/**
		 * Vote Ajax Calls.
		 */
		function king_flag_ajax() {
			$user_id = get_current_user_id();
			$post_id = sanitize_text_field( wp_unslash( $_POST['id'] ) );
			$ptype   = sanitize_text_field( wp_unslash( $_POST['ty'] ) );
			$nonce   = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			$fdis    = sanitize_text_field( wp_unslash( $_POST['ds'] ) );
			if ( ! wp_verify_nonce( $nonce, 'king_flag_nonce' ) ) {
				die( '-1' );
			} elseif ( ! is_user_logged_in() ) {
				die( '-1' );
			} elseif ( empty( $post_id ) ) {
				die( '-1' );
			}
			if ( 'p' === $ptype ) {
				$like = get_post_meta( $post_id, 'king_flags' );
			} else {
				$like = get_comment_meta( $post_id, 'king_flags' );
			}
			$likess = $like[0];
			$likes  = check_array( $user_id, $like );
			$count  = get_option( 'king_flag_count' );
			if ( $fdis == 1 ) {
				if ( 'p' === $ptype ) {
					delete_post_meta( $post_id, 'king_flags' );
				} else {
					delete_comment_meta( $post_id, 'king_flags' );
				}
			} else {
				if ( is_array( $likess ) && in_array( $user_id, $likess, true ) ) {
					if ( $likes ) {
						$uid_key = array_search( $user_id, $likes, true );
						unset( $likes[ $uid_key ] );
						if ( 0 === count( $likes ) ) {
							if ( 'p' === $ptype ) {
								delete_post_meta( $post_id, 'king_flags' );
							} else {
								delete_comment_meta( $post_id, 'king_flags' );
							}
						} else {
							if ( 'p' === $ptype ) {
								update_post_meta( $post_id, 'king_flags', $likes );
							} else {
								update_comment_meta( $post_id, 'king_flags', $likes );
							}
						}
						$nototal = (int) $count - 1;
						update_option( 'king_flag_count', $nototal );
					}
				} else {
					if ( get_field( 'hide_posts_flag', 'options' ) ) {
						$amount = get_field( 'hide_after_this_amount', 'options' );
						if ( 'p' === $ptype ) {
							update_post_meta( $post_id, 'king_flags', $likes );
							if ( $amount == count( $likess ) ) {
								wp_update_post( array( 'ID' => $post_id, 'post_status' => 'pending' ) );
							}
						} else {
							update_comment_meta( $post_id, 'king_flags', $likes );
							if ( $amount == count( $likess ) ) {
								wp_set_comment_status( $post_id, 'hold' );
							}
						}
					} else {
						if ( 'p' === $ptype ) {
							update_post_meta( $post_id, 'king_flags', $likes );
						} else {
							update_comment_meta( $post_id, 'king_flags', $likes );
						}
					}
					if ( empty( $count ) || '' === $count ) {
						$count = 0;
					}
					$nototal = (int) $count + 1;
					update_option( 'king_flag_count', $nototal );
					echo '1';
				}
			}
			die();
		}
		add_action( 'wp_ajax_nopriv_king_flag_ajax', 'king_flag_ajax' );
		add_action( 'wp_ajax_king_flag_ajax', 'king_flag_ajax' );
	endif;
	if ( ! function_exists( 'king_show_flag' ) ) :
		/**
		 * Show flagged posts with ajax.
		 */
		function king_show_flag() {

			$flags     = get_posts( array( 'meta_key' => 'king_flags', 'post_type' => king_post_types(), 'post_status'    => array( 'pending', 'publish' ), ) );
			$fcomments = get_comments( array( 'meta_key' => 'king_flags' ) );
			$ftext     = '';
			if ( $flags || $fcomments ) {
				if ( $flags ) {
					foreach ( $flags as $flag ) {
						$gflag = get_post_meta( $flag->ID, 'king_flags' );
						$ftext .= '<li><i class="far fa-flag"></i>' . king_who_flagged( $gflag ) . '' . esc_html__( ' flagged post  ', 'king' ) . ' <a href="' . get_permalink( $flag->ID ) . '" >' . esc_attr( get_the_title( $flag->ID ) ) . '</a></li>';
					}
				}
				if ( $fcomments ) {
					foreach ( $fcomments as $fcomment ) {
						$gflag = get_comment_meta( $fcomment->comment_ID, 'king_flags' );
						$ftext .= '<li><i class="far fa-flag"></i>' . king_who_flagged( $gflag ) . '' . esc_html__( 'flagged comment ', 'king' ) . ' <a href="' . get_comment_link( $fcomment->comment_ID ) . '" >' . esc_html__( 'comment#', 'king' ) . esc_attr( $fcomment->comment_ID ) . '</a></li>';
					}
				}
			} else {
				$ftext .= '<li class="king-clean-center"><i class="fas fa-battery-empty"></i><br>' . esc_html__( 'Nothing new right now !', 'king' ) . '</li>';
			}
			delete_option( 'king_flag_count' );
			echo $ftext;
			die();
		}
		add_action( 'wp_ajax_nopriv_king_show_flag', 'king_show_flag' );
		add_action( 'wp_ajax_king_show_flag', 'king_show_flag' );
	endif;
	if ( ! function_exists( 'king_who_flagged' ) ) :
		/**
		 * Who flagged function.
		 *
		 * @param <type> $flags The flags.
		 *
		 * @return string ( description_of_the_return_value )
		 */
		function king_who_flagged( $flags ) {
			$ftitle = '';
			foreach ( $flags['0'] as $flag ) {
				$ftitle .= '<a href="' . esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . get_user_by( 'id', $flag )->user_login ) . '">' . get_user_by( 'id', $flag )->user_login . '</a>, ';
			}
			return $ftitle;
		}
	endif;
	if ( ! function_exists( 'king_homepage_login' ) && get_field( 'enable_homepage_login', 'options' ) ) :
		/**
		 * Login as homepage.
		 */
		function king_homepage_login() {
			if ( ! get_query_var( 'bplogin' ) && ! get_query_var( 'bpregister' ) && ! get_query_var( 'bpreset' ) && ! is_user_logged_in() ) {
				wp_safe_redirect(  site_url() . '/' . $GLOBALS['king_login']  ); 
			}
		}
		add_action( 'template_redirect', 'king_homepage_login' );
	endif;
	if ( ! function_exists( 'king_social_share' ) ) :
		/**
		 * King highlist story function.
		 */
		function king_highlights() {
			if ( ! is_user_logged_in() ) {
				die( '-1' );
			}
			$postid = ( isset( $_POST['to_book'] ) && is_numeric( $_POST['to_book'] ) ) ? $_POST['to_book'] : '';
			if ( empty( $postid ) ) {
				die( '-1' );
			}
			if ( metadata_exists( 'post', $postid, 'king_highlights' ) ) {
				delete_post_meta( $postid, 'king_highlights' );
			} else {
				update_post_meta( $postid, 'king_highlights', true );
				echo '1';
			}
			die();
		}
		add_action( 'wp_ajax_nopriv_king_highlights', 'king_highlights' );
		add_action( 'wp_ajax_king_highlights', 'king_highlights' );
	endif;
endif;
	if ( ! function_exists( 'king_social_share' ) ) :
		/**
		 * Social Share buttons.
		 */
		function king_social_share() {
			?>
			<div class="share-buttons">
				<?php echo king_ft_share( get_the_ID() , rawurlencode( html_entity_decode( get_the_title( get_the_ID() ), ENT_COMPAT, 'UTF-8' ) )); ?>
				<?php if ( get_field( 'display_pinterest_share_button', 'options' ) ) : ?>      
					<a class="social-icon share-pin" href="#" title="<?php esc_html_e( 'Pin this', 'king' ); ?>" rel="nofollow" target="_blank" onclick="window.open('//pinterest.com/pin/create/button/?url=<?php echo rawurlencode( get_permalink( get_the_ID() ) ); ?>&amp;media=<?php echo rawurlencode( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ); ?>&amp;description=<?php echo rawurlencode( html_entity_decode( get_the_title( get_the_ID() ), ENT_COMPAT, 'UTF-8' ) ); ?>','pin-share-dialog','width=626,height=436');return false;"><i class="fab fa-pinterest-square"></i></a>
				<?php endif; ?>
				<a class="social-icon share-em" href="mailto:?subject=<?php echo rawurlencode( html_entity_decode( get_the_title( get_the_ID() ), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;body=<?php echo rawurlencode( get_permalink( get_the_ID() ) ); ?>" title="<?php esc_html_e( 'Email this', 'king' ); ?>"><i class="fas fa-envelope"></i></a>
				<?php if ( get_field( 'display_thumblr_share_button', 'option' ) ) : ?>
					<a class="social-icon share-tb" href="#" title="<?php esc_html_e( 'Share on Tumblr', 'king' ); ?>" rel="nofollow" target="_blank" onclick="window.open( 'http://www.tumblr.com/share/link?url=<?php echo rawurlencode( get_permalink( get_the_ID() ) ); ?>&amp;name=<?php echo rawurlencode( html_entity_decode( get_the_title( get_the_ID() ), ENT_COMPAT, 'UTF-8' ) ); ?>','tumblr-share-dialog','width=626,height=436' );return false;"><i class="fab fa-tumblr-square"></i></a>
				<?php endif; ?>    
				<?php if ( get_field( 'display_linkedin_share_button', 'options' ) ) : ?>    
					<a class="social-icon share-link" href="#" title="<?php esc_html_e( 'Share on LinkedIn', 'king' ); ?>" rel="nofollow" target="_blank" onclick="window.open( 'http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo rawurlencode( get_permalink( get_the_ID() ) ); ?>&amp;title=<?php echo rawurlencode( html_entity_decode( get_the_title( get_the_ID() ), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;source=<?php echo rawurlencode( get_bloginfo( 'name' ) ); ?>','linkedin-share-dialog','width=626,height=436');return false;"><i class="fab fa-linkedin"></i></a>
				<?php endif; ?>      

				<?php if ( get_field( 'display_vk_share_button', 'options' ) ) : ?>    
					<a class="social-icon share-vk" href="#" title="<?php esc_html_e( 'Share on Vk', 'king' ); ?>" rel="nofollow" target="_blank" onclick="window.open('http://vkontakte.ru/share.php?url=<?php echo rawurlencode( get_permalink( get_the_ID() ) ); ?>','vk-share-dialog','width=626,height=436');return false;"><i class="fab fa-vk"></i></a> 
				<?php endif; ?>  
				<?php if ( get_field( 'display_wapp_share_button', 'options' ) ) : ?> 
					<a class="social-icon share-wapp" href="whatsapp://send?text=<?php echo rawurlencode( get_permalink( get_the_ID() ) ); ?>" data-action="share/whatsapp/share" title="<?php esc_html_e( 'Share on whatsapp', 'king' ); ?>"><i class="fab fa-whatsapp"></i></a>
				<?php endif; ?>
				<?php if ( is_single() ) : ?>
					<input type="text" id="modal-url" value="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
					<span class="copied" style="display: none;"><?php esc_html_e( 'Link Copied', 'king' ); ?></span>
				<?php endif; ?>
			</div>
			<?php
		}
	endif;
	if ( ! function_exists( 'king_ft_share' ) ) :
		function king_ft_share( $post_id, $text ) {
			$output = '<a class="post-share share-fb" href="#" title="' . esc_html__( 'Share on Facebook', 'king' ) . '" onclick="window.open(\'https://www.facebook.com/sharer/sharer.php?u=' .  rawurlencode( get_permalink( $post_id ) ) . '&quote=' . $text . '\',\'facebook-share-dialog\',\'width=626,height=436\');return false;" target="_blank" rel="nofollow"><i class="fab fa-facebook-square"></i></i></a>';
			$output .= '<a class="social-icon share-tw" href="#" onclick="window.open(\'http://twitter.com/share?text=' . $text . '&amp;url=' . rawurlencode( get_permalink( $post_id ) ) . '\',\'twitter-share-dialog\',\'width=626,height=436\');return false;" title="' . esc_html__( 'Share on Twitter', 'king' ) . '" rel="nofollow" target="_blank"><i class="fab fa-twitter"></i></a>';
			return $output;
		}
	endif;
	if ( ! function_exists( 'king_facebook_share' ) ) :
		/**
		 *  Facebook Share counter.
		 *
		 * @param <type> $post_id  The post identifier
		 *
		 * @return integer ( description_of_the_return_value )
		 */
		function king_facebook_share( $post_id ) {
			$url          = get_permalink( $post_id );
			$access_token = get_field( 'facebook_access_token', 'option' );
			$api_url      = 'https://graph.facebook.com/v3.2/?id=' . $url . '&fields=engagement&access_token=' . $access_token . '';
			$connection   = wp_remote_get( $api_url, array( 'timeout' => 60 ) );
			if ( is_wp_error( $connection ) || ( isset( $connection['response']['code'] ) && 200 !== $connection['response']['code'] ) ) {
				$total = 0;
			} else {
				$_data = json_decode( $connection['body'], true );

				if ( isset( $_data['engagement']['share_count'] ) ) {
					$count = intval( $_data['engagement']['share_count'] );

					$total = $count;
				} else {
					$total        = 0;
					$fb_graph_url = 'https://graph.facebook.com/?id=' . rawurlencode( $url ) . '&scrape=true';
					$result       = wp_remote_post( $fb_graph_url );
				}
			}
			return $total;
		}
	endif;
if ( ! function_exists( 'king_social_shares' ) ) :
	/**
	 * Calculate total share count.
	 *
	 * @param <type> $post_id The post identifier.
	 */
	function king_social_shares( $post_id ) {
		$fb           = king_facebook_share( $post_id );
		$totalcounts  = $fb;
		$sharecounter = get_post_meta( $post_id, 'share_counter', true );
		if ( $totalcounts !== $sharecounter  ) {
			update_post_meta( $post_id, 'share_counter', $totalcounts );
		}
	}
endif;
if ( ! function_exists( 'king_vote_count' ) ) :
	/**
	 * Count Votes.
	 *
	 * @param <type> $post_id The post identifier.
	 * @param <type> $format The format.
	 *
	 * @return <type> ( description_of_the_return_value )
	 */
	function king_vote_count( $post_id, $format ) {
		if ( 'c' === $format ) {
			$lcount = get_comment_meta( $post_id, 'king_like_count', true );
			$dcount = get_comment_meta( $post_id, 'king_dislike_count', true );
		} elseif ( 'p' === $format ) {
			$lcount = get_post_meta( $post_id, 'king_like_count', true );
			$dcount = get_post_meta( $post_id, 'king_dislike_count', true );
		}
		$count['number'] = (int) $lcount - (int) $dcount;
		$count['sl']     = king_sl_format_count( $count['number'] );
		return $count;
	}
endif;
if ( ! function_exists( 'king_get_the_user_ip' ) ) :
	/**
	 * Gets the user ip.
	 *
	 * @return     <type>  The user ip.
	 */
	function king_get_the_user_ip() {
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CLIENT_IP'] ) );
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
		} else {
			$ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
		}
		return ip2long( apply_filters( 'wpb_get_ip', $ip ) );
	}
endif;
if ( ! function_exists( 'king_post_format' ) ) :
	/**
	 * Get post format or type.
	 */
	function king_post_format() {
		$return = '<div class="king-post-format">';
		if ( has_post_format( 'quote' ) ) :
			$return .= '<a href="' . esc_url( get_post_format_link( 'quote' ) ) . '" class="pformat-news nav-news">' . esc_html__( 'News', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( has_post_format( 'video' ) ) :
			$return .= '<a href="' . esc_url( get_post_format_link( 'video' ) ) . '" class="pformat-video nav-video">' . esc_html__( 'Video', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( has_post_format( 'image' ) ) :
			$return .= '<a href="' . esc_url( get_post_format_link( 'image' ) ) . '" class="pformat-image nav-image">' . esc_html__( 'Image', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( has_post_format( 'audio' ) ) :
			$return .= '<a href="' . esc_url( get_post_format_link( 'audio' ) ) . '" class="pformat-music nav-music">' . esc_html__( 'music', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( 'arlem' === get_post_type() ) : //KB CHANGES TODO FOLLOW UP pformat-image nav-image
			$return .= '<a href="' . esc_url( get_post_format_link( 'arlem' ) ) . '" class="pformat-arlem nav-arlem">' . esc_html__( 'ARLEM', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( 'list' === get_post_type() ) :
			$return .= '<a href="' . esc_url( get_post_type_archive_link( 'list' ) ) . '" class="pformat-list nav-list">' . esc_html__( 'List', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( 'poll' === get_post_type() ) :
			$return .= '<a href="' . esc_url( get_post_type_archive_link( 'poll' ) ) . '" class="pformat-poll nav-poll">' . esc_html__( 'Poll', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( 'trivia' === get_post_type() ) :
			$return .= '<a href="' . esc_url( get_post_type_archive_link( 'trivia' ) ) . '" class="pformat-trivia nav-trivia">' . esc_html__( 'Trivia Quiz', 'king' ) . '<i class="far fa-circle"></i></a>';
		endif;
		$return .= '</div>';
		return $return;
	}
endif;

if ( ! function_exists( 'king_num_perc' ) ) :
	/**
	 * get number percent
	 *
	 * @param      <type>  $less   The less
	 * @param      <type>  $full   The full
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function king_num_perc( $less, $full ) {
		$return = round( $less * 100 / $full, 2 ) . '%';
		return $return;
	}
endif;