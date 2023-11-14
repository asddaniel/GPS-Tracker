<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Test\Controller;

class Update extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'vehicle.update';

    /**
     * @var string
     */
    protected string $action = 'update';

    /**
     * @return void
     */
    public function testGetGuestUnauthorizedFail(): void
    {
        $this->getGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testPostGuestUnauthorizedFail(): void
    {
        $this->postGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testGetAuthSuccess(): void
    {
        $this->getAuthSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $this->postAuthSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthAdminSuccess(): void
    {
        $this->getAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthAdminSuccess(): void
    {
        $this->postAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateSuccess(): void
    {
        $this->postAuthUpdateSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthUpdateAdminSuccess(): void
    {
        $this->getAuthUpdateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateAdminFail(): void
    {
        $this->postAuthUpdateAdminFail(vehicle: false, device: false);
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateAdminSuccess(): void
    {
        $this->postAuthUpdateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthUpdateManagerSuccess(): void
    {
        $this->getAuthUpdateManagerSuccess(vehicle: false, device: false);
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateManagerSuccess(): void
    {
        $this->postAuthUpdateManagerSuccess(vehicle: false, device: false);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
