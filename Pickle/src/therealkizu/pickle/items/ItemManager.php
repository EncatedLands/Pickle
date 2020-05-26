<?php

/**
 * Pickle (c) 2020
 * This project is licensed under GNU LESSER GENERAL PUBLIC LICENSE v3.0
 * It is free to use, and copyright free.
 *
 * @author TheRealKizu
 */

declare(strict_types=1);

namespace therealkizu\pickle\items;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;

use therealkizu\pickle\items\Boat;
use therealkizu\pickle\items\Crossbow;
use therealkizu\pickle\items\Minecart;
use therealkizu\pickle\items\Shield;

class ItemManager {

    public function __construct() {
        $this->init();
    }

    public function init() {
        ItemFactory::registerItem(new Boat(), true);
        ItemFactory::registerItem(new Crossbow(), true);
        ItemFactory::registerItem(new Minecart(), true);
        ItemFactory::registerItem(new Shield(), true);
        Item::initCreativeItems();
    }

}
