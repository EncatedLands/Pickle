<?php

/**
 * Pickle (c) 2020
 * This project is licensed under GNU LESSER GENERAL PUBLIC LICENSE v3.0
 * It is free to use, and copyright free.
 *
 * @author TheRealKizu
 */

namespace therealkizu\pickle\utils;

use therealkizu\pickle\Pickle;

class Utils {

    /** @var Pickle $pickle */
    private $pickle;

    public function __construct(Pickle $pickle) {
        $this->pickle = $pickle;
    }

    /**
     * This translates the message by the selected language
     *
     * @param string $langKey
     * @param array $keys
     * @return string|string[]
     */
    public function translateLang(string $langKey, array $keys = array()) {
        $language = $this->pickle->lang;
        $key = $language->get($langKey);
        if (!is_string($key)){
            return "Error translating ${langKey}";
        }

        $key = strtr($key, $keys);
        return str_replace("&", "§", $key);
    }

}