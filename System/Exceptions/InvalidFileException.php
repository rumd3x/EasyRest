<?php
namespace EasyRest\System\Exceptions;

use Exception;

class InvalidFileException extends Exception
{
    /**
     * @var string
     */
    public $filePath;

    /**
     * @var string
     */
    public $message;

    public function __construct(string $message, string $filePath)
    {
        $this->message = $message;
        $this->filePath = $filePath;
        $finalMessage = sprintf('File "%s": %s', $this->filePath, $this->message);
        parent::__construct($finalMessage, 0, null);
    }
}
