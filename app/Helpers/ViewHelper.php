<?php

declare(strict_types=1);

namespace App\Helpers;

class ViewHelper
{

    /**
     * Load the common header for the page.
     *
     * @param string $page_title The title of the page.
     * @return void
     */
    public static function loadHeader(string $page_title): void
    {
        $page_title = $page_title ?? 'Default Title';
        require_once APP_VIEWS_PATH . '/common/header.php';
    }

    /**
     * Load the common JavaScript scripts for the page.
     *
     * @return void
     */
    public static function loadJsScripts(): void
    {
        require_once APP_VIEWS_PATH . '/common/js-scripts.php';
    }

    /**
     * Load the common footer for the page.
     *
     * @return void
     */
    public static function loadFooter(): void
    {
        require_once APP_VIEWS_PATH . '/common/footer.php';
    }

    /**
     * Generates HTML option elements for a select dropdown with secure output.
     *
     * Creates a series of <option> elements from an array of data, with automatic
     * HTML escaping for XSS protection and proper selection handling. Includes
     * a default "-- Select --" option and validates input data structure.
     *
     * @param array $items Array of associative arrays containing the dropdown data
     * @param string $previous_select The value to be marked as selected (empty string for no selection)
     * @param string $value_key The array key to use for option values
     * @param string $option_key The array key to use for option display text
     * @return string HTML string containing all option elements
     *
     * @example Basic usage with countries array
     * $countries = [
     *     ['id' => 1, 'name' => 'Canada'],
     *     ['id' => 2, 'name' => 'United States']
     * ];
     * $options = ViewHelper::renderSelectOptions($countries, '1', 'id', 'name');
     * echo '<select name="country">' . $options . '</select>';
     *
     * @example With no pre-selected value
     * $options = ViewHelper::renderSelectOptions($users, '', 'user_id', 'full_name');
     *
     * @since 1.0.0
     * @see hs() Global HTML escaping function for XSS protection
     */
    public static function renderSelectOptions(array $items, string $previous_select, string $value_key, string $option_key): string
    {
        $options = '';
        $hasSelection = !empty($previous_select);

        // Default option - only selected if no previous selection
        $defaultSelected = !$hasSelection ? ' selected' : '';
        $options .= '<option value=""' . $defaultSelected . '>-- Select --</option>';

        foreach ($items as $item) {
            // Validate required keys exist
            if (!isset($item[$value_key]) || !isset($item[$option_key])) {
                continue;
            }

            $value = hs((string)$item[$value_key]);
            $text = hs((string)$item[$option_key]);
            $selected = ($previous_select === (string)$item[$value_key]) ? ' selected' : '';

            $options .= "<option value=\"{$value}\"{$selected}>{$text}</option>";
        }

        return $options;
    }
}
