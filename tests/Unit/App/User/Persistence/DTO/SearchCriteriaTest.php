<?php

use App\User\Persistence\DTO\SearchCriteria;
use PHPUnit\Framework\TestCase;

class SearchCriteriaTest extends TestCase
{
    public function testGetters()
    {
        $criteria = new SearchCriteria(
            'email',
            'name'
        );

        $this->assertEquals('email', $criteria->getEmail());
        $this->assertEquals('name', $criteria->getName());
    }
}
