<?php

namespace meritocracy\Messages;


/**
 * Class MessageReceiptElement
 *
 * @package meritocracy\Messages
 */
class MessageListElement extends MessageElement
{


    protected $default_action;


    /**
     * MessageReceiptElement constructor.
     *
     * @param string $title
     * @param string $subtitle
     * @param string $image_url
     * @param int $quantity
     * @param int $price
     * @param string $currency
     */
    public function __construct($title, $subtitle, $image_url = '', $defaultAction,$buttons)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->image_url = $image_url;
        $this->default_action = $defaultAction;
        $this->buttons = $buttons;

    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'image_url' => $this->image_url,
            'default_action' => $this->default_action,
            'buttons' => $this->buttons
        ];
    }
}