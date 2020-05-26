<?php

 /**
 * Pickle (c) 2020
 * This project is licensed under GNU LESSER GENERAL PUBLIC LICENSE v3.0
 * It is free to use, and copyright free.
 *
 * @author TheRealKizu
 */

declare(strict_types=1);

namespace therealkizu\pickle\Items;

use pocketmine\item\Item;
use therealkizu\pickle\Pickle;

class Elytra extends Item {
  
	public function __construct(int $meta = 0){
		parent::__construct(Item::ELYTRA, $meta, "Elytra Wings");
	}

	public function getArmorSlot() : int{
		return 1;
	}

	public function getMaxStackSize() : int{
		return 1;
	}
}