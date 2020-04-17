<?php


namespace App\Exception;


class SupportSiteException extends BaseException
{
    protected $code    = 200;
    protected $message = 'Default support site exception';

    protected array $additionalCodeMessageArray = [
        200 => 'Default support site exception',
        201 => 'Can\'t find data from db',
    ];
}