<?php

namespace EnderChest;

use pocketmine\block\Block;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\utils\Config;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\EnderChest;
use pocketmine\tile\Tile;
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
                     $nbt = new CompoundTag("", [new StringTag("id", Tile::CHEST), new StringTag("CustomName", "EnderChest"), new IntTag("x", (int)floor($sender->x)), new IntTag("y", (int)floor($sender->y) - 4), new IntTag("z", (int)floor($sender->z))]);
                      
			               $tile = Tile::createTile("EnderChest", $sender->getLevel(), $nbt);
			               $block = Block::get(Block::ENDER_CHEST);
			               $block->x = (int)$tile->x;
			               $block->y = (int)$tile->y;
			               $block->z = (int)$tile->z;
			               $block->level = $tile->getLevel();
			               $block->level->sendBlocks([$sender], [$block]);
			               $sender->getEnderChestInventory()->setHolderPosition($tile);
			               $sender->addWindow($sender->getEnderChestInventory());
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
