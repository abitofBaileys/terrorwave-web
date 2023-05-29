<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Mauricius\LaravelHtmx\Http\HtmxRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Process;

class Randomizer extends BaseController
{
    private ?HtmxRequest $request = null;
    public array $allowed = [
        // These are the valid file md5 checksums to accept
        'file' => [
            ['key' => '6efc477d6203ed2b3b9133c1cd9e9c5d', 'value' => 'NA'],
            ['key' => '026b649ed316448e038349e39a6fe579', 'value' => 'Fixxxer'],
            ['key' => 'b58c76f2ac0b2aeb9b779e880d2bff18', 'value' => 'Frue']
        ],
        // These are the valid flags
        'flag' => [
            ['key' => 'c', 'value' => 'Randomize characters'],
            ['key' => 'i', 'value' => 'Randomize items and equipment'],
            ['key' => 'l', 'value' => 'Randomize learnable spells'],
            ['key' => 'm', 'value' => 'Randomize monsters'],
            ['key' => 'o', 'value' => 'Randomize monster movements'],
            ['key' => 'p', 'value' => 'Randomize capsule monsters'],
            ['key' => 's', 'value' => 'Randomize shops'],
            ['key' => 't', 'value' => 'Randomize treasure chests'],
            ['key' => 'w', 'value' => 'Create an open-world seed'],
            'default' => 'v',
        ],
        // These are the valid codes
        'code' => [
            ['key' => 'airship',             'value' => 'Start the game with the airship'],
            ['key' => 'bossy',               'value' => 'Very random bosses (unbalanced even with scaling)'],
            ['key' => 'fourkeys',            'value' => 'Open World, but there are only four keys'],
            ['key' => 'scale',               'value' => 'Scale enemy status in open-world mode'],
            ['key' => 'noscale',             'value' => 'Do not scale enemies in open-world mode'],
            ['key' => 'splitscale',          'value' => 'Input custom values for scaling bosses and nonbosses'],
            ['key' => 'easymodo',            'value' => 'Every enemy dies in one hit'],
            ['key' => 'holiday',             'value' => 'Enemies run from the player'],
            ['key' => 'monstermash',         'value' => 'Randomize which monsters appear in dungeons'],
            ['key' => 'nothingpersonnelkid', 'value' => 'Extremely aggressive enemies'],
            ['key' => 'anywhere',            'value' => 'Equipment slots are randomized (breaks "Strongest")'],
            ['key' => 'nocap',               'value' => 'Disable multiple capsule monsters being usable in battle'],
        ],
    ];

    /**
     * @param HtmxRequest $request The request issued by the htmx form
     * @throws Exception
     */
    public function makeRom(HtmxRequest $request)
    {
        if ($request->isHtmxRequest()) {
            // Save the request to use elsewhere in this class
            $this->request = $request;

            // If invalid checksum, return error message
            if (!$this->validateChecksum()) {
                return view('fragments.error');
            }

            // Get original filename
            $_originalFile = $this->request->file('file')->getClientOriginalName();
            // Store filename and extension separately
            $filename = pathinfo($_originalFile, PATHINFO_FILENAME);
            $extension = pathinfo($_originalFile, PATHINFO_EXTENSION);
            // Store the file in public storage under original filename
            $path = Storage::putFileAs(
                'roms',
                $this->request->file('file'),
                $_originalFile
            );

            // Filter out all flags that are not allowed
            $flags = $this->getSanitizedArgumentsFromRequest('flag');

            // Filter out all codes that are not allowed
            $codes = $this->getSanitizedArgumentsFromRequest('code');

            // Get seed from form, if none or invalid, create new
            $seed = $this->request->get('seed') ?? $this->newSeed();
            $seed = substr($seed,0,10);
            $seed = ltrim($seed,"0");
            $seed = ($this->isOnlyDigits($seed)) ? $seed : $this->newSeed();

            // Get randomness factor from form, if none specified use 0.5
            $randomness = ($this->request->get('randomness') ?? "0.5");

            // Get difficulty factor from form, if none specified use 1.0
            $difficulty = ($this->request->get('difficulty') ?? "1.0");

            // Chain arguments to a single string
            $argumentString = " {$flags}{$codes} {$seed} {$randomness} {$difficulty}";

            // Build the command to execute
            $command = "python " . base_path() . '/vendor/abyssonym/terrorwave/randomizer.py ';
            $command .= "'" . base_path('/public/storage/') . "{$path}'{$argumentString}";

            // Start the process
            //dd(storage_path('app'));
            $process = Process::run($command);

            if ($process->successful()) {
                // Build the file path to the randomized Rom file based on randomizer naming scheme
                // "The randomizer will output a new, randomized rom with the seed in the filename."
                // e.g. L2.sfc -> L2.stw.123456789.sfc
                $outputFilePath = "storage/roms/{$filename}.{$flags}.{$seed}.{$extension}";
                $outputSpoilerFilePath = "storage/roms/spoiler.{$filename}.{$flags}.{$seed}.{$extension}.txt";
                // Return a download button to this Rom file

                return view('fragments.download', [
                    'file_path' => $outputFilePath,
                    'file_name' => "{$filename}.{$flags}.{$seed}.{$extension}",
                    'spoiler_file_path' => $outputSpoilerFilePath,
                    'spoiler_file_name' => "spoiler.{$filename}.{$flags}.{$seed}.{$extension}.txt",
                ]);
            } else {
                return view('fragments.errorprocess',['data' => $process->errorOutput()]);
            }
        } else {
            dd("JavaScript is not activated or you didn't POST via htmx.");
        }
    }


    /**
     * Sanitizes arguments passed from the form and returns a string containing the arguments
     * @param string $type The input name, referring the keys in $this->allowed
     * @return String
     */
    private function getSanitizedArgumentsFromRequest(string $type) : String
    {
        $arguments = array();
        // Filter out all arguments that are not allowed
        foreach ($this->request->get($type) ?? [] as $lookupKey) {
            if ($this->lookupAllowed($lookupKey, $type)) {
                $arguments[] = $lookupKey;
            }
        }
        // If no arguments are given, use default value if exists, otherwise empty string
        if (sizeof($arguments) === 0) $arguments[] = ($this->allowed[$type]['default'] ?? '');
        return implode($arguments);
    }

    private function validateChecksum() : bool
    {
        $fileCSUM = md5_file($this->request->file('file'));
        return $this->lookupAllowed($fileCSUM, 'file');
    }

    /**
     * Returns whether $needle exists in $this->allowed[$type]['key']
     * @param string $needle The string to check
     * @param string $type
     * @return bool
     */
    private function lookupAllowed(string $needle, string $type) : bool
    {
        return in_array($needle, array_column($this->allowed[$type], "key"));
    }

    /**
     * Checks whether a string only contains digits
     * Also trims 0s in front
     * @param string $string The input string
     * @return bool
     */
    private static function isOnlyDigits(string $string): bool
    {
        return ctype_digit($string);
    }

    /**
     * Returns a new seed
     * @throws Exception
     */
    private static function newSeed(): string
    {
        return (string) random_int(1, 9999999999);
    }

    /**
     * @param HtmxRequest $request The request issued by the htmx form
     */
    private function deleteRoms(HtmxRequest $request)
    {
        dd("Not implemented yet.");
        if ($this->request->isHtmxRequest()) {
            $foo = File::delete([
                $this->request->get('file_path'),
                $this->request->get('file_path_orig'),
                $this->request->get('file_path_spoiler'),
            ]);
            dd($foo);
        } else {
            dd("JavaScript is not activated or you didn't POST via htmx.");
        }
    }

}
