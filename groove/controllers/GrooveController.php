<?php
namespace Craft;

class GrooveController extends BaseController
{
    protected $settings;
    protected $allowAnonymous = [ 'actionSubmitTicket' ];

    public function init ()
    {
        $this->settings = craft()->plugins->getPlugin('groove')->getSettings();
    }

    public function actionSubmitTicket ()
    {
        $this->requirePostRequest();
        //$message = craft()->request->getPost('message');

        $model = new Groove_TicketModel();

        $data = $this->_gatherDataFromPost();

        foreach ($data as $key => $value) {
            $model->setAttribute($key, $value);
        }

        $result = craft()->groove->submitTicket($model);

        if ( $model->hasErrors() ) {
            $this->returnErrorJson($model->getErrors());
        }

        $this->returnJson($model->getAttributes());
    }

    /**
     * Returns an 'error' response.
     *
     * @param $entry
     */
    private function _returnError ($entry)
    {
        if ( craft()->request->isAjaxRequest() ) {
            $this->returnJson(array(
                'errors' => $entry->getErrors(),
            ));
        }
        else {
            craft()->userSession->setError(Craft::t('Couldn’t save entry.'));

            // Send the entry back to the template
            $entryVariable = craft()->config->get('entryVariable', 'guestentries');

            craft()->urlManager->setRouteVariables(array(
                $entryVariable => $entry
            ));
        }
    }

    private function _gatherDataFromPost ()
    {
        $supportedAttributes = [
            'email',
            'name',
            'message',
        ];
        $returnData          = [ ];

        $data = craft()->request->getPost();
        foreach ($data as $key => $value) {
            if ( in_array($key, $supportedAttributes) ) {
                $returnData[ $key ] = $value;
            }
        }

        return $returnData;
    }
}