<?php get_header(); ?>

<section class="hero">
    <div class="slider" id="heroSlider">
        <?php
        $slides = array(
            array(
                'title' => 'Upacara & Kegiatan Sekolah',
                'text'  => 'Rangkaian acara meriah dan penuh kreativitas.',
                'image' => 'https://picsum.photos/seed/dorkas1/1200/600',
            ),
            array(
                'title' => 'Prestasi dan Penghargaan',
                'text'  => 'Siswa berprestasi di lomba regional.',
                'image' => 'https://picsum.photos/seed/dorkas2/1200/600',
            ),
            array(
                'title' => 'Ekstrakurikuler Aktif',
                'text'  => 'Musik, olahraga, dan klaster sains yang beragam.',
                'image' => 'https://picsum.photos/seed/dorkas3/1200/600',
            ),
        );

        foreach ($slides as $index => $slide) :
            $active = $index === 0 ? 'active' : '';
            ?>
            <div class="slide <?php echo esc_attr($active); ?>">
                <img src="<?php echo esc_url($slide['image']); ?>" alt="<?php echo esc_attr($slide['title']); ?>">
                <div class="slide-caption">
                    <h1><?php echo esc_html($slide['title']); ?></h1>
                    <p><?php echo esc_html($slide['text']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <button class="slider-prev" aria-label="Previous">‹</button>
        <button class="slider-next" aria-label="Next">›</button>
        <div class="slider-dots" id="heroDots" aria-label="Slider pagination"></div>
    </div>
</section>

<section class="news container">
    <h2>Berita Terbaru</h2>
    <div class="cards">
        <?php
        $posts = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
        ));

        if ($posts->have_posts()) :
            while ($posts->have_posts()) : $posts->the_post();
                ?>
                <article class="card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                    <?php else : ?>
                        <img src="https://picsum.photos/seed/school-<?php the_ID(); ?>/400/240" alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
                    <a class="read-more" href="<?php the_permalink(); ?>">Baca selengkapnya →</a>
                </article>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <article class="card">
                <img src="https://picsum.photos/seed/dorkas1/400/240" alt="Kegiatan Sekolah">
                <h3>Upacara Hari Jadi Sekolah</h3>
                <p>Rangkaian acara dan lomba antar kelas yang meriah.</p>
                <a class="read-more" href="#">Baca selengkapnya →</a>
            </article>
            <article class="card">
                <img src="https://picsum.photos/seed/dorkas2/400/240" alt="Prestasi Siswa">
                <h3>Juara Lomba Matematika</h3>
                <p>Siswa SMP Kristen Dorkas menorehkan prestasi di tingkat kabupaten.</p>
                <a class="read-more" href="#">Baca selengkapnya →</a>
            </article>
            <?php
        endif;
        ?>
    </div>
</section>

<section class="info container">
    <div class="grid">
        <div>
            <h3>Fasilitas Modern</h3>
            <p>Laboratorium, perpustakaan, dan lapangan olahraga yang terawat.</p>
        </div>
        <div>
            <h3>Program Ekstrakurikuler</h3>
            <p>Musik, olahraga, sains, dan pengembangan karakter.</p>
        </div>
        <div>
            <h3>Pendampingan Rohani</h3>
            <p>Pembentukan karakter dan kegiatan ibadah rutin.</p>
        </div>
    </div>
</section>

<?php get_footer(); ?>
