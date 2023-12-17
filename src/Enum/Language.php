<?php namespace Intellex\Pixabay\Enum;

/**
 * Holds the list of all available languages.
 */
abstract class Language {
	public const CS = 'cs';
	public const DA = 'da';
	public const DE = 'de';
	public const EN = 'en';
	public const ES = 'es';
	public const FR = 'fr';
	public const ID = 'id';
	public const IT = 'it';
	public const HU = 'hu';
	public const NL = 'nl';
	public const NO = 'no';
	public const PL = 'pl';
	public const PT = 'pt';
	public const RO = 'ro';
	public const SK = 'sk';
	public const FI = 'fi';
	public const SV = 'sv';
	public const TR = 'tr';
	public const VI = 'vi';
	public const TH = 'th';
	public const BG = 'bg';
	public const RU = 'ru';
	public const EL = 'el';
	public const JA = 'ja';
	public const KO = 'ko';
	public const ZH = 'zh';

	/** @return string[] */
	public static function getAll(): array {
		return [
			self::CS,
			self::DA,
			self::DE,
			self::EN,
			self::ES,
			self::FR,
			self::ID,
			self::IT,
			self::HU,
			self::NL,
			self::NO,
			self::PL,
			self::PT,
			self::RO,
			self::SK,
			self::FI,
			self::SV,
			self::TR,
			self::VI,
			self::TH,
			self::BG,
			self::RU,
			self::EL,
			self::JA,
			self::KO,
			self::ZH
		];
	}
}
