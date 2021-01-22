<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\User;

class AdminUserControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
        public function testExample()
        {
            $user = new User;
            $this->assertInstanceOf(User::class, $user);
        }
    public function test_create_users(){

            $mockUser = \Mockery::mock(User::class)->makePartial();
            $response = User::post('admin/users/store',[
                'name' => 'Test name',
                'email' => 'testemail@gmail.com',
                'password' => 'testpassword123',
                'active_status' => 'unlock_test',
                'role' => 'admin_test',
            ]);

            $this->assertCount(1,User::all());
      }

}
