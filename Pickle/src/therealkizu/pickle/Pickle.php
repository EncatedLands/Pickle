<?php

/**
 * Pickle (c) 2020
 * This project is licensed under GNU LESSER GENERAL PUBLIC LICENSE v3.0
 * It is free to use, and copyright free.
 *
 * @author TheRealKizu
 */

declare(strict_types=1);

namespace therealkizu\pickle;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use therealkizu\pickle\items\ItemManager;
use therealkizu\pickle\utils\Utils;

class Pickle extends PluginBase {

    /** @var Config $config */
    public $config;
    /** @var Config $lang */
    public $lang;
    /** @var Utils $utils */
    public $utils;

    public function onLoad() {
        if (!is_dir($this->getDataFolder())) {
            @mkdir($this->getDataFolder());
        }

        if (!is_dir($this->getDataFolder() . "languages/")) {
            @mkdir($this->getDataFolder() . "languages/");
        }

        if (!is_file($this->getDataFolder() . "config.yml")) {
            $this->saveResource("config.yml");
        }
    }

    public function onEnable() {
        $this->getLogger()->info("Pickle is now enabled!");
        $this->getLogger()->info("Pickle is licensed under LGPL-3.0");

        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->utils = new Utils($this);

        $this->registerManagers();
    }

    /**
     * This registers the Block, Item Managers
     *
     * @return void
     */
    public function registerManagers(): void {
        new ItemManager();
    }

}
