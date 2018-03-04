<?php
/**
 * Created by PhpStorm.
 * User: pgk
 * Date: 3/3/18
 * Time: 5:30 PM
 */

namespace Pgk\Drivers;


use Pgk\Contracts\SearchProviderInterface;

/**
 * Class SearchDriver
 * @package Pgk\Drivers
 */
abstract class SearchDriver implements SearchProviderInterface
{

    /**
     * If data that we need is deeper in
     * returned result, than we need to provide
     * a key for this
     *
     * TODO: If data is deeper than one level
     *
     * @var null
     */
    protected $dataKey = null;

    /**
     * These are the search options, we provide to the user
     * This keys are our decision, later will be changed with
     * these, provided by curent driver from machParams()
     *
     * @var array
     */
    protected $search_options = [
        'phrase' => 'kdjfkdjfkddhfdjh', //TODO
        'results_per_page' => 25,
        'sort_by' => 'score'
    ];

    /**
     * Update search options with user preferences
     *
     * @param array|string|Object $query
     */
    public function searchRepository($query)
    {
        $this->setSearchOptions($query);
    }

    /**
     * Make posted query understandable for search provider
     *
     * Update search options with user preferences
     *
     * @param array $query
     */
    public function setSearchOptions($query)
    {
        $new_options = $this->formatInput($query);

        $this->search_options = array_intersect_key($new_options, $this->search_options) + $this->search_options;
    }


    /**
     * This should not be here ...
     *
     * @param $response
     * @return array
     */
    public function formatOutput($response)
    {
        return array_map([$this, 'formatResponse'], $this->dataKey ? $response->{$this->dataKey} : $response);
    }
}