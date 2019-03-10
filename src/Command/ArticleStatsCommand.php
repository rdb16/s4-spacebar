<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ArticleStatsCommand extends Command
{
    protected static $defaultName = 'article:stats';

    protected function configure()
    {
        $this
            ->setDescription('Renvoie des statistiques sur les articles!!')
            ->addArgument('slug', InputArgument::OPTIONAL, 'le slug de l\'article')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'Format de sortie','text')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');

        $data = [
            'slug' => $slug,
            'hearts' => rand(10,100),
        ];

       switch ($input->getOption('format')) {
           case 'text':
               $rows = [];
               foreach ($data as $key =>$val){
                   $rows[] = [$key, $val];
               }
               $io->table(['clé', 'valeur'], $rows);
               break;

           case 'json':
               $io->write(json_encode($data));
               break;

           default:
               throw new \Exception('Format pas prévu, byyyyee...');
       }
    }
}
