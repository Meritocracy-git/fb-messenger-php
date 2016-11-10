<?php

namespace meritocracy\Messages;

/**
 * Class Adjustment
 *
 * @package meritocracy\Messages
 */
class DefaultAction
{
    /**
     * @var array
     */

    protected $type;
    protected $url;
    protected $fallbackUrl;
    protected $messengerExtensions;
    protected $webViewHeightRatio;


    /**
     * Adjustment constructor.
     *
     * @param array $data
     */
    public function __construct($url, $type="web_url",  $fallbackUrl = null, $messengerExtensions = true, $webviewHeightRatio = "tall")
    {
        $this->type = $type;
        $this->url=$url;
        $this->fallbackUrl=$fallbackUrl;
        $this->messengerExtensions=$messengerExtensions;
        $this->webViewHeightRatio=$webviewHeightRatio;
    }

    /**
     * Get Data
     *
     * @return array
     */
    public function getData()
    {
        return [
            "type"=>$this->type,
            "url"=>$this->url,
            "fallback_url"=>$this->fallbackUrl,
            "messenger_extensions"=>$this->messengerExtensions,
            "webview_height_ratio"=>$this->webViewHeightRatio
        ];
    }


}