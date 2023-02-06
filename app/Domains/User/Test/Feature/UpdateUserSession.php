<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

class UpdateUserSession extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.update.user-session';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->routeFactoryCreateModel())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->routeFactoryCreateModel())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testGetUserFail(): void
    {
        $this->authUser();

        $this->get($this->routeFactoryCreateModel())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->routeFactoryCreateModel())
            ->assertStatus(200);
    }
}
