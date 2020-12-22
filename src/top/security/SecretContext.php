<?php

namespace TopClient\security;

class SecretContext
{
    public $secret;
    public $secretVersion;
    public $invalidTime;
    public $maxInvalidTime;

    public function __construct()
    {
    }
}
