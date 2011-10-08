<?php

namespace DoctrineExtensions\DataFixtures\Tools\Console\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Input\InputOption;
use Doctrine\Common\DataFixtures\Loader,
    Doctrine\Common\DataFixtures\Executor\ORMExecutor,
    Doctrine\Common\DataFixtures\Purger\ORMPurger,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\Internal\CommitOrderCalculator,
    Doctrine\ORM\Mapping\ClassMetadata;
use InvalidArgumentException;

require_once(realpath(dirname(__FILE__).'/../../../../../../../application/common.php'));

/**
 * Description of LoadFixturesCommand
 *
 * @author Loban Amaan Rahman
 */
class LoadFixturesCommand extends Command
{
    private $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
        
        parent::__construct();
    }
    
    protected function configure()
    {
        $this
            ->setName('fixtures:load')
            ->setDescription('Load data fixtures to your database.')
            ->addOption('fixtures', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The directory or file to load data fixtures from.')
            ->addOption('append', null, InputOption::VALUE_NONE, 'Append the data fixtures instead of flushing the database first.')
            ->setHelp(<<<EOT
The <info>fixtures:load</info> command loads data fixtures from your bundles:

  <info>./app/console fixtures:load</info>

You can also optionally specify the path to fixtures with the <info>--fixtures</info> option:

  <info>./app/console doctrine:fixtures:load --fixtures=/path/to/fixtures1 --fixtures=/path/to/fixtures2</info>

If you want to append the fixtures instead of flushing the database first you can use the <info>--append</info> option:

  <info>./app/console doctrine:fixtures:load --append</info>
EOT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->em) {
            throw new InvalidArgumentException(
                sprintf(
                    'Could not find an entity manager configured with the name "%s". Check your '.
                    'application configuration to configure your Doctrine entity managers.', $emName
                )
            );
        }

        $dirOrFile = $input->getOption('fixtures');
        if ($dirOrFile) {
            $paths = is_array($dirOrFile) ? $dirOrFile : array($dirOrFile);
        } else {
            $paths = array(APPLICATION_PATH . '/models/DataFixture');
        }

        $loader = new Loader();
        foreach ($paths as $path) {
            if (is_dir($path)) {
                $loader->loadFromDirectory($path);
            }
        }
        
        $fixtures = $loader->getFixtures();
        if (!$fixtures) {
            throw new InvalidArgumentException(
                sprintf('Could not find any fixtures to load in: %s', "\n\n- ".implode("\n- ", $paths))
            );
        }
        
        $purger = new ORMPurger($this->em);

        $executor = new ORMExecutor($this->em, $purger);
        $executor->setLogger(function($message) use ($output) {
            $output->writeln(sprintf('  <comment>></comment> <info>%s</info>', $message));
        });
        
        $executor->execute($fixtures, $input->getOption('append'));
    }

}

?>
