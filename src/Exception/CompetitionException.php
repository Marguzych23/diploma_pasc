<?php


namespace App\Exception;


class CompetitionException extends BaseException
{
    protected $code    = 100;
    protected $message = 'Default competition exception';

    protected array $additionalCodeMessageArray = [
        100 => 'Default competition exception',
        110 => 'Can\'t load data from URL',
        111 => 'Can\'t load data from HTML file',
        112 => 'Can\'t load data from PDF file',
    ];

}