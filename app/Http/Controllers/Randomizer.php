<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Mauricius\LaravelHtmx\Http\HtmxRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Process;

class Randomizer extends BaseController
{
    // These are the valid file md5 checksums to accept
    public array $MD5_hashes = [
        ['hash' => '6efc477d6203ed2b3b9133c1cd9e9c5d', 'version' => 'NA'],
        ['hash' => '026b649ed316448e038349e39a6fe579', 'version' => 'Fixxxer'],
        ['hash' => 'b58c76f2ac0b2aeb9b779e880d2bff18', 'version' => 'Frue']
    ];
    /**
     * @param HtmxRequest $request The request issued by the htmx form
     */
    public function makeRom(HtmxRequest $request)
    {
        if ($request->isHtmxRequest()) {

            // Fetch the uploaded file
            $uploadedFile = $request->file('file');
            // Compare checksums
            $fileCSUM = md5_file($uploadedFile);
            $CSUM_valid = in_array($fileCSUM, array_column($this->MD5_hashes, 'hash'));
            // If invalid checksum, return error message
            if (!$CSUM_valid) {
                return view()->renderFragment('output', 'error');
            }

            // Get original filename
            $_originalFile = $uploadedFile->getClientOriginalName();
            // Store filename and extension separately
            $filename = pathinfo($_originalFile, PATHINFO_FILENAME);
            $extension = pathinfo($_originalFile, PATHINFO_EXTENSION);
            // Store the file in public storage under original filename
            $path = Storage::putFileAs(
                'public/roms',
                $request->file('file'),
                $_originalFile
            );

            // Get flags from form, if none specified, use v flag (Dummy flag: Randomize nothing)
            $flags = implode($request->get('flag') ?? ["v"]);
            // Get secret codes from form, if none specified, use no codes
            $codes = implode($request->get('code') ?? [""]);
            // Get seed from form, if none specified, use timestamp
            $seed = ($request->get('seed') ?? time());
            // Get randomness factor from form, if none specified use 0.5
            $randomness = ($request->get('randomness') ?? "0.5");
            // Get difficulty factor from form, if none specified use 1.0
            $difficulty = ($request->get('difficulty') ?? "1.0");
            // Chain arguments to a single string
            $arguments = " ".$flags.$codes." ".$seed." ".$randomness." ".$difficulty;

            // Build the command to execute
            $command = "python " . base_path().'/vendor/abyssonym/terrorwave/randomizer.py ';
            $command .= "'".storage_path('app') . "/" . $path."'".$arguments;

            // Start the process
            Process::path(storage_path('app'))->run($command);
            // Build the file path to the randomized Rom file based on randomizer naming scheme
            // "The randomizer will output a new, randomized rom with the seed in the filename."
            // e.g. L2.sfc -> L2.stw.123456789.sfc
            $outputFilePath = "storage/roms/" . $filename . '.' . $flags . '.' . $seed . '.' . $extension;
            $outputSpoilerFilePath = "storage/roms/spoiler." . $filename . '.' . $flags . '.' . $seed . '.' . $extension . ".txt";
            // Return a download button to this Rom file
            return view()->renderFragment('output', 'download', [
                'file_path' => $outputFilePath,
                'file_name' => $filename . '.' . $flags . '.' . $seed . '.' . $extension,
                'spoiler_file_path' => $outputSpoilerFilePath,
                'spoiler_file_name' => "spoiler." . $filename . '.' . $flags . '.' . $seed . '.' . $extension . ".txt",
            ]);
        } else {
            dd("JavaScript is not activated or you didn't POST via htmx.");
        }
    }

    /**
     * @param HtmxRequest $request The request issued by the htmx form
     */
    public function deleteRoms(HtmxRequest $request)
    {
        if ($request->isHtmxRequest()) {
            $foo = File::delete([
                    $request->get('file_path'),
                    $request->get('file_path_orig'),
                    $request->get('file_path_spoiler'),
                ]);
            dd($foo);
        } else {
            dd("JavaScript is not activated or you didn't POST via htmx.");
        }
    }
}
