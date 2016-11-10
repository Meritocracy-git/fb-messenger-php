<?php

namespace meritocracy\Messages;

/**
 * Class Summary
 *
 * @package meritocracy\Messages
 */
class Summary
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Summary constructor.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get Data
     * 
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}