<?php

namespace FerdinandFrank\LaravelFileGenerator;

/**
 * StubFinder
 * -----------------------
 * Tries to find the path to a stub file or to the stubs folder.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank
 */
class StubHelper {

    /**
     * Path to the Laravel Framework source directory
     *
     * @var string
     */
    private static $FRAMEWORK_PATH = 'vendor/laravel/framework/src/';

    /**
     * The framework paths where to search for the used stub file or folder.
     *
     * @var array
     */
    private static $STUB_FRAMEWORK_PATHS = [
        'Illuminate/Database/Console/Seeds/stubs/',
        'Illuminate/Foundation/Console/stubs/',
        'Illuminate/Routing/Console/stubs/'
    ];

    /**
     * Gets the path to the specified stub file or to the stubs folder if no file is specified.
     *
     * @param null|string $stubFile The stub file to search. Can be null to just search for the stubs folder.
     *
     * @return string|null The path to the stubs file/folder or {@code null} if no file/folder was found.
     */
    public static function find($stubFile = null) {

        // Check if the stub file/folder is found on the specified path of the user or on the default stubs path
        $path = self::getStubsFolderPath();
        if (file_exists($path . $stubFile ?? '')) {
            return $path . $stubFile ?? '';
        }

        // Check if the stub file/folder is found on the package's stub folder
        $path = __DIR__ . '/../resources/stubs/';
        if (file_exists($path . $stubFile ?? '')) {
            return $path . $stubFile ?? '';
        }

        // Check if the stub file/folder is found on the framework paths
        foreach (self::$STUB_FRAMEWORK_PATHS as $stubPath) {
            $path = base_path(self::$FRAMEWORK_PATH . $stubPath);
            if (file_exists($path . $stubFile ?? '')) {
                return $path . $stubFile ?? '';
            }
        }

        return null;
    }

    /**
     * Gets the path to the custom stub files.
     *
     * @return string
     */
    public static function getStubsFolderPath() {
        return config('laravel-file-generator.stubs_path', resource_path('stubs'));
    }
}