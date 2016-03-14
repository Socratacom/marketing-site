<?php
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' ); $url = $thumb['0'];
	$do_not_duplicate = array();

	// The Query
	$args1 = array(
	'post_type'         => 'post',
	'posts_per_page'    => 1,
	);
	$query1 = new WP_Query( $args1 );

	// The Loop
	while ( $query1->have_posts() ) {
	$query1->the_post();
	$do_not_duplicate[] = get_the_ID(); ?>

	<section class="feature-image blog-feature-image overlay-black" style="background-image: url(<?=$url?>);">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="text truncate">
						<div class="categories text-reverse"><?php Roots\Sage\Extras\blog_the_categories(); ?></div>
						<h2 class="text-reverse"><?php the_title(); ?></h2>
					</div>							
	            	<div class="meta text-reverse">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
					<div class="avatars">
						<?php  global $post;
		                $author_id=$post->post_author;
		                foreach( get_coauthors() as $coauthor ): ?>
		                <?php echo get_avatar( $coauthor->user_email, '50' ); ?>
		                <?php endforeach; ?>
	            	</div>
				</div>
			</div>
		</div>
		<a href="<?php the_permalink() ?>" class="link"></a>
	</section>

	<?php
	}

	wp_reset_postdata();
?>

<section>

<div class="container">
	<div class="row">
		<div class="col-sm-4 col-md-3 col-padding">
			<?php
			$args = array(
			'post_type'         => 'post',
			'order'             => 'desc',
			'posts_per_page'    => 10,
			'offset'			=> 1,
			'post_status'       => 'publish',
			);

			// The Query
			$the_query = new WP_Query( $args );

			// The Loop
			if ( $the_query->have_posts() ) {
			echo '<ul class="no-bullets sidebar-list">';
			echo '<li><h5>Recent Articles</h5></li>';
			while ( $the_query->have_posts() ) {
			$the_query->the_post(); { ?> 
			<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0'];?>
			<li>
			  <div class="article-img-container">
			    <img src="<?=$url?>" class="img-responsive">
			  </div>
			  <div class="article-title-container">
			    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a><br><small><?php the_time('F j, Y') ?></small>
			  </div>
			</li>
			<?php }
			}
			echo '</ul>';
			} else {
			// no posts found
			}
			/* Restore original Post Data */
			wp_reset_postdata();
			?>
		</div>


		<div class="col-sm-8 col-md-9 background-clouds col-padding">
			<div class="row">
				<div class="col-md-6">
					<ul class="margin-bottom-30 category-list">
						<li><a href="/digital-government-transformation/category/open-data-article/" class="btn background-green-sea">Open Data <i class="fa fa-arrow-circle-o-right"></i></a></li>
						<?php
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0'];
						// The Query
						$args1 = array(
						'post_type'         => 'post',
						'category_name'     => 'open-data-article',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 1,
						'post__not_in' => $do_not_duplicate 
						);
						$query1 = new WP_Query( $args1 );

						// The Loop
						while ( $query1->have_posts() ) {
						$query1->the_post();
						$do_not_duplicate[] = get_the_ID(); ?>
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>

						<li>
							<div class="thumb">
								<a href="<?php the_permalink() ?>"><img src="<?=$url?>" class="img-responsive"></a>
								<div class="avatars">
									<?php  global $post;
					                $author_id=$post->post_author;
					                foreach( get_coauthors() as $coauthor ): ?>
					                <?php echo get_avatar( $coauthor->user_email, '50' ); ?>
					                <?php endforeach; ?>
				            	</div>
							</div>
							<div class="padding-15">
								<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
								<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
							</div>
						</li>

						<?php
						}

						wp_reset_postdata();

						/* The 2nd Query (without global var) */
						$args2 = array(
						'post_type'         => 'post',
						'category_name'     => 'open-data-article',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 2,
						'post__not_in' => $do_not_duplicate 
						);
						$query2 = new WP_Query( $args2 );

						// The 2nd Loop
						while ( $query2->have_posts() ) {
						$query2->the_post(); ?>

						<li>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
							<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
						</li>

						<?php
						}
						wp_reset_postdata();
						?>
					</ul>
					<ul class="margin-bottom-30 category-list">
						<li><a href="/digital-government-transformation/category/effective-governing/" class="btn background-carrot">Effective Governing <i class="fa fa-arrow-circle-o-right"></i></a></li>
						<?php
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0'];
						// The Query
						$args1 = array(
						'post_type'         => 'post',
						'category_name'     => 'effective-governing',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 1,
						'post__not_in' => $do_not_duplicate 
						);
						$query1 = new WP_Query( $args1 );

						// The Loop
						while ( $query1->have_posts() ) {
						$query1->the_post();
						$do_not_duplicate[] = get_the_ID(); ?>
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>

						<li>
							<div class="thumb">
								<a href="<?php the_permalink() ?>"><img src="<?=$url?>" class="img-responsive"></a>
								<div class="avatars">
									<?php  global $post;
					                $author_id=$post->post_author;
					                foreach( get_coauthors() as $coauthor ): ?>
					                <?php echo get_avatar( $coauthor->user_email, '50' ); ?>
					                <?php endforeach; ?>
				            	</div>
							</div>							
							<div class="padding-15">
								<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
								<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
							</div>
						</li>

						<?php
						}

						wp_reset_postdata();

						/* The 2nd Query (without global var) */
						$args2 = array(
						'post_type'         => 'post',
						'category_name'     => 'effective-governing',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 2,
						'post__not_in' => $do_not_duplicate 
						);
						$query2 = new WP_Query( $args2 );

						// The 2nd Loop
						while ( $query2->have_posts() ) {
						$query2->the_post(); ?>

						<li>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
							<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
						</li>

						<?php
						}
						wp_reset_postdata();
						?>
					</ul>
					<ul class="margin-bottom-30 category-list">
						<li><a href="/digital-government-transformation/category/public-safety/" class="btn background-alizarin">Public Safety <i class="fa fa-arrow-circle-o-right"></i></a></li>
						<?php
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0'];
						// The Query
						$args1 = array(
						'post_type'         => 'post',
						'category_name'     => 'public-safety',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 1,
						'post__not_in' => $do_not_duplicate 
						);
						$query1 = new WP_Query( $args1 );

						// The Loop
						while ( $query1->have_posts() ) {
						$query1->the_post();
						$do_not_duplicate[] = get_the_ID(); ?>
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>

						<li>
							<div class="thumb">
								<a href="<?php the_permalink() ?>"><img src="<?=$url?>" class="img-responsive"></a>
								<div class="avatars">
									<?php  global $post;
					                $author_id=$post->post_author;
					                foreach( get_coauthors() as $coauthor ): ?>
					                <?php echo get_avatar( $coauthor->user_email, '50' ); ?>
					                <?php endforeach; ?>
				            	</div>
							</div>							
							<div class="padding-15">
								<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
								<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
							</div>
						</li>

						<?php
						}

						wp_reset_postdata();

						/* The 2nd Query (without global var) */
						$args2 = array(
						'post_type'         => 'post',
						'category_name'     => 'public-safety',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 2,
						'post__not_in' => $do_not_duplicate 
						);
						$query2 = new WP_Query( $args2 );

						// The 2nd Loop
						while ( $query2->have_posts() ) {
						$query2->the_post(); ?>

						<li>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
							<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
						</li>

						<?php
						}
						wp_reset_postdata();
						?>
					</ul>
				</div>
				<div class="col-md-6">
					<ul class="margin-bottom-30 category-list">
						<li><a href="/digital-government-transformation/category/public-finance/" class="btn background-belize-hole">Public Finance <i class="fa fa-arrow-circle-o-right"></i></a></li>
						<?php
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0'];
						// The Query
						$args1 = array(
						'post_type'         => 'post',
						'category_name'     => 'public-finance',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 1,
						'post__not_in' => $do_not_duplicate 
						);
						$query1 = new WP_Query( $args1 );

						// The Loop
						while ( $query1->have_posts() ) {
						$query1->the_post();
						$do_not_duplicate[] = get_the_ID(); ?>
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>

						<li>
							<div class="thumb">
								<a href="<?php the_permalink() ?>"><img src="<?=$url?>" class="img-responsive"></a>
								<div class="avatars">
									<?php  global $post;
					                $author_id=$post->post_author;
					                foreach( get_coauthors() as $coauthor ): ?>
					                <?php echo get_avatar( $coauthor->user_email, '50' ); ?>
					                <?php endforeach; ?>
				            	</div>
							</div>							
							<div class="padding-15">
								<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
								<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
							</div>
						</li>

						<?php
						}

						wp_reset_postdata();

						/* The 2nd Query (without global var) */
						$args2 = array(
						'post_type'         => 'post',
						'category_name'     => 'public-finance',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 2,
						'post__not_in' => $do_not_duplicate 
						);
						$query2 = new WP_Query( $args2 );

						// The 2nd Loop
						while ( $query2->have_posts() ) {
						$query2->the_post(); ?>

						<li>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
							<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
						</li>

						<?php
						}
						wp_reset_postdata();
						?>
					</ul>
					<ul class="margin-bottom-30 category-list">
						<li><a href="/digital-government-transformation/category/data-rockstars/" class="btn background-nephritis">Data Rockstars <i class="fa fa-arrow-circle-o-right"></i></a></li>
						<?php
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0'];
						// The Query
						$args1 = array(
						'post_type'         => 'post',
						'category_name'     => 'data-rockstars',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 1,
						'post__not_in' => $do_not_duplicate 
						);
						$query1 = new WP_Query( $args1 );

						// The Loop
						while ( $query1->have_posts() ) {
						$query1->the_post();
						$do_not_duplicate[] = get_the_ID(); ?>
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>

						<li>
							<div class="thumb">
								<a href="<?php the_permalink() ?>"><img src="<?=$url?>" class="img-responsive"></a>
								<div class="avatars">
									<?php  global $post;
					                $author_id=$post->post_author;
					                foreach( get_coauthors() as $coauthor ): ?>
					                <?php echo get_avatar( $coauthor->user_email, '50' ); ?>
					                <?php endforeach; ?>
				            	</div>
							</div>							
							<div class="padding-15">
								<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
								<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
							</div>
						</li>

						<?php
						}

						wp_reset_postdata();

						/* The 2nd Query (without global var) */
						$args2 = array(
						'post_type'         => 'post',
						'category_name'     => 'data-rockstars',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 2,
						'post__not_in' => $do_not_duplicate 
						);
						$query2 = new WP_Query( $args2 );

						// The 2nd Loop
						while ( $query2->have_posts() ) {
						$query2->the_post(); ?>

						<li>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
							<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
						</li>

						<?php
						}
						wp_reset_postdata();
						?>
					</ul>
					<ul class="margin-bottom-30 category-list">
						<li><a href="/digital-government-transformation/category/open-data-download/" class="btn background-wisteria">Open Data Download <i class="fa fa-arrow-circle-o-right"></i></a></li>
						<?php
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0'];
						// The Query
						$args1 = array(
						'post_type'         => 'post',
						'category_name'     => 'open-data-download',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 1,
						'post__not_in' => $do_not_duplicate 
						);
						$query1 = new WP_Query( $args1 );

						// The Loop
						while ( $query1->have_posts() ) {
						$query1->the_post();
						$do_not_duplicate[] = get_the_ID(); ?>
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>

						<li>
							<div class="thumb">
								<a href="<?php the_permalink() ?>"><img src="<?=$url?>" class="img-responsive"></a>
								<div class="avatars">
									<?php  global $post;
					                $author_id=$post->post_author;
					                foreach( get_coauthors() as $coauthor ): ?>
					                <?php echo get_avatar( $coauthor->user_email, '50' ); ?>
					                <?php endforeach; ?>
				            	</div>
							</div>							
							<div class="padding-15">
								<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
								<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
							</div>
						</li>

						<?php
						}

						wp_reset_postdata();

						/* The 2nd Query (without global var) */
						$args2 = array(
						'post_type'         => 'post',
						'category_name'     => 'open-data-download',
						'order'             => 'desc',
						'post_status'       => 'publish',
						'posts_per_page'    => 2,
						'post__not_in' => $do_not_duplicate 
						);
						$query2 = new WP_Query( $args2 );

						// The 2nd Loop
						while ( $query2->have_posts() ) {
						$query2->the_post(); ?>

						<li>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
							<div class="meta">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?></div>
						</li>

						<?php
						}
						wp_reset_postdata();
						?>
					</ul>
				</div>
			</div><!-- End Nested Row -->
		</div>
	</div><!-- End Row -->
</div><!-- End Continer -->
</section>




