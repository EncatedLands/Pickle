<?php

/**
 * Pickle (c) 2020
 * This project is licensed under GNU LESSER GENERAL PUBLIC LICENSE v3.0
 * It is free to use, and copyright free.
 *
 * @author EncatedLands
 */

declare(strict_types=1);

namespace therealkizu\pickle\items;

use pocketmine\item\Item;

class Elytra extends Item {
  
	public function __construct(){
		parent::__construct(self::ELYTRA, 0, "ElytraWings");
	}

	public function getMaxStackSize() : int{
		return 1;
	}
}