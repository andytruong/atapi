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
        $rootNode = $treeBuilder->root('atapi');

        /* @var $route_item NodeBuilder */
        $route_item = $rootNode->children()->arrayNode('routes')->prototype('array')->children();

        $this->oldStyleRouteItem($route_item);
        $this->templateRouteItem($route_item);

        return $treeBuilder;
    }

    private function oldStyleRouteItem(NodeBuilder $route_item)
    {
        $route_item->scalarNode('title')->isRequired();
        $route_item->booleanNode('access');
        $route_item->arrayNode('access arguments')->prototype('scalar');
    }

    private function templateRouteItem(NodeBuilder $route_item)
    {
        /* @var $controller NodeBuilder */
        $controller = $route_item->arrayNode('controller')->children();
        $controller->scalarNode(0)->isRequired();
        $controller->scalarNode(1)->isRequired();
        $controller->variableNode(2);

        // Template/Templates/Inline template
        // @todo: validate -> developer can only provide config for one.
        $route_item->scalarNode('content');
        $route_item->scalarNode('template');
        $route_item->arrayNode('templates')->prototype('scalar');

        // Template variables
        $route_item->variableNode('variables');
    }

}
