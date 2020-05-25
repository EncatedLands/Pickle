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

use pocketmine\Player;
use pocketmine\entity\Entity;
use pocketmine\entity\projectile\Projectile;
use pocketmine\item\ItemFactory;
use pocketmine\item\Tool;
use pocketmine\item\Item;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use therealkizu\pickle\Pickle;

class Crossbow extends Tool {
	
	public function __construct(int $meta = 0) {
		parent::__construct(self::CROSSBOW, $meta, "Crossbow");
	}
	
	public function getFuelTime() : int{
		return 200;
	}

	public function getMaxDurability() : int{
		return 385;
	}
	
	public function onClickAir(Player $player, Vector3 $directionVector) : bool{
		if($this->isFullyLoaded()){
			$this->fireCrossbow($player);
			$player->getInventory()->setItemInHand($this);
			return true;
		}
		if($this->isLoaded()){
			return true;
		}
		if($player->getGamemode() === 0 and !$player->getInventory()->contains(ItemFactory::get(Item::ARROW, 0, 2))){
			$player->getInventory()->sendContents($player);
			return false;
		}
		$ud = $player->getItemUseDuration();
		if($ud <= 0){
			$player->getInventory()->setItemInHand($this);
      $player->getLevel()->broadcastLevelSoundEvent($player, LevelSoundEventPacket::SOUND_CROSSBOW_LOADING_START);
		}
		if($ud >= 24){
			$player->getInventory()->setItemInHand($this);
     $player->getLevel()->broadcastLevelSoundEvent($player, LevelSoundEventPacket::SOUND_CROSSBOW_LOADING_END);
			$this->setFullyLoaded($player, true);
		}
		return true;
	} 
	
  private function isFullyLoaded() {
		$tag = $this->getNamedTagEntry("loadedCrossbow");
		if($tag == null){
			return false;
		}
		if($tag->getInt("loadedCrossbowTime") > time()){
			return false;
		}
		return true;
	}
	
	public function fireCrossbow(Player $player) {
		$nbt = Entity::createBaseNBT(
			$player->add(0, $player->getEyeHeight(), 0),
			$player->getDirectionVector(),
			($player->yaw > 180 ? 360 : 0) - $player->yaw,
			-$player->pitch
		);
		$nbt->setShort("Fire", $player->isOnFire() ? 45 * 60 : 0);
		$entity = Entity::createEntity("Arrow", $player->getLevel(), $nbt, $player);
		if($entity instanceof Projectile){
			$ev = new EntityShootBowEvent($player, $this, $entity, 7);
			$ev->call();
			$entity = $ev->getProjectile();
			if($ev->isCancelled()){
				$entity->flagForDespawn();
				$player->getInventory()->sendContents($player);
			} else {
				$entity->setMotion($entity->getMotion()->multiply($ev->getForce()));
				if($player->getGamemode() === 0){
					$this->applyDamage(1);
				}
				if($entity instanceof Projectile){
					$projectileEv = new ProjectileLaunchEvent($entity);
					$projectileEv->call();
					if($projectileEv->isCancelled()){
						$ev->getProjectile()->flagForDespawn();
					}else{
						$ev->getProjectile()->spawnToAll();
						$this->setFullyLoaded($player, false);
            $player->getLevel()->broadcastLevelSoundEvent($player, LevelSoundEventPacket::SOUND_CROSSBOW_SHOOT);
					}
				} else {
					$entity->spawnToAll();
				}
			}
		} else {
			$entity->spawnToAll();
		}
	}

	private function setFullyLoaded(Player $player, bool $value){
		if(!$value){
			$this->removeNamedTagEntry("loadedCrossbow");
			return;
		}
		if($player->getGamemode() === 0){
			$player->getInventory()->removeItem(ItemFactory::get(Item::ARROW, 0, 1));
		}
		$arrow = ItemFactory::get(Item::ARROW, 0, 1);
		$tag = $arrow->nbtSerialize(-1, "loadedCrossbow");
		$tag->removeTag("id");
		$tag->setString("Name", "minecraft:arrow");
		$tag->setInt("loadedCrossbowTime", time() + 1);
		$this->setNamedTagEntry($tag);
	}
	
	public function isLoaded(){
		$tag = $this->getNamedTagEntry("loadedCrossbow");
		if($tag == null){
			return false;
		}
		return true;
	}
	
}