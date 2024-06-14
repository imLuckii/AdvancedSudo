<?php

declare(strict_types=1);

namespace imLuckii\AdvancedSudo;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use imLuckii\AdvancedSudo\commands\SudoCommand;
use imLuckii\AdvancedSudo\commands\SudoAllCommand;
use pocketmine\utils\Config;

class Loader extends PluginBase
{
    use SingletonTrait;
    private const CURRENT_CONFIG_VERSION = "1.0";
    private Config $config;

    protected function onEnable(): void
    {
        self::setInstance($this);
        $this->checkAndUpdateConfig();
        $this->getServer()->getCommandMap()->register("AdvancedSudo", new SudoCommand($this));
        $this->getServer()->getCommandMap()->register("AdvancedSudo", new SudoAllCommand($this));
    }

    public static function getInstance(): ?self
    {
        return self::$instance ?? null;
    }

    private function checkAndUpdateConfig(): void
    {
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();

        // Check the config version
        $configVersion = $this->config->get("config-version", "");
        if ($configVersion !== self::CURRENT_CONFIG_VERSION) {
            $this->getLogger()->warning("Config version mismatch or missing. Updating to the latest config.");
            $this->replaceConfigWithDefault();
        }
    }

    private function replaceConfigWithDefault(): void
    {
        $configFile = $this->getDataFolder() . "config.yml";

        // Backup the old config if it exists
        if (file_exists($configFile)) {
            $backupFile = $this->getDataFolder() . "config-backup.yml";
            copy($configFile, $backupFile);
        }

        // Save the default config from the resources
        $this->saveResource("config.yml", true);

        // Reload the updated config
        $this->reloadConfig();
        $this->config = $this->getConfig();
    }
}
