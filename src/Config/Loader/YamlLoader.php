<?php

namespace Drupal\atapi\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlLoader extends FileLoader
{

    public function load($resource, $type = null)
    {
        $rawConfig = array();
        $paths = $this->getLocator()->locate($resource);
        foreach (is_string($paths) ? array($paths) : $paths as $path) {
            $rawConfig = \array_merge($rawConfig, Yaml::parse($path));
        }

        // handle the config values
        // maybe import some other resource:
        // $this->import('extra_users.yml');

        return $rawConfig;
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo(
                $resource, PATHINFO_EXTENSION
        );
    }

}
