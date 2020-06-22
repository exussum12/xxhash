<?php

namespace exussum12\xxhash;

interface Hash
{
    public function hash(string $input): string;

    public function hashStream($input): string;
}
