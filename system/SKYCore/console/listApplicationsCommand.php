<?php

namespace SKYCore\Console;

use Symfony\Component\Console\{
    Command\Command,
    Input\InputInterface,
    Output\OutputInterface
};

class listApplicationsCommand extends Command
{

    protected function configure()
    {
        $this->setName('app:list_all')
            ->setDescription(getLangGroup('cli','ListApplicationsCommand','description'))
            ->setHelp(getLangGroup('cli','ListApplicationsCommand','help'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf(getLangGroup('cli','ListApplicationsCommand','text1'),APPPATH.'global'.DS.'config.php'));

        $apps = getConfigs('apps');

        echo PHP_EOL;

        if(is_array($apps)){
            $a = 1;
            for($i = 0; $i < count($apps); $i++){
                echo $a.') '.$apps[$i].PHP_EOL;
                $a++;
            }
        } elseif (is_string($apps)){
            echo '1) '.$apps;
        }

        echo PHP_EOL;

        echo getLangGroup('cli','geral','default_app').getConfigs('default_app');

        echo PHP_EOL;

    }

}