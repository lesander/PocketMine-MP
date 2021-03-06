<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

namespace pocketmine\block;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\Server;
use pocketmine\entity\Entity;

class StillLava extends Lava{
	public function __construct($meta = 0){
		parent::__construct(self::STILL_LAVA, $meta, "Still Lava");
		$this->hardness = 500;
	}

	public function getBoundingBox(){
		return null;
	}

	public function onEntityCollide(Entity $entity){
		$entity->setOnFire(15);
		$ev = new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_LAVA, 4);
		Server::getInstance()->getPluginManager()->callEvent($ev);
		if(!$ev->isCancelled()){
			$entity->attack($ev->getFinalDamage(), $ev);
		}
		$entity->attack(4, EntityDamageEvent::CAUSE_LAVA);
	}

}