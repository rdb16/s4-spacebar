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
use Symfony\Component\Security\Core\Security;

class MarkdownHelper
{
    private $cache;
    private $markdown;
    private $logger;
    private $isDebug;
    /**
     * @var Security
     */
    private $security;

    /**
     * MarkdownHelper constructor.
     * @param AdapterInterface $cache
     * @param MarkdownInterface $markdown
     * @param LoggerInterface $logger
     * @param bool $isDebug
     * @param Security $security
     */
    public function  __construct(AdapterInterface $cache, MarkdownInterface $markdown,
                                 LoggerInterface $logger, bool $isDebug, Security $security)
    {
        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->logger = $logger;
        $this->isDebug = $isDebug;
        $this->security = $security;
    }

    public function parse(string $source): string
    {

        if (stripos($source, 'bacon') !== false) {
            $this->logger->info('On parle encore de jambon !!!!!', [
                'user' => $this->security->getUser()
            ]);
        }

        if ($this->isDebug) {
            return $this->markdown->transform($source);

        }

        $item = $this->cache->getItem('markdown_'.md5($source));
        if(!$item->isHit()){
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }

        return $item->get();
    }
}
