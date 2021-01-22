<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\AdminUserController;
//use PHPUnit\Framework\TestCase;
use App\Messenger;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;
use App\User;
use Mockery as m;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Http\Request;
use function Symfony\Component\String\u;

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
    public function setUp() :void
    {
        $this->afterApplicationCreated(function () {
            $this->db = m::mock(
                Connection::class.'[select,update,insert,delete]',
                [m::mock(\PDO::class)]
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

    public function test_index_returns_view()
    {
        $controller = new AdminUserController();

        $this->db->shouldReceive('select')->once()->withArgs([
            'select * from "users"',
            [],
            m::any(),
        ])->andReturn((object)[]);

        $view = $controller->index();

        $this->assertEquals('directory.posts.index', $view->getName());
        $this->assertArrayHasKey('user', $view->getData());
    }

    public function test_create_returns_view()
    {
        $controller = new AdminUserController();

        $view = $controller->create();

        $this->assertEquals('directory.posts.create', $view->getName());
    }

    public function test_create_users(){

        $usercontroller = new AdminUserController();

        $data = [
            'name' => 'new user',
            'email' => 'user21@gmail.com',
            'active_status' =>'unlock',
            'password' =>'new213password',
            'roles' =>'admin',
        ];

        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        // Mock Validation Presence Query
        $this->db->shouldReceive('select')->once();

        $this->db->getPdo()->shouldReceive('lastInsertId')->andReturn(333);

        $this->db->shouldReceive('insert')->once()
            ->withArgs([
                'insert into "users" ("name", "email","active_status","password","roles") values (?, ?, ?, ?, ? )',
                m::on(function ($arg) {
                    return is_array($arg) &&
                        $arg[0] == 'new user';
                })
            ])
            ->andReturn(true);

        /** @var RedirectResponse $response */
        $response = $usercontroller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('users.index'), $response->headers->get('Location'));
        $this->assertEquals(333, $response->getSession()->get('created'));
    }

    public function test_edit_returns_view()
    {
        $userId = ['id' => 1];
        $user = new User($userId);

        $controller = new AdminUserController();

        $view = $controller->edit($user);
        $this->assertEquals('directory.posts.edit', $view->getName());
        $this->assertArrayHasKey('user', $view->getData());
    }

    public function test_update_user()
    {
        $controller = new AdminUserController();

        $data = [
            'id' => 1,
            'name' => 'New User',
        ];

        $user = $this->userMock->forceFill(['id' => 1, 'name' => 'Old User']);
        $newCity = (new User())->forceFill(['id' => 1, 'name' => $data['name']]);

        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        // Mock Validation Presence Query
        $this->db->shouldReceive('select')->once()->withArgs([
            'select count(*) as aggregate from "users" where "name" = ? and "id" <> ?',
            [$data['name'], $data['id']],
            m::any(),
        ])->andReturn([(object) ['aggregate' => 0]]);

        $this->userMock->shouldReceive('update')->once()->withArgs([
            m::on(function($arg) {
                return is_array($arg) && $arg['name'] == 'New User';
            }
            )])->andReturn($newCity);

        $this->db->getPdo()->shouldReceive('lastInsertId')->andReturn($data['id']);

        $response = $controller->update($request, $user);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('users.index'), $response->headers->get('Location'));
        $this->assertEquals($data['id'], $response->getSession()->get('updated'));
    }

    public function test_destroy_user()
    {
        $controller = new AdminUserController();

        $data = [
            'id' => 1,
        ];

        $user = $this->userMock->forceFill($data);

        $this->userMock->shouldReceive('delete')->once()->andReturn(true);

        $response = $controller->destroy($user);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('users.index'), $response->headers->get('Location'));
        $this->assertEquals($data['id'], $response->getSession()->get('deleted'));
    }

    public function test_view_messages_for_user () {
        $controller = new AdminUserController();

        $data = [
            'id' => 1,
        ];

        $messages = m::mock(Messenger::class);
        $messages->shouldReceive('select')->once()->withArgs([
            'select * from "messages" where "id" = ?',
            [$data['id'],],
            m::any(),
        ])->andReturn([(object) []]);

        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        $response = $controller->view_messages_for_user($request);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(333, $response->getSession()->get('created'));

    }

}
