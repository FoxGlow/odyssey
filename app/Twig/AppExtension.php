<?php

namespace App\Twig;

use Core\File\Config;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension {

    public function getFunctions()
    {
        return [
            new TwigFunction('css', [$this, 'css']),
            new TwigFunction('svg', [$this, 'svg']),
            new TwigFunction('formError', [$this, 'formError'])
        ];
    }

    public function css(string $css_file) {
        return Config::get('paths.css') . DIRECTORY_SEPARATOR . $css_file;
    }

    public function svg(string $svg_file) {
        echo file_get_contents('.' . Config::get('paths.images') . DIRECTORY_SEPARATOR . $svg_file);
    }

    public function formError($error) {
        if (strlen($error) != 0)
            echo "<span id=\"error-register\" class=\"error\">$error</span>";
    }

}