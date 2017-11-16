<?php

namespace Pizzahaet\EnderPearl;

use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\Listener;
use pocketmine\entity\EnderPearl;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
//use pocketmine\utils\TextFormat as C;

class Main extends PluginBase implements Listener {

    private $coolDown = 60;
    private $timer = [];

    public function onEnable() {
        $this->getServer()->getLogger()->Info("E-Pearl Cooldown Was Loaded!");
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->coolDown = $this->getConfig()->get("E-PearlCoolDown");
    }

    public function onThrow(ProjectileLaunchEvent $event) {
        if ($event->isCancelled()) return;

        $shooter = $event->getEntity();
        if ($shooter instanceof Player) {
            if ($event->getEntity() instanceof EnderPearl){
                $name = strtolower($shooter->getDisplayName());
                if (!isset($this->timer[$name]) OR time() > $this->timer[$name]) {
                    $this->timer[$name] = $this->coolDown;
                } else {
                    $event->setCancelled();
                    $shooter->sendPopup("please wait " . round($this->timer[$name] - time()) . " to use that again");
                    //$shooter->sendTitle("Please wait...", "You have" . round($this->timer[$name] - time()) . "Until you can use that again", 5, 10, 15);
                }
            }
        }
    }

    public function onDisable() {
        $this->getServer()->getLogger()->Info("E-Pearl Cooldown disabled... Did server stop?");
    }
}
