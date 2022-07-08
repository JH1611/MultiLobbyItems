<?php
namespace JH1611\MultiLobbyItems;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\player\Player;

class eventListener implements Listener{

    protected Main $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        if(!$this->main->worldInfo->isInLobbyWorld($player))return;

        $world = $this->main->worldInfo->getLobbyWorld();

        $this->main->invInfo->setPlayerItems($player, $world);
    }

    public function onDropItem(PlayerDropItemEvent $event){
        $player = $event->getPlayer();
        if(!$this->main->worldInfo->isInLobbyWorld($player))return;

        $event->cancel();
    }

    public function onITE(InventoryTransactionEvent $event){
        $transaction = $event->getTransaction();
        $player = $transaction->getSource();
        if(!$this->main->worldInfo->isInLobbyWorld($player))return;

        $event->cancel();
    }

    public function onDeath(PlayerDeathEvent $event){
        $player = $event->getPlayer();
        if($this->main->invInfo->canKeepInv($player)){
            $event->setKeepInventory(true);
        }
    }

    public function onEntityTeleport(EntityTeleportEvent $event) : void{
		$player = $event->getEntity();
		if($player instanceof Player){
            $from = $event->getFrom()->getWorld()->getFolderName();
            $to = $event->getTo()->getWorld()->getFolderName();
			
			if($from !== $to){

                $player->getInventory()->clearAll();
                
                if(!$this->main->worldInfo->isTpLobby($to))return;

                $this->main->invInfo->setPlayerItems($player, $to);
            }
        }
    }

    public function onUseItem(PlayerItemUseEvent $event){
        $playerName=$event->getPlayer()->getName();
        $player=$event->getPlayer();
        $itemName = $event->getItem()->getName();

        if(!$this->main->worldInfo->isInLobbyWorld($player))return;

        $world = $this->main->worldInfo->getLobbyWorld();

        $command = $this->main->invInfo->getItemCommand($itemName, $world);

        if($command=='error')return;

        $command = str_replace('{player}', $playerName, $command);

        $this->main->getServer()->dispatchCommand(new ConsoleCommandSender($this->main->getServer(), $this->main->getServer()->getLanguage()), $command);
    }   

    //This function is better for mobile devices
    public function onInteract(PlayerInteractEvent $event){
        $playerName=$event->getPlayer()->getName();
        $player=$event->getPlayer();
        $itemName = $event->getItem()->getName();

        if(!$this->main->worldInfo->isInLobbyWorld($player))return;

        $world = $this->main->worldInfo->getLobbyWorld();

        $command = $this->main->invInfo->getItemCommand($itemName, $world);

        if($command=='error')return;

        $command = str_replace('{player}', $playerName, $command);

        $this->main->getServer()->dispatchCommand(new ConsoleCommandSender($this->main->getServer(), $this->main->getServer()->getLanguage()), $command);
    }

}