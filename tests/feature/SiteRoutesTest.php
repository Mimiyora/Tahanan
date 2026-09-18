<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class SiteRoutesTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testLandingPageLoads(): void
    {
        $result = $this->get('/');

        $result->assertOK();
        $result->assertSee('Rooted in tradition.');
    }

    public function testAboutPageLoads(): void
    {
        $result = $this->get('/about');

        $result->assertOK();
        $result->assertSee('A coffeehouse with');
    }

    public function testCustomersPageListsStaticRecords(): void
    {
        $result = $this->get('/customers');

        $result->assertOK();
        $result->assertSee('Isabella Santos');
        $result->assertSee('Gabriel Navarro');
    }

    public function testUsersPageListsStaticRecords(): void
    {
        $result = $this->get('/users');

        $result->assertOK();
        $result->assertSee('Ana Cruz');
        $result->assertSee('Luis Dizon');
    }
}
