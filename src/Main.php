<?php

declare(strict_types=1);

namespace NhanAZ\OpList;

use InvalidArgumentException;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;

final class Main extends PluginBase {
	private ?OpListSettings $settings = null;

	protected function onEnable(): void {
		$this->saveDefaultConfig();
		try {
			$this->settings = OpListSettings::fromConfig($this->getConfig());
		} catch (InvalidArgumentException $error) {
			$this->getLogger()->error($error->getMessage());
		}
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
		if ($command->getName() === "oplist") {
			if ($this->settings === null) {
				$sender->sendMessage("OpList configuration is invalid. Check the server log.");
				return true;
			}
			(new OpManager($this->getServer(), $this->settings))->sendOpList($sender, $args[0] ?? "1");
		}
		return true;
	}
}
