<?php
function theme_settings_page()
{
    include_admin_file('theme-panel/view');
}

// Add page to menu
add_action("admin_menu", function () {
    add_menu_page(__("Theme settings", 'wope'), __("Theme settings", 'wope'), "manage_options", "theme-panel", "theme_settings_page", null, 80);
});

// Contacts
add_action("admin_init", function () {
    add_settings_section("section-contacts", __("Contacts", "wope"), null, "theme-options");

    add_settings_field("phone_number", __("Phone number", "wope"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'phone_number']);
    add_settings_field("mobile_number", __("Mobile number", "wope"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'mobile_number']);
    add_settings_field("fax_number", __("Fax number", "wope"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'fax_number']);
    add_settings_field("whatsapp_number", __("Whatsapp number", "wope"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'whatsapp_number']);
    add_settings_field("telegram_number", __("Telegram number", "wope"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'telegram_number']);
    add_settings_field("telegram_username", __("Telegram username", "wope"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'telegram_username']);
    add_settings_field("email_address", __("Email address", "wope"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'email_address']);
    add_settings_field("address", __("Company address", "wope"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'input', 'id' => 'address']);
    add_settings_field("google_map", __("Google map", "wope"), "admin_theme_panel_option_element", "theme-options", "section-contacts", ['type' => 'textarea', 'id' => 'google_map', 'attrs' => 'rows="4"']);

    register_setting("section", "phone_number");
    register_setting("section", "mobile_number");
    register_setting("section", "fax_number");
    register_setting("section", "whatsapp_number");
    register_setting("section", "telegram_number");
    register_setting("section", "telegram_username");
    register_setting("section", "email_address");
    register_setting("section", "address");
    register_setting("section", "google_map");
});

// Social media
add_action("admin_init", function () {
    add_settings_section("section-xsocials", __("Social media", "wope"), null, "theme-options");

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
    add_settings_section("section-google_console_api", "Google console", null, "theme-options");
    add_settings_field("google_console_api", "API key", "admin_theme_panel_option_element", "theme-options", "section-google_console_api", ['type' => 'input', 'id' => 'google_console_api']);
    register_setting("section", "google_console_api");
});

// Google Console Recaptcha
add_action("admin_init", function () {
    add_settings_section("section-recaptcha", "Google console", null, "theme-options");

    add_settings_field("recaptcha_public_key", "Public key", "admin_theme_panel_option_element", "theme-options", "section-recaptcha", ['type' => 'input', 'id' => 'recaptcha_public_key']);
    add_settings_field("recaptcha_secret_key", "Secret key", "admin_theme_panel_option_element", "theme-options", "section-recaptcha", ['type' => 'input', 'id' => 'recaptcha_secret_key']);

    register_setting("section", "recaptcha_public_key");
    register_setting("section", "recaptcha_secret_key");
});

// Instagram access token
add_action("admin_init", function () {
    add_settings_section("section-instagram_token", "Instagram access token", null, "theme-options");
    add_settings_field("instagram_access_token", "Token key", "admin_theme_panel_option_element", "theme-options", "section-instagram_token", ['type' => 'input', 'id' => 'instagram_access_token']);
    register_setting("section", "instagram_access_token");
});
