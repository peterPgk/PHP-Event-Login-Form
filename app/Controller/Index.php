<?php
namespace Pgk\Controller;

use Pgk\Core\Controller;
use Pgk\Core\Redirect;
use Pgk\Core\Request;
use Pgk\Core\Search;
use Pgk\Core\Session;
use Pgk\Drivers\GithubDriver;

/**
 * Class Index
 * 
 * @package Pgk\Controller
 */
class Index extends Controller
{
    public function __construct( $container ) {
        parent::__construct( $container );
    }

    /**
     * Default action
     */
    public function index() {

	    if (! Session::user_is_logged() ) {
		    Redirect::to('login/index');
	    }
        $this->view->render('index/index');
    }

    public function search()
    {
        //TODO: Select search driver from options
        //TODO: Pull from Container
        $search = new Search(new GithubDriver);

        try {
            $data = $search->find(Request::post('phrase'));

        } catch (\Exception $e) {
			$data[] = $e->getMessage();
        }

	    $this->view->render('search/results', $data);

    }
}
