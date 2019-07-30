<?php

class util {
    static function error($err) {
        die($err);
    }

    static function redirect($url)
    {
        // Scrub all output buffer before we redirect.
        // @see http://www.mombu.com/php/php/t-output-buffering-and-zlib-compression-issue-3554315-last.html
        while (ob_get_level() > 1) ob_end_clean();

        header('Location: ' . $url);
    }
}