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

    public function testWelcomePageShowsOnlyTodaysTasks(): void
    {
        $result = $this->get('/');

        $result->assertOK();
        $result->assertSee('Make space for');
        $result->assertSee('Review daily priorities');
        $result->assertSee('Submit the progress update');
        $result->assertDontSee('Organize project reference files');
        $result->assertDontSee('Plan tomorrow&#039;s development session');
    }

    public function testTaskListShowsEverySeededTask(): void
    {
        $result = $this->get('/tasks');

        $result->assertOK();
        $result->assertSee('Confirm completed requirements from yesterday');
        $result->assertSee('Review daily priorities');
        $result->assertSee('Archive finished project notes');
        $result->assertSee('10');
    }

    public function testProfileShowsTheSingleDatabaseUser(): void
    {
        $result = $this->get('/profile');

        $result->assertOK();
        $result->assertSee('Gerard Doroja');
        $result->assertSee('@gerard.doroja');
        $result->assertSee('gerard.doroja@example.com');
        $this->assertSame(1, db_connect()->table('users')->countAllResults());
    }

    public function testAboutPageIdentifiesTheDeveloper(): void
    {
        $result = $this->get('/about');

        $result->assertOK();
        $result->assertSee('About the system');
        $result->assertSee('Gerard Doroja');
        $result->assertSee('IT0049 Web System Technologies');
    }

    public function testCoffeehouseLandingAndStoryRemainAvailable(): void
    {
        $landing = $this->get('/coffeehouse');
        $story = $this->get('/coffeehouse/about');

        $landing->assertOK();
        $landing->assertSee('Rooted in tradition.');
        $story->assertOK();
        $story->assertSee('A coffeehouse with');
    }

    public function testCoffeehouseDirectoriesRemainAvailable(): void
    {
        $customers = $this->get('/customers');
        $users = $this->get('/users');

        $customers->assertOK();
        $customers->assertSee('Isabella Santos');
        $customers->assertSee('Gabriel Navarro');
        $users->assertOK();
        $users->assertSee('Ana Cruz');
        $users->assertSee('Luis Dizon');
        $this->assertSame(6, db_connect()->table('customers')->countAllResults());
        $this->assertSame(6, db_connect()->table('staff_members')->countAllResults());
        $this->assertSame(1, db_connect()->table('users')->countAllResults());
    }

    public function testSeedDataMeetsRecordAndDateRequirements(): void
    {
        $database = db_connect();
        $dateCount = $database->table('tasks')
            ->select('task_date')
            ->distinct()
            ->countAllResults();

        $this->assertGreaterThanOrEqual(8, $database->table('tasks')->countAllResults());
        $this->assertGreaterThanOrEqual(3, $dateCount);
        $this->assertSame(
            4,
            $database->table('tasks')->where('task_date', date('Y-m-d'))->countAllResults(),
        );
    }
}
