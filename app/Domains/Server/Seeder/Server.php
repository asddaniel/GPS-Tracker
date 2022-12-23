<?php declare(strict_types=1);

namespace App\Domains\Server\Seeder;

use App\Domains\Server\Model\Server as Model;
use App\Domains\Shared\Seeder\SeederAbstract;

class Server extends SeederAbstract
{
    /**
     * @return void
     */
    public function run()
    {
        if (Model::query()->count()) {
            return;
        }

        $this->insertWithoutDuplicates(Model::class, $this->json('server'), 'port');
    }
}
