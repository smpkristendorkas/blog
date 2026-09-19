<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <article class="single-content">
        <header class="entry-header">
            <div class="entry-meta"><?php echo esc_html(get_the_date()); ?></div>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header>

        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large', array('class' => 'wp-post-image')); ?>
        <?php endif; ?>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>
