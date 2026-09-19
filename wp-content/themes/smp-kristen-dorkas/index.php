<?php get_header(); ?>

<section class="container section-title">
    <h2>Berita Terbaru</h2>
</section>

<section class="container">
    <div class="post-grid">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article class="post-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                    <?php else : ?>
                        <img src="https://picsum.photos/seed/blog-<?php the_ID(); ?>/400/240" alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                    <div class="post-card-body">
                        <span class="entry-meta"><?php echo esc_html(get_the_date()); ?></span>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                        <a class="post-link" href="<?php the_permalink(); ?>">Baca selengkapnya →</a>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Belum ada post yang dipublikasikan.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
