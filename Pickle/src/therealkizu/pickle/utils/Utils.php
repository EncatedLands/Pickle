<?php

/**
 * Pickle (c) 2020
 * This project is licensed under GNU LESSER GENERAL PUBLIC LICENSE v3.0
 * It is free to use, and copyright free.
 *
 * @author TheRealKizu
 */

namespace therealkizu\pickle\utils;

use pocketmine\utils\Config;
use therealkizu\pickle\Pickle;

class Utils {

    /** @var Pickle $pickle */
    private $pickle;

    public function __construct(Pickle $pickle) {
        $this->pickle = $pickle;

        $this->checkLanguages($this->pickle->config);
    }

    /**
     * This checks what language the plugin will be using.
     *
     * @param Config $config
     * @return void
     */
    public function checkLanguages(Config $config): void {
        if (!is_dir($this->pickle->getDataFolder() . "languages/")) {
            @mkdir($this->pickle->getDataFolder() . "languages/");
        }

        $language = $config->get("language");
        if (!is_file($this->pickle->getDataFolder() . "languages/{$language}.yml")) {
            if ($this->pickle->saveResource("languages/{$language}.yml")) {
                $this->pickle->getLogger()->warning("{$language} not found. Reverting to default language...");

                $language = "en_US";
                $this->pickle->saveResource("languages/en_US.yml");
            }
        }

        $this->pickle->lang = new Config($this->pickle->getDataFolder() . "languages/{$language}.yml", Config::YAML);
        $this->pickle->lang->save();
        $this->pickle->getLogger()->info($this->translateLang("language-selected"));
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