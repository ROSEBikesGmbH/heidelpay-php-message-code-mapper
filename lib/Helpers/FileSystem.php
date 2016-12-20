<?php
namespace Heidelpay\CustomerMessages\Helpers;

class FileSystem
{
    /*
     * @var resource
     */
    private $_handle;

    /**
     * FileSystem constructor.
     *
     * @param $path
     */
    public function __construct($path)
    {
        // we just want to read files, so mode 'r' will be fine at all.
        $this->_handle = fopen($path, 'r');
    }

    /**
     * Destructs the instance and closes the file handle.
     */
    public function __destruct()
    {
        // no matter what, we want to close the handle as
        // soon as this instance is not needed anymore.
        fclose($this->_handle);
    }

    /**
     * @return array
     */
    public function getCsvContent()
    {
        $ret = [];

        // instead of returning an array for each element, we create
        // an array with the error-code as key and the message as value.
        while ( $content = fgetcsv($this->_handle) ) {

            // 0 = HPError-Code, 1 = Message
            if ( isset($content[0]) && isset($content[1]) ) {
                $ret[$content[0]] = $content[1];
            }
        }

        // reset the file pointer, if we want to read the file again.
        rewind($this->_handle);

        // return the array.
        return $ret;
    }
}