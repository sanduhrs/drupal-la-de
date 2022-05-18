<?php

/**
 * @file
 * Contains \DrupalProject\composer\ScriptHandler.
 */

namespace DrupalProject\composer;

use Composer\Script\Event;
use Composer\Semver\Comparator;
use Symfony\Component\Filesystem\Filesystem;

class ScriptHandler {

  protected static function getDrupalRoot($project_root) {
    return $project_root . '/docroot';
  }

  public static function createRequiredDirectories (Event $event) {
    $fs = new Filesystem();
    $project_root = getcwd();
    $root = static::getDrupalRoot($project_root);

    // Create the files directory with chmod 0777.
    if (!$fs->exists("$root/sites/default/files")) {
      $oldmask = umask(0);
      $fs->mkdir("$root/sites/default/files", 0777);
      umask($oldmask);
    }
  }

  /**
   * Replaces a desired string with a new one in specified file
   *
   * @param $pathToFile
   * @param $newNew
   * @param $oldOld
   */
  public static function fileStringReplace($pathToFile, $newNew, $oldOld)
  {
    $content = file_get_contents($pathToFile);
    $content = str_replace($oldOld, $newNew, $content);
    file_put_contents($pathToFile, $content);
  }

  /**
   * Helper function to recursively copy files from one directory to another
   *
   * @param $src
   * @param $dst
   * @param $theme
   * @return bool
   * @see https://www.php.net/manual/en/function.copy.php#91010
   */
  public static function recursiveCopy($src, $dst, $theme): bool
  {
    // Check to make sure that source directory actually exists
    if(is_dir($src))
    {
      $dir = opendir($src);
      @mkdir($dst);

      while(false !== ( $file = readdir($dir)) )
      {
        if(( $file != '.' ) && ( $file != '..' ))
        {
          // recursively calls this function on directories
          if ( is_dir($src . '/' . $file) )
          {
            self::recursiveCopy($src . '/' . $file, $dst . '/' . $file, $theme);
          }
          else
          {
            $fileCopy = str_replace('starterkit', $theme, $file);
            copy($src . '/' . $file,$dst . '/' . $fileCopy);
            static::fileStringReplace($dst . '/' . $fileCopy, $theme, 'starterkit');
            static::fileStringReplace($dst . '/' . $fileCopy, ucfirst($theme), 'Starter Kit');
          }
        }
      }
      closedir($dir);
      return true;
    }
    else
    {
      echo "\033[31m$src is not a valid directory\n";
      return false;
    }


  }

  /**
   * @param Event $event
   * Copy themekit's and adminkit's starterkit from contrib folders to custom folders
   */
  public static function themeStartkitCopy(Event $event)
  {
    $themes = ['themekit', 'adminkit'];
    $project_root = getcwd();
    $drupal_root = static::getDrupalRoot($project_root);

    foreach($themes as $theme) {
      if (!is_dir($drupal_root . "/themes/custom/$theme")) {
        if (!is_dir($drupal_root . 'themes/custom')) {
          @mkdir($drupal_root . '/themes/custom');
        }

        $srcFolder = $drupal_root . "/themes/contrib/paragon_$theme/starterkit";
        $dstFolder = $drupal_root . "/themes/custom/$theme";

        echo "  - Copy \033[32m$srcFolder \033[97mto \033[32m$dstFolder\033[97m\n";

        if (static::recursiveCopy($srcFolder, $dstFolder, $theme)) {
          echo "Successfully copied $srcFolder -> $dstFolder\n";
        } else {
          echo "Failed to copy $srcFolder -> $dstFolder\n";
        }
      }
    }
  }
}
