<?php

namespace Drupal\atapi\Config\Definition;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class RadioArrayNodeDefinition extends ArrayNodeDefinition
{

    private $radioOptions = [];

    public function mustFillOnlyOneOfTheseKeys(array $keys)
    {
        $this->radioOptions[] = $keys;
    }

    protected function createNode()
    {
        $node = parent::createNode();
        $node->setFinalValidationClosures([
            [$this, 'validateRadioOptions']
        ]);
        return $node;
    }

    public function validateRadioOptions($value)
    {
        foreach ($this->radioOptions as $radioOptions) {
            $count = 0;
            foreach ($radioOptions as $radioKey) {
                if (!is_null($value[$radioKey])) {
                    $count++;
                }
            }

            switch ($count) {
                case 1:
                    return $value;

                case 0:
                    throw new InvalidConfigurationException('One of these keys is required but none given: ' . implode(', ', $radioOptions));

                default:
                    throw new InvalidConfigurationException('Only one of these keys is allowed: ' . implode(', ', $radioOptions));
            }
        }
    }

}
