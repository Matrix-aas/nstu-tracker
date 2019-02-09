<?php

namespace App\Console\Commands;

use App\DTO\AdminDTO;
use App\Services\Users\IAdminService;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdmin extends Command
{
    protected $signature = "make:admin {login}";

    protected $description = "Create new Administrator";

    private $adminService;

    public function __construct(IAdminService $adminService)
    {
        $this->adminService = $adminService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $adminDTO = new AdminDTO([
            'login' => $input->getArgument('login')
        ]);

        $adminDTO->setPassword($this->secret("Password"));

        $adminDTO->setFirstname($this->ask("Firstname"));
        $adminDTO->setSurname($this->ask("Surname"));
        $adminDTO->setMiddlename($this->ask("Middlename"));

        $this->info("Creating administrator...");

        try {
            if ($this->adminService->save($adminDTO)) {
                $this->info("Admin \"" . $adminDTO->getLogin() . "\" successfully created!");
                return 0;
            } else {
                $this->error("Can't create new admin!");
                return 1;
            }
        } catch (ValidationException $exception) {
            $this->error("Can't create new admin!");
            $this->warn("Validation error: " . $exception->validator->getMessageBag()->first());
        }
    }
}