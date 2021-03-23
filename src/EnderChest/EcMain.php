<?php

namespace EnderChest;

use pocketmine\inventory\EnderChestInventory;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\utils\Config;
use pocketmine\command\CommandSender;

class EcMain extends PluginBase implements Listener{
  
  public function onEnable(){
   $this->getLogger()->notice("EnderChest loaded ! ");
    
    @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
  }
  
  public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        switch ($command->getName()){
            case "ec":
                if ($sender instanceof Player){
                    if ($sender->hasPermission("enderchest.cmd")){
                     $ec = new EnderChestInventory();
                    } else{
                        $sender->sendMessage($this->cfg->get("no-perms"));
                    }
                } else{
                    $sender->sendMessage($this->cfg->get("no-console"));
                }
                break;
        }
        return true;
    }
}
