<!--<time class="updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
<p class="byline author vcard"><?= __('By', 'sage'); ?> <a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?= get_the_author(); ?></a></p>-->

<ul class="byline">
<li><?php echo get_avatar( get_the_author_meta('ID'), 50 ); ?></li>
<li style="line-height: normal;"><small>By <strong><?php the_author(); ?></strong><br><?php the_time('F j, Y') ?></small></li>
</ul>
