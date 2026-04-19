<?php
/**
 * Comments template.
 *
 * @package BH_Starter
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			printf(
				esc_html( _n( '%d Comment', '%d Comments', $comment_count, 'bh-starter' ) ),
				intval( $comment_count )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'callback'    => 'bh_starter_comment',
				'avatar_size' => 48,
			) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="comment-navigation">
				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'bh-starter' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'bh-starter' ) ); ?></div>
			</nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(); ?>

</div>
