<?php

declare(strict_types=1);

namespace JH1611\MultiLobbyItems;

use pocketmine\plugin\PluginBase;
use JH1611\MultiLobbyItems\utils\inventoryInfo;
use JH1611\MultiLobbyItems\utils\playerWorldInfo;

class Main extends PluginBase{

    public inventoryInfo $invInfo;
    public playerWorldInfo $worldInfo;

    protected function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents(new eventListener($this), $this);
        $this->invInfo = new inventoryInfo($this);
        $this->worldInfo = new playerWorldInfo($this);
        $this->getLogger()->info("MultiLobbyItems Enabled");
    }

}
