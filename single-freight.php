<?php

get_header();
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$all_meta        = get_post_meta( get_the_ID() );
		$freight_details = array(
				'length',
				'width',
				'height',
				'weight',
				'quantity'
		);
		$map_addresses   = array(
				'from_address' =>  esc_html( implode( ', ', $all_meta['from_address'] ) ),
				'to_address'   => esc_html( implode( ', ', $all_meta['to_address'] ) ),
		);
		?>

		<div class="bg-primary text-white py-4">
			<h2 class="text-center"><?php echo __( 'Freight Details', 'freighty' ); ?></h2>
		</div>

		<section class="container my-4">
			<h2 class="mb-4"><?php echo esc_html( implode( ', ', $all_meta['category_name'] ) ); ?>
				- <?php echo esc_html( implode( ', ', $all_meta['subcategory_name'] ) ); ?> - <?php the_title(); ?>
			</h2>
			<div class="row">
				<div class="col-md-4">
					<div class="card">
						<?php
						$image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
						if ( empty( $image_url ) ) :
							$image_url = get_template_directory_uri() . '/assets/images/placeholder-300x300.png';
						endif;
						?>
						<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo __( 'Freight Image', 'freighty' ); ?>" class="card-img-top">
					</div>
					<br />
						<h3 class=""><?php echo __( 'Freight Route', 'freighty' ); ?></h3>
					<div class="card google-map">

						<?php include_once 'templates/google_map.php'; ?>
					</div>

				</div>

				<div class="col-md-8">
					<div class="card-body">
						<div class="row mb-3">
							<h5><?php echo __( 'Description', 'freighty' ); ?>  </h5>
							<?php the_content(); ?>
						</div>
						<?php if ( $all_meta ) : ?>
							<?php foreach ( $all_meta as $meta_key => $meta_value ) :
								if ( in_array( $meta_key, $freight_details ) ) : ?>
									<div class="row mb-3">
										<div class="col-4"><h5><?php echo esc_html( $meta_key ); ?>: </h5></div>
										<div class="col-8"><?php echo esc_html( implode( ', ', $meta_value ) ); ?></div>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
	<?php
	endwhile;
endif;
wp_reset_postdata();
get_footer();
