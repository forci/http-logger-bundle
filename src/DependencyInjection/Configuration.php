<?php

/*
 * This file is part of the ForciHttpLoggerBundle package.
 *
 * (c) Martin Kirilov <wucdbm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Forci\Bundle\HttpLoggerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('forci_http_logger');

        $rootNode
            ->children()
                ->arrayNode('configs')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->stringNode('table_prefix')->cannotBeEmpty()->end()
                            ->stringNode('log_class')->cannotBeEmpty()->end()
                            ->stringNode('log_message_class')->cannotBeEmpty()->end()
                            ->stringNode('log_message_type_class')->cannotBeEmpty()->end()
                            ->stringNode('log_exception_class')->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
