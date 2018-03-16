<?php

namespace SKYCore\Console;

use Symfony\Component\Console\{
    Command\Command,
    Input\InputArgument,
    Input\InputInterface,
    Output\OutputInterface
};

class configurationCommand extends Command
{
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(printf(getLangGroup('cli','ConfigurationCommand','text1'),$this->getName()));
    }

    protected function configure()
    {
        $this->setName('app:set_config')
            ->setDescription(getLangGroup('cli','ConfigurationCommand','description'))
            ->setHelp(getLangGroup('cli','ConfigurationCommand','help'))
            ->addArgument('app',InputArgument::REQUIRED)
            ->addArgument('configuration-key',InputArgument::REQUIRED)
            ->addArgument('value',InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(getLangGroup('cli','ConfigurationCommand',''));
    }

}