<?php

declare(strict_types=1);

require dirname(__DIR__) . "/src/Pagination.php";

use NhanAZ\OpList\Pagination;

$cases = [
	["1", 3, 1],
	["3", 3, 3],
	["4", 3, null],
	["0", 3, null],
	["-1", 3, null],
	["abc", 3, null],
	["1.5", 3, null],
	["", 3, null],
	["999999999999999999999999999999", 3, null],
];

foreach ($cases as [$input, $maxPage, $expected]) {
	if (Pagination::parsePage($input, $maxPage) !== $expected) {
		throw new RuntimeException("Unexpected page result for '$input'.");
	}
}

echo "PASS: 9 pagination cases\n";
