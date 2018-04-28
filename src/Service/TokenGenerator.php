<?php

namespace Infinum\Service;

class TokenGenerator
{
    public function generate()
    {
        return uniqid();
    }
}