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


    public function __construct()
    {
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getImage()
    {
        return $this->image_url;
    }

    /**
     * @param null|string $image_url
     */
    public function setImage($image_url)
    {
        $this->image_url = $image_url;
    }

    /**
     * @return null|string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param null|string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @return null|string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param null|string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return array
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    /**
     * @param array $buttons
     */
    public function setButtons(array $buttons)
    {
        $this->buttons = $buttons;
    }


    public function setButton($button){
        $this->buttons[]=$button->getData();
    }

    public function setDefaultAction($defaultAction){
        $this->default_action=$defaultAction->getData();
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