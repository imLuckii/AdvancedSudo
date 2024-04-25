<?php

namespace imlucki\commands;

use imlucki\Loader;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class SudoCommand extends Command
{
    private $plugin;

    public function __construct(Loader $plugin)
    {
        parent::__construct("sudo", "Send a message as another player", null, []);
        $this->plugin = $plugin;
        $this->setPermission("sudo.command");
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

        $player = null;
        if ($this->plugin->getConfig()->get("partial_username")) {
            if (strlen($args[0]) < 3) {
                $sender->sendMessage(TextFormat::RED . "Player name must be at least 3 characters long");
                return false;
            }
            $player = $this->plugin->getServer()->getPlayerByPrefix($args[0]);
        } else {
            $player = $this->plugin->getServer()->getPlayerExact($args[0]);
        }

        if ($player instanceof Player) {
            $message = implode(" ", array_slice($args, 1));
            $player->chat($message);
            $sender->sendMessage(TextFormat::GREEN . "Message sent as " . TextFormat::WHITE . $player->getName());
        } else {
            $sender->sendMessage(TextFormat::RED . "That player cannot be found");
        }
        return true;
    }
}
