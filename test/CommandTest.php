<?php

namespace Test;

use Takemo101\LaravelSimpleVM\MakeViewModelCommand;

class CommandTest extends TestCase
{
    /**
     * @test
     */
    public function executeCommand__OK(): void
    {
        $this->artisan(MakeViewModelCommand::class, [
            'name' => 'Demo',
        ])
            ->assertExitCode(0);

        $this->artisan(MakeViewModelCommand::class, [
            'name' => 'Test\Test',
        ])
            ->assertExitCode(0);
    }
}
