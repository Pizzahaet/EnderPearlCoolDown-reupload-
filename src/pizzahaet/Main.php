<?php
namespace EnderPearlCoolDown;
/*
*
*/
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\item\Item;
use pocketmine\item\EnderPearl;
use pocketmine\event\entity\ProjectileLaunchEvent;

use pocketmine\utils\Text_Format as C;

use pocketmine\Server;
use pocketmine\utils\Config;

  class Main extends PluginBase implements Listener
     {
	  
  private $coolDown = 60;
  private $timer = [];
	  
   public function onEnable(){
     $this->getServer()->getLogger()->Info("E-Pearl Cooldown Was Loaded!");
       @mkdir($this->getDataFolder())
           $this->saveDefaultConfig();
       	        $this->getServer()->getPluginManager()->registerEvents($this, $this);
         $this->coolDown = $this->getConfig()->get("E-PearlCoolDown");
   }	
     public function onThrow(ProjectileLaunchEvent $pce){
      if ($pce->isCancelled()) return;
	     
  	if ($pce->getItem()->getId() == Item::ENDER_PEARL){
	    $this = strtolower($pce->getPlayer()->getDisplayName());
		
		if(!isset($this->timer[$name]) OR time() > $this->timer[$name]){
			$this->timer[$name] = $this->coolDown;
		} else{
		  $pce->setCancelled();
		     $pce->getPlayer()->sendPopup(C::BOLD.C::RED."Error".C::DARK_GRAY. ">"."On EnderPearl CoolDown: \nWait".round($this->timer[$name]-time()).C::RESET);
		  //Timer made by Derpific aka DerpDev from his GappleCoolDown plugin Thanks for allowing us to use this   
		   }
                }
	     }
   public function onDisable(){
     $this->getServer()->getLogger()->Info("E-Pearl Cooldown disabled... Did server stop?");
  }
}
