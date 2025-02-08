<?php

declare(strict_types=1);

namespace Application;

class Module
{
    public function getConfig(): array
    {
        $configFile = __DIR__ . '/../config/module.config.php';

        if (!file_exists($configFile)) {
            throw new \RuntimeException("Arquivo de configuração não encontrado: $configFile");
        }

        $config = include $configFile;

        if (!is_array($config)) {
            throw new \RuntimeException("O arquivo de configuração não retornou um array válido.");
        }

        return $config;
    }
}
