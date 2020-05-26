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

use pocketmine\Player;
use pocketmine\entity\Entity;
use pocketmine\block\Block;
use pocketmine\math\Vector3; 
use pocketmine\item\Item;

class Boat extends Item {
  
	public function __construct(){
		parent::__construct(self::BOAT, 0, "Boat");
	}

	public function getFuelTime() : int{
		return 400; 
	}

	public function getMaxStackSize() : int{
		return 64;
	}
  // Work in progress...
	public function onActivate(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector) : bool {
		$nbt = Entity::createBaseNBT($blockReplace->add(0.5, 0, 0.5));
		$nbt->setInt("Variant", $this->getDamage());
		$entity = Entity::createEntity("Boat", $player->level, $nbt);
		$entity->spawnToAll();
		$this->pop();

		return true;
	}
}