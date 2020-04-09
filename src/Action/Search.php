<?php
declare(strict_types=1);

namespace App\Action;

use App\User\Command\DoSearchAction;

class Search
{
    private DoSearchAction $doSearchAction;

    /**
     * Search constructor.
     */
    public function __construct(DoSearchAction $doSearchAction)
    {
        $this->doSearchAction = $doSearchAction;
    }

    public function run(string $email, string $name): string
    {
        $users = $this->doSearchAction->run($email, $name);

        return json_encode($users);
    }
}
