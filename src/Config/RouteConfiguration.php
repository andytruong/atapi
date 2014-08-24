<?php

namespace Drupal\atapi\Config;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class RouteConfiguration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('routing');

        /* @var $route_item NodeBuilder */
        $route_item = $rootNode->children()->arrayNode('routes')->prototype('array')->children();
        $route_item->scalarNode('title')->isRequired();
        $route_item->booleanNode('access');
        $route_item->arrayNode('access arguments')->prototype('scalar');

        /* @var $controller NodeBuilder */
        $controller = $route_item->arrayNode('controller')->children();
        $controller->scalarNode(0)->isRequired();
        $controller->scalarNode(1)->isRequired();
        $controller->arrayNode(2)->prototype('scalar');

        // Template/Templates/Inline template
        $route_item->scalarNode('content');
        $route_item->scalarNode('template');
        $route_item->arrayNode('templates')->prototype('scalar');

        // Template variables
        $route_item->variableNode('variables');
        # $route_item->

        return $treeBuilder;
    }

}
