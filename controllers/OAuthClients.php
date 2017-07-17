<?php namespace Octobro\API\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * O Auth Clients Back-end Controller
 */
class OAuthClients extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Octobro.API', 'api', 'oauthclients');
    }
}
