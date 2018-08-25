<?php declare(strict_types=1);

namespace tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class RegistrationControllerTest extends WebTestCase
{
    /** @var Registry */
    private static $doctrine;

    public static function setUpBeforeClass()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        static::$doctrine = $kernel->getContainer()->get('doctrine');
    }

    /**
     * @dataProvider userValidProvider
     */
    public function testRegisterAction(array $data)
    {
        $this->removeTestValues($data['email']);

        $client = $this->makeRequest($data);
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider userValidProvider
     */
    public function testRegisterActionWithSameEmail(array $data)
    {
        $client = $this->makeRequest($data);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider userInvalidProvider
     */
    public function testRegisterActionWithInvalidData(array $data)
    {
        $client = $this->makeRequest($data);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function userValidProvider() : array
    {
        return [
            [
                [
                    'username' => 'test1',
                    'email' => 'test1@gmail.com',
                    'plainPassword' => ['first' => 'test123', 'second' => 'test123']
                ]
            ],
        ];
    }

    public function userInvalidProvider() : array
    {
        return [
            [
                [
                    'username' => 'test2',
                    'email' => 'test@dasdasd',
                    'plainPassword' => ['first' => 'test123', 'second' => 'test123']
                ],
            ],
            [
                [
                    'username' => 'test2',
                    'email' => 'test@dasdasd',
                    'plainPassword' => ['first' => 'test123', 'second' => 'test1233']
                ],
            ]
        ];
    }

    private function removeTestValues(string $email)
    {
        $user = self::$doctrine->getRepository(User::class)->findOneBy(['email' => $email]);
        if (null !== $user) {
            self::$doctrine->getManager()->remove($user);
            self::$doctrine->getManager()->flush();
        }
    }

    private function makeRequest(array $data) : Client
    {
        $client = static::createClient();
        $client->request(Request::METHOD_POST, '/api/v1/register', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        return $client;
    }
}