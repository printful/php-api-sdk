<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Printful\Exceptions\PrintfulApiFileNotFoundException;

if(!function_exists('readEnvFile')) {
    function readEnvFile()
    {
        $envFile = __DIR__ . '/../.env';
        if (!file_exists($envFile)) {
            throw new PrintfulApiFileNotFoundException('Environment file not found. Please create a .env file according to the .env.example file.');
        }

        try {
            $fn = fopen($envFile, "r");
            while (!feof($fn)) {
                $line = fgets($fn);
                if ($line) {
                    list($key, $value) = explode('=', $line);
                    $value = preg_replace("/[\n\r]/",'', $value);
                    $value = trim($value, '"');
                    putenv("$key=$value");
                }
            }
            fclose($fn);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

    }
}

readEnvFile();