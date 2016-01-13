<?php
/**
 * List View Loop
 * This file sets up the structure for the list loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/loop.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<?php
global $post;
global $more;
$more = false;
?>
<ul class="event-list">
<?php while ( have_posts() ) : the_post(); ?>	

              <?php
                if( has_term( 'webinar','tribe_events_cat' ) ) { ?>
                  <li>
                    <p class="categories"><?php events_the_categories(); ?></p>
                    <?php $meta = get_marketo_meta(); 
                      if ($meta[0]) { ?>
                        <h4><a href="<?php echo $meta[0];?>" target="_blank"><?php the_title(); ?></a></h4>
                        <?php
                      }
                      else { ?>
                        <h4><?php the_title(); ?></h4>
                      <?php
                      }
                    ?>                    
                    <?php echo tribe_events_event_schedule_details( $event_id, '<p class="date">', '</p>' ); ?>
                    <?php the_excerpt(); ?>
                    <?php $meta = get_marketo_meta(); 
                      if ($meta[0]) { ?>
                        <p style="margin-top:15px;"><a href="<?php echo $meta[0];?>" class="btn btn-primary" target="_blank">Register Now</a></p>
                        <?php
                      }
                    ?>   
                  </li>
                <?php
                }
                elseif ( has_term( 'lunch-and-learn','tribe_events_cat' ) ) { ?>
                  <li>
                    <p class="categories"><?php events_the_categories(); ?></p>
                    <?php $meta = get_marketo_meta(); 
                      if ($meta[0]) { ?>
                        <h4><a href="<?php echo $meta[0];?>" target="_blank"><?php the_title(); ?></a></h4>
                        <?php
                      }
                      else { ?>
                        <h4><?php the_title(); ?></h4>
                      <?php
                      }
                    ?>
                    <?php echo tribe_events_event_schedule_details( $event_id, '<p class="date">', '</p>' ); ?>
                    <?php the_excerpt(); ?>
                    <?php $meta = get_marketo_meta(); 
                      if ($meta[0]) { ?>
                        <p style="margin-top:15px;"><a href="<?php echo $meta[0];?>" class="btn btn-primary" target="_blank">Sign-up Now</a></p>
                        <?php
                      }
                    ?>
                  </li>
                <?php
                }
                elseif ( has_term( 'conference','tribe_events_cat' ) ) { ?>
                  <li>
                    <p class="categories"><?php events_the_categories(); ?></p>
                    <?php $meta = get_marketo_meta(); 
                      if ($meta[0]) { ?>
                        <h4><a href="<?php echo $meta[0];?>" target="_blank"><?php the_title(); ?></a></h4>
                        <?php
                      }
                      else { ?>
                        <h4><?php the_title(); ?></h4>
                      <?php
                      }
                    ?>
                    <?php echo tribe_events_event_schedule_details( $event_id, '<p class="date">', '</p>' ); ?>
                    <?php the_excerpt(); ?>
                    <p style="margin-top:15px;"><a href="mailto:events@socrata.com" class="btn btn-primary" target="_blank">Meet Us</a></p>
                  </li>
                <?php
                }
                else { ?>
                  <li>
                    <p class="categories"><?php events_the_categories(); ?></p>
                    <h4><?php the_title(); ?></h4>
                    <?php echo tribe_events_event_schedule_details( $event_id, '<p class="date">', '</p>' ); ?>
                    <?php the_excerpt(); ?>
                  </li>
                <?php
                }
              ?>
          
<?php endwhile; ?>

</ul>
