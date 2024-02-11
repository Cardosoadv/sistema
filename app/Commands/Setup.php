<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Commands\Database\Migrate;
use CodeIgniter\Commands\Database\Seed;
use CodeIgniter\Test\Filters\CITestStreamFilter;
use Config\Services;

class Setup extends BaseCommand
{
    
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'sistema:install';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Create table structures and populate then';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->runMigrations();
        $this->runSeeders();
    }

    private function runMigrations(): void
    {
        
        $command = new Migrate(Services::logger(), Services::commands());
        $command->run(['all' => null]);
    }

    private function runSeeders()
    {
        $command = new Seed(Services::logger(), Services::commands());
        $command->run(['seeder_name'=>'admin']);
    }
}
