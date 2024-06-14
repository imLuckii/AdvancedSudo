<?php

namespace imLuckii\AdvancedSudo\commands;

use imLuckii\AdvancedSudo\Loader;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginOwned;

class SudoCommand extends Command implements PluginOwned
{
    private $blacklist;

    public function __construct(Loader $plugin)
    {
        parent::__construct("sudo", "Send a message as another player", null, []);
        $this->setPermission("advancedsudo.command.sudo");

        $this->blacklist = array_map('trim', explode(',', $plugin->getConfig()->get('blacklist', '')));
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) < 2) {
            $sender->sendMessage(TextFormat::RED . "Usage: /sudo <player> <message>");
            return false;
        }

        $playerName = $args[0];
        $player = null;

        if ($this->getOwningPlugin()->getConfig()->get("partial_username")) {
            if (strlen($playerName) < $this->getOwningPlugin()->getConfig()->get("partial-username-min")) {
                $sender->sendMessage(TextFormat::RED . "Player name must be at least " . $this->getOwningPlugin()->getConfig()->get("partial-username-min") . " characters long");
                return false;
            }
            $player = $this->getOwningPlugin()->getServer()->getPlayerByPrefix($playerName);
        } else {
            $player = $this->getOwningPlugin()->getServer()->getPlayerExact($playerName);
        }

        if ($player instanceof Player) {
            // Check if the player is blacklisted
            if (in_array($player->getName(), $this->blacklist)) {
                $sender->sendMessage(TextFormat::RED . "You cannot sudo this player");
                return false;
            }

            $message = implode(" ", array_slice($args, 1));
            $player->chat($message);
            $sender->sendMessage(TextFormat::GREEN . "Message sent as " . TextFormat::WHITE . $player->getName());
        } else {
            $sender->sendMessage(TextFormat::RED . "That player cannot be found");
        }
        return true;
    }

    public function getOwningPlugin(): Loader
    {
        return Loader::getInstance();
    }
}
