<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class SiteRoutesTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $namespace = 'App';
    protected $basePath = APPPATH . 'Database';
    protected $seed = 'DatabaseSeeder';

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

    public function testCustomersPageListsDatabaseRecords(): void
    {
        $result = $this->get('/customers');

        $result->assertOK();
        $result->assertSee('Isabella Santos');
        $result->assertSee('Gabriel Navarro');
        $result->assertSee('Live database records');
        $result->assertDontSee('Temporary static data');
    }

    public function testUsersPageListsDatabaseRecords(): void
    {
        $result = $this->get('/users');

        $result->assertOK();
        $result->assertSee('Ana Cruz');
        $result->assertSee('Luis Dizon');
        $result->assertSee('@ana.cruz');
        $result->assertSee('Sep 1, 2026');
        $result->assertSee('Live database records');
        $result->assertDontSee('Temporary static data');
    }
}
