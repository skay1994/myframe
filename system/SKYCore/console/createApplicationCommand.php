<?php

namespace SKYCore\Console;

use Symfony\Component\Console\{
    Command\Command, Command\LockableTrait, Input\InputInterface, Output\OutputInterface, Question\ConfirmationQuestion, Question\Question
};

class createApplicationCommand extends Command
{
    use LockableTrait;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $app_info = [
            'name' => '',
            'folder' => '',
            'enable_db' => false,
            'lang' => 'en',
            'meta_charset' => 'utf-8',
            'db_connect' => array(
                'driver'    =>  '' ,
                'user'      =>  '' ,
                'password'  =>  '' ,
                'dbname'    =>  ''
            )
        ];

        $output->writeln(getLangGroup('cli','CreateApplicationCommand','description'));

        $helper = $this->getHelper('question');

        $lang = getLangGroup('cli','CreateApplicationCommand','new');

        $output->writeln(PHP_EOL);
        $output->writeln($lang['title']);
        $output->writeln(PHP_EOL);

        $name = new Question($lang['name']);
        $app_info['name'] = $helper->ask($input,$output,$name);

        $folder = new Question($lang['folder']);
        $app_info['folder'] = $helper->ask($input,$output,$folder);

        $lang_app = new Question($lang['lang']);
        $app_info['lang'] = $helper->ask($input,$output,$lang_app);

        $output->writeln(PHP_EOL);
        $output->writeln($lang['database']['title']);
        $output->writeln(PHP_EOL);

        $enable_db = new ConfirmationQuestion($lang['database']['enable']);
        $app_info['enable_db'] = $helper->ask($input,$output,$enable_db);

        if($app_info['enable_db']){

            $output->writeln(PHP_EOL);
            $output->writeln($lang['database']['configuration']);
            $output->writeln(PHP_EOL);

            $driver = new Question($lang['database']['driver']);
            $app_info['db_connect']['driver'] = $helper->ask($input,$output,$driver);

            $name = new Question($lang['database']['driver']);
            $app_info['db_connect']['driver'] = $helper->ask($input,$output,$name);

        }
    }

    protected function configure(){
        $this->setName('app:create-new')
            ->setDescription(getLangGroup('cli','CreateApplicationCommand','description'))
            ->setHelp(getLangGroup('cli','CreateApplicationCommand','help'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(!$this->lock()){
            $output->writeln(getLangGroup('cli','geral','execution_exists'));
            return false;
        }
    }
}