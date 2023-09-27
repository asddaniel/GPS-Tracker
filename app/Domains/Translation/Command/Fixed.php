<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

class Fixed extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'translation:fixed {--paths-exclude=*}';

    /**
     * @var string
     */
    protected $description = 'Search fixed texts on app and views';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->requestWithOptions();

        $this->info($this->action()->fixed());

        $this->info('[END]');
    }
}
