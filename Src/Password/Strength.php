<?php
/**
 * Copyright (c) 2013 HasOffers Solutions Inc.
 * All rights reserved.
 */
namespace Password;

/**
 * A Password strength utility class
 */
class Strength
{
    /**
     * @var string
     */
    private $_password;

    /**
     * @var string
     */
    private $_passwordDict;

    /**
     * Constructor
     * @param string $password
     * @param string $filename
     */
    public function __construct( $password, $filename ) {
        $this->_password = $password;

        $this->_passwordDict = $this->getWeakPasswordsFromFile($filename);
    }

    /**
     * Open up weak password file and return an array of weak passwords
     * @param string $filename
     * @return array
     * @throws \InvalidArgumentException  If file doesn't exist or unable to read
     */
    private function getWeakPasswordsFromFile( $filename ) {
        $contents = @file($filename, FILE_IGNORE_NEW_LINES);

        if( false === $contents ) {
            $error = \error_get_last();
            throw new \InvalidArgumentException($error['message']);
        }

        return $contents;
    }

    /**
     * A factory method to enforce strong password
     * @param string $filename
     * @throws WeakPasswordException
     */
    public function enforceStrongPassword() {
        // Is password listed in the file?
        if( in_array($this->_password, $this->_passwordDict) ) {
            throw new WeakPasswordException("Password {$this->_password} is weak");
        }
    }

}
