<?php
/**
 * Created by PhpStorm.
 * User: pgk
 * Date: 3/3/18
 * Time: 3:26 PM
 */

namespace Pgk\Drivers;

use Pgk\Contracts\SearchProviderInterface;

class GithubDriver extends SearchDriver implements SearchProviderInterface
{

    protected $dataKey = 'items';

    /**
     * We must provide current search provider implementation for the search options,
     * that user use in our system
     *
     * @return array
     */
    public function machParams()
    {
        return [
            'phrase' => 'q',
            'results_per_page' => 'per_page',
            'sort_by' => 'sort_by'
        ];
    }

    /**
     * Make search query understandable for Search provider
     *
     * @param $query
     * @return mixed
     */
    public function formatInput($query)
    {
        parse_str($query, $parsed);

        return $parsed;
    }

    /**
     * @return string
     */
    public function baseUrl()
    {
        return 'https://api.github.com/search/';
    }

    /**
     * @param array|string|Object $query
     * @return string
     */
    public function searchRepository($query)
    {
        parent::searchRepository($query);

        return $this->baseUrl() . "repositories?" . $this->generateSearchQuery();
    }

    /**
     * @param array|string|Object $query
     * @return string
     */
    public function searchUser($query)
    {
        parent::searchRepository($query);

        return $this->baseUrl() . "users?" . $this->generateSearchQuery();
    }

    /**
     * Replace search options keys that we provide for use of the user with
     * current search provider implementation
     *
     * @return string
     */
    public function generateSearchQuery()
    {
        return http_build_query( array_combine(array_merge($this->search_options, $this->machParams()), $this->search_options) );
    }

    /**
     * @param $response_row
     * @return array|mixed
     */
    public function formatResponse($response_row)
    {
        return [
            'name' => $response_row->name,
            'user' => $response_row->owner->login
        ];
    }
}