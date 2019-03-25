<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use App\EventSubscriber\PasswordHashSubscriber;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class PasswordHashSubscriberTest extends TestCase
{
    public function testGetSubscribedEvents()
    {
        $result = PasswordHashSubscriber::getSubscribedEvents();

        $this->assertArrayHasKey(KernelEvents::VIEW, $result);
        $this->assertEquals(['hashPassword', EventPriorities::PRE_WRITE], $result[KernelEvents::VIEW]);
    }
    
    public function providerHashPassword()
    {
        return [
            // If everything is ok
            [User::class, true, 'POST', true],
            [User::class, true, 'PUT', true],
            // If class isn't right
            ['BadClass', false, 'POST', false],
            // If method isn't PUT or POST
            [User::class, false, 'GET', false]
        ];
    }
    
    /**
     * @dataProvider providerHashPassword
     */
    public function testHashPassword($classname, bool $shouldCallSetPassword, string $method, bool $shouldEncodePasswordBeCalled)
    {
        $entityMock = $this->getEntityMock($classname, $shouldCallSetPassword);
        $requestMock = $this->getRequestMock($method);
        $eventMock = $this->getEventMock($entityMock, $requestMock);
        $encoderMock = $this->getEncoderMock($shouldEncodePasswordBeCalled);

        (new PasswordHashSubscriber($encoderMock))->hashPassword($eventMock);
    }

    //GetResponseForControllerResultEvent
    private function getEventMock($entityMock, $requestMock)
    {
        $eventMock = $this->getMockBuilder(GetResponseForControllerResultEvent::class)
                          ->disableOriginalConstructor() 
                          ->getMock();
        $eventMock->expects($this->once())
                  ->method('getControllerResult')
                  ->willReturn($entityMock);
        $eventMock->expects($this->once())
                  ->method('getRequest')
                  ->willReturn($requestMock);

        return $eventMock;
    }

    // UserPasswordEncoderInterface
    private function getEncoderMock(bool $shouldEncodePasswordBeCalled)
    {
        $encoderMock = $this->getMockBuilder(UserPasswordEncoderInterface::class)
                            ->getMockForAbstractClass();
        $encoderMock->expects($shouldEncodePasswordBeCalled ? $this->once() : $this->never())
                    ->method('encodePassword')
                    ->willReturn('test');

        return $encoderMock;
    }

    // User
    private function getEntityMock(string $classname, bool $shouldCallSetPassword)
    {
        $entityMock = $this->getMockBuilder($classname)
                           ->setMethods(['setPassword'])
                           ->getMock();
        $entityMock->expects($shouldCallSetPassword ? $this->once() : $this->never())
                   ->method('setPassword')
                   ->willReturn(new $classname());

        return $entityMock;
    }

    // Request
    private function getRequestMock(string $method)
    {
        $requestMock = $this->getMockBuilder(Request::class)
                            ->getMock();
        $requestMock->expects($this->once())
                    ->method('getMethod')
                    ->willReturn($method);
                   
        return $requestMock;
    }
}