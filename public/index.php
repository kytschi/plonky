<?php

use Plonky\Plonky;
use Plonky\Exceptions\Exception;

try {
    new Plonky();
} catch (\Exception $err) {
    (new Exception($err->getMessage()))->fatal();
}
