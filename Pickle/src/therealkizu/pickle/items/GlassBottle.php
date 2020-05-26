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
use pocketmine\item\Item; 
use pocketmine\item\Potion;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\item\GlassBottle as PMGlassBottle;

class GlassBottle extends PMGlassBottle {
  
	public function onActivate(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector): bool {
		if (in_array($blockClicked->getId(), [Block::STILL_WATER, Block::FLOWING_WATER]) || in_array($blockReplace->getId(), [Block::STILL_WATER, Block::FLOWING_WATER])){
			if ($player->getGamemode() === 0){
				$this->count--;
			}
			$player->getInventory()->addItem(Item::get(Item::POTION, Potion::WATER, 1)); 
			$player->getInventory()->removeItem(Item::get(Item::GLASS_BOTTLE));
		}

		return true;
	}
	
 }
