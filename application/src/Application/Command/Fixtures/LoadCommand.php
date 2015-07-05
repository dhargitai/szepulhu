<?php

namespace Application\Command\Fixtures;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadCommand extends Command
{
    private $output;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('szepulhu:fixtures:load')
            ->setDescription('Generate development data for the Szepul.hu project.')
            ->setHelp(<<<EOT
Generate development data for the Szepul.hu project.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->dropDatabaseSchema();
        $this->createDatabaseSchema();
        $this->importExistingData();
        $this->loadFixturesWithoutTruncate();
    }

    private function dropDatabaseSchema()
    {
        return $this->runCommandWithArguments('doctrine:schema:drop', ['--force' => true]);
    }

    private function createDatabaseSchema()
    {
        return $this->runCommandWithArguments('doctrine:schema:create');
    }

    private function importExistingData()
    {
        $returnCodes = [];
        $sqlFilesToImport = [
            'src/Application/DataFixtures/sql/01.Country-County.sql',
            'src/Application/DataFixtures/sql/02.City.sql',
        ];

        foreach ($sqlFilesToImport as $file) {
            $returnCodes[$file] = $this->runCommandWithArguments('dbal:import', ['file' => $file]);
        }

        return $returnCodes;
    }

    private function loadFixturesWithoutTruncate()
    {
        return $this->runCommandWithArguments('doctrine:fixtures:load', ['--append' => true]);
    }

    private function runCommandWithArguments($commandName, array $arguments = [])
    {
        $command = $this->getApplication()->find($commandName);
        $arguments = array_merge(['command' => $commandName], $arguments);
        $input = new ArrayInput($arguments);
        return $command->run($input, $this->output);
    }
}
