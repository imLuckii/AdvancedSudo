<?php

namespace imlucki\commands;

use imlucki\Loader;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat;

class SudoAllCommand extends Command
{
    private $plugin;

    public function __construct(Loader $plugin)
    {
        parent::__construct("sudoall", "Send a message as all players", null, ["sa"]);
        $this->plugin = $plugin;
        $this->setPermission("sudoall.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) < 1) {
            $sender->sendMessage(TextFormat::RED . "Usage: /sudoall <message>");
            return false;
        }

        $message = implode(" ", $args);

        $onlinePlayers = $this->getOnlinePlayers($sender);
        if (empty($onlinePlayers)) {
            $sender->sendMessage(TextFormat::RED . "No one is online");
            return true;
        }

        foreach ($onlinePlayers as $player) {
            $player->chat($message);
        }

        $sender->sendMessage(TextFormat::GREEN . "Message sent as all online players");

        return true;
    }

    private function getOnlinePlayers(CommandSender $sender): array
    {
        $onlinePlayers = [];
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            if ($player->getName() !== $sender->getName()) {
                $onlinePlayers[] = $player;
            }
        }
        return $onlinePlayers;
    }
}