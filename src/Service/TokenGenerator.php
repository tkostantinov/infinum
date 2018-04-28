<?php

namespace Infinum\Service;

class TokenGenerator
{
    public function generate()
    {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }
}