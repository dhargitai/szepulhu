<?php

namespace Application\Command\Doctrine;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;

/**
 * Class ImportCommand
 *
 * This class is extending the default Doctrine import command to be able to use dbal:import in the app/console.
 * This command is disabled in the Symfony version of Doctrine by default.
 *
 * @package Application\Command
 * Source reference:
 * http://stackoverflow.com/questions/23234127/enabling-doctrine-dbal-commands-in-symfony-app-console#answer-23258819
 */
class ImportCommand extends \Doctrine\DBAL\Tools\Console\Command\ImportCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getApplication()->getKernel()->getContainer();

        $doctrine = $container->get('doctrine');

        $em = $doctrine->getEntityManager();
        $db = $em->getConnection();

        $helperSet = $this->getHelperSet();
        $helperSet->set(new ConnectionHelper($db), 'db');
        $helperSet->set(new EntityManagerHelper($em), 'em');

        parent::execute($input, $output);
    }
}
