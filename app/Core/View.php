<?php
namespace Pgk\Core;

/**
 * Class View
 * The part that handles all the output
 */
class View
{
    protected $data = [];

    public function render($filename, $data = null)
    {
        if ($data) {
            /**
             * ??? two years ago I can't remember why this way
             * but will not change for now
             */
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }

            $this->data = (array)$data;
        }

	    if ( Ajax::isAjaxRequest() ) {
			$this->render_solo( $filename );
	    }
	    else {
		    $this->load( 'header' );
		    $this->load( $filename );
		    $this->load( 'footer' );
	    }
    }

	/**
	 * View without header and footer
	 * @param $filename
	 */
	public function render_solo( $filename ) {
		$this->load($filename);
	}


    /**
     * Renders pure JSON to the browser, useful for API construction
     * @param $data
     */
    public function renderJSON($data)
    {
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    /**
     * renders the feedback messages into the view
     */
    public function renderFeedbackMessages()
    {
        $this->load( 'feedback' );
        Session::set('feedback', []);
    }
    
    /**
     * Converts characters to HTML entities
     * This is important to avoid XSS attacks, and attempts to inject malicious code in your page.
     *
     * @param  string $str The string.
     * @return string
     */
    public function encodeHTML($str){
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }

	protected function load( $file ) {
		require Config::get('template_path') . $file . '.php';
	}
}
