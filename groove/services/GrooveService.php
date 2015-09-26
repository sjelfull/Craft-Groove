<?php
namespace Craft;

class GrooveService extends BaseApplicationComponent
{
    protected $settings;
    protected $_endpoint = 'https://api.groovehq.com';
    protected $client;
    protected $errors = [];

    public function init ()
    {
        $plugin = craft()->plugins->getPlugin('groove');

        if ( !$plugin ) {
            throw new Exception('Couldn’t find the Groove plugin!');
        }

        $this->settings = $plugin->getSettings();

        $this->client = new \Guzzle\Http\Client($this->_endpoint,
            array(
                'request.options' => array(
                    //'headers' => array( 'Authorization' => 'Bearer ' . $this->settings->privateToken ),
                    'query' => array( 'access_token' => $this->settings->privateToken ),
                    //'a uth'    => array('username', 'password', 'Basic|Digest|NTLM|Any'),
                    //'proxy'   => 'tcp://localhost:80'
                )
            )
        );
        //$this->client->setDefaultOption('verify', false);

    }

    public function submitTicket (Groove_TicketModel &$model)
    {
        if ( $model->validate() ) {
            $result = $this->_sendPostRequest('/tickets', [
                'body'  => $model->getAttribute('message'),
                'from'  => $model->getAttribute('email'),
                'to'    => 'fred@sjelfull.no',
                'email' => $model->getAttribute('email'),
                'name'  => $model->getAttribute('name'),
                // assignee
                // assigned_group
                // subject
                // tags
                // phone_number
            ]);

            if (!$result) {
                $this->addErrorsToModel($model);
            }

            return $result;
        }
    }

    public function getMailboxes ()
    {
        return $this->_sendGetRequest($url = '/mailboxes');
    }

    protected function _sendPostRequest ($url, $data = [ ])
    {

        try {
            $request  = $this->client->post('/v1' . $url, [], $data);
            $response = $request->send();

            $data = $response->json();

            return $data;
        }
        catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            GroovePlugin::log('(Groove) POST request failed: ' . $e->getMessage());

            return false;
        }
    }

    protected function _sendGetRequest ($url)
    {

        try {
            $request  = $this->client->get('/v1/' . $url);
            $response = $request->send();

            $data = $response->json();

            return $data;
        }
        catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            GroovePlugin::log('(Groove) GET request failed: ' . $e->getMessage());

            return false;
        }
    }

    protected function addErrorsToModel (&$model)
    {
        if (count($this->errors) > 0) {
            foreach ($this->errors as $error) {
                $model->addError('groove', $error);
            }
        }
    }

}