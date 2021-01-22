<?php

namespace Tests\Unit;

use App\Http\Controllers\AdminUserController;
use PHPUnit\Framework\TestCase;
use App\User;
use Mockery as m;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Http\Request;

class AdminUserControllerTest extends TestCase
{
    protected $db;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $userMock;

        public function testExample()
        {
            $user = new User;
            $this->assertInstanceOf(User::class, $user);
        }

    /**
     *
     */
    public function setUp(): void
        {
        $this->afterApplicationCreated(function () {
            $this->db = m::mock(
                Connection::class.'[select,update,insert,delete]',
                [m::mock(User::class)]
            );

            $manager = $this->app['db'];
            $manager->setDefaultConnection('mock');

            $r = new \ReflectionClass($manager);
            $p = $r->getProperty('connections');
            $p->setAccessible(true);
            $list = $p->getValue($manager);
            $list['mock'] = $this->db;
            $p->setValue($manager, $list);

            $this->userMock = m::mock(User::class . '[update, delete]');
        });

        parent::setUp();
    }
    public function test_create_users(){
        $usercontroller = new AdminUserController();

        $data = [
            'name' => 'new user',
            'email' => 'user@gmail.com',
            'password' =>'newpassword',
            'active_status' =>'newtring',
            'roles' =>'newtringr'
        ];

        $request = new Request();
        $request->headers->set('content-type','application/json');
        $request->setJson(new ParameterBag($data));

        $this->db->shouldReceive('select')->once();

        $this->db->shouldReceive('lastInsertId')->andReturn(333);
        $this->db->shouldReceive('insert')->once()
            ->withArgs(array(
                'insert into "users" ("name", "email", "active_status","password","roles") values (?, ?, ?, ?, ? )',
                m::on(function ($arg) {
                    return is_array($arg) &&
                        $arg[0] == 'New User';
                })
            ))
            ->andReturn(true);

        $response = $usercontroller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('users.index'), $response->headers->get('Location'));
        $this->assertEquals(333, $response->getSession()->get('created'));
      }

}
