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

    private function loginSession(): array
    {
        return [
            'isLoggedIn' => true,
            'userId'     => 1,
            'username'   => 'gerard.doroja',
            'fullName'   => 'Gerard Doroja',
        ];
    }

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
        $customers = $this->withSession($this->loginSession())->get('/customers');
        $users = $this->withSession($this->loginSession())->get('/users');

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

    public function testCustomerCreateAndEditPagesAreAvailable(): void
    {
        $create = $this->withSession($this->loginSession())->get('/customers/new');
        $edit = $this->withSession($this->loginSession())->get('/customers/1/edit');

        $create->assertOK();
        $create->assertSee('Create a customer account');
        $create->assertSee('Save customer');
        $edit->assertOK();
        $edit->assertSee('Isabella Santos');
        $edit->assertSee('Update customer');
    }

    public function testCustomerValidationRejectsBadInputAndValidInputIsInserted(): void
    {
        $database = db_connect();
        $before = $database->table('customers')->countAllResults();

        $invalid = $this->withSession($this->loginSession())->post('/customers', [
            'full_name' => '',
            'email'     => 'not-an-email',
            'phone'     => '0917 555 0101',
        ]);
        $invalid->assertRedirect();
        $this->assertSame($before, $database->table('customers')->countAllResults());

        $valid = $this->withSession($this->loginSession())->post('/customers', [
            'full_name' => 'Leah Bautista',
            'email'     => 'leah.bautista@example.com',
            'phone'     => '+63 917 555 0101',
        ]);
        $valid->assertRedirectTo('/customers');
        $this->assertSame($before + 1, $database->table('customers')->countAllResults());
    }

    public function testUserCreateAndEditPagesExposeAvatarWorkflow(): void
    {
        $create = $this->withSession($this->loginSession())->get('/users/new');
        $edit = $this->withSession($this->loginSession())->get('/users/1/edit');

        $create->assertOK();
        $create->assertSee('Create a user account');
        $edit->assertOK();
        $edit->assertSee('Profile picture');
        $edit->assertSee('JPG or PNG only');
        $database = db_connect();
        $this->assertContains('avatar', $database->getFieldNames($database->prefixTable('users')));
    }

    public function testUsernamesRemainUniqueAndValidUsersCanBeCreated(): void
    {
        $database = db_connect();
        $before = $database->table('users')->countAllResults();

        $duplicate = $this->withSession($this->loginSession())->post('/users', [
            'username'  => 'gerard.doroja',
            'full_name' => 'Another Gerard',
            'email'     => 'another.gerard@example.com',
            'password'  => 'SecurePass123!',
        ]);
        $duplicate->assertRedirect();
        $this->assertSame($before, $database->table('users')->countAllResults());

        $valid = $this->withSession($this->loginSession())->post('/users', [
            'username'  => 'leah.bautista',
            'full_name' => 'Leah Bautista',
            'email'     => 'leah.bautista@example.com',
            'password'  => 'SecurePass123!',
        ]);
        $valid->assertRedirect();
        $this->assertSame($before + 1, $database->table('users')->countAllResults());
    }

    public function testLegacyTeamHasItsOwnRoute(): void
    {
        $result = $this->get('/coffeehouse/team');

        $result->assertOK();
        $result->assertSee('Legacy directory');
        $result->assertSee('Ana Cruz');
        $result->assertSee('Luis Dizon');
    }

    public function testCustomerAndUserUpdatesPersist(): void
    {
        $customer = $this->withSession($this->loginSession())->post('/customers/1', [
            'full_name' => 'Isabella Santos-Reyes',
            'email'     => 'isabella.reyes@example.com',
            'phone'     => '+63 917 234 0182',
        ]);
        $customer->assertRedirectTo('/customers');
        $this->seeInDatabase('customers', [
            'id'        => 1,
            'full_name' => 'Isabella Santos-Reyes',
            'email'     => 'isabella.reyes@example.com',
        ]);

        $user = $this->withSession($this->loginSession())->post('/users/1', [
            'username'  => 'gerard.doroja',
            'full_name' => 'Gerard Doroja',
            'email'     => 'gerard.updated@example.com',
            'password'  => '',
        ]);
        $user->assertRedirectTo('/users');
        $this->seeInDatabase('users', [
            'id'    => 1,
            'email' => 'gerard.updated@example.com',
        ]);
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

    public function testProtectedAccountRoutesRedirectGuestsToLogin(): void
    {
        foreach (['/customers', '/customers/new', '/users', '/users/1/edit'] as $uri) {
            $this->get($uri)->assertRedirectTo('/login');
        }
    }

    public function testTaskManagementRoutesRedirectGuestsToLogin(): void
    {
        $this->get('/tasks/new')->assertRedirectTo('/login');
        $this->get('/tasks/1/edit')->assertRedirectTo('/login');
        $this->post('/tasks', [])->assertRedirectTo('/login');
        $this->post('/tasks/1', [])->assertRedirectTo('/login');
        $this->post('/tasks/1/delete', [])->assertRedirectTo('/login');
    }

    public function testAuthenticatedUserCanCreateAndUpdateTask(): void
    {
        $database = db_connect();
        $before = $database->table('tasks')->countAllResults();

        $createPage = $this->withSession($this->loginSession())->get('/tasks/new');
        $createPage->assertOK();
        $createPage->assertSee('Create a new task');

        $invalid = $this->withSession($this->loginSession())->post('/tasks', [
            'title'     => '',
            'status'    => 'pending',
            'task_date' => '',
        ]);
        $invalid->assertRedirectTo('/tasks/new');
        $this->assertSame($before, $database->table('tasks')->countAllResults());

        $valid = $this->withSession($this->loginSession())->post('/tasks', [
            'title'     => 'Prepare TSA2 demonstration',
            'status'    => 'pending',
            'task_date' => date('Y-m-d'),
        ]);
        $valid->assertRedirectTo('/tasks');
        $this->assertSame($before + 1, $database->table('tasks')->countAllResults());

        $task = $database->table('tasks')->where('title', 'Prepare TSA2 demonstration')->get()->getRowArray();
        $this->assertNotNull($task);

        $update = $this->withSession($this->loginSession())->post('/tasks/' . $task['id'], [
            'title'     => 'Present TSA2 demonstration',
            'status'    => 'completed',
            'task_date' => date('Y-m-d'),
        ]);
        $update->assertRedirectTo('/tasks');
        $this->seeInDatabase('tasks', [
            'id'          => $task['id'],
            'title'       => 'Present TSA2 demonstration',
            'status'      => 'completed',
            'is_archived' => 0,
        ]);
    }

    public function testArchivingTaskRetainsRowAndRemovesItFromPublicPages(): void
    {
        $database = db_connect();
        $task = $database->table('tasks')->where('task_date', date('Y-m-d'))->get()->getRowArray();
        $this->assertNotNull($task);

        $archive = $this->withSession($this->loginSession())->post('/tasks/' . $task['id'] . '/delete');
        $archive->assertRedirectTo('/tasks');
        $this->seeInDatabase('tasks', ['id' => $task['id'], 'is_archived' => 1]);

        $this->get('/')->assertDontSee($task['title']);
        $this->get('/tasks')->assertDontSee($task['title']);
    }

    public function testLoginRejectsInvalidPasswordAndAcceptsTheSeededAccount(): void
    {
        $loginPage = $this->get('/login');
        $loginPage->assertOK();
        $loginPage->assertSee('Welcome back.');

        $invalid = $this->post('/login', [
            'username' => 'gerard.doroja',
            'password' => 'wrong-password',
        ]);
        $invalid->assertRedirectTo('/login');

        $valid = $this->post('/login', [
            'username' => 'gerard.doroja',
            'password' => 'Tahanan123!',
        ]);
        $valid->assertRedirectTo('/users');
        $valid->assertSessionHas('isLoggedIn', true);
        $valid->assertSessionHas('userId', 1);

        $storedHash = (string) db_connect()->table('users')->where('id', 1)->get()->getRow('password');
        $this->assertNotSame('Tahanan123!', $storedHash);
        $this->assertTrue(password_verify('Tahanan123!', $storedHash));
    }

    public function testAuthenticatedUserCanOpenProtectedPageAndLogout(): void
    {
        $this->withSession($this->loginSession())->get('/users')->assertOK();
        $this->withSession($this->loginSession())->post('/logout')->assertRedirectTo('/login');
    }
}
