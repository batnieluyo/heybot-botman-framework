<?php

namespace App\AutoLoaders;

use InvalidArgumentException;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

/**
 * For extremely large directories, using lower-level functions like scandir or glob can offer better performance since these functions are closer to the underlying file system operations and have less overhead compared to higher-level abstractions like Symfony's Finder. Below are examples of how to use scandir and glob for efficiently handling large directories.
 * scandir is likely to be more performant and memory-efficient as it processes files one at a time.
 * glob is a good alternative when you need simple pattern matching and can afford loading all matching files into memory at once.
 * Both methods offer better performance than higher-level abstractions like Symfony's Finder, especially in scenarios with large numbers of files or when low-level control is needed.
 * */
class JourneyAutoloader
{
    /**
     * @return \App\AutoLoaders\JourneyStageInterface
     */
    public static function boot(string $stage)
    {
        $location = base_path('app/Actions/Journey/Stages');
        $namespace = 'App\\Actions\\Journey\\Stages\\';

        $files = (new Finder)
            ->in($location)
            ->depth(0)
            ->files()
            ->name('*.php');

        $classBase = null;

        foreach ($files as $file) {
            if ($file instanceof SplFileInfo) {
                $basename = basename($file->getRelativePathname(), '.php');
                $stageClass = $namespace.$basename;

                if (defined("$stageClass::ACTION_NAME")
                    && $stageClass::ACTION_NAME === $stage
                ) {
                    $classBase = $stageClass;
                    break;
                }
            }
        }

        if (is_null($classBase)) {
            throw new InvalidArgumentException("The $stage stage is not registered");
        }

        return new $classBase;
    }
}
