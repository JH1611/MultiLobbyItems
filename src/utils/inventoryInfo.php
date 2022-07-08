<?php

namespace JH1611\MultiLobbyItems\utils;

use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use JH1611\MultiLobbyItems\Main;

class inventoryInfo {
    protected Main $main;

    public function __construct(Main $main)
    {
        $this -> main = $main;
    }

    public function canKeepInv(Player $player): bool{
        $pw = $player->getWorld()->getFolderName();
        $world = $this->main->getConfig()->get("world");
        foreach($world as $key0 => $w){
                if($key0 == $pw){
                return true;
                }
        }
        return false;
    }

    public function setPlayerItems(Player $player,string $world){
        $items = $this->getWorldItems($world);


        $player->getInventory()->clearAll();
        foreach ($items as $key => $item) {
           if($item['slot']<=9){
            $player->getInventory()->setItem($item['slot']-1,ItemFactory::getInstance()->get($item['item-id'])->setCustomName($item['item-name']));
           }else{
            $this->main->getLogger()->info('invalid slot number');
           }
        }
    }

    public function getWorldItems(string $world): array{
        $config = $this->main->getConfig()->get("world");
        return $config[$world];
    }


    public function getItemCommand(string $itemName,string $world){
        $config = $this->main->getConfig()->get("world");
        foreach($config[$world] as $key => $item){
            if($item['item-name']==$itemName){
                if(!isset($item['command']))return "error";

                return $item['command'];
            }
        }
        return "error";
    }
}