<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package WordPress
 * @subpackage 米澤総合法律事務所
 * @since 20260115
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/content/content');
            }

            the_posts_navigation();
        } else {
            get_template_part('template-parts/content/content', 'none');
        }
        ?>

    </main>
    <?php get_sidebar(); ?>
</div>

<?php
get_footer();
