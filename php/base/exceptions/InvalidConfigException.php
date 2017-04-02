<?php
namespace app;

/**
 * Description of InvalidConfigException
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class InvalidConfigException extends Exception
{
    public function getName() {
        return 'Invalid Configuration';
    }
}
