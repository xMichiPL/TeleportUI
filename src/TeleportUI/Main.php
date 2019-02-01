<?php

namespace TeleportUI;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\utils\TextFormat as C;

use pocketmine\event\Listener;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\plugin\PluginBase;

use jojoe77777\FormAPI;
 
use TeleportUI\Main;

class Main extends PluginBase implements Listener {
    
	public function onEnable(){
        $this->getLogger()->info("Plugin has been enabled!");
    }

	public function onDisable(){
        $this->getLogger()->info("Plugin has been disabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        switch($command->getName()){
        case "tpui":
        if(!($sender instanceof Player)){
                $sender->sendMessage("This command can't be used here!");
                return true;
        }
        if(!$sender->hasPermission("tpui.command")){
                return true;
        }
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function(Player $sender, array $data){
            $result = $data[0];
            if($data !== null){
				$command = "tp " . $data[1];
                $this->getServer()->getCommandMap()->dispatch($sender, $command);
            }
        });
        $form->setTitle(C::AQUA . "TeleportUI");
        $form->addLabel("Which player you want to teleport?
        ");
        $form->addInput("Name:");
        $form->sendToPlayer($sender);
        }
        return true;
    }
}