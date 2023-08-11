<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Randomizer Configuration
    |--------------------------------------------------------------------------
    | This config file declares the appearance and behavior of the web GUI form
    | In order to avoid setting default values multiple times in this config, this
    | uses values from .env using env('RANDOMIZER_DEFAULT_*', 'fallback') in multiple places
    |
    | However flag, code and preset "behavior" configs need to be manually adjusted
    | if new mods are being added and each f/c/p should be changed accordingly
    */

    'seed' => [
        'min' => env('RANDOMIZER_DEFAULT_SEED_MIN', "1000000000"),
        'max' => env('RANDOMIZER_DEFAULT_SEED_MAX', "9999999999")
    ],

    /*
    |--------------------------------------------------------------------------
    | Code categories
    |--------------------------------------------------------------------------
    | Categories for codes are specified here. Category assigned codes will be grouped
    */
    'categories' => [
        0 => 'OPEN WORLD RELATED',
        1 => 'OPEN WORLD ENEMY SCALING',
        2 => 'CHEATS',
        3 => 'OTHER'
    ],
    /*
    |--------------------------------------------------------------------------
    | File / Rom
    |--------------------------------------------------------------------------
    | key:       the md5 hash of the rom file
    | value:     the string of its usual file name (without ending)
    | allowed:   whether this rom is allowed to be passed to the python script
    | displayed: whether this rom should be communicated to the user
    */
    'file' => [
        [
            'key' => '6efc477d6203ed2b3b9133c1cd9e9c5d',
            'value' => 'Lufia II - Rise of the Sinistrals (USA)',
            'allowed' => true,
            'displayed' => false,
        ],
        [
            'key' => '026b649ed316448e038349e39a6fe579',
            'value' => 'Lufia II Fixxxer Deluxe',
            'allowed' => true,
            'displayed' => false,
        ],
        [
            'key' => 'b58c76f2ac0b2aeb9b779e880d2bff18',
            'value' => 'Frue Lufia',
            'allowed' => true,
            'displayed' => false,
        ]
    ],
    /*
    |--------------------------------------------------------------------------
    | Flags
    |--------------------------------------------------------------------------
    | key:        the flag
    | value:      the string that describes it
    | allowed:    whether this flag should be passed to the python script
    | displayed:  whether this flag should be shown in the form
    | enabled:    whether this flag should be toggled on by default
    | default:    if no flags are used, use this flag as fallback
    | behavior[]: off:   array of codes to toggle off when toggling this
    |             on:    array of codes to toggle on when toggling this
    |             set[]: arrays containing key + value pairs of mods to set when toggling this
    |
    |             example on/off: ['flag-c', 'code-airship']
    |             example set:    [['mod-randomness', '1.5'], ['mod-difficulty', '2']]
    */
    'flag' => [
        'w' => array(
            'key' => 'w',
            'value' => 'Create an open-world seed',
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('w', explode(',', env('RANDOMIZER_DEFAULT_FLAG', 'w'))),
        ),
        'c' => [
            'key' => 'c',
            'value' => 'Randomize characters',
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('c', explode(',', env('RANDOMIZER_DEFAULT_FLAG', 'w'))),
        ],
        'i' => [
            'key' => 'i',
            'value' => 'Randomize items and equipment',
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('i', explode(',', env('RANDOMIZER_DEFAULT_FLAG', 'w'))),
        ],
        'l' => [
            'key' => 'l',
            'value' => 'Randomize learnable spells',
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('l', explode(',', env('RANDOMIZER_DEFAULT_FLAG', 'w'))),
        ],
        'm' => [
            'key' => 'm',
            'value' => 'Randomize monsters',
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('m', explode(',', env('RANDOMIZER_DEFAULT_FLAG', 'w'))),
        ],
        'o' => [
            'key' => 'o',
            'value' => 'Randomize monster movements',
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('o', explode(',', env('RANDOMIZER_DEFAULT_FLAG', 'w'))),
        ],
        'p' => [
            'key' => 'p',
            'value' => 'Randomize capsule monsters',
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('p', explode(',', env('RANDOMIZER_DEFAULT_FLAG', 'w'))),
        ],
        's' => [
            'key' => 's',
            'value' => 'Randomize shops',
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('s', explode(',', env('RANDOMIZER_DEFAULT_FLAG', 'w'))),
        ],
        't' => [
            'key' => 't',
            'value' => 'Randomize treasure chests',
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('t', explode(',', env('RANDOMIZER_DEFAULT_FLAG', 'w'))),
        ],
        'v' => [
            'key' => 'v',
            'value' => 'Randomize nothing. (dummy flag to create vanilla seeds)',
            'allowed' => false,
            'displayed' => false,
            'enabled' => in_array('v', explode(',', env('RANDOMIZER_DEFAULT_FLAG', 'w'))),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Codes
    |--------------------------------------------------------------------------
    | key:        the code
    | value:      the string that describes it
    | category:   the category id
    | allowed:    whether this code should be passed to the python script
    | displayed:  whether this code should be shown in the form
    | enabled:    whether this code should be toggled on by default
    | behavior[]: off:   array of codes to toggle off when toggling this
    |             on:    array of codes to toggle on when toggling this
    |             set[]: arrays containing key + value pairs of mods to set when toggling this
    |
    |             example on/off: ['flag-c', 'code-airship']
    |             example set:    [['mod-randomness', '1.5'], ['mod-difficulty', '2']]
    */
    'code' => [
        'airship' => [
            'key' => 'airship',
            'value' => 'Start the game with the airship',
            'category' => 0,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('airship', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
        ],
        'bossy' => [
            'key' => 'bossy',
            'value' => 'Very random bosses (unbalanced even with scaling)',
            'category' => 0,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('bossy', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
        ],
        'fourkeys' => [
            'key' => 'fourkeys',
            'value' => 'Open World, but there are only four keys',
            'category' => 0,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('fourkeys', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
        ],
        'scale' => [
            'key' => 'scale',
            'value' => 'Scale enemy status in open-world mode',
            'category' => 1,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('scale', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
            'behavior' => [
                'off' => ['code-noscale']
            ],
        ],
        'noscale' => [
            'key' => 'noscale',
            'value' => 'Do not scale enemies in open-world mode',
            'category' => 1,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('noscale', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
            'behavior' => [
                'off' => ['code-scale']
            ],
        ],
        'splitscale' => [
            'key' => 'splitscale',
            'value' => 'Input custom values for scaling bosses and nonbosses',
            'category' => 1,
            'allowed' => false,
            'displayed' => false,
            'enabled' => in_array('splitscale', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
        ],
        'easymodo' => [
            'key' => 'easymodo',
            'value' => 'Every enemy dies in one hit',
            'category' => 2,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('easymodo', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
        ],
        'holiday' => [
            'key' => 'holiday',
            'value' => 'Enemies run from the player',
            'category' => 2,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('holiday', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
        ],
        'monstermash' => [
            'key' => 'monstermash',
            'value' => 'Randomize which monsters appear in dungeons',
            'category' => 3,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('monstermash', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
        ],
        'nothingpersonnelkid' => [
            'key' => 'nothingpersonnelkid',
            'value' => 'Extremely aggressive enemies',
            'category' => 3,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('nothingpersonnelkid', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
        ],
        'anywhere' => [
            'key' => 'anywhere',
            'value' => 'Equipment slots are randomized (breaks "Strongest")',
            'category' => 3,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('anywhere', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
        ],
        'nocap' => [
            'key' => 'nocap',
            'value' => 'Disable multiple capsule monsters being usable in battle',
            'category' => 3,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('nocap', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
        ],
        'blitz' => [
            'key' => 'blitz',
            'value' => "Allows a faster playthrough (\u{26A0}Testing Phase)",
            'category' => 0,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('blitz', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
        ],
        'sinistrals' => [
            'key' => 'sinistrals',
            'value' => "Maidens are always guarded by sinistrals.<br>Makes Daos last boss.",
            'category' => 0,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('sinistrals', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
            'behavior' => [
                'off' => ['code-last_sinistral']
            ],
        ],
        'last_sinistral' => [
            'key' => 'last_sinistral',
            'value' => "Last boss is always one of the sinistrals.<br>Conflicts with 'sinistrals' code.",
            'category' => 0,
            'allowed' => true,
            'displayed' => true,
            'enabled' => in_array('last_sinistral', explode(',', env('RANDOMIZER_DEFAULT_CODE', ''))),
            'behavior' => [
                'off' => ['code-sinistrals']
            ],
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Presets
    |--------------------------------------------------------------------------
    | label:      the string that is displayed to the user
    | displayed:  whether this preset should be shown in the form
    | palette[]:  array of color codes or BS variables https://getbootstrap.com/docs/5.0/customize/css-variables/
    |             background-color: color/var for the preset bg color
    |             border-color:     color/var for the preset border color
    |             color:            color/var for the preset text color
    |
    |             example: '#FF0000', 'var(--bs-red)', 'transparent'
    | behavior[]: on:    array of codes to toggle on when toggling this
    |             set[]: arrays containing key + value pairs of mods to set when toggling this
    |
    |             example on/off: ['flag-c', 'code-airship']
    |             example set:    [['mod-randomness', '1.5'], ['mod-difficulty', '2']]
    */
    'preset' => [
        'recommended' => [
            'key' => "recommended",
            'label' => "Recommended",
            'displayed' => true,
            'enabled' => true,
            'palette' => [
                'background-color' => 'var(--bs-success)',
                'border-color' => 'var(--bs-success)',
                'color' => 'var(--bs-white)',
            ],
            'behavior' => [
                'on' => ['flag-s', 'flag-t', 'flag-w', 'code-nocap'],
                'set' => [
                    'mod-randomness' => [
                        'key' => 'mod-randomness',
                        'value' => '0.5'
                    ],
                    'mod-difficulty' => [
                        'key' => 'mod-difficulty',
                        'value' => '1.0'
                    ],
                ],
            ],
        ],
        'full' => [
            'key' => "full",
            'label' => "Full",
            'displayed' => true,
            'enabled' => true,
            'palette' => [
                'background-color' => 'var(--bs-danger)',
                'border-color' => 'var(--bs-danger)',
                'color' => 'var(--bs-white)',
            ],
            'behavior' => [
                'on' => ['flag-c','flag-i','flag-l','flag-m','flag-o','flag-p','flag-s','flag-t','flag-w','code-monstermash','code-scale','code-nocap'],
                'set' => [
                    'mod-randomness' => [
                        'key' => 'mod-randomness',
                        'value' => '0.5'
                    ],
                    'mod-difficulty' => [
                        'key' => 'mod-difficulty',
                        'value' => '1.0'
                    ],
                ],
            ],
        ],
        'fourkeys' => [
            'key' => "fourkeys",
            'label' => "Four Keys",
            'displayed' => true,
            'enabled' => true,
            'palette' => [
                'background-color' => 'var(--bs-warning)',
                'border-color' => 'var(--bs-warning)',
                'color' => 'var(--bs-dark)',
            ],
            'behavior' => [
                'on' => ['flag-s', 'flag-t', 'flag-w', 'code-fourkeys', 'code-scale', 'code-nocap'],
                'set' => [
                    'mod-randomness' => [
                        'key' => 'mod-randomness',
                        'value' => '0.5'
                    ],
                    'mod-difficulty' => [
                        'key' => 'mod-difficulty',
                        'value' => '1.0'
                    ],
                ],
            ],
        ],
        'blitz' => [
            'key' => "blitz",
            'label' => "Blitz",
            'displayed' => true,
            'enabled' => true,
            'palette' => [
                'background-color' => 'var(--bs-dark)',
                'border-color' => 'var(--bs-info)',
                'color' => 'var(--bs-info)',
            ],
            'behavior' => [
                'on' => ['flag-s', 'flag-t', 'flag-w', 'code-blitz', 'code-scale', 'code-nocap'],
                'set' => [
                    'mod-randomness' => [
                        'key' => 'mod-randomness',
                        'value' => '0.5'
                    ],
                    'mod-difficulty' => [
                        'key' => 'mod-difficulty',
                        'value' => '1.0'
                    ],
                ],
            ],
        ],
        'race' => [
            'key' => "standard-race",
            'label' => "Standard Race",
            'displayed' => true,
            'enabled' => true,
            'palette' => [
                'background-color' => 'var(--bs-light)',
                'border-color' => 'var(--bs-light)',
                'color' => 'var(--bs-dark)',
            ],
            'behavior' => [
                'on' => ['flag-s', 'flag-t', 'flag-w', 'code-monstermash', 'code-noscale', 'code-nocap'],
                'set' => [
                    'mod-randomness' => [
                        'key' => 'mod-randomness',
                        'value' => '0.5'
                    ],
                    'mod-difficulty' => [
                        'key' => 'mod-difficulty',
                        'value' => '1.0'
                    ],
                ],
            ],
        ],
        'nightmare' => [
            'key' => "nightmare",
            'label' => "Nightmare",
            'displayed' => true,
            'enabled' => true,
            'palette' => [
                'background-color' => 'var(--bs-dark)',
                'border-color' => 'var(--bs-danger)',
                'color' => 'var(--bs-danger)',
            ],
            'behavior' => [
                'on' => ['flag-s', 'flag-t', 'flag-w', 'code-scale', 'code-monstermash', 'code-bossy', 'code-nocap'],
                'set' => [
                    'mod-randomness' => [
                        'key' => 'mod-randomness',
                        'value' => '0.6'
                    ],
                    'mod-difficulty' => [
                        'key' => 'mod-difficulty',
                        'value' => '2.0'
                    ],
                ],
            ],
        ],
        'reset' => [
            'key' => "reset",
            'label' => "Reset",
            'displayed' => true,
            'enabled' => true,
            'palette' => [
                'background-color' => 'var(--bs-info)',
                'border-color' => 'var(--bs-info)',
                'color' => 'var(--bs-dark)',
            ],
            'behavior' => [
                'on' => [
                    'flag-'.implode(',#flag-', explode(',', env('RANDOMIZER_DEFAULT_FLAG', 'w'))),
                    'code-'.implode(',#code-', explode(',', env('RANDOMIZER_DEFAULT_CODE', null))),
                ],
                'set' => [
                    'mod-randomness' => [
                        'key' => 'mod-randomness',
                        'value' => env('RANDOMIZER_DEFAULT_RANDOMNESS', "0.5")
                    ],
                    'mod-difficulty' => [
                        'key' => 'mod-difficulty',
                        'value' => env('RANDOMIZER_DEFAULT_DIFFICULTY', "1.0")
                    ],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Mods
    |--------------------------------------------------------------------------
    | label:       the string that is displayed to the user
    | displayed:   whether this mod should be shown in the form
    | description: the description string that is displayed to the user
    | value:       the mod's initial value
    | min:         the mod's minimum value
    | max:         the mod's maximum value
    | step:        the value step
    */
    'mod' => [
        'randomness' => [
            'key' => 'randomness',
            'label' => 'Randomness',
            'displayed' => true,
            'description' => 'This option controls how extreme the randomizations are. At 0.0, almost nothing will be randomized. At 1.0, enemies in the starting area will most likely have boss stats. Any open world setting squares the randomness (x^2).',
            'value' => env('RANDOMIZER_DEFAULT_RANDOMNESS', "0.5"),
            'min' => env('RANDOMIZER_DEFAULT_RANDOMNESS_MIN', "0.0"),
            'max' => env('RANDOMIZER_DEFAULT_RANDOMNESS_MAX', "1.0"),
            'step' => env('RANDOMIZER_DEFAULT_RANDOMNESS_STEP', "0.05"),
        ],
        'difficulty' => [
            'key' => 'difficulty',
            'label' => 'Difficulty',
            'displayed' => true,
            'description' => 'This option controls how extreme the difficulty modifier is. Any setting beyond 1.0 becomes unbalanced relatively quickly.',
            'value' => env('RANDOMIZER_DEFAULT_DIFFICULTY', "1.0"),
            'min' => env('RANDOMIZER_DEFAULT_DIFFICULTY_MIN', "0.5"),
            'max' => env('RANDOMIZER_DEFAULT_DIFFICULTY_MAX', "3.0"),
            'step' => env('RANDOMIZER_DEFAULT_DIFFICULTY_STEP', "0.1"),
        ],
    ],
];
