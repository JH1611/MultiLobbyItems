<?php

namespace JH1611\MultiLobbyItems\utils;

use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use JH1611\MultiLobbyItems\Main;

class playerWorldInfo {
    protected Main $main;
    public string $world;

    public function __construct(Main $main)
    {
        $this -> main = $main;
    }

    public function isTpLobby(string $world):bool{
        $worlds = $this->main->getConfig()->get("world");
        foreach($worlds as $key0 => $w){
                if($key0 == $world){
                    $this->world = $world;
                    return true;
                }
        }
        return false;
    }

    public function isInLobbyWorld(Player $player): bool{
        $pw = $player->getWorld()->getFolderName();
        $world = $this->main->getConfig()->get("world");
        foreach($world as $key0 => $w){
                if($key0 == $pw){
                    $this->world = $pw;
                    return true;
                }
        }
        return false;
    }

    public function getLobbyWorld(): string{
        return $this->world;
    }
    
}
