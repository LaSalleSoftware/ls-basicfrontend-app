<?php

namespace Tests\Feature\Library\Authentication\LoginLogout;

// LaSalle Software
use Lasallesoftware\Library\Testing\Concerns\Auth\InteractsWithAuthentication;
use Lasallesoftware\Library\Testing\Concerns\Uuid\InteractsWithUuid;

// Laravel
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class LoggingInTest extends TestCase
{
    // Define hooks to migrate the database before and after each test
    use DatabaseMigrations;
    use InteractsWithAuthentication;
    use InteractsWithUuid;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('lslibrary:customseed');
        $this->makeUuidgenerator();
    }

    /**
     * HTTP test that I login successfully
     *
     * @group login2
     *
     * @return void
     */
    public function test_I_login_successfully()
    {
        // Simulate my logging in via submitting the login form
        $response = $this
            ->createUuid()   // The first thing the login controller does is create the UUID
            ->loginBob()     // Log me in! Go straight to the heart of the matter and log me via LasalleGuard::login()
            ->get('/home')   // Redirected to "home" when successfully logged in
        ;

        // Was I redirected to "home" when I logged in?
        $response->assertStatus(200);
        $response->assertSee('You are logged in!');

        // When I am successfully logged in, there are two variables "put" to the session:
        // the loginToken
        $response->assertSessionHas('loginToken');
        // the personbydomain_id
        $response->assertSessionHas($this->getTheNameFromTheGetNameMethod());
        // just because we can, let's assert that the session has no errors
        $response->assertSessionHasNoErrors();

        // When I am successfully logged in, the logins table has a record:
        $record = \Lasallesoftware\Library\Authentication\Models\Login::orderBy('created_at', 'desc')->first();
        $this->assertTrue($record->personbydomain_id == $this->app['session']->get($this->getTheNameFromTheGetNameMethod()),'***The login personbydomain_id should be 1***');
        $this->assertTrue($record->token == $this->app['session']->get('loginToken'),'***The login token is wrong***');
        //$this->assertTrue($record->uuid == UUIDGENERATORUUID,'***The uuid is wrong***');
        $this->assertTrue($record->created_at <> null,'***The created_at is wrong***');
        $this->assertTrue($record->created_by == 1,'***The created_by should be 1***');
        // just because we can, see if these two fields are integers
        $this->assertTrue(is_int($record->personbydomain_id), "***The personbydomain_id must be an integer***");
        $this->assertTrue(is_int($record->created_by), "***The created_by must be an integer***");

        // When I am successfully logged in, the UUID inserted into the uuids table should be the same as the UUID constant
        $uuid = \Lasallesoftware\Library\UniversallyUniqueIDentifiers\Models\Uuid::find(2);
        $this->assertTrue($record->uuid == UUIDGENERATORUUID,'***The two uuids do not match***');
    }
}
