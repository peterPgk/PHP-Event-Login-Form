<?php
/**
 * Created by PhpStorm.
 * User: pgk
 * Date: 2/27/18
 * Time: 3:17 PM
 */

namespace Pgk\Core;


use Pgk\Contracts\SearchProviderInterface;

/**
 * Class Search
 * @package Pgk\Core
 */
class Search
{
    protected $provider;

    protected $headers = []; //TODO

    public function __construct(SearchProviderInterface $search_provider )
    {
        $this->provider = $search_provider;
    }

    /**
     * @param $query
     * @return mixed
     * @throws \Exception
     */
    public function find($query)
    {
        $curl = curl_init($this->provider->searchRepository($query));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31');

        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
        	$error = curl_error($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);

            throw new \Exception($error);
        }

        curl_close($curl);

        $decoded = json_decode($curl_response);

        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            throw new \Exception($decoded->response->errormessage);
        }

        /**
         * In fact this should not be task of search provider,
         * but in our case I put this f-n there
         */
        return $this->provider->formatOutput($decoded);
    }

}