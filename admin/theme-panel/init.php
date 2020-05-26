<?php
function theme_settings_page()
{
    include_admin_file('theme-panel/view');
}

// Add page to menu
add_action("admin_menu", function () {
    add_menu_page(__trs("Site settings"), __trs("Site settings"), "manage_options", "theme-panel", "theme_settings_page", null, 80);
});

// Contacts
add_action("admin_init", function () {
    add_settings_section("section-contacts", __trs("Contacts"), null, "theme-options");

    add_settings_field("phone_number", __trs("Phone number"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'phone_number']);
    add_settings_field("mobile_number", __trs("Mobile number"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'mobile_number']);
    add_settings_field("fax_number", __trs("Fax number"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'fax_number']);
    add_settings_field("email_address", __trs("Email address"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'email_address']);
    add_settings_field("address", __trs("Company address"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'address']);
    add_settings_field("google_map", __trs("Google map"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'textarea', 'id' => 'google_map', 'attrs' => 'rows="4"']);

    register_setting("section", "phone_number");
    register_setting("section", "mobile_number");
    register_setting("section", "fax_number");
    register_setting("section", "email_address");
    register_setting("section", "address");
    register_setting("section", "google_map");
});

// Social media
add_action("admin_init", function () {
    add_settings_section("section-xsocials", __trs("Social media"), null, "theme-options");

    add_settings_field("facebook_url", "Facebook", "admin_theme_panel_option_element", "theme-options", "section-xsocials", ['type' => 'input', 'id' => 'facebook_url']);
    add_settings_field("instagram_url", "Instagram", "admin_theme_panel_option_element", "theme-options", "section-xsocials", ['type' => 'input', 'id' => 'instagram_url']);
    add_settings_field("linkedin_url", "Linkedin", "admin_theme_panel_option_element", "theme-options", "section-xsocials", ['type' => 'input', 'id' => 'linkedin_url']);
    add_settings_field("pinterest_url", "Pinterest", "admin_theme_panel_option_element", "theme-options", "section-xsocials", ['type' => 'input', 'id' => 'pinterest_url']);
    add_settings_field("twitter_url", "Twitter", "admin_theme_panel_option_element", "theme-options", "section-xsocials", ['type' => 'input', 'id' => 'twitter_url']);
    add_settings_field("youtube_url", "Youtube", "admin_theme_panel_option_element", "theme-options", "section-xsocials", ['type' => 'input', 'id' => 'youtube_url']);

    register_setting("section", "facebook_url");
    register_setting("section", "instagram_url");
    register_setting("section", "linkedin_url");
    register_setting("section", "pinterest_url");
    register_setting("section", "twitter_url");
    register_setting("section", "youtube_url");
});


// Google Console API Key
add_action("admin_init", function () {
    add_settings_section("section-google_console_api", "Google Console", null, "theme-options");
    add_settings_field("google_console_api", "API key", "admin_theme_panel_option_element", "theme-options", "section-google_console_api", ['type' => 'input', 'id' => 'google_console_api']);
    register_setting("section", "google_console_api");
});

// Instagram access token
add_action("admin_init", function () {
    add_settings_section("section-instagram_token", "Instagram access token", null, "theme-options");
    add_settings_field("instagram_access_token", "Token key", "admin_theme_panel_option_element", "theme-options", "section-instagram_token", ['type' => 'input', 'id' => 'instagram_access_token']);
    register_setting("section", "instagram_access_token");
});

// Option element
function admin_theme_panel_option_element($args)
{
    $type = array_value($args, 'type');
    $id = array_value($args, 'id');
    $attrs = array_value($args, 'attrs');
    $editor = array_value($args, 'editor', array());

    if ($type == 'input') {
        echo '<input type="text" class="form-control" name="'. $id .'" id="'. $id .'" value="'. get_option($id) .'" '. $attrs .' />';
    } elseif ($type == 'textarea') {
        echo '<textarea class="form-control" name="'. $id .'" id="'. $id .'" '. $attrs .'>'. get_option($id) .'</textarea>';
    } elseif ($type == 'editor') {
        $editor['textarea_name'] = $id;
        wp_editor(get_option($id), $id, $editor);
    }
}
