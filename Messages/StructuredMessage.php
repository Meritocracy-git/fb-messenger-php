<?php

namespace meritocracy\Messages;

/**
 * Class StructuredMessage
 *
 * @package meritocracy\Messages
 */
class StructuredMessage extends Message
{
    /**
     * Structured message button type
     */
    const TYPE_BUTTON = "button";

    /**
     * Structured message generic type
     */
    const TYPE_GENERIC = "generic";

    /**
     * Structured message list type
     */
    const TYPE_LIST = "list";


    /**
     * Structured message receipt type
     */
    const TYPE_RECEIPT = "receipt";

    /**
     * @var null|string
     */
    protected $type = null;

    /**
     * @var null|string
     */
    protected $title = null;

    /**
     * @var null|string
     */
    protected $subtitle = null;

    /**
     * @var array
     */
    protected $elements = [];

    /**
     * @var array
     */
    protected $buttons = [];

    protected $viewMoreButton = null;

    /**
     * @var null|string
     */
    protected $recipient_name = null;

    /**
     * @var null|integer
     */
    protected $order_number = null;

    /**
     * @var string
     */
    protected $currency = "USD";

    /**
     * @var null|string
     */
    protected $payment_method = null;

    /**
     * @var null|string
     */
    protected $order_url = null;

    /**
     * @var null|integer
     */
    protected $timestamp = null;

    /**
     * @var array
     */
    protected $address = [];

    /**
     * @var array
     */
    protected $summary = [];

    /**
     * @var array
     */
    protected $adjustments = [];

    /**
     * StructuredMessage constructor.
     *
     * @param string $recipient
     * @param string $type
     * @param array $data
     */
    public function __construct($recipient, $type, $data = null)
    {
        $this->recipient = $recipient;
        $this->type = $type;

        switch ($type) {
            case self::TYPE_BUTTON:
                $this->title = $data['text'];
                $this->buttons = $data['buttons'];
                break;

            case self::TYPE_GENERIC:
                $this->elements = $data['elements'];
                break;

            case self::TYPE_LIST:
                if (isset($data['elements'])) {
                    $this->elements = $data['elements'];
                }
                break;

            case self::TYPE_RECEIPT:
                $this->recipient_name = $data['recipient_name'];
                $this->order_number = $data['order_number'];
                $this->currency = $data['currency'];
                $this->payment_method = $data['payment_method'];
                $this->order_url = $data['order_url'];
                $this->timestamp = $data['timestamp'];
                $this->elements = $data['elements'];
                $this->address = $data['address'];
                $this->summary = $data['summary'];
                $this->adjustments = $data['adjustments'];
                break;
        }
    }

    /**
     * Get Data
     *
     * @return array
     */
    public function getData()
    {
        $result = [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => $this->type
                ]
            ]
        ];

        switch ($this->type) {
            case self::TYPE_BUTTON:
                $result['attachment']['payload']['text'] = $this->title;
                $result['attachment']['payload']['buttons'] = [];

                foreach ($this->buttons as $btn) {
                    $result['attachment']['payload']['buttons'][] = $btn->getData();
                }

                break;

            case self::TYPE_GENERIC:
            case self::TYPE_LIST:
                $result['attachment']['payload']['elements'] = [];

                foreach ($this->elements as $btn) {

                    if (!is_array($btn)) {
                        $result['attachment']['payload']['elements'][] = $btn->getData();

                    } else {
                        $result['attachment']['payload']['elements'][] = $btn;

                    }
                }

                if ($this->viewMoreButton != null) {
                    $result['attachment']['payload']['buttons'][] = $this->viewMoreButton->getData();
                }

                break;

            case self::TYPE_RECEIPT:
                $result['attachment']['payload']['recipient_name'] = $this->recipient_name;
                $result['attachment']['payload']['order_number'] = $this->order_number;
                $result['attachment']['payload']['currency'] = $this->currency;
                $result['attachment']['payload']['payment_method'] = $this->payment_method;
                $result['attachment']['payload']['order_url'] = $this->order_url;
                $result['attachment']['payload']['timestamp'] = $this->timestamp;
                $result['attachment']['payload']['elements'] = [];

                foreach ($this->elements as $btn) {
                    $result['attachment']['payload']['elements'][] = $btn->getData();
                }

                $result['attachment']['payload']['address'] = $this->address->getData();
                $result['attachment']['payload']['summary'] = $this->summary->getData();
                $result['attachment']['payload']['adjustments'] = [];

                foreach ($this->adjustments as $btn) {
                    $result['attachment']['payload']['adjustments'][] = $btn->getData();
                }
                break;
        }

        return [
            'recipient' => [
                'id' => $this->recipient
            ],
            'message' => $result
        ];
    }

    /**
     * @return null
     */
    public function getViewMoreButton()
    {
        return $this->viewMoreButton;
    }

    /**
     * @param null $viewMoreButton
     */
    public function setViewMoreButton($viewMoreButton)
    {
        $this->viewMoreButton = $viewMoreButton;
    }

    public function addElement($element)
    {
        $this->elements[] = $element->getData();
    }


}