<?php

namespace pimax;

use GuzzleHttp\Client;
use pimax\Messages\Message;
use pimax\Messages\MessageButton;

class FbBotApp
{
    /**
     * Request type GET
     */
    const TYPE_GET = "get";

    /**
     * Request type POST
     */
    const TYPE_POST = "post";

    /**
     * Request type DELETE
     */
    const TYPE_DELETE = "delete";

    /**
     * FB Messenger API Url
     *
     * @var string
     */
    protected $apiUrl = 'https://graph.facebook.com/v2.6/';

    /**
     * @var null|string
     */
    protected $token = null;

    /**
     * FbBotApp constructor.
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Send Message
     *
     * @param Message $message
     * @return array
     */
    public function send($message)
    {
        return $this->call('me/messages', $message->getData());
    }

    /**
     * Get User Profile Info
     *
     * @param int    $id
     * @param string $fields
     * @return UserProfile
     */
    public function userProfile($id, $fields = 'first_name,last_name,profile_pic,locale,timezone,gender')
    {
        return new UserProfile($this->call($id, [
            'fields' => $fields
        ], self::TYPE_GET));
    }

    /**
     * Set Persistent Menu
     *
     * @see https://developers.facebook.com/docs/messenger-platform/thread-settings/persistent-menu
     * @param MessageButton[] $buttons
     * @return array
     */
    public function setPersistentMenu($buttons)
    {
        $elements = [];

        foreach ($buttons as $btn) {
            $elements[] = $btn->getData();
        }

        return $this->call('me/thread_settings', [
            'setting_type' => 'call_to_actions',
            'thread_state' => 'existing_thread',
            'call_to_actions' => $elements
        ], self::TYPE_POST);
    }

    /**
     * Remove Persistent Menu
     *
     * @see https://developers.facebook.com/docs/messenger-platform/thread-settings/persistent-menu
     * @return array
     */
    public function deletePersistentMenu()
    {
        return $this->call('me/thread_settings', [
            'setting_type' => 'call_to_actions',
            'thread_state' => 'existing_thread'
        ], self::TYPE_DELETE);
    }

    /**
     * Request to API
     *
     * @param string $url
     * @param array  $data
     * @param string $type Type of request (GET|POST|DELETE)
     * @return array
     */
    protected function call($url, $data, $type = self::TYPE_POST)
    {


        $headers = [
            'Content-Type: application/json',
        ];

        $method="POST";

        if ($type == self::TYPE_GET) {
            $url .= '?'.http_build_query($data);
            $method="GET";
        }


        if ($type == self::TYPE_DELETE) {
            $method="DELETE";
        }

        $client=new Client();
        $data['access_token'] = $this->token;

        $response=$client->request($method,$this->apiUrl.$url,["form_params"=>$data,"headers"=>$headers]);

        die(Var_dump($response->getContent()->getBody()));


        return json_decode($respose->getContent()->getBody()    , true);
    }
}
