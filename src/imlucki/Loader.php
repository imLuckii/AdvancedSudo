<?php

declare(strict_types=1);

namespace imlucki;

use pocketmine\plugin\PluginBase;
use imlucki\commands\SudoCommand;
use imlucki\commands\SudoAllCommand;

class Loader extends PluginBase
{

    protected function onEnable(): void
    {
        $this->getServer()->getCommandMap()->register("sudo", new SudoCommand($this));
        $this->getServer()->getCommandMap()->register("sudoall", new SudoAllCommand($this));
    }
}
