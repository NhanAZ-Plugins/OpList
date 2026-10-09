<?php

declare(strict_types=1);

namespace NhanAZ\OpList;

use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

final class OpManager {
	public function __construct(private Server $server, private OpListSettings $settings) {
	}

	/** @return list<string> */
	private function getOpList(): array {
		$names = [];
		foreach (array_keys($this->server->getOps()->getAll()) as $name) {
			if (is_string($name)) {
				$names[] = $name;
			}
		}
		return $names;
	}

	private function isOnline(string $name): bool {
		return $this->server->getPlayerExact($name) !== null;
	}

	/** @param list<string> $ops */
	private function getOpsOnline(array $ops): int {
		$count = 0;
		foreach ($ops as $name) {
			if ($this->isOnline($name)) {
				++$count;
			}
		}
		return $count;
	}

	public function sendOpList(CommandSender $sender, string $pageArgument): void {
		$ops = $this->getOpList();
		if ($ops === []) {
			$sender->sendMessage(TextFormat::colorize($this->settings->noOperator));
			return;
		}

		$maxPage = intdiv(count($ops) - 1, $this->settings->perPage) + 1;
		$page = Pagination::parsePage($pageArgument, $maxPage);
		if ($page === null) {
			$sender->sendMessage(TextFormat::colorize($this->settings->pageNotFound));
			return;
		}

		$header = strtr($this->settings->opListTag, [
			"{page}" => (string) $page,
			"{maxPage}" => (string) $maxPage,
			"{totalOpsOnline}" => (string) $this->getOpsOnline($ops),
		]);
		$sender->sendMessage(TextFormat::colorize($header));

		$start = ($page - 1) * $this->settings->perPage;
		foreach (array_slice($ops, $start, $this->settings->perPage) as $offset => $name) {
			$line = strtr($this->settings->opListFormat, [
				"{numericalOrder}" => (string) ($start + $offset + 1),
				"{opName}" => $name,
				"{onlineStatus}" => $this->isOnline($name) ? $this->settings->onlineStatusTag : $this->settings->offlineStatusTag,
			]);
			$sender->sendMessage(TextFormat::colorize($line));
		}

		if ($this->settings->endPage !== "") {
			$sender->sendMessage(TextFormat::colorize($this->settings->endPage));
		}
	}
}
