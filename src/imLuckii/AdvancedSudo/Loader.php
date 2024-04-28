<?php

declare(strict_types=1);

namespace imLuckii\AdvancedSudo;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use imLuckii\AdvancedSudo\commands\SudoCommand;
use imLuckii\AdvancedSudo\commands\SudoAllCommand;

class Loader extends PluginBase
{
    use SingletonTrait;

    protected function onEnable(): void
    {
        self::setInstance($this);
        $this->getServer()->getCommandMap()->register("AdvancedSudo", new SudoCommand($this));
        $this->getServer()->getCommandMap()->register("AdvancedSudo", new SudoAllCommand($this));
    }

    public static function getInstance(): ?self
    {
        return self::$instance ?? null;
    }
}
