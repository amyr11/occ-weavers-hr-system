<?php

namespace App\Utils;

use Alkoumi\LaravelHijriDate\Hijri;
use Carbon\Carbon;
use DateTime;
use Remls\HijriDate\HijriDate;

class HijriUtil
{
	// Based on this converter online: https://beseyat.com/calendars/en/date-converter-hijri-gregorian.php

	/**
	 * Parse Hijri date string to Gregorian date.
	 * 
	 * @param string $hijriDate
	 * Format: "yyyy-mm-dd"
	 * @return DateTime
	 */
	public static function toGregorian(string $hijriDate): DateTime
	{
		$hijriDate = HijriDate::parse($hijriDate);
		$gregorianString = Hijri::DateToGregorianFromDMY($hijriDate->format('d'), $hijriDate->format('m'), $hijriDate->format('Y'));
		$gregorianDate = DateTime::createFromFormat('Y/m/d', $gregorianString);

		return $gregorianDate;
	}

	/**
	 * Convert Gregorian date to Hijri date.
	 * 
	 * @param Carbon|string $gregorianDate
	 * @return HijriDate
	 */
	public static function toHijri(Carbon|string $gregorianDate): HijriDate
	{
		$hijriDate = HijriDate::createFromGregorian($gregorianDate);

		return $hijriDate;
	}
}
