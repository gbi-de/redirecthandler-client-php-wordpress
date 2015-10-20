<?php
/**
 * @package redirecthandler-client-php-wordpress
 */
/*
Plugin Name: Goldbach Interactive (Germany) Redirect Handler
Plugin URI: http://github.com/gbi-de
Description: Redirect Handler provides a 404 Routine to redirect invalid website requests to valid pages
Version: 0.1.0
Author: Goldbach Interactive (Germany) AG
Author URI: http://goldbach-interactive.de
License: Apache v2
Text Domain: redirecthandler
*/

/*
Copyright 2015 Severin Orth (Goldbach Interactive (Germany) AG)

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/


// Security Test
defined('ABSPATH') or die('No script kiddies please!');

// Our option constants
const RH_GBI_KEY = "RH_GBI_KEY";
const RH_GBI_URL = "RH_GBI_URL";

// Register Handler
add_action('wp', 'rh_test_and_redirect');
add_action('admin_menu', 'rh_admin_menu');

// Add API URL and API KEY Option
add_option(RH_GBI_KEY);
add_option(RH_GBI_URL, 'https://tao.goldbach.com/redirect/');

/**
 * Add a settings page for plugin
 */
function rh_admin_menu() {
    add_options_page('Redirect Handler', 'Redirect Handler', 'manage_options', basename(__FILE__), 'rh_options_menu');
}

/**
 * Options Menu
 */
function rh_options_menu()
{
    if (!current_user_can('manage_options')) {
        wp_die(__("You cannot change settings."));
    }

    // Persist settings
    if (array_key_exists("rh_api_url", $_POST)) {
        $url = esc_url($_POST["rh_api_url"]);
        update_option(RH_GBI_URL, $url);
    }
    if (array_key_exists("rh_api_key", $_POST)) {
        $key = esc_attr($_POST["rh_api_key"]);
        update_option(RH_GBI_KEY, $key);
    }

    ?>
    <div class="wrap">
        <h1>Redirect Handler Settings</h1>
        <form method="POST">
        <p>
            Please provide your api key and api url.
        </p>
        <div class="procontainer">
            <div class="inner">
                    <table class="form-table">
                        <tr>
                            <th>
                                <label for="rh_api_url">API URL:</label>
                            </th>
                            <td>
                                <input class="regular-text" type="text" name="rh_api_url" id="rh_api_url" value="<?= get_option(RH_GBI_URL); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="rh_api_key">API KEY:</label>
                            </th>
                            <td>
                                <input class="regular-text" type="text" name="rh_api_key" id="rh_api_key" value="<?= get_option(RH_GBI_KEY); ?>"/>
                            </td>
                        </tr>
                    </table>
            </div>
        </div>
        <p class="submit">
            <input type="submit" name="submit" class="button button-primary" value="Save Changes" />
        </p>
        </form>

    </div>
    <?php
}

/**
 * Test for 404 and whether a redirection exists
 *
 * When true redirects to the target page
 * Otherwise continues execution
 */
function rh_test_and_redirect() {
    if (is_404()) {
        $link = $_SERVER['REQUEST_URI'];

        $api_key = get_option(RH_GBI_KEY);
        $api_url = get_option(RH_GBI_URL);

        $redirect_url = $api_url . '?r=' . urlencode($link);

        $headers = getHeaders($redirect_url, $api_key);
        $responseStatus = $headers[0];

        if (strpos($responseStatus, '404 Not Found') !== false || $responseStatus =='') {
            return false;
        }

        foreach ($headers as $headerValue) {
            header($headerValue);
        }

        exit();
    }
}

/**
 * Requesting the Redirecthandler Server
 * @param string $url to request normaly https://tao.goldbach.com/redirect
 * @param string $api_key your api key (some md5 hash)
 * @return array of headers
 */
function getHeaders($url, $api_key) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-gbi-key: " . $api_key));
    $r = curl_exec($ch);
    $r = @split("\n", $r);
    return $r;
}