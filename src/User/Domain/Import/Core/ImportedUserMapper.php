<?php
declare(strict_types=1);

namespace App\User\Domain\Import\Core;

use App\User\Common\UserFactory;
use App\User\Domain\Core\Exception\InvalidPropertyValue;
use App\User\Domain\Core\Status\Active;
use App\User\Domain\Core\User;
use App\User\Domain\Import\Core\Exception\ImportedValueIsNotValid;

class ImportedUserMapper
{
    private UserFactory $factory;

    /**
     * ImportedUserMapper constructor.
     */
    public function __construct(UserFactory $factory)
    {
        $this->factory = $factory;
    }

    public function mapUserFromDTO(ImportedUser $importedUser): User
    {
        try {
            return $this->factory->create(
                $importedUser->name,
                $importedUser->email,
                new Active()
            );
        } catch (InvalidPropertyValue $e) {
            throw new ImportedValueIsNotValid(sprintf('Error has been occured during import: %s', $e->getMessage()));
        }
    }
}
