<?php

declare(strict_types=1);

namespace NhanAZ\OpList;

use InvalidArgumentException;
use pocketmine\utils\Config;

final class OpListSettings {
	public function __construct(
		public readonly string $opListTag,
		public readonly string $opListFormat,
		public readonly string $onlineStatusTag,
		public readonly string $offlineStatusTag,
		public readonly string $pageNotFound,
		public readonly string $noOperator,
		public readonly string $endPage,
		public readonly int $perPage
	) {
	}

	public static function fromConfig(Config $config): self {
		$messages = [];
		foreach (["opListTag", "opListFormat", "onlineStatusTag", "offlineStatusTag", "pageNotFound", "noOperator", "endPage"] as $key) {
			$value = $config->get($key);
			if (!is_string($value)) {
				throw new InvalidArgumentException("Configuration value '$key' must be a string.");
			}
			$messages[$key] = $value;
		}

		$perPage = $config->get("perPage");
		if (!is_int($perPage) || $perPage < 1) {
			throw new InvalidArgumentException("Configuration value 'perPage' must be a positive integer.");
		}

		return new self(
			$messages["opListTag"],
			$messages["opListFormat"],
			$messages["onlineStatusTag"],
			$messages["offlineStatusTag"],
			$messages["pageNotFound"],
			$messages["noOperator"],
			$messages["endPage"],
			$perPage
		);
	}
}
