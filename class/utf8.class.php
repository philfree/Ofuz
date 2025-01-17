<?php

/**
  * UTF-8 friendly replacement functions - v0.2
  * Copyright (C) 2004-2006 Niels Leenheer & Andy Matsubara
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2
  * of the License, or (at your option) any later version.
  *
  *	Supported functions:
  * - utf8::convert()
  * - utf8::detect()
  * - utf8::strtolower()
  * - utf8::strtoupper()
  * - utf8::strlen()
  * - utf8::strwidth()
  * - utf8::substr()
  * - utf8::strimwidth()
  * - utf8::strcut()
  * - utf8::strrpos()
  * - utf8::strpos()
  * - utf8::substr_count()
  * - utf8::encode_mimeheader()
  * - utf8::send_mail()
  * - utf8::encode_javascript()
  * - utf8::encode_numericentity()
  *
  * @package core
  */

// force UTF-8 �?

$_zp_UTF8 = new utf8();

class utf8 {
	/**
	 * Character set translation support
	 *
	 * @return utf8
	 */
	
	var $charsets;
	var $validsets;
	var $mb_sets;
	var $iconv_sets;
	
	function utf8() {
		$this->charsets = array(	"ASMO-708" => "Arabic",
															"BIG5" => "Chinese Traditional",
															"CP1026" => "IBM EBCDIC (Turkish Latin-5)",
															"cp866" => "Cyrillic (DOS)",
															"CP870" => "IBM EBCDIC (Multilingual Latin-2)",
															"CISO2022JP" => "Japanese (JIS-Allow 1 byte Kana)",
															"DOS-720" => "Arabic (DOS)",
															"DOS-862" => "Hebrew (DOS)",
															"EBCDIC-CP-US" => "IBM EBCDIC (US-Canada)",
															"EUC-CN" => "Chinese Simplified (EUC)",
															"EUC-JP" => "Japanese (EUC)",
															"EUC-KR" => "Korean (EUC)",
															"GB2312" => "Chinese Simplified (GB2312)",
															"HZ-GB-2312" => "Chinese Simplified (HZ)",
															"IBM437" => "OEM United States",
															"IBM737" => "Greek (DOS)",
															"IBM775" => "Baltic (DOS)",
															"IBM850" => "Western European (DOS)",
															"IBM852" => "Central European (DOS)",
															"IBM857" => "Turkish (DOS)",
															"IBM861" => "Icelandic (DOS)",
															"IBM869" => "Greek, Modern (DOS)",
															"ISO-2022-JP" => "Japanese (JIS)",
															"ISO-2022-JP" => "Japanese (JIS-Allow 1 byte Kana - SO/SI)",
															"ISO-2022-KR" => "Korean (ISO)",
															"ISO-8859-1" => "Western European (ISO)",
															"ISO-8859-15" => "Latin 9 (ISO)",
															"ISO-8859-2" => "Central European (ISO)",
															"ISO-8859-3" => "Latin 3 (ISO)",
															"ISO-8859-4" => "Baltic (ISO)",
															"ISO-8859-5" => "Cyrillic (ISO)",
															"ISO-8859-6" => "Arabic (ISO)",
															"ISO-8859-7" => "Greek (ISO)",
															"ISO-8859-8" => "Hebrew (ISO-Visual)",
															"ISO-8859-8-i" => "Hebrew (ISO-Logical)",
															"ISO-8859-9" => "Turkish (ISO)",
															"JOHAB" => "Korean (Johab)",
															"KOi8-R" => "Cyrillic (KOI8-R)",
															"KOi8-U" => "Cyrillic (KOI8-U)",
															"KS_C_5601-1987" => "Korean",
															"MACINTOSH" => "Western European (MAC)",
															"SHIFT_JIS" => "Japanese (Shift-JIS)",
															"UNICODE" => "Unicode",
															"UNICODEFFFE" => "Unicode (Big-Endian)",
															"US-ASCII" => "US-ASCII",
															"UTF-7" => "Unicode (UTF-7)",
															"UTF-8" => "Unicode (UTF-8)",
															"WINDOWS-1250" => "Central European (Windows)",
															"WINDOWS-1251" => "Cyrillic (Windows)",
															"WINDOWS-1252" => "Western European (Windows)",
															"WINDOWS-1253" => "Greek (Windows)",
															"WINDOWS-1254" => "Turkish (Windows)",
															"WINDOWS-1255" => "Hebrew (Windows)",
															"WINDOWS-1256" => "Arabic (Windows)",
															"WINDOWS-1257" => "Baltic (Windows)",
															"WINDOWS-1258" => "Vietnamese (Windows)",
															"WINDOWS-874" => "Thai (Windows)",
															"X-CHINESE-CNS" => "Chinese Traditional (CNS)",
															"X-CHINESE-ETEN" => "Chinese Traditional (Eten)",
															"X-EBCDIC-Arabic" => "IBM EBCDIC (Arabic)",
															"X-EBCDIC-CP-US-EURO" => "IBM EBCDIC (US-Canada-Euro)",
															"X-EBCDIC-CYRILLICRUSSIAN" => "IBM EBCDIC (Cyrillic Russian)",
															"X-EBCDIC-CYRILLICSERBIANBULGARIAN" => "IBM EBCDIC (Cyrillic Serbian-Bulgarian)",
															"X-EBCDIC-DENMARKNORWAY" => "IBM EBCDIC (Denmark-Norway)",
															"X-EBCDIC-DENMARKNORWAY-euro" => "IBM EBCDIC (Denmark-Norway-Euro)",
															"X-EBCDIC-FINLANDSWEDEN" => "IBM EBCDIC (Finland-Sweden)",
															"X-EBCDIC-FINLANDSWEDEN-EURO" => "IBM EBCDIC (Finland-Sweden-Euro)",
															"X-EBCDIC-FINLANDSWEDEN-EURO" => "IBM EBCDIC (Finland-Sweden-Euro)",
															"X-EBCDIC-FRANCE-EURO" => "IBM EBCDIC (France-Euro)",
															"X-EBCDIC-GERMANY" => "IBM EBCDIC (Germany)",
															"X-EBCDIC-GERMANY-EURO" => "IBM EBCDIC (Germany-Euro)",
															"X-EBCDIC-GREEK" => "IBM EBCDIC (Greek)",
															"X-EBCDIC-GREEKMODERN" => "IBM EBCDIC (Greek Modern)",
															"X-EBCDIC-HEBREW" => "IBM EBCDIC (Hebrew)",
															"X-EBCDIC-ICELANDIC" => "IBM EBCDIC (Icelandic)",
															"X-EBCDIC-ICELANDIC-EURO" => "IBM EBCDIC (Icelandic-Euro)",
															"X-EBCDIC-INTERNATIONAL-EURO" => "IBM EBCDIC (International-Euro)",
															"X-EBCDIC-ITALY" => "IBM EBCDIC (Italy)",
															"X-EBCDIC-ITALY-EURO" => "IBM EBCDIC (Italy-Euro)",
															"X-EBCDIC-JAPANESEANDJAPANESELATIN" => "IBM EBCDIC (Japanese and Japanese-Latin)",
															"X-EBCDIC-JAPANESEANDKANA" => "IBM EBCDIC (Japanese and Japanese Katakana)",
															"X-EBCDIC-JAPANESEANDUSCANADA" => "IBM EBCDIC (Japanese and US-Canada)",
															"X-EBCDIC-JAPANESEKATAKANA" => "IBM EBCDIC (Japanese katakana)",
															"X-EBCDIC-KOREANANDKOREANEXTENDED" => "IBM EBCDIC (Korean and Korean EXtended)",
															"X-EBCDIC-KOREANEXTENDED" => "IBM EBCDIC (Korean EXtended)",
															"X-EBCDIC-SIMPLIFIEDCHINESE" => "IBM EBCDIC (Simplified Chinese)",
															"X-EBCDIC-SPAIN" => "IBM EBCDIC (Spain)",
															"X-ebcdic-SPAIN-EURO" => "IBM EBCDIC (Spain-Euro)",
															"X-EBCDIC-THAI" => "IBM EBCDIC (Thai)",
															"X-EBCDIC-TRADITIONALCHINESE" => "IBM EBCDIC (Traditional Chinese)",
															"X-EBCDIC-TURKISH" => "IBM EBCDIC (Turkish)",
															"X-EBCDIC-UK" => "IBM EBCDIC (UK)",
															"X-EBCDIC-UK-EURO" => "IBM EBCDIC (UK-Euro)",
															"X-EUROPA" => "Europa",
															"X-IA5" => "Western European (IA5)",
															"X-IA5-GERMAN" => "German (IA5)",
															"X-IA5-NORWEGIAN" => "Norwegian (IA5)",
															"X-IA5-SWEDISH" => "Swedish (IA5)",
															"X-ISCII-AS" => "ISCII Assamese",
															"X-ISCII-BE" => "ISCII Bengali",
															"X-ISCII-DE" => "ISCII Devanagari",
															"X-ISCII-GU" => "ISCII Gujarathi",
															"X-ISCII-KA" => "ISCII Kannada",
															"X-ISCII-MA" => "ISCII Malayalam",
															"X-ISCII-OR" => "ISCII Oriya",
															"X-ISCII-PA" => "ISCII Panjabi",
															"X-ISCII-TA" => "ISCII Tamil",
															"X-ISCII-TE" => "ISCII Telugu",
															"X-MAC-ARABIC" => "Arabic (Mac)",
															"X-MAC-CE" => "Central European (Mac)",
															"X-MAC-CHINESESIMP" => "Chinese Simplified (Mac)",
															"X-MAC-CHINESETRAD" => "Chinese Traditional (Mac)",
															"X-MAC-CYRILLIC" => "Cyrillic (Mac)",
															"X-MAC-GREEK" => "Greek (Mac)",
															"X-MAC-HEBREW" => "Hebrew (Mac)",
															"X-MAC-ICELANDIC" => "Icelandic (Mac)",
															"X-MAC-JAPANESE" => "Japanese (Mac)",
															"X-MAC-KOREAN" => "Korean (Mac)",
															"X-MAC-TURKISH" => "Turkish (Mac)"
															);
		// prune the list to supported character sets
		if (function_exists('mb_convert_encoding')) {
			$list = mb_list_encodings();
			foreach ($this->charsets as $key=>$encoding) {
				if (in_array($key, $list)) {
					$this->mb_sets[$key] = $encoding;
				}
			}
		}
		if (function_exists('iconv')) {
			foreach ($this->charsets as $key=>$encoding) {
				if (@iconv("UTF-8", $key, " ")!==false) {
					$this->iconv_sets[$key] = $encoding;
				}
			}
		}
		$this->validsets = array_merge($this->mb_sets, $this->iconv_sets);
	}

	/**
	 * Convert a foreign charset encoding from or to UTF-8
	 */
	function convert($string, $encoding = '', $destination = 'UTF-8') {
		if ($encoding == '') $encoding = utf8::detect($string);
		if ($encoding == $destination) return $string; 
		
		$encode_mb = array_key_exists($encoding, $this->mb_sets);
		$encode_iconv = array_key_exists($encoding, $this->iconv_sets);
		$dest_mb = array_key_exists($destination, $this->mb_sets);
		$dest_iconv = array_key_exists($destination, $this->iconv_sets);
		
		if ($encode_mb && $dest_mb) {
			@mb_substitute_character('none');
			return @mb_convert_encoding($string, $destination, $encoding );
		}
		if ($encode_iconv && $dest_iconv) {
			return @iconv($encoding, $destination . '//IGNORE', $string);
		}
		// must use mixed conversion
		@mb_substitute_character('none');
		if ($encode_mb) {
			$instring = @mb_convert_encoding($string, 'UTF-8', $encoding);
		} else if ($encode_iconv) {
			$instring = @iconv($encoding, 'UTF-8' . '//IGNORE', $string);
		} else  {
			$instring = $string;
		}
		if ($dest_mb) {
			$outstring = @mb_convert_encoding($string, $destination, 'UTF-8');
		} else if ($dest_iconv) {
			$outstring = @iconv('UTF-8', $destination . '//IGNORE', $string);
		} else {
			$outstring = $string;
		}
		return $outstring;
	}

	/**
	 * Detect the encoding of the string
	 */
	function detect($string) {
		if (function_exists('mb_detect_encoding')) return mb_detect_encoding($string);
		if (!ereg("[\x80-\xFF]", $string) && !ereg("\x1B", $string))
			return 'US-ASCII';

		if (!ereg("[\x80-\xFF]", $string) && ereg("\x1B", $string))
			return 'ISO-2022-JP';

		if (preg_match("/^([\x01-\x7F]|[\xC0-\xDF][\x80-\xBF]|[\xE0-\xEF][\x80-\xBF][\x80-\xBF])+$/", $string) == 1)
			return 'UTF-8';

		if (preg_match("/^([\x01-\x7F]|\x8E[\xA0-\xDF]|\x8F[xA1-\xFE][\xA1-\xFE]|[\xA1-\xFE][\xA1-\xFE])+$/", $string) == 1)
			return 'EUC-JP';

		if (preg_match("/^([\x01-\x7F]|[\xA0-\xDF]|[\x81-\xFC][\x40-\xFC])+$/", $string) == 1)
			return 'Shift_JIS';

		return 'ISO-8859-1';
	}


	/**
	 * Determine the number of characters of a string
	 * Compatible with mb_strlen(), an UTF-8 friendly replacement for strlen()
	 */
	function strlen($str) {
		return preg_match_all('/[\x01-\x7F]|[\xC0-\xDF][\x80-\xBF]|[\xE0-\xEF][\x80-\xBF][\x80-\xBF]/', $str, $arr);
	}

	/**
	 * Count the number of substring occurances
	 * Compatible with mb_substr_count(), an UTF-8 friendly replacement for substr_count()
	 */
	function substr_count($haystack, $needle) {
		return substr_count($haystack, $needle);
	}

	/**
	 * Return part of a string, length and offset in characters
	 * Compatible with mb_substr(), an UTF-8 friendly replacement for substr()
	 */
	function substr($str, $start , $length = NULL) {
		preg_match_all('/[\x01-\x7F]|[\xC0-\xDF][\x80-\xBF]|[\xE0-\xEF][\x80-\xBF][\x80-\xBF]/', $str, $arr);

		if (is_int($length))
			return implode('', array_slice($arr[0], $start, $length));
		else
			return implode('', array_slice($arr[0], $start));
	}

	/**
	 * Return part of a string, length and offset in bytes
	 * Compatible with mb_strcut()
	 */
	function strcut($str, $start, $length = NULL) {
		if ($start < 0)	$start += strlen($str);
		$original = $start;
		while ($start > 0 && intval(ord($str[$start]) & 0xC0) == 0x80)
			$start--;

		$start = max($start, 0);
		$original = max($original, 0);

		if ($start < strlen($str))
		{
			if (is_null($length)) {
				return substr($str, $start);
			}
			elseif ($length > 0) {
				$end = $start + $length;

				while ($end > 0 && intval(ord($str[$end]) & 0xC0) == 0x80)
					$end--;

				return substr($str, $start, $end - $start);
			}
			elseif ($length < 0) {
				$end = strlen($str) + $length - ($original - $start);

				while ($end > 0 && intval(ord($str[$end]) & 0xC0) == 0x80)
					$end--;

				if ($end > 0)
					return substr($str, $start, $end - $start);
			}
		}

		return '';
	}

	/**
	 * Determine the width of a string
	 * Compatible with mb_strwidth()
	 */
	function strwidth($str) {
		$double = preg_match_all('/[\xE2-\xEF][\x80-\xBF][\x80-\xBF]/', $str, $arr) - 			// U+2000 - U+FFFF = double width
				  preg_match_all('/\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F]/', $str, $arr);		// U+FF61 - U+FF9F = single width
		$null   = preg_match_all('/[\x00-\x19]/', $str, $arr);									// U+0000 - U+0019 = no width

		return UTF8::strlen($str) - $null + $double;
	}

	/**
	 * Get truncated string with specified width
	 * Compatible with mb_strimwidth()
	 */
	function strimwidth($str, $start, $width, $trimmarker = '') {

		$str   = UTF8::substr($str, $start);
		$width = $width - UTF8::strwidth($trimmarker);

		for ($i = 0; $i < strlen($str); $i++)
		{
			$b1 = (int)ord($str[$i]);

			if ($b1 < 0x80 || $b1 > 0xBF)
			{
				$c++;

				if ($b1 > 0xE2)
				{
					$b2 = (int)ord($str[$i + 1]);
					$b3 = (int)ord($str[$i + 2]);

					if (($b2 == 0xBD && $b3 >= 0xA1) || ($b2 == 0xBE && $b3 <= 0x9F))
						$count++;
					else
						$count = $count + 2;
				}
				else
					$count++;
			}

			if ($count > $width) {
				return UTF8::substr($str, 0, $c - 1) . $trimmarker;
			}
		}
	}

	/**
	 * Find position of last occurance of a string in another string
	 * Compatible with mb_strrpos(), an UTF-8 friendly replacement for strrpos()
	 */
	function strrpos($haystack, $needle) {
		$pos = strrpos($haystack, $needle);

		if ($pos === false)
			return false;
		else
			return UTF8::strlen(substr($haystack, 0, $pos));
	}

	/**
	 * Find position of first occurance of a string in another string
	 * Compatible with mb_strpos(), an UTF-8 friendly replacement for strpos()
	 */
	function strpos($haystack, $needle, $offset = 0) {
		$comp = 0;

		while (!isset($length) || $length < $offset)
		{
			$pos = strpos($haystack, $needle, $offset + $comp);
			if ($pos === false) return false;
			$length = utf_strlen(substr($haystack, 0, $pos));
			if ($length < $offset) $comp = $pos - $length;
		}

		return $length;
	}

	/**
	 * Convert a string to lower case
	 * Compatible with mb_strtolower(), an UTF-8 friendly replacement for strtolower()
	 */
	function strtolower($str) {
		global $UTF8_TABLES;
		return strtr($str, $UTF8_TABLES['strtolower']);
	}

	/**
	 * Convert a string to upper case
	 * Compatible with mb_strtoupper(), an UTF-8 friendly replacement for strtoupper()
	 */
	function strtoupper($str) {
		global $UTF8_TABLES;
		return strtr($str, $UTF8_TABLES['strtoupper']);
	}

	/**
	 * Encode a string for use in a MIME header
	 * Simplied replacement for mb_encode_mimeheader()
	 */
	function encode_mimeheader($str) {
		$length = 45; $pos = 0; $max = strlen($str);
    $buffer = '';
		while ($pos < $max)
		{
			if ($pos + $length < $max)
			{
				$adjust = 0;

				while (intval(ord($str[$pos + $length + $adjust]) & 0xC0) == 0x80)
					$adjust--;

				$buffer .= ($buffer == '' ? '' : "?=\n =?UTF-8?B?") . base64_encode(substr($str, $pos, $length + $adjust));
				$pos = $pos + $length + $adjust;
			}
			else
			{
				$buffer .= ($buffer == '' ? '' : "?=\n =?UTF-8?B?") . base64_encode(substr($str, $pos));
				$pos = $max;
			}
		}

		return '=?UTF-8?B?' . $buffer . '?=';
	}

	/**
	 * Send mail
	 * Replacement for mb_send_mail(), an UTF-8 friendly replacement for mail()
	 */
	function send_mail($to, $subject, $message , $additional_headers = '', $additional_parameter = '') {
		$subject = UTF8::encode_mimeheader($subject);
		$message = chunk_split(base64_encode($message));

		$additional_headers = trim($additional_headers);

		if ($additional_headers != '')
			$additional_headers .= "\n";

		$additional_headers .=
			"Mime-Version: 1.0\n" .
			"Content-Type: text/plain; charset=UTF-8\n" .
			"Content-Transfer-Encoding: base64";

		if(ini_get('safe_mode')) 
		{
			@mail($to, $subject, $message, $additional_headers); 
		}
		else
		{
			@mail($to, $subject, $message, $additional_headers, $additional_parameter);
		}
	}

	/**
	 * Prepare an UTF-8 string for use in JavaScript
	 */
	function encode_javascript($string)
	{
		$string = str_replace ('\\', '\\\\', $string);
		$string = str_replace ('"', '\\"', $string);
		$string = str_replace ("'", "\\'", $string);
		$string = str_replace ("\n", "\\n", $string);
		$string = str_replace ("\r", "\\r", $string);
		$string = str_replace ("\t", "\\t", $string);

		$len = strlen ($string);
		$pos = 0;
		$out = '';

		while ($pos < $len)
		{
			$ascii = ord (substr ($string, $pos, 1));

			if ($ascii >= 0xF0)
			{
				$byte[1] = ord(substr ($string, $pos, 1)) - 0xF0;
				$byte[2] = ord(substr ($string, $pos + 1, 1)) - 0x80;
				$byte[3] = ord(substr ($string, $pos + 2, 1)) - 0x80;
				$byte[4] = ord(substr ($string, $pos + 3, 1)) - 0x80;


				$char_code = ($byte[1] << 18) + ($byte[2] << 12) + ($byte[3] << 6) + $byte[4];
				$pos += 4;
			}
			elseif (($ascii >= 0xE0) && ($ascii < 0xF0))
			{
				$byte[1] = ord(substr ($string, $pos, 1)) - 0xE0;
				$byte[2] = ord(substr ($string, $pos + 1, 1)) - 0x80;
				$byte[3] = ord(substr ($string, $pos + 2, 1)) - 0x80;

				$char_code = ($byte[1] << 12) + ($byte[2] << 6) + $byte[3];
				$pos += 3;
			}
			elseif (($ascii >= 0xC0) && ($ascii < 0xE0))
			{
				$byte[1] = ord(substr ($string, $pos, 1)) - 0xC0;
				$byte[2] = ord(substr ($string, $pos + 1, 1)) - 0x80;

				$char_code = ($byte[1] << 6) + $byte[2];
				$pos += 2;
			}
			else
			{
				$char_code = ord(substr ($string, $pos, 1));
				$pos += 1;
			}

			if ($char_code < 0x80)
				$out .= chr($char_code);
			else
				$out .=  '\\u'. str_pad(dechex($char_code), 4, '0', STR_PAD_LEFT);
		}

		return $out;
	}

	/**
	 * Encode an UTF-8 string with numeric entities
	 * Simplied replacement for mb_encode_numericentity()
	 */
	function encode_numericentity($string)
	{
		$len = strlen ($string);
		$pos = 0;
		$out = '';

		while ($pos < $len)
		{
			$ascii = ord (substr ($string, $pos, 1));

			if ($ascii >= 0xF0)
			{
				$byte[1] = ord(substr ($string, $pos, 1)) - 0xF0;
				$byte[2] = ord(substr ($string, $pos + 1, 1)) - 0x80;
				$byte[3] = ord(substr ($string, $pos + 2, 1)) - 0x80;
				$byte[4] = ord(substr ($string, $pos + 3, 1)) - 0x80;

				$char_code = ($byte[1] << 18) + ($byte[2] << 12) + ($byte[3] << 6) + $byte[4];
				$pos += 4;
			}
			elseif (($ascii >= 0xE0) && ($ascii < 0xF0))
			{
				$byte[1] = ord(substr ($string, $pos, 1)) - 0xE0;
				$byte[2] = ord(substr ($string, $pos + 1, 1)) - 0x80;
				$byte[3] = ord(substr ($string, $pos + 2, 1)) - 0x80;

				$char_code = ($byte[1] << 12) + ($byte[2] << 6) + $byte[3];
				$pos += 3;
			}
			elseif (($ascii >= 0xC0) && ($ascii < 0xE0))
			{
				$byte[1] = ord(substr ($string, $pos, 1)) - 0xC0;
				$byte[2] = ord(substr ($string, $pos + 1, 1)) - 0x80;

				$char_code = ($byte[1] << 6) + $byte[2];
				$pos += 2;
			}
			else
			{
				$char_code = ord(substr ($string, $pos, 1));
				$pos += 1;
			}

			if ($char_code < 0x80)
				$out .= chr($char_code);
			else
				$out .=  '&#'. str_pad($char_code, 5, '0', STR_PAD_LEFT) . ';';
		}

		return $out;
	}
}

/*******************************************************************************************************/

global $UTF8_TABLES;

$UTF8_TABLES['strtolower'] = array(
"Ｚ"=>"�?","Ｙ"=>"�?","Ｘ"=>"�?","Ｗ"=>"�?","Ｖ"=>"�?","Ｕ"=>"�?",
"Ｔ"=>"�?","Ｓ"=>"�?","Ｒ"=>"�?","Ｑ"=>"�?","Ｐ"=>"ｐ","Ｏ"=>"ｏ",
"Ｎ"=>"�?","Ｍ"=>"ｍ","Ｌ"=>"�?","Ｋ"=>"�?","Ｊ"=>"�?","Ｉ"=>"�?",
"Ｈ"=>"�?","Ｇ"=>"�?","Ｆ"=>"�?","Ｅ"=>"�?","Ｄ"=>"�?","Ｃ"=>"�?",
"Ｂ"=>"�?","Ａ"=>"ａ","�?�"=>"å","�?�"=>"k","�?�"=>"�?","Ώ"=>"ώ",
"Ὼ"=>"ὼ","Ό"=>"ό","Ὸ"=>"ὸ","Ῥ"=>"ῥ","Ύ"=>"ύ","Ὺ"=>"ὺ",
"Ῡ"=>"ῡ","Ῠ"=>"� ","�?"=>"ί","�?"=>"ὶ","�?"=>"�?","�?"=>"ῐ",
"�?"=>"ή","�?"=>"ὴ","�?"=>"έ","�?"=>"ὲ","Ά"=>"ά","Ὰ"=>"ὰ",
"Ᾱ"=>"ᾱ","Ᾰ"=>"ᾰ","Ὧ"=>"ὧ","Ὦ"=>"ὦ","Ὥ"=>"ὥ","Ὤ"=>"ὤ",
"Ὣ"=>"ὣ","Ὢ"=>"ὢ","Ὡ"=>"ὡ","Ὠ"=>"� ","�?"=>"�?","Ὕ"=>"�?",
"�?"=>"�?","�?"=>"�?","Ὅ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"ὁ","�?"=>"�?","Ἷ"=>"ἷ","Ἶ"=>"ἶ","Ἵ"=>"ἵ","Ἴ"=>"ἴ",
"Ἳ"=>"ἳ","Ἲ"=>"ἲ","Ἱ"=>"ἱ","Ἰ"=>"ἰ","Ἧ"=>"ἧ","Ἦ"=>"ἦ",
"Ἥ"=>"ἥ","Ἤ"=>"ἤ","Ἣ"=>"ἣ","Ἢ"=>"ἢ","Ἡ"=>"ἡ","Ἠ"=>"� ",
"Ἕ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"ἐ",
"Ἇ"=>"�?","�?"=>"�?","Ἅ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"ἁ","�?"=>"�?","Ỹ"=>"ỹ","Ỷ"=>"ỷ","Ỵ"=>"ỵ","Ỳ"=>"ỳ",
"Ự"=>"ự","Ữ"=>"ữ","Ử"=>"ử","Ừ"=>"ừ","Ứ"=>"ứ","Ủ"=>"ủ",
"Ụ"=>"ụ","Ợ"=>"ợ","� "=>"ỡ","�?"=>"�?","�?"=>"ờ","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","Ố"=>"�?","�?"=>"ỏ",
"�?"=>"ọ","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"ề","Ế"=>"ế","Ẽ"=>"ẽ","Ẻ"=>"ẻ","Ẹ"=>"ẹ","Ặ"=>"ặ",
"Ẵ"=>"ẵ","Ẳ"=>"ẳ","Ằ"=>"ằ","Ắ"=>"ắ","Ậ"=>"ậ","Ẫ"=>"ẫ",
"Ẩ"=>"ẩ","Ầ"=>"ầ","Ấ"=>"ấ","Ả"=>"ả","� "=>"ạ","�?"=>"�?",
"�?"=>"�?","Ẑ"=>"�?","�?"=>"ẏ","�?"=>"ẍ","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"ẁ","Ṿ"=>"ṿ","Ṽ"=>"ṽ",
"Ṻ"=>"ṻ","Ṹ"=>"ṹ","Ṷ"=>"ṷ","Ṵ"=>"ṵ","Ṳ"=>"ṳ","Ṱ"=>"ṱ",
"Ṯ"=>"ṯ","Ṭ"=>"ṭ","Ṫ"=>"ṫ","Ṩ"=>"ṩ","Ṧ"=>"ṧ","Ṥ"=>"ṥ",
"Ṣ"=>"ṣ","� "=>"ṡ","�?"=>"�?","�?"=>"ṝ","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","Ṑ"=>"�?","�?"=>"ṏ","�?"=>"ṍ",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"ṁ",
"Ḿ"=>"ḿ","Ḽ"=>"ḽ","Ḻ"=>"ḻ","Ḹ"=>"ḹ","Ḷ"=>"ḷ","Ḵ"=>"ḵ",
"Ḳ"=>"ḳ","Ḱ"=>"ḱ","Ḯ"=>"ḯ","Ḭ"=>"ḭ","Ḫ"=>"ḫ","Ḩ"=>"ḩ",
"Ḧ"=>"ḧ","Ḥ"=>"ḥ","Ḣ"=>"ḣ","� "=>"ḡ","�?"=>"�?","�?"=>"ḝ",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","Ḑ"=>"�?",
"�?"=>"ḏ","�?"=>"ḍ","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"ḁ","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"ց","Ր"=>"�?","Տ"=>"տ","�?"=>"վ","Ս"=>"ս",
"�?"=>"ռ","�?"=>"ջ","�?"=>"պ","�?"=>"չ","�?"=>"ո","�?"=>"շ",
"�?"=>"ն","�?"=>"յ","�?"=>"մ","�?"=>"ճ","�?"=>"ղ","Ձ"=>"ձ",
"�?"=>"հ","Կ"=>"կ","Ծ"=>"ծ","Խ"=>"խ","Լ"=>"լ","Ի"=>"ի",
"Ժ"=>"ժ","Թ"=>"թ","Ը"=>"ը","Է"=>"է","Զ"=>"զ","Ե"=>"ե",
"Դ"=>"դ","Գ"=>"գ","Բ"=>"բ","Ա"=>"ա","�?"=>"ԏ","�?"=>"ԍ",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"ԁ",
"Ӹ"=>"ӹ","Ӵ"=>"ӵ","Ӳ"=>"ӳ","Ӱ"=>"ӱ","Ӯ"=>"ӯ","Ӭ"=>"ӭ",
"Ӫ"=>"ӫ","Ө"=>"ө","Ӧ"=>"ӧ","Ӥ"=>"ӥ","Ӣ"=>"ӣ","� "=>"ӡ",
"�?"=>"�?","�?"=>"ӝ","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","Ӑ"=>"�?","Ӎ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","Ӂ"=>"�?","Ҿ"=>"ҿ","Ҽ"=>"ҽ","Һ"=>"һ",
"Ҹ"=>"ҹ","Ҷ"=>"ҷ","Ҵ"=>"ҵ","Ҳ"=>"ҳ","Ұ"=>"ұ","Ү"=>"ү",
"Ҭ"=>"ҭ","Ҫ"=>"ҫ","Ҩ"=>"ҩ","Ҧ"=>"ҧ","Ҥ"=>"ҥ","Ң"=>"ң",
"� "=>"ҡ","�?"=>"�?","�?"=>"ҝ","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","Ґ"=>"�?","�?"=>"ҏ","�?"=>"ҍ","�?"=>"�?",
"�?"=>"ҁ","Ѿ"=>"ѿ","Ѽ"=>"ѽ","Ѻ"=>"ѻ","Ѹ"=>"ѹ","Ѷ"=>"ѷ",
"Ѵ"=>"ѵ","Ѳ"=>"ѳ","Ѱ"=>"ѱ","Ѯ"=>"ѯ","Ѭ"=>"ѭ","Ѫ"=>"ѫ",
"Ѩ"=>"ѩ","Ѧ"=>"ѧ","Ѥ"=>"ѥ","Ѣ"=>"ѣ","� "=>"ѡ","Я"=>"я",
"Ю"=>"�?","Э"=>"э","Ь"=>"�?","Ы"=>"�?","Ъ"=>"�?","Щ"=>"�?",
"Ш"=>"�?","Ч"=>"�?","Ц"=>"�?","Х"=>"�?","Ф"=>"�?","У"=>"�?",
"Т"=>"�?","С"=>"с","� "=>"�?","�?"=>"п","�?"=>"о","Н"=>"н",
"�?"=>"м","�?"=>"л","�?"=>"к","�?"=>"й","�?"=>"и","�?"=>"з",
"�?"=>"ж","�?"=>"е","�?"=>"д","�?"=>"г","�?"=>"в","�?"=>"б",
"А"=>"а","Џ"=>"�?","�?"=>"�?","Ѝ"=>"ѝ","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","Ё"=>"�?","�?"=>"ѐ","ϴ"=>"θ",
"Ϯ"=>"ϯ","Ϭ"=>"ϭ","Ϫ"=>"ϫ","Ϩ"=>"ϩ","Ϧ"=>"ϧ","Ϥ"=>"ϥ",
"Ϣ"=>"ϣ","� "=>"ϡ","�?"=>"�?","�?"=>"ϝ","�?"=>"�?","�?"=>"�?",
"Ϋ"=>"�?","Ϊ"=>"�?","Ω"=>"�?","Ψ"=>"�?","Χ"=>"�?","Φ"=>"�?",
"Υ"=>"�?","Τ"=>"�?","Σ"=>"�?","Ρ"=>"ρ","� "=>"�?","�?"=>"ο",
"�?"=>"ξ","Ν"=>"ν","�?"=>"μ","�?"=>"λ","�?"=>"κ","�?"=>"ι",
"�?"=>"θ","�?"=>"η","�?"=>"ζ","�?"=>"ε","�?"=>"δ","�?"=>"γ",
"�?"=>"β","�?"=>"α","Ώ"=>"�?","�?"=>"ύ","�?"=>"�?","�?"=>"ί",
"�?"=>"ή","�?"=>"έ","�?"=>"ά","Ȳ"=>"ȳ","Ȱ"=>"ȱ","Ȯ"=>"ȯ",
"Ȭ"=>"ȭ","Ȫ"=>"ȫ","Ȩ"=>"ȩ","Ȧ"=>"ȧ","Ȥ"=>"ȥ","Ȣ"=>"ȣ",
"� "=>"�?","�?"=>"�?","�?"=>"ȝ","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","Ȑ"=>"�?","�?"=>"ȏ","�?"=>"ȍ","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"ȁ","Ǿ"=>"ǿ",
"Ǽ"=>"ǽ","Ǻ"=>"ǻ","Ǹ"=>"ǹ","Ƿ"=>"ƿ","Ƕ"=>"�?","Ǵ"=>"ǵ",
"Ǳ"=>"ǳ","Ǯ"=>"ǯ","Ǭ"=>"ǭ","Ǫ"=>"ǫ","Ǩ"=>"ǩ","Ǧ"=>"ǧ",
"Ǥ"=>"ǥ","Ǣ"=>"ǣ","� "=>"ǡ","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","Ǐ"=>"ǐ","Ǎ"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","Ƽ"=>"ƽ","Ƹ"=>"ƹ","Ʒ"=>"�?",
"Ƶ"=>"ƶ","Ƴ"=>"ƴ","Ʋ"=>"�?","Ʊ"=>"�?","Ư"=>"ư","Ʈ"=>"�?",
"Ƭ"=>"ƭ","Ʃ"=>"�?","Ƨ"=>"ƨ","Ʀ"=>"�?","Ƥ"=>"ƥ","Ƣ"=>"ƣ",
"� "=>"ơ","�?"=>"ɵ","Ɲ"=>"ɲ","�?"=>"ɯ","�?"=>"�?","�?"=>"ɨ",
"�?"=>"ɩ","�?"=>"ɣ","�?"=>"� ","�?"=>"�?","Ɛ"=>"�?","Ə"=>"�?",
"�?"=>"ǝ","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","Ɓ"=>"�?","Ž"=>"ž","Ż"=>"ż","Ź"=>"ź",
"Ÿ"=>"ÿ","Ŷ"=>"ŷ","Ŵ"=>"ŵ","Ų"=>"ų","Ű"=>"ű","Ů"=>"ů",
"Ŭ"=>"ŭ","Ū"=>"ū","Ũ"=>"ũ","Ŧ"=>"ŧ","Ť"=>"ť","Ţ"=>"ţ",
"� "=>"š","�?"=>"�?","�?"=>"ŝ","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","Ő"=>"�?","�?"=>"ŏ","�?"=>"ō","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","Ł"=>"�?","Ŀ"=>"�?","Ľ"=>"ľ",
"Ļ"=>"ļ","Ĺ"=>"ĺ","Ķ"=>"ķ","Ĵ"=>"ĵ","Ĳ"=>"ĳ","İ"=>"i",
"Į"=>"į","Ĭ"=>"ĭ","Ī"=>"ī","Ĩ"=>"ĩ","Ħ"=>"ħ","Ĥ"=>"ĥ",
"Ģ"=>"ģ","� "=>"ġ","�?"=>"�?","�?"=>"ĝ","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","Đ"=>"�?","�?"=>"ď","�?"=>"č",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"ā",
"�?"=>"þ","Ý"=>"ý","�?"=>"ü","�?"=>"û","�?"=>"ú","�?"=>"ù",
"�?"=>"ø","�?"=>"ö","�?"=>"õ","�?"=>"ô","�?"=>"ó","�?"=>"ò",
"�?"=>"ñ","Ð"=>"ð","Ï"=>"ï","�?"=>"î","Í"=>"í","�?"=>"ì",
"�?"=>"ë","�?"=>"ê","�?"=>"é","�?"=>"è","�?"=>"ç","�?"=>"æ",
"�?"=>"å","�?"=>"ä","�?"=>"ã","�?"=>"â","Á"=>"á","�?"=>"� ",
"Z"=>"z","Y"=>"y","X"=>"x","W"=>"w","V"=>"v","U"=>"u",
"T"=>"t","S"=>"s","R"=>"r","Q"=>"q","P"=>"p","O"=>"o",
"N"=>"n","M"=>"m","L"=>"l","K"=>"k","J"=>"j","I"=>"i",
"H"=>"h","G"=>"g","F"=>"f","E"=>"e","D"=>"d","C"=>"c",
"B"=>"b","A"=>"a"
);


$UTF8_TABLES['strtoupper'] = array(
"�?"=>"Ｚ","�?"=>"Ｙ","�?"=>"Ｘ","�?"=>"Ｗ","�?"=>"Ｖ","�?"=>"Ｕ",
"�?"=>"Ｔ","�?"=>"Ｓ","�?"=>"Ｒ","�?"=>"Ｑ","ｐ"=>"Ｐ","ｏ"=>"Ｏ",
"�?"=>"Ｎ","ｍ"=>"Ｍ","�?"=>"Ｌ","�?"=>"Ｋ","�?"=>"Ｊ","�?"=>"Ｉ",
"�?"=>"Ｈ","�?"=>"Ｇ","�?"=>"Ｆ","�?"=>"Ｅ","�?"=>"Ｄ","�?"=>"Ｃ",
"�?"=>"Ｂ","ａ"=>"Ａ","ῳ"=>"ῼ","ῥ"=>"Ῥ","ῡ"=>"Ῡ","� "=>"Ῠ",
"�?"=>"�?","ῐ"=>"�?","�?"=>"�?","ι"=>"�?","ᾳ"=>"ᾼ","ᾱ"=>"Ᾱ",
"ᾰ"=>"Ᾰ","ᾧ"=>"ᾯ","ᾦ"=>"ᾮ","ᾥ"=>"ᾭ","ᾤ"=>"ᾬ","ᾣ"=>"ᾫ",
"ᾢ"=>"ᾪ","ᾡ"=>"ᾩ","� "=>"ᾨ","�?"=>"�?","�?"=>"�?","�?"=>"ᾝ",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","ᾐ"=>"�?","�?"=>"ᾏ",
"�?"=>"�?","�?"=>"ᾍ","�?"=>"�?","�?"=>"�?","�?"=>"�?","ᾁ"=>"�?",
"�?"=>"�?","ώ"=>"Ώ","ὼ"=>"Ὼ","ύ"=>"Ύ","ὺ"=>"Ὺ","ό"=>"Ό",
"ὸ"=>"Ὸ","ί"=>"�?","ὶ"=>"�?","ή"=>"�?","ὴ"=>"�?","έ"=>"�?",
"ὲ"=>"�?","ά"=>"Ά","ὰ"=>"Ὰ","ὧ"=>"Ὧ","ὦ"=>"Ὦ","ὥ"=>"Ὥ",
"ὤ"=>"Ὤ","ὣ"=>"Ὣ","ὢ"=>"Ὢ","ὡ"=>"Ὡ","� "=>"Ὠ","�?"=>"�?",
"�?"=>"Ὕ","�?"=>"�?","�?"=>"�?","�?"=>"Ὅ","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","ὁ"=>"�?","�?"=>"�?","ἷ"=>"Ἷ","ἶ"=>"Ἶ","ἵ"=>"Ἵ",
"ἴ"=>"Ἴ","ἳ"=>"Ἳ","ἲ"=>"Ἲ","ἱ"=>"Ἱ","ἰ"=>"Ἰ","ἧ"=>"Ἧ",
"ἦ"=>"Ἦ","ἥ"=>"Ἥ","ἤ"=>"Ἤ","ἣ"=>"Ἣ","ἢ"=>"Ἢ","ἡ"=>"Ἡ",
"� "=>"Ἠ","�?"=>"Ἕ","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"ἐ"=>"�?","�?"=>"Ἇ","�?"=>"�?","�?"=>"Ἅ","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","ἁ"=>"�?","�?"=>"�?","ỹ"=>"Ỹ","ỷ"=>"Ỷ","ỵ"=>"Ỵ",
"ỳ"=>"Ỳ","ự"=>"Ự","ữ"=>"Ữ","ử"=>"Ử","ừ"=>"Ừ","ứ"=>"Ứ",
"ủ"=>"Ủ","ụ"=>"Ụ","ợ"=>"Ợ","ỡ"=>"� ","�?"=>"�?","ờ"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"Ố",
"ỏ"=>"�?","ọ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","ề"=>"�?","ế"=>"Ế","ẽ"=>"Ẽ","ẻ"=>"Ẻ","ẹ"=>"Ẹ",
"ặ"=>"Ặ","ẵ"=>"Ẵ","ẳ"=>"Ẳ","ằ"=>"Ằ","ắ"=>"Ắ","ậ"=>"Ậ",
"ẫ"=>"Ẫ","ẩ"=>"Ẩ","ầ"=>"Ầ","ấ"=>"Ấ","ả"=>"Ả","ạ"=>"� ",
"�?"=>"� ","�?"=>"�?","�?"=>"�?","�?"=>"Ẑ","ẏ"=>"�?","ẍ"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","ẁ"=>"�?",
"ṿ"=>"Ṿ","ṽ"=>"Ṽ","ṻ"=>"Ṻ","ṹ"=>"Ṹ","ṷ"=>"Ṷ","ṵ"=>"Ṵ",
"ṳ"=>"Ṳ","ṱ"=>"Ṱ","ṯ"=>"Ṯ","ṭ"=>"Ṭ","ṫ"=>"Ṫ","ṩ"=>"Ṩ",
"ṧ"=>"Ṧ","ṥ"=>"Ṥ","ṣ"=>"Ṣ","ṡ"=>"� ","�?"=>"�?","ṝ"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"Ṑ",
"ṏ"=>"�?","ṍ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","ṁ"=>"�?","ḿ"=>"Ḿ","ḽ"=>"Ḽ","ḻ"=>"Ḻ","ḹ"=>"Ḹ",
"ḷ"=>"Ḷ","ḵ"=>"Ḵ","ḳ"=>"Ḳ","ḱ"=>"Ḱ","ḯ"=>"Ḯ","ḭ"=>"Ḭ",
"ḫ"=>"Ḫ","ḩ"=>"Ḩ","ḧ"=>"Ḧ","ḥ"=>"Ḥ","ḣ"=>"Ḣ","ḡ"=>"� ",
"�?"=>"�?","ḝ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"Ḑ","ḏ"=>"�?","ḍ"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","ḁ"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","ց"=>"�?","�?"=>"Ր","տ"=>"Տ",
"վ"=>"�?","ս"=>"Ս","ռ"=>"�?","ջ"=>"�?","պ"=>"�?","չ"=>"�?",
"ո"=>"�?","շ"=>"�?","ն"=>"�?","յ"=>"�?","մ"=>"�?","ճ"=>"�?",
"ղ"=>"�?","ձ"=>"Ձ","հ"=>"�?","կ"=>"Կ","ծ"=>"Ծ","խ"=>"Խ",
"լ"=>"Լ","ի"=>"Ի","ժ"=>"Ժ","թ"=>"Թ","ը"=>"Ը","է"=>"Է",
"զ"=>"Զ","ե"=>"Ե","դ"=>"Դ","գ"=>"Գ","բ"=>"Բ","ա"=>"Ա",
"ԏ"=>"�?","ԍ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","ԁ"=>"�?","ӹ"=>"Ӹ","ӵ"=>"Ӵ","ӳ"=>"Ӳ","ӱ"=>"Ӱ",
"ӯ"=>"Ӯ","ӭ"=>"Ӭ","ӫ"=>"Ӫ","ө"=>"Ө","ӧ"=>"Ӧ","ӥ"=>"Ӥ",
"ӣ"=>"Ӣ","ӡ"=>"� ","�?"=>"�?","ӝ"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"Ӑ","�?"=>"Ӎ","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"Ӂ","ҿ"=>"Ҿ",
"ҽ"=>"Ҽ","һ"=>"Һ","ҹ"=>"Ҹ","ҷ"=>"Ҷ","ҵ"=>"Ҵ","ҳ"=>"Ҳ",
"ұ"=>"Ұ","ү"=>"Ү","ҭ"=>"Ҭ","ҫ"=>"Ҫ","ҩ"=>"Ҩ","ҧ"=>"Ҧ",
"ҥ"=>"Ҥ","ң"=>"Ң","ҡ"=>"� ","�?"=>"�?","ҝ"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"Ґ","ҏ"=>"�?",
"ҍ"=>"�?","�?"=>"�?","ҁ"=>"�?","ѿ"=>"Ѿ","ѽ"=>"Ѽ","ѻ"=>"Ѻ",
"ѹ"=>"Ѹ","ѷ"=>"Ѷ","ѵ"=>"Ѵ","ѳ"=>"Ѳ","ѱ"=>"Ѱ","ѯ"=>"Ѯ",
"ѭ"=>"Ѭ","ѫ"=>"Ѫ","ѩ"=>"Ѩ","ѧ"=>"Ѧ","ѥ"=>"Ѥ","ѣ"=>"Ѣ",
"ѡ"=>"� ","�?"=>"Џ","�?"=>"�?","ѝ"=>"Ѝ","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"Ё","ѐ"=>"�?","я"=>"Я",
"�?"=>"Ю","э"=>"Э","�?"=>"Ь","�?"=>"Ы","�?"=>"Ъ","�?"=>"Щ",
"�?"=>"Ш","�?"=>"Ч","�?"=>"Ц","�?"=>"Х","�?"=>"Ф","�?"=>"У",
"�?"=>"Т","с"=>"С","�?"=>"� ","п"=>"�?","о"=>"�?","н"=>"Н",
"м"=>"�?","л"=>"�?","к"=>"�?","й"=>"�?","и"=>"�?","з"=>"�?",
"ж"=>"�?","е"=>"�?","д"=>"�?","г"=>"�?","в"=>"�?","б"=>"�?",
"а"=>"А","ϵ"=>"�?","ϲ"=>"Σ","ϱ"=>"Ρ","ϰ"=>"�?","ϯ"=>"Ϯ",
"ϭ"=>"Ϭ","ϫ"=>"Ϫ","ϩ"=>"Ϩ","ϧ"=>"Ϧ","ϥ"=>"Ϥ","ϣ"=>"Ϣ",
"ϡ"=>"� ","�?"=>"�?","ϝ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"� ",
"�?"=>"Φ","�?"=>"�?","ϐ"=>"�?","�?"=>"Ώ","ύ"=>"�?","�?"=>"�?",
"�?"=>"Ϋ","�?"=>"Ϊ","�?"=>"Ω","�?"=>"Ψ","�?"=>"Χ","�?"=>"Φ",
"�?"=>"Υ","�?"=>"Τ","�?"=>"Σ","�?"=>"Σ","ρ"=>"Ρ","�?"=>"� ",
"ο"=>"�?","ξ"=>"�?","ν"=>"Ν","μ"=>"�?","λ"=>"�?","κ"=>"�?",
"ι"=>"�?","θ"=>"�?","η"=>"�?","ζ"=>"�?","ε"=>"�?","δ"=>"�?",
"γ"=>"�?","β"=>"�?","α"=>"�?","ί"=>"�?","ή"=>"�?","έ"=>"�?",
"ά"=>"�?","�?"=>"Ʒ","�?"=>"Ʋ","�?"=>"Ʊ","�?"=>"Ʈ","�?"=>"Ʃ",
"�?"=>"Ʀ","ɵ"=>"�?","ɲ"=>"Ɲ","ɯ"=>"�?","ɩ"=>"�?","ɨ"=>"�?",
"ɣ"=>"�?","� "=>"�?","�?"=>"Ɛ","�?"=>"Ə","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"Ɓ","ȳ"=>"Ȳ","ȱ"=>"Ȱ","ȯ"=>"Ȯ","ȭ"=>"Ȭ",
"ȫ"=>"Ȫ","ȩ"=>"Ȩ","ȧ"=>"Ȧ","ȥ"=>"Ȥ","ȣ"=>"Ȣ","�?"=>"�?",
"ȝ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"Ȑ","ȏ"=>"�?","ȍ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","ȁ"=>"�?","ǿ"=>"Ǿ","ǽ"=>"Ǽ","ǻ"=>"Ǻ",
"ǹ"=>"Ǹ","ǵ"=>"Ǵ","ǳ"=>"ǲ","ǯ"=>"Ǯ","ǭ"=>"Ǭ","ǫ"=>"Ǫ",
"ǩ"=>"Ǩ","ǧ"=>"Ǧ","ǥ"=>"Ǥ","ǣ"=>"Ǣ","ǡ"=>"� ","�?"=>"�?",
"ǝ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","ǐ"=>"Ǐ","�?"=>"Ǎ","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"ƿ"=>"Ƿ","ƽ"=>"Ƽ","ƹ"=>"Ƹ","ƶ"=>"Ƶ","ƴ"=>"Ƴ","ư"=>"Ư",
"ƭ"=>"Ƭ","ƨ"=>"Ƨ","ƥ"=>"Ƥ","ƣ"=>"Ƣ","ơ"=>"� ","�?"=>"� ",
"�?"=>"�?","�?"=>"Ƕ","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","ſ"=>"S","ž"=>"Ž","ż"=>"Ż","ź"=>"Ź","ŷ"=>"Ŷ",
"ŵ"=>"Ŵ","ų"=>"Ų","ű"=>"Ű","ů"=>"Ů","ŭ"=>"Ŭ","ū"=>"Ū",
"ũ"=>"Ũ","ŧ"=>"Ŧ","ť"=>"Ť","ţ"=>"Ţ","š"=>"� ","�?"=>"�?",
"ŝ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"Ő","ŏ"=>"�?","ō"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"Ł","�?"=>"Ŀ","ľ"=>"Ľ","ļ"=>"Ļ","ĺ"=>"Ĺ",
"ķ"=>"Ķ","ĵ"=>"Ĵ","ĳ"=>"Ĳ","ı"=>"I","į"=>"Į","ĭ"=>"Ĭ",
"ī"=>"Ī","ĩ"=>"Ĩ","ħ"=>"Ħ","ĥ"=>"Ĥ","ģ"=>"Ģ","ġ"=>"� ",
"�?"=>"�?","ĝ"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"Đ","ď"=>"�?","č"=>"�?","�?"=>"�?","�?"=>"�?",
"�?"=>"�?","�?"=>"�?","�?"=>"�?","ā"=>"�?","ÿ"=>"Ÿ","þ"=>"�?",
"ý"=>"Ý","ü"=>"�?","û"=>"�?","ú"=>"�?","ù"=>"�?","ø"=>"�?",
"ö"=>"�?","õ"=>"�?","ô"=>"�?","ó"=>"�?","ò"=>"�?","ñ"=>"�?",
"ð"=>"Ð","ï"=>"Ï","î"=>"�?","í"=>"Í","ì"=>"�?","ë"=>"�?",
"ê"=>"�?","é"=>"�?","è"=>"�?","ç"=>"�?","æ"=>"�?","å"=>"�?",
"ä"=>"�?","ã"=>"�?","â"=>"�?","á"=>"Á","� "=>"�?","µ"=>"�?",
"z"=>"Z","y"=>"Y","x"=>"X","w"=>"W","v"=>"V","u"=>"U",
"t"=>"T","s"=>"S","r"=>"R","q"=>"Q","p"=>"P","o"=>"O",
"n"=>"N","m"=>"M","l"=>"L","k"=>"K","j"=>"J","i"=>"I",
"h"=>"H","g"=>"G","f"=>"F","e"=>"E","d"=>"D","c"=>"C",
"b"=>"B","a"=>"A"
);

?>
