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

class Shield extends Item {
  
  public function __construct(int $meta = 0){
        parent::__construct(self::SHIELD, $meta, "Shield");
    }

    public function onUpdate(Player $player) : void{
	    $player->setGenericFlag(Entity::DATA_FLAG_BLOCKING, $player->isSneaking());
    }

	public function getMaxStackSize() : int{
        return 1;
    }
}