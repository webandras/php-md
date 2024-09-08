<?php

/**
 * Safely escape and format a string for various output contexts.
 *
 * @param  string|null  $input  The string to be escaped.
 * @param  string  $encoding  (Optional) The character encoding to use for escaping. Defaults to 'UTF-8'.
 * @param  string  $output_format  (Optional) The desired output format: 'html' (default), 'xml', 'json', 'javascript', or 'attribute'.
 *
 * @return string The escaped and formatted string ready for safe inclusion in the specified context.
 */
function out(?string $input, string $encoding = 'UTF-8', string $output_format = 'html'): string {
    $flags = ENT_QUOTES;

    if ($input === null) {
        $input = '';
    }

    if ($output_format === 'xml') {
        $flags = ENT_XML1;
    } elseif ($output_format === 'json') {
        // Customize JSON escaping as needed
        $input = json_encode($input, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $flags = ENT_NOQUOTES;
    } elseif ($output_format === 'javascript') {
        // JavaScript-encode the input
        $input = json_encode($input, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    } elseif ($output_format === 'attribute') {
        // Escape for HTML attributes
        $flags = ENT_QUOTES;
    } else {
        // Dynamically choose the right function
        $input = ($output_format === 'html') ? htmlspecialchars($input, $flags, $encoding) : htmlentities($input, $flags, $encoding);
        return $input;
    }

    return htmlspecialchars($input, $flags, $encoding);
}


/**
 * @param  string  $language
 *
 * @return string
 */
function get_language_segment(string $language): string
{
    return $language !== DEFAULT_LANGUAGE ? ($language.'/') : '';
}


/**
 * @param  string  $template_name
 * @param  string  $compare
 *
 * @return string
 */
function set_active_page_link(string $template_name, string $compare = 'index'): string {
    return $template_name === $compare ? 'aria-current="page"' : '';
}