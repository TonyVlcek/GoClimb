<?php

namespace GoClimb;

use BadMethodCallException;
use InvalidArgumentException as PhpInvalidArgumentException;


abstract class InvalidArgumentException extends PhpInvalidArgumentException {}


class NotImplementedException extends BadMethodCallException {}
