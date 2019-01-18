<?php
namespace EasyRest\System\Response;

abstract class Response
{
    abstract public function print();

    /**
     * Magically converts object into string using the print method
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->print();
    }

    /**
     * Sends response to the browser
     *
     * @return void
     */
    protected function send()
    {
        echo $this;
    }

    public function __destruct()
    {
        $this->send();
    }
}
