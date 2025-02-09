<?php

declare(strict_types=1);

namespace Application\Command;

use Laminas\Mvc\Application;
use Laminas\Router\RouteStackInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListRoutesCommand extends Command
{
    protected static $defaultName = 'list:routes';

    protected function configure()
    {
        $this->setDescription('Lista todas as rotas registradas no Laminas');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = Application::init(require 'config/application.config.php');
        $router = $app->getServiceManager()->get('Router');

        if (!$router instanceof RouteStackInterface) {
            $output->writeln('<error>Router não encontrado!</error>');
            return Command::FAILURE;
        }

        $output->writeln("<info>Rotas registradas:</info>");
        foreach ($router->getRoutes() as $name => $route) {
            $output->writeln(sprintf("<comment>%s</comment>: %s", $name, method_exists($route, 'getRoute') ? $route->getRoute() : 'N/A'));
        }

        return Command::SUCCESS;
    }
}
