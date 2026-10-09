<?php

declare(strict_types=1);

namespace NhanAZ\OpList;

final class Pagination {
	public static function parsePage(string $input, int $maxPage): ?int {
		$page = filter_var($input, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
		return $page !== false && $page <= $maxPage ? $page : null;
	}
}
