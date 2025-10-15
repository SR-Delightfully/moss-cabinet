<?php

declare(strict_types=1);

/**
 * This file contains various helper functions that can be used throughout the
 * application. These functions are not part of any class and can be called
 * directly.
 */


/**
 * dd: dump and die.
 *
 * This helper function is very useful for debugging: it outputs the content of the supplied variable and
 * terminates the execution of the application.
 *
 * @see https://www.php.net/manual/en/function.var-dump.php
 * @see https://www.php.net/manual/en/function.die.php
 *
 * @param  mixed $data The variable whose content needs to be dumped.
 * @return void
 */
function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

/**
 * Escapes a string for safe output in HTML context.
 *
 * This function is a wrapper around htmlspecialchars() with secure defaults
 * for preventing Cross-Site Scripting (XSS) attacks. It converts special
 * characters to HTML entities using UTF-8 encoding and HTML5 standards.
 *
 * Characters escaped:
 * - & (ampersand) becomes &amp;
 * - " (double quote) becomes &quot;
 * - ' (single quote) becomes &#039;
 * - < (less than) becomes &lt;
 * - > (greater than) becomes &gt;
 *
 * @param string $string The input string to be escaped.
 *
 * @return string The escaped string safe for HTML output.
 *
 * @example
 * echo e('<script>alert("XSS")</script>');
 * // Outputs: &lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;
 *
 * @example
 * echo '<input value="' . e($userInput) . '">';
 * // Safely outputs user input in HTML attribute
 *
 * @see htmlspecialchars()
 * @link https://www.php.net/manual/en/function.htmlspecialchars.php
 */
function hs($string)
{
    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5 | ENT_DISALLOWED, 'UTF-8');
}


if (!function_exists('get_asset_url')) {
    /**
     * Assets URL helper function.
     *
     * This function will create an asset file URL that includes a cache busting parameter in order
     * to invalidate the browser cache in case of an update.
     *
     * @param string $asset_uri Relative URI (just like the one used in the base_url helper).
     *
     * @return string Returns the final asset URL.
     */
    function get_asset_url(string $asset_uri = ''): string
    {
        $debug = APP_DEBUG_MODE;

        $cache_busting_token = !$debug ? '?' . CACHE_BUSTING_TOKEN : '';

        if (str_contains(basename($asset_uri), '.js') && !str_contains(basename($asset_uri), '.min.js') && !$debug) {
            $asset_uri = str_replace('.js', '.min.js', $asset_uri);
        }

        if (str_contains(basename($asset_uri), '.css') && !str_contains(basename($asset_uri), '.min.css') && !$debug) {
            $asset_uri = str_replace('.css', '.min.css', $asset_uri);
        }

        //TODO: APP_BASE_URL can be replaced by a base_url function. where the protocol can be detected.
        return APP_BASE_URL . $asset_uri . $cache_busting_token;
    }
}

if (!function_exists('css_link')) {

    /**
     * Creates a <link> HTML element linking the supplied CSS file's URI.
     *
     * @param  mixed $css_uri  The URI of the CSS resource to be linked
     * @return string A configured <link> element.
     */
    function css_link(string $css_uri): string
    {
        // dd(APP_ASSETS_DIR . $css_uri);
        if (file_exists(APP_ASSETS_DIR_PATH . $css_uri)) {
            //we know it will exists within the HTTP Context
            $css_uri = APP_ASSETS_DIR_URL . $css_uri;
            return sprintf('<link href="%s" rel="stylesheet" type="text/css">', get_asset_url($css_uri));
            // return sprintf("<script type=\"text/javascript\" src=\"%s\"></script>", $css_uri);
        }
        return "<!-- Unable to load $css_uri -->";
    }
}

if (!function_exists('js_link')) {

    /**
     * Creates a <script> HTML element linking the supplied JS file's URI.
     *
     * @param  mixed $js_uri The URI of the JS file to be linked
     * @param  bool $is_module Whether the JS file is an ES6 module.
     * @return string A string representing a configured <script> element.
     */
    function js_link(string $js_uri, bool $is_module = false): string
    {
        $script_type = $is_module ? 'module' : 'text/javascript';
        if (file_exists(APP_ASSETS_DIR_PATH . $js_uri)) {
            //we know it will exists within the HTTP Context
            $js_uri = APP_ASSETS_DIR_URL . $js_uri;
            return sprintf('<script  type="%s" src="%s"></script>', $script_type, get_asset_url($js_uri));
        }
        return "<!-- Unable to load $js_uri -->";
    }
}

/**
 * Removes the trailing seconds from the supplied date.
 *
 * @param  mixed $date The date in string representation to be formatted.
 * @return string The formatted date without seconds.
 */
function date_remove_secs(string $date): string
{
    return date('Y-m-d H:i', strtotime($date));
}

/**
 * Get the name of the error.
 *
 * @param  int $error_no The error number.
 * @return string The name of the error.
 */
function getErrorName(int $error_no): string
{
    $error_types = [
        E_ERROR             => 'E_ERROR',
        E_WARNING           => 'E_WARNING',
        E_PARSE             => 'E_PARSE',
        E_NOTICE            => 'E_NOTICE',
        E_CORE_ERROR        => 'E_CORE_ERROR',
        E_CORE_WARNING      => 'E_CORE_WARNING',
        E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
        E_USER_ERROR        => 'E_USER_ERROR',
        E_USER_WARNING      => 'E_USER_WARNING',
        E_USER_NOTICE       => 'E_USER_NOTICE',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_DEPRECATED        => 'E_DEPRECATED',
        E_USER_DEPRECATED   => 'E_USER_DEPRECATED',
    ];

    return $error_types[$error_no] ?? "UNKNOWN_ERROR";
}
