<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

class Create extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.create';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetUserFail(): void
    {
        $this->authUser();

        $this->get($this->route())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testPostUserFail(): void
    {
        $this->authUser();

        $this->post($this->route())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testGetEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->route())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->route())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route())
            ->assertStatus(200);
    }
}
