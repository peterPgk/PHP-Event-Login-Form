<?php
/**
 * Created by PhpStorm.
 * User: pgk
 * Date: 2/27/18
 * Time: 3:14 PM
 */

namespace Pgk\Contracts;

/**
 * Interface SearchProviderInterface
 * @package Pgk\Contracts
 */
interface SearchProviderInterface
{

    /**
     * Must return an array wich maps current provider search keys
     * with search keys for our SearchDriver
     *
     * @return array
     */
    public function machParams();
//    public function machParams() : array;

    /**
     * Base URL for the provider
     *
     * @return string
     */
    public function baseUrl();

    /**
     * @param $query - Search query string
     * @return string
     */
    public function searchRepository($query);

    /**
     * @param $query
     * @return mixed
     */
    public function searchUser($query);


    /**
     * In real life, this should be in a different interface
     * ResponseInterface or something
     *
     * How to format each row of the result - what we want to return
     *
     * @param $response_row
     * @return mixed
     */
    public function formatResponse($response_row);

    /**
     * In real life, this should be in a different interface
     * InputInterface or something
     *
     * Make input query understandable for our Provider
     *
     * For instance in our case this translates search strings in format
     * query_string to array, but in other cases this must be set of POST/GET
     * variables
     *
     * @param $query
     * @return mixed
     */
    public function formatInput($query);

}