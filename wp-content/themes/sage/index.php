<section>
<?php $my_query = new WP_Query( 'post_type=post&posts_per_page=1' );
			while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
			<div class="col-sm-12">
			<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>
			<div class="featured-post overlay-black" style="background-image: url(<?=$url?>);">				
			<div class="text truncate">
			<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>	
			</div>				
			<?php get_template_part('templates/entry-meta'); ?>
			<a href="<?php the_permalink() ?>" class="link"></a>
			</div>
			</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>

</section>
<section class="section-padding">

<div class="container">
	<div class="row">
		<div class="col-sm-3">
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
wp_reset_postdata(); ?>
		</div>
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-12 col-md-6">


<h4>Category Title</h4>
<ul>
<?php
$do_not_duplicate = array();
// The Query
$args1 = array(
'post_type'         => 'post',
'category_name'     => 'opengov',
'order'             => 'desc',
'post_status'       => 'publish',
'posts_per_page'    => 1,
);
$query1 = new WP_Query( $args1 );

// The Loop
while ( $query1->have_posts() ) {
$query1->the_post();
$do_not_duplicate[] = get_the_ID(); ?>
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>

<li><h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4></li>

<?php
}

wp_reset_postdata();

/* The 2nd Query (without global var) */
$args2 = array(
'post_type'         => 'post',
'category_name'     => 'opengov',
'order'             => 'desc',
'post_status'       => 'publish',
'posts_per_page'    => 4,
'post__not_in' => $do_not_duplicate 
);
$query2 = new WP_Query( $args2 );

// The 2nd Loop
while ( $query2->have_posts() ) {
$query2->the_post(); ?>

<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>

<?php
}
wp_reset_postdata();

?>
<li><a href="#">View More</a></li>
</ul>


				</div>
				<div class="col-sm-12 col-md-6">

<h4>Category Title</h4>
<ul>
<?php
$do_not_duplicate = array();
// The Query
$args1 = array(
'post_type'         => 'post',
'category_name'     => 'opengov',
'order'             => 'desc',
'post_status'       => 'publish',
'posts_per_page'    => 1,
);
$query1 = new WP_Query( $args1 );

// The Loop
while ( $query1->have_posts() ) {
$query1->the_post();
$do_not_duplicate[] = get_the_ID(); ?>
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>

<li><h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4></li>

<?php
}

wp_reset_postdata();

/* The 2nd Query (without global var) */
$args2 = array(
'post_type'         => 'post',
'category_name'     => 'opengov',
'order'             => 'desc',
'post_status'       => 'publish',
'posts_per_page'    => 4,
'post__not_in' => $do_not_duplicate 
);
$query2 = new WP_Query( $args2 );

// The 2nd Loop
while ( $query2->have_posts() ) {
$query2->the_post(); ?>

<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>

<?php
}
wp_reset_postdata();

?>
<li><a href="#">View More</a></li>
</ul>

				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-6">

<h4>Category Title</h4>
<ul>
<?php
$do_not_duplicate = array();
// The Query
$args1 = array(
'post_type'         => 'post',
'category_name'     => 'opengov',
'order'             => 'desc',
'post_status'       => 'publish',
'posts_per_page'    => 1,
);
$query1 = new WP_Query( $args1 );

// The Loop
while ( $query1->have_posts() ) {
$query1->the_post();
$do_not_duplicate[] = get_the_ID(); ?>
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>

<li><h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4></li>

<?php
}

wp_reset_postdata();

/* The 2nd Query (without global var) */
$args2 = array(
'post_type'         => 'post',
'category_name'     => 'opengov',
'order'             => 'desc',
'post_status'       => 'publish',
'posts_per_page'    => 4,
'post__not_in' => $do_not_duplicate 
);
$query2 = new WP_Query( $args2 );

// The 2nd Loop
while ( $query2->have_posts() ) {
$query2->the_post(); ?>

<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>

<?php
}
wp_reset_postdata();

?>
<li><a href="#">View More</a></li>
</ul>

				</div>
				<div class="col-sm-12 col-md-6">

<h4>Category Title</h4>
<ul>
<?php
$do_not_duplicate = array();
// The Query
$args1 = array(
'post_type'         => 'post',
'category_name'     => 'opengov',
'order'             => 'desc',
'post_status'       => 'publish',
'posts_per_page'    => 1,
);
$query1 = new WP_Query( $args1 );

// The Loop
while ( $query1->have_posts() ) {
$query1->the_post();
$do_not_duplicate[] = get_the_ID(); ?>
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' ); $url = $thumb['0']; ?>

<li><h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4></li>

<?php
}

wp_reset_postdata();

/* The 2nd Query (without global var) */
$args2 = array(
'post_type'         => 'post',
'category_name'     => 'opengov',
'order'             => 'desc',
'post_status'       => 'publish',
'posts_per_page'    => 4,
'post__not_in' => $do_not_duplicate 
);
$query2 = new WP_Query( $args2 );

// The 2nd Loop
while ( $query2->have_posts() ) {
$query2->the_post(); ?>

<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>

<?php
}
wp_reset_postdata();

?>
<li><a href="#">View More</a></li>
</ul>


				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<p>Category Query</p>
				</div>
				<div class="col-sm-12 col-md-6">
					<p>Category Query</p>
				</div>
			</div>
		</div>
		<div class="col-sm-3 hidden-xs">



		
			<?php echo do_shortcode('[newsletter-sidebar]'); ?>
			
		</div>
	</div>
</div>
</section>




