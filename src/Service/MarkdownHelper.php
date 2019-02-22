<?php
/**
 * Created by PhpStorm.
 * User: rdb
 * Date: 2019-02-20
 * Time: 17:11
 */

namespace App\Service;


use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{
    private $cache;
    private $markdown;
    private $logger;
    private $isDebug;

    public function  __construct(AdapterInterface $cache, MarkdownInterface $markdown,
                                 LoggerInterface $logger, bool $isDebug)
    {
        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }

    public function parse(string $source): string
    {
        if ($this->isDebug) {
            if (stripos($source, 'bacon') !== false) {
                $this->logger->info('On parle encore de jambon !!!!!');
            }
        }

        //dump($this->cache);die;



        $item = $this->cache->getItem('markdown_'.md5($source));
        if(!$item->isHit()){
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }

        return $item->get();
    }
}
