<div class="form-group">
    <label for="language">Langues</label>
    <br>
    {{
        Form::select('language', [
        'ANY' => 'All Languages',
        'ENG' => 'English',
        'ABK' => 'Abkhaz',
        'ACE' => 'Achinese',
        'ACH' => 'Acoli',
        'ADA' => 'Adangme',
        'ADY' => 'Adygei',
        'AAR' => 'Afar',
        'AFH' => 'Afrihili (Artificial language)',
        'AFR' => 'Afrikaans',
        'AFA' => 'Afroasiatic (Other)',
        'AIN' => 'Ainu',
        'AKA' => 'Akan',
        'AKK' => 'Akkadian',
        'ALB' => 'Albanian',
        'ALE' => 'Aleut',
        'ALG' => 'Algonquian (Other)',
        'ALT' => 'Altai',
        'TUT' => 'Altaic (Other)',
        'AMH' => 'Amharic',
        'ANP' => 'Angika',
        'APA' => 'Apache languages',
        'ARA' => 'Arabic',
        'ARG' => 'Aragonese',
        'ARC' => 'Aramaic',
        'ARP' => 'Arapaho',
        'ARW' => 'Arawak',
        'ARM' => 'Armenian',
        'RUP' => 'Aromanian',
        'ART' => 'Artificial (Other)',
        'ASM' => 'Assamese',
        'ATH' => 'Athapascan (Other)',
        'AUS' => 'Australian languages',
        'MAP' => 'Austronesian (Other)',
        'AVA' => 'Avaric',
        'AVE' => 'Avestan',
        'AWA' => 'Awadhi',
        'AYM' => 'Aymara',
        'AZE' => 'Azerbaijani',
        'AST' => 'Bable',
        'BAN' => 'Balinese',
        'BAT' => 'Baltic (Other)',
        'BAL' => 'Baluchi',
        'BAM' => 'Bambara',
        'BAI' => 'Bamileke languages',
        'BAD' => 'Banda languages',
        'BNT' => 'Bantu (Other)',
        'BAS' => 'Basa',
        'BAK' => 'Bashkir',
        'BAQ' => 'Basque',
        'BTK' => 'Batak',
        'BEJ' => 'Beja',
        'BEL' => 'Belarusian',
        'BEM' => 'Bemba',
        'BEN' => 'Bengali',
        'BER' => 'Berber (Other)',
        'BHO' => 'Bhojpuri',
        'BIH' => 'Bihari (Other)',
        'BIK' => 'Bikol',
        'BYN' => 'Bilin',
        'BIS' => 'Bislama',
        'ZBL' => 'Blissymbolics',
        'BOS' => 'Bosnian',
        'BRA' => 'Braj',
        'BRE' => 'Breton',
        'BUG' => 'Bugis',
        'BUL' => 'Bulgarian',
        'BUA' => 'Buriat',
        'BUR' => 'Burmese',
        'CAD' => 'Caddo',
        'CAR' => 'Carib',
        'CAT' => 'Catalan',
        'CAU' => 'Caucasian (Other)',
        'CEB' => 'Cebuano',
        'CEL' => 'Celtic (Other)',
        'CAI' => 'Central American Indian (Other)',
        'CHG' => 'Chagatai',
        'CMC' => 'Chamic languages',
        'CHA' => 'Chamorro',
        'CHE' => 'Chechen',
        'CHR' => 'Cherokee',
        'CHY' => 'Cheyenne',
        'CHB' => 'Chibcha',
        'CHI' => 'Chinese',
        'CHN' => 'Chinook jargon',
        'CHP' => 'Chipewyan',
        'CHO' => 'Choctaw',
        'CHU' => 'Church Slavic',
        'CHK' => 'Chuukese',
        'CHV' => 'Chuvash',
        'COP' => 'Coptic',
        'COR' => 'Cornish',
        'COS' => 'Corsican',
        'CRE' => 'Cree',
        'MUS' => 'Creek',
        'CRP' => 'Creoles and Pidgins (Other)',
        'CPE' => 'Creoles and Pidgins, English-based (Other)',
        'CPF' => 'Creoles and Pidgins, French-based (Other)',
        'CPP' => 'Creoles and Pidgins, Portuguese-based (Other)',
        'CRH' => 'Crimean Tatar',
        'HRV' => 'Croatian [current]',
        'SCR' => 'Croatian [used until 2008]',
        'CUS' => 'Cushitic (Other)',
        'CZE' => 'Czech',
        'DAK' => 'Dakota',
        'DAN' => 'Danish',
        'DAR' => 'Dargwa',
        'DAY' => 'Dayak',
        'DEL' => 'Delaware',
        'DIN' => 'Dinka',
        'DIV' => 'Divehi',
        'DOI' => 'Dogri',
        'DGR' => 'Dogrib',
        'DRA' => 'Dravidian (Other)',
        'DUA' => 'Duala',
        'DUT' => 'Dutch',
        'DUM' => 'Dutch, Middle (ca. 1050-1350)',
        'DYU' => 'Dyula',
        'DZO' => 'Dzongkha',
        'BIN' => 'Edo',
        'EFI' => 'Efik',
        'EGY' => 'Egyptian',
        'EKA' => 'Ekajuk',
        'ELX' => 'Elamite',
        'ENM' => 'English, Middle (1100-1500)',
        'ANG' => 'English, Old (ca. 450-1100)',
        'MYV' => 'Erzya',
        'EPO' => 'Esperanto',
        'EST' => 'Estonian',
        'GEZ' => 'Ethiopic',
        'EWE' => 'Ewe',
        'EWO' => 'Ewondo',
        'FAN' => 'Fang',
        'FAT' => 'Fanti',
        'FAO' => 'Faroese',
        'FIJ' => 'Fijian',
        'FIL' => 'Filipino',
        'FIN' => 'Finnish',
        'FIU' => 'Finno-Ugrian (Other)',
        'FON' => 'Fon',
        'FRE' => 'French',
        'FRM' => 'French, Middle (ca. 1300-1600)',
        'FRO' => 'French, Old (ca. 842-1300)',
        'FRY' => 'Frisian',
        'FRS' => 'Frisian, East',
        'FRR' => 'Frisian, North',
        'FUR' => 'Friulian',
        'FUL' => 'Fula',
        'GAA' => 'Ga',
        'GLG' => 'Galician',
        'LUG' => 'Ganda',
        'GAY' => 'Gayo',
        'GBA' => 'Gbaya',
        'GEO' => 'Georgian',
        'GER' => 'German',
        'NDS' => 'German, Low',
        'GMH' => 'German, Middle High (ca. 1050-1)',
        'GOH' => 'German, Old High (ca. 750-1050)',
        'GEM' => 'Germanic (Other)',
        'GIL' => 'Gilbertese',
        'GON' => 'Gondi',
        'GOR' => 'Gorontalo',
        'GOT' => 'Gothic',
        'GRB' => 'Grebo',
        'GRC' => 'Greek, Ancient (to 1453)',
        'GRE' => 'Greek, Modern (1453)',
        'GRN' => 'Guarani',
        'GUJ' => 'Gujarati',
        'GWI' => 'Gwich\'in',
        'HAI' => 'Haida',
        'HAT' => 'Haitian French Creole',
        'HAU' => 'Hausa',
        'HAW' => 'Hawaiian',
        'HEB' => 'Hebrew',
        'HER' => 'Herero',
        'HIL' => 'Hiligaynon',
        'HIN' => 'Hindi',
        'HMO' => 'Hiri Motu',
        'HIT' => 'Hittite',
        'HMN' => 'Hmong',
        'HUN' => 'Hungarian',
        'HUP' => 'Hupa',
        'IBA' => 'Iban',
        'ICE' => 'Icelandic',
        'IDO' => 'Ido',
        'IBO' => 'Igbo',
        'IJO' => 'Ijo',
        'ILO' => 'Iloko',
        'INC' => 'Indic (Other)',
        'INE' => 'Indo-European (Other)',
        'IND' => 'Indonesian',
        'INH' => 'Ingush',
        'INA' => 'Interlingua (International Auxiliary Language Assoc)',
        'ILE' => 'Interlingue',
        'IKU' => 'Inuktitut',
        'IPK' => 'Inupiaq',
        'IRA' => 'Iranian (Other)',
        'GLE' => 'Irish',
        'MGA' => 'Irish, Middle (ca. 1100-1550)',
        'SGA' => 'Irish, Old (to 1100)',
        'IRO' => 'Iroquoian (Other)',
        'ITA' => 'Italian',
        'NAP' => 'Italian, Neapolitan',
        'SCN' => 'Italian, Sicilian',
        'JPN' => 'Japanese',
        'JAV' => 'Javanese',
        'JRB' => 'Judeo-Arabic',
        'JPR' => 'Judeo-Persian',
        'KBD' => 'Kabardian',
        'KAB' => 'Kabyle',
        'KAC' => 'Kachin',
        'KAL' => 'Kalatdlisut',
        'KAM' => 'Kamba',
        'KAN' => 'Kannada',
        'KAU' => 'Kanuri',
        'KAA' => 'Kara-Kalpak',
        'KRC' => 'Karachay-Balkar',
        'KRL' => 'Karelian',
        'KAR' => 'Karen languages',
        'KAS' => 'Kashmiri',
        'CSB' => 'Kashubian',
        'KAW' => 'Kawi',
        'KAZ' => 'Kazakh',
        'KHA' => 'Khasi',
        'KHM' => 'Khmer',
        'KHI' => 'Khoisan (Other)',
        'KHO' => 'Khotanese',
        'KIK' => 'Kikuyu',
        'KMB' => 'Kimbundu',
        'KIN' => 'Kinyarwanda',
        'TLH' => 'Klingon (Artificial language)',
        'KOM' => 'Komi',
        'KON' => 'Kongo',
        'KOK' => 'Konkani',
        'KUT' => 'Kootenai',
        'KOR' => 'Korean',
        'KOS' => 'Kosraean',
        'KPE' => 'Kpelle',
        'KRO' => 'Kru (Other)',
        'KUA' => 'Kuanyama',
        'KUM' => 'Kumyk',
        'KUR' => 'Kurdish',
        'KRU' => 'Kurukh',
        'KIR' => 'Kyrgyz',
        'LAD' => 'Ladino',
        'LAH' => 'Lahnda',
        'LAM' => 'Lamba (Zambia and Congo)',
        'LAO' => 'Lao',
        'LAT' => 'Latin',
        'LAV' => 'Latvian',
        'LEZ' => 'Lezgian',
        'LIM' => 'Limburgish',
        'LIN' => 'Lingala',
        'LIT' => 'Lithuanian',
        'JBO' => 'Lojban (Artificial language)',
        'LOZ' => 'Lozi',
        'LUB' => 'Luba-Katanga',
        'LUA' => 'Luba-Lulua',
        'LUI' => 'Luiseno',
        'LUN' => 'Lunda',
        'LUO' => 'Luo (Kenya and Tanzania)',
        'LUS' => 'Lushai',
        'LTZ' => 'Luxembourgish',
        'MAS' => 'Maasai',
        'MAC' => 'Macedonian',
        'MAD' => 'Madurese',
        'MAG' => 'Magahi',
        'MAI' => 'Maithili',
        'MAK' => 'Makasar',
        'MLG' => 'Malagasy',
        'MAY' => 'Malay',
        'MAL' => 'Malayalam',
        'MLT' => 'Maltese',
        'MNC' => 'Manchu',
        'MDR' => 'Mandar',
        'MAN' => 'Mandingo',
        'MNI' => 'Manipuri',
        'MNO' => 'Manobo languages',
        'GLV' => 'Manx',
        'MAO' => 'Maori',
        'ARN' => 'Mapuche',
        'MAR' => 'Marathi',
        'CHM' => 'Mari',
        'MAH' => 'Marshallese',
        'MWR' => 'Marwari',
        'MYN' => 'Mayan languages',
        'MEN' => 'Mende',
        'MIC' => 'Micmac',
        'MIN' => 'Minangkabau',
        'MWL' => 'Mirandese',
        'MOH' => 'Mohawk',
        'MDF' => 'Moksha',
        'MKH' => 'Mon-Khmer (Other)',
        'LOL' => 'Mongo-Nkundu',
        'MON' => 'Mongolian',
        'MOS' => 'Moore',
        'MUN' => 'Munda (Other)',
        'NAH' => 'Nahuatl',
        'NAU' => 'Nauru',
        'NAV' => 'Navajo',
        'NBL' => 'Ndebele (South Africa)',
        'NDE' => 'Ndebele (Zimbabwe)',
        'NDO' => 'Ndonga',
        'NEP' => 'Nepali',
        'NEW' => 'Newari',
        'NWC' => 'Newari, Old',
        'NIA' => 'Nias',
        'NIC' => 'Niger-Kordofanian (Other)',
        'SSA' => 'Nilo-Saharan (Other)',
        'NIU' => 'Niuean',
        'NQO' => 'N\'Ko',
        'NOG' => 'Nogai',
        'NON' => 'Norse, Old',
        'NAI' => 'North American Indian (Other)',
        'NOR' => 'Norwegian',
        'NNO' => 'Norwegian (Nynorsk)',
        'NOB' => 'Norwegian (Bokmal)',
        'NUB' => 'Nubian languages',
        'NYM' => 'Nyamwezi',
        'NYA' => 'Nyanja',
        'NYN' => 'Nyankole',
        'NYO' => 'Nyoro',
        'NZI' => 'Nzima',
        'OCI' => 'Occitan (post 1500)',
        'XAL' => 'Oirat',
        'OJI' => 'Ojibwa',
        'ORI' => 'Oriya',
        'ORM' => 'Oromo',
        'OSA' => 'Osage',
        'OSS' => 'Ossetic',
        'OTO' => 'Otomian languages',
        'PAL' => 'Pahlavi',
        'PAU' => 'Palauan',
        'PLI' => 'Pali',
        'PAM' => 'Pampanga',
        'PAG' => 'Pangasinan',
        'PAN' => 'Panjabi',
        'PAP' => 'Papiamento',
        'PAA' => 'Papuan (Other)',
        'PER' => 'Persian',
        'PEO' => 'Persian, Old (ca. 600-400 B.C.)',
        'PHI' => 'Philippine (Other)',
        'PHN' => 'Phoenician',
        'PON' => 'Pohnpeian',
        'POL' => 'Polish',
        'POR' => 'Portuguese',
        'PRA' => 'Prakrit languages',
        'PRO' => 'Provencal (to 1500)',
        'PUS' => 'Pushto',
        'QUE' => 'Quechua',
        'ROH' => 'Raeto-Romance',
        'RAJ' => 'Rajasthani',
        'RAP' => 'Rapanui',
        'RAR' => 'Rarotongan',
        'ROA' => 'Romance (Other)',
        'ROM' => 'Romani',
        'RUM' => 'Romanian',
        'RUN' => 'Rundi',
        'RUS' => 'Russian',
        'SAL' => 'Salishan languages',
        'SAM' => 'Samaritan Aramaic',
        'SMI' => 'Sami',
        'SMN' => 'Sami, Inari',
        'SMJ' => 'Sami, Lule',
        'SME' => 'Sami, Northern',
        'SMS' => 'Sami, Skolt',
        'SMA' => 'Sami, Southern',
        'SMO' => 'Samoan',
        'SAD' => 'Sandawe',
        'SAG' => 'Sango (Ubangi Creole)',
        'SAN' => 'Sanskrit',
        'SAT' => 'Santali',
        'SRD' => 'Sardinian',
        'SAS' => 'Sasak',
        'SCO' => 'Scots',
        'GLA' => 'Scottish Gaelic',
        'SEL' => 'Selkup',
        'SEM' => 'Semitic (Other)',
        'SPR' => 'Serbian',
        'SRR' => 'Serer',
        'SHN' => 'Shan',
        'SNA' => 'Shona',
        'III' => 'Sichuan Yi',
        'SID' => 'Sidamo',
        'SGN' => 'Sign languages',
        'BLA' => 'Siksika',
        'SND' => 'Sindhi',
        'SIN' => 'Sinhalese',
        'SIT' => 'Sino-Tibetan (Other)',
        'SIO' => 'Siouan (Other)',
        'DEN' => 'Slavey',
        'SLA' => 'Slavic (Other)',
        'SLO' => 'Slovak',
        'SLV' => 'Slovenian',
        'SOG' => 'Sogdian',
        'SOM' => 'Somali',
        'SON' => 'Songhai',
        'SNK' => 'Soninke',
        'DSB' => 'Sorbian, Lower',
        'WEN' => 'Sorbian (Other)',
        'HSB' => 'Sorbian, Upper',
        'SOT' => 'Sotho',
        'NSO' => 'Sotho, Northern',
        'SAI' => 'South American Indian (Other)',
        'SPA' => 'Spanish',
        'SRN' => 'Sranan',
        'SUK' => 'Sukuma',
        'SUX' => 'Sumerian',
        'SUN' => 'Sundanese',
        'SUS' => 'Susu',
        'SWA' => 'Swahili',
        'SSW' => 'Swazi',
        'SWE' => 'Swedish',
        'GSW' => 'Swiss German',
        'SYC' => 'Syriac',
        'SYR' => 'Syriac, Modern',
        'TGL' => 'Tagalog',
        'TAH' => 'Tahitian',
        'TAI' => 'Tai (Other)',
        'TGK' => 'Tajik',
        'TMH' => 'Tamashek',
        'TAM' => 'Tamil',
        'TAT' => 'Tatar',
        'TEL' => 'Telugu',
        'TEM' => 'Temne',
        'TER' => 'Terena',
        'TET' => 'Tetum',
        'THA' => 'Thai',
        'TIB' => 'Tibetan',
        'TIG' => 'Tigre',
        'TIR' => 'Tigrinya',
        'TIV' => 'Tiv',
        'TLI' => 'Tlingit',
        'TPI' => 'Tok Pisin',
        'TKL' => 'Tokelauan',
        'TOG' => 'Tonga (Nyasa)',
        'TON' => 'Tongan',
        'TSI' => 'Tsimshian',
        'TSN' => 'Tswana',
        'TSO' => 'Tsonga',
        'TUM' => 'Tumbuka',
        'TUP' => 'Tupi languages',
        'TUR' => 'Turkish',
        'OTA' => 'Turkish, Ottoman',
        'TUK' => 'Turkmen',
        'TVL' => 'Tuvaluan',
        'TYV' => 'Tuvinian',
        'TWI' => 'Twi',
        'UDM' => 'Udmurt',
        'UGA' => 'Ugaritic',
        'UIG' => 'Uighur',
        'UKR' => 'Ukrainian',
        'UMB' => 'Umbundu',
        'URD' => 'Urdu',
        'UZB' => 'Uzbek',
        'VAI' => 'Vai',
        'VEN' => 'Venda',
        'VIE' => 'Vietnamese',
        'VOL' => 'Volapuk',
        'VOT' => 'Votic',
        'WAK' => 'Wakashan languages',
        'WLN' => 'Walloon',
        'WAR' => 'Waray',
        'WAS' => 'Washoe',
        'WEL' => 'Welsh',
        'HIM' => 'Western Pahari languages',
        'WAL' => 'Wolayta',
        'WOL' => 'Wolof',
        'XHO' => 'Xhosa',
        'SAH' => 'Yakut',
        'YAO' => 'Yao (Africa)',
        'YAP' => 'Yapese',
        'YID' => 'Yiddish',
        'YOR' => 'Yoruba',
        'YPK' => 'Yupik languages',
        'ZND' => 'Zande languages',
        'ZAP' => 'Zapotec',
        'ZZA' => 'Zaza',
        'ZEN' => 'Zenaga',
        'ZHA' => 'Zhuang',
        'ZUL' => 'Zulu',
        'ZUN' => 'Zuni',
        'MIS' => 'Miscellaneous languages',
        'ZXX' => 'No linguistic content'], 'FRE',
        ['class' => 'select2 form-control', 'title' => 'Sélectionner une langue', 'id'    =>'language', 'size'  =>'5'])
    }}
</div>