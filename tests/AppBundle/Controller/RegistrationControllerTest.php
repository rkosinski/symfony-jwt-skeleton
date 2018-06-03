<?php

namespace tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;
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
     * @param [] $data
     */
    public function testRegisterAction($data)
    {
        $this->removeTestValues($data['email']);

        $client = $this->makeRequest($data);
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider userValidProvider
     * @param [] $data
     */
    public function testRegisterActionWithSameEmail($data)
    {
        $client = $this->makeRequest($data);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider userInvalidProvider
     * @param [] $data
     */
    public function testRegisterActionWithInvalidData($data)
    {
        $client = $this->makeRequest($data);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public function userValidProvider()
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

    /**
     * @return array
     */
    public function userInvalidProvider()
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

    /**
     * @param string $email
     */
    private function removeTestValues($email)
    {
        $user = self::$doctrine->getRepository(User::class)->findOneBy(['email' => $email]);
        if (null !== $user) {
            self::$doctrine->getManager()->remove($user);
            self::$doctrine->getManager()->flush();
        }
    }

    /**
     * @param [] $data
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    private function makeRequest($data)
    {
        $client = static::createClient();
        $client->request(Request::METHOD_POST, '/api/v1/anonymous/register', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        return $client;
    }
}