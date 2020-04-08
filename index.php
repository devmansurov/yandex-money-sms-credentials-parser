<?php

/**
 * Yandex Money SMS credentials parser.
 *
 * @param  string  $message
 * @return array
 */

function parseYandexMoneySMS(string $message) :array 
{
	// Get confirm code from string
	$confirmCodeRegex = '/(?<![\d.,])\d{4,6}(?![\d.,])/m';
	preg_match_all($confirmCodeRegex, $message, $confirmCodeMatches, PREG_SET_ORDER, 0);

	[$confirmCode] = count($confirmCodeMatches) ? reset($confirmCodeMatches) : null;

	// Get amount from string
	$amountRegex = '/\d+[.,]\d+/m';
	preg_match_all($amountRegex, $message, $amountMatches, PREG_SET_ORDER, 0);

	[$amount] = count($amountMatches) ? reset($amountMatches) : null;

	// Get wallet number from string
	$walletNumberRegex = '/[0-9]{13,15}/m';
	preg_match_all($walletNumberRegex, $message, $walletNumberMatches, PREG_SET_ORDER, 0);

	[$walletNumber] = count($walletNumberMatches) ? reset($walletNumberMatches) : null;

	// Return result data
	$data = [
		'confirmCode' => $confirmCode,
		'amount' => $amount,
		'walletNumber' => $walletNumber
	];

	return $data;
}

$message = "Пароль: 6105 Спишется 1507,54р. Перевод на счет 410017866772740";
$result = parseYandexMoneySMS($message);

print_r($result); // Array ( [confirmCode] => 6105 [amount] => 1507,54 [walletNumber] => 410017866772740 )
