<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testBasicExample()
    {
        $this->visit('/')
            ->click('Users')
            ->seePageIs('/portal/users');
    }

    public function findemail(){
        $this->seeInDatabase('users', ['email' => 'admin@gmail.com']);
    }
}
