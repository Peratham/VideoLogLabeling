<?php
namespace app;

/**
 * Description of UnknownPropertyException
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class InvalidValueException extends Exception
{
    public function getName() {
        return 'InvalidValueException';
    }
}
