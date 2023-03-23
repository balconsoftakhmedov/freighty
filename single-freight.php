<?php
/**
 * The Template for displaying all single posts.
 */

get_header();
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
		<article>
			<h1><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php $all_meta = get_post_meta( get_the_ID() ); ?>
			<?php if ( $all_meta ) : ?>
				<div class="post-meta">
					<h2>Post Meta</h2>
					<ul>
						<?php foreach ( $all_meta as $meta_key => $meta_value ) : ?>
							<li><strong><?php echo esc_html( $meta_key ); ?>:</strong> <?php echo esc_html( implode( ', ', $meta_value ) ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</article>

	<?php
	endwhile;
endif;
wp_reset_postdata();
get_footer();

