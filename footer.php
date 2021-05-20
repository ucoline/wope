<?php wp_footer(); ?>
<?php wp_nonce_field('ajax-action-nonce', 'ajax_action'); ?>

<script type="text/javascript">
    var ajax_nonce = $("#ajax_action").val();
</script>

<!--- JS Libs & Scripts --->
<script src="<?= libs_url('js/popper.min.js'); ?>"></script>
<script src="<?= libs_url('js/maskedinput.min.js'); ?>"></script>
<script src="<?= libs_url('bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?= libs_url('fancybox/jquery.fancybox.min.js'); ?>"></script>
<script src="<?= libs_url('owl-carousel/owl.carousel.min.js'); ?>"></script>

<script src="<?= theme_url('js/global.js'); ?>"></script>
<script src="<?= theme_url('js/custom.js?ver=1.0.0'); ?>"></script>

<?php
// Container js files
$js_files = Container::js_files();

if ($js_files) {
    foreach ($js_files as $js_file) {
        echo '<script src="' . $js_file . '"></script>';
    }
} ?>