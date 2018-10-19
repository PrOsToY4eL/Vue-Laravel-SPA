<?php

namespace Tests\Unit;

use App\Exceptions\ValidationFaildException;
use App\Services\UserValidationService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserValidationTest extends TestCase
{
    private $userValidationService;
    
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->userValidationService = new UserValidationService();
    }

    private const CREDENTIALS = [
        'email' => 'test@gmal.com',
        'password' => 'secret',
        'name' => 'UserTestName'
    ];
    private const WRONG_CREDENTIALS = [
        'email' => 'testgmalcom',
        'password' => 'sec',
        'name' => 'UserTestName'
    ];

    /**
     * @return void
     * @throws ValidationFaildException
     */
    public function testWrongCredentials()
    {
        $credentials = self::WRONG_CREDENTIALS;
        $this->expectException(ValidationFaildException::class);

        $this->userValidationService->validateUser($credentials);
    }

    /**
     * @throws ValidationFaildException
     */
    public function testSuccessCredentials()
    {
        $credentials = self::CREDENTIALS;
        $this->userValidationService->validateUser($credentials);

        $this->assertEmpty($this->userValidationService->errors());
    }
}
