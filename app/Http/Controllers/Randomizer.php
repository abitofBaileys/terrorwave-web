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

    public function buildForm() {
        return view('randomizer',['data' => config('randomizer')]);
    }

    /**
     * @param HtmxRequest $request The request issued by the htmx form
     * @throws Exception
     */
    public function makeRom(HtmxRequest $request)
    {
        if ($request->isHtmxRequest()) {
            // Save the request to use elsewhere in this class
            $this->request = $request;
            //dd($this->request);

            // If invalid checksum, return error message
            if (!$this->validateChecksum()) {
                return view('fragments.modal.error');
            }

            // Get original filename
            $_originalFile = $this->request->file('file')->getClientOriginalName();
            // Store filename and extension separately
            $filename = pathinfo($_originalFile, PATHINFO_FILENAME);
            $extension = pathinfo($_originalFile, PATHINFO_EXTENSION);
            // Store the file in public storage under original filename
            $path = Storage::putFileAs(
                'storage/app/public/roms',
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
            $command .= "'" . base_path() . "/{$path}'{$argumentString}";

            // Start the process
            //dd($command);
            //dd(storage_path());
            $process = Process::run($command);
            ///var/www/html/public/storage/roms/

            if ($process->successful()) {
                // Build the file path to the randomized Rom file based on randomizer naming scheme
                // "The randomizer will output a new, randomized rom with the seed in the filename."
                // e.g. L2.sfc -> L2.stw.123456789.sfc
                $outputFilePath = "/storage/roms/{$filename}.{$flags}.{$seed}.{$extension}";
                $outputSpoilerFilePath = "/storage/roms/spoiler.{$filename}.{$flags}.{$seed}.{$extension}.txt";
                // Return a download button to this Rom file

                return view('fragments.modal.download', [
                    'file_path' => $outputFilePath,
                    'file_name' => "{$filename}.{$flags}.{$seed}.{$extension}",
                    'spoiler_file_path' => $outputSpoilerFilePath,
                    'spoiler_file_name' => "spoiler.{$filename}.{$flags}.{$seed}.{$extension}.txt",
                ]);
            } else {
                return view('fragments.modal.errorprocess',['data' => $process->errorOutput()]);
            }
        } else {
            dd("JavaScript is not activated or you didn't POST via htmx.");
        }
    }


    /**
     * Sanitizes arguments passed from the form and returns a string containing the arguments
     * @param string $type The input name, referring the keys in config('randomizer.allowed')
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
        if (sizeof($arguments) === 0) $arguments[] = (config('randomizer.allowed')[$type]['default'] ?? '');
        if ($type == "flag") sort($arguments);
        return implode($arguments);
    }

    private function validateChecksum() : bool
    {
        $fileCSUM = md5_file($this->request->file('file'));
        return $this->lookupAllowed($fileCSUM, 'file');
    }

    /**
     * Returns whether $needle exists in config('randomizer.allowed')[$type]['key']
     * @param string $needle The string to check
     * @param string $type
     * @return bool
     */
    private function lookupAllowed(string $needle, string $type) : bool
    {
        return in_array($needle, array_column(config('randomizer')[$type], "key"));
    }

    /**
     * Checks whether a string only contains digits
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
