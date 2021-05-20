<!DOCTYPE html>
<html lang="<?= Container::$current_lang; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="theme-color" content="#D13138">
    <title><?= meta_title(); ?></title>

    <?php
    wp_enqueue_style('font-roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700,700i', false, '1.0.0');
    wp_enqueue_style('bootstrap-css', libs_url('bootstrap/css/bootstrap.min.css'), false, '4.2.1');
    wp_enqueue_style('fancybox-css', libs_url('fancybox/jquery.fancybox.min.css'), false, '3.2.1');
    wp_enqueue_style('owl-carousel-css', libs_url('owl-carousel/assets/owl.carousel.min.css'), false, '2.2.1');
    wp_enqueue_style('owl-carousel-theme-css', libs_url('owl-carousel/assets/owl.theme.default.min.css'), false, '2.2.1');
    wp_enqueue_style('theme-main-css', theme_url('css/main.min.css'), false, '1.0.0');
    wp_enqueue_style('theme-style-css', theme_url('css/style.css'), false, '1.0.0');
    wp_enqueue_style('theme-responsive-css', theme_url('css/responsive.css'), false, '1.0.0');

    wp_head(); ?>

    <script type="text/javascript">
        var site_url = '<?= home_url(); ?>/';
        var this_url = window.location.href;
        var images_url = '<?= images_url(); ?>';
        var ajax_error_msg = '<?= __('An error occurred while processing your request! Please try again.', 'wope'); ?>';

        var sdwidth, sdevice;

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (navigator.userAgent.match(/Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i)) {
            var uagent = 'mobile';
        } else {
            var uagent = 'desktop';
        }
    </script>

    <!--[if lt IE 9]>
        <script src="<?= libs_url('js/html5shiv.min.js'); ?>"></script>
        <script src="<?= libs_url('js/respond.min.js'); ?>"></script>
    <![endif]-->
</head>

<body <?php body_class(); ?>>