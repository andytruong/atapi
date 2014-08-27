<?php

namespace Drupal\atapi\Config;

use Drupal\atapi\Config\Definition\RadioArrayNodeDefinition;
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
        $route_item = $rootNode->children()
            ->setNodeClass('radioArray', 'Drupal\atapi\Config\Definition\RadioArrayNodeDefinition')
            ->arrayNode('routes')
            ->prototype('radioArray');

        $this->oldStyleRouteItem($route_item->children());
        $this->templateRouteItem($route_item);

        return $treeBuilder;
    }

    private function oldStyleRouteItem(NodeBuilder $route_item)
    {
        $route_item->scalarNode('title')->isRequired();
        $route_item->booleanNode('access');
        $route_item->arrayNode('access arguments')->prototype('scalar');
    }

    private function templateRouteItem(RadioArrayNodeDefinition $route_item)
    {
        $children = $route_item->children();

        /* @var $controller NodeBuilder */
        $controller = $children->arrayNode('controller')->children();
        $controller->scalarNode(0)->isRequired();
        $controller->scalarNode(1)->isRequired();
        $controller->variableNode(2);

        // Template/Templates/Inline template
        $route_item->mustFillOnlyOneOfTheseKeys(['content', 'template', 'templates']);
        $children->scalarNode('content');
        $children->scalarNode('template');
        $children->arrayNode('templates')->prototype('scalar');

        // Template variables
        $children->variableNode('variables');
    }

}
