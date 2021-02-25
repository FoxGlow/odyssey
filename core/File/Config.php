<?php
/**
 * Lets the developper get a quick access to config file variables
 * 
 * @author Hugolin Mariette
 */

namespace Core\File;

use Core\File\Exceptions\ConfigFileNotFoundException;
use Core\File\Exceptions\KeyNotFoundException;
use Core\File\Exceptions\NoConfigFileLoadedException;

class Config {
    /**
     * @var array the configuration
     */
    private static $config = null;

    /**
     * Loads a config file that return an array
     * @param string $config_file the configuration file
     * @throws ConfigFileNotFoundException if the config file cannot be loaded
     */
    public static function load(string $config_file) {
        try {
            self::$config = require($config_file);
        }
        catch (ConfigFileNotFoundException $e) {
            throw $e;
        }
    }

    /**
     * Gets the value of the key
     * @param string|null $key the key to find
     * @param mixed $default the value returned if no entry was found
     * @throws KeyNotFoundException if no entry was found for this key and if no default value was set too
     * @return mixed
     */
    public static function get(?string $key = null, $default = null) {
        if (self::$config === null) throw new NoConfigFileLoadedException();
        if (is_null($key) || $key === "") return self::$config;
        $exploded_key = explode('.', $key);
        $depth = count($exploded_key);
        $current = self::$config;
        for ($i = 0; $i < $depth; $i++) {
            if (!array_key_exists($exploded_key[$i], $current)) {
                if (!isset($default)) throw new KeyNotFoundException($key);
                return $default;
            }
            $current = $current[$exploded_key[$i]];
        }
        return $current;
    }
}