<?php
/*
 * Copyright (c) 2013 Adapp Solutions Inc.
 * All rights reserved.
 */
namespace Test\Api\Library\Model\Authentication;

use Password\Strength as PasswordStrength;

/**
 * Password strength model test
 */
class PasswordStrengthTest extends \PHPUnit_Framework_TestCase
{
    public function testEnforceStrongPasswordWeakPasswordDetected() {
        $weakPasswords = array('demo', 'bar');

        foreach( $weakPasswords as $password ) {
            $this->setExpectedException( '\Password\WeakPasswordException', "Password {$password} is weak" );
            $this->_passwordStrength = new PasswordStrength($password, __DIR__ . '/_files/weakpasswords.txt' );
            $this->_passwordStrength->enforceStrongPassword();
        }
    }

    public function testEnforceStrongPasswordPass() {
        $strongPasswords = array('superhardtoguess1213232', 'goodPassword!@@#');

        foreach( $strongPasswords as $password ) {
            $this->_passwordStrength = new PasswordStrength($password,  __DIR__ . '/_files/weakpasswords.txt' );
            $this->assertEmpty($this->_passwordStrength->enforceStrongPassword());
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage file(nosuchfile.txt): failed to open stream: No such file or directory
     */
    public function testEnforceStrongPasswordWhenFileNotFound() {
        // Test when file does not exists
        $this->_passwordStrength = new PasswordStrength('demo','nosuchfile.txt');
        $this->_passwordStrength->enforceStrongPassword();
    }

}
