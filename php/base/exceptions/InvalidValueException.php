<?php
namespace app;

/**
 * Description of InvalidValueException
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class InvalidValueException extends Exception
{
    public function getName() {
        return 'InvalidValueException';
    }
}