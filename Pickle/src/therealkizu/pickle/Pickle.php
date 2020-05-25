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

class Pickle extends PluginBase {

    public function onLoad() {
        if (!is_dir($this->getDataFolder())) {
            @mkdir($this->getDataFolder());
        }
    }

    public function onEnable() {
        $this->getLogger()->info("Pickle is now enabled!");
    }

}