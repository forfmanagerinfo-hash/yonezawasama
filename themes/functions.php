<?php
// =============================
// 米澤総合法律事務所 テーマ用 functions.php
// =============================

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('mytheme-hero', 1200, 630, true);

    register_nav_menus(array(
        'global' => 'Global Navi',
    ));

    add_theme_support('html5', array(
        'comment-form',
        'comment-list',
    ));
});

add_action('wp_enqueue_scripts', function () {
    $ver = wp_get_theme()->get('Version');
    wp_enqueue_style('yonezawa-style', get_stylesheet_uri(), [], $ver);
    wp_enqueue_style('yonezawa-scroll', get_template_directory_uri() . '/assets/css/scroll.css', ['yonezawa-style'], $ver);
    wp_enqueue_style('yonezawa-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap', [], null);

    wp_enqueue_script('main-script', get_template_directory_uri() . '/js/service.js', [], $ver, true);
});

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'サイドバー',
        'id' => 'sidebar',
        'description' => 'サイドバーウィジェット',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="side-title">',
        'after_title' => '</h3>'
    ));
}

add_action('wp_head', function () {

    $site_name = '米澤総合法律事務所';
    $desc_fallback = '米澤総合法律事務所の公式サイト。企業法務、契約書作成・レビュー、労務、債権回収、紛争解決などの法律相談に対応しています。';
    $desc = (is_singular() && has_excerpt())
        ? wp_strip_all_tags(get_the_excerpt(), true)
        : $desc_fallback;

    if (function_exists('mb_strimwidth')) {
        $desc = mb_strimwidth($desc, 0, 220, '…', 'UTF-8');
    }

    $title = wp_get_document_title();
    $url = function_exists('wp_get_canonical_url') && wp_get_canonical_url()
        ? wp_get_canonical_url()
        : home_url(add_query_arg([], $GLOBALS['wp']->request ?? ''));

    $img = (is_singular() && has_post_thumbnail())
        ? get_the_post_thumbnail_url(null, 'large')
        : get_template_directory_uri() . '/assets/ogp.jpg';

    $robots = (is_search() || is_404()) ? 'noindex,follow' : 'index,follow';
    ?>
    <meta name="description" content="<?php echo esc_attr($desc); ?>">
    <link rel="canonical" href="<?php echo esc_url($url); ?>">
    <meta name="robots" content="<?php echo esc_attr($robots); ?>">

    <meta property="og:locale" content="ja_JP">
    <meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
    <meta property="og:title" content="<?php echo esc_attr($title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($desc); ?>">
    <meta property="og:url" content="<?php echo esc_url($url); ?>">
    <meta property="og:image" content="<?php echo esc_url($img); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($desc); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($img); ?>">

    <link rel="icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon.ico'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri() . '/assets/apple-touch-icon.png'); ?>">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LegalService",
        "name": "米澤総合法律事務所",
        "url": "<?php echo esc_url(home_url('/')); ?>",
        "logo": "<?php echo esc_url(get_template_directory_uri() . '/assets/logo.png'); ?>",
        "description": "企業法務、契約書作成・レビュー、労務、債権回収、紛争解決など、法人・個人の法律相談に対応する法律事務所です。",
        "areaServed": "JP",
        "telephone": "",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "JP",
            "addressRegion": "",
            "addressLocality": "",
            "streetAddress": ""
        },
        "sameAs": []
    }
    </script>
    <?php
}, 1);

add_filter('wp_resource_hints', function ($hints, $relation_type) {
    if ('preconnect' === $relation_type) {
        $hints[] = 'https://fonts.googleapis.com';
        $hints[] = [
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        ];
    }
    return $hints;
}, 10, 2);
