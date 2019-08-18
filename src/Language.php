<?php
declare(strict_types=1);

namespace LanguageApp;

use Exception;
use LanguageApp\LanguageInterface;
use Curl\Curl;

/**
 * This class will process different language related module required
 */
class Language implements LanguageInterface
{
    private $curl;

    /**
     * construct with curl dependency
     */
    public function __construct(Curl $curl)
    {        
        $this->curl = $curl;
    }

    /**
     * this method will process language details for a country
     */
    public function getLanguageDetails( $countryName ): string
    {
        try {
            // input validation
            if( preg_match('/^[a-zA-Z]{2,}/', $countryName )) {
                // restcountries API
                $url = "https://restcountries.eu/rest/v2/name/" . $countryName . "?fullText=true";
                $result = $this->curl->get( $url );

                // curl output validation
                if ($this->curl->error) {
                    return $this->output( $this->curl->error_code );

                } else {
                    $finalResult = 'Country language code: ';
                    $response = json_decode($result->response);

                    // some countries have more than one official languages eg. India
                    foreach($response[0]->languages as $language)
                    {
                        $finalResult .= $language->iso639_1 . ', ';

                        // check which other countries speak same language
                        $url = "https://restcountries.eu/rest/v2/lang/" . $language->iso639_1;
                        $result = $this->curl->get( $url );

                        // curl output validation
                        if ($this->curl->error) {
                            return $this->output( $this->curl->error_code );
        
                        } else {
                            $responseCountries = json_decode($result->response);
                            $tempResult = '';

                            $cnt = 0;
                            // check all countries speak in same language
                            foreach($responseCountries as $country)
                            {
                                if($country->name != $countryName) {
                                    $tempResult .= $country->name . ', ';
                                    $cnt++;
                                }                                
                            }
                        }                                                
                    }

                    // removing the last , and space
                    $finalResult = substr($finalResult, 0, -2);
                    if($cnt > 0) { 
                        $finalResult .= "\r\n" . $countryName . ' speaks same language with these countries: ' . substr($tempResult, 0, -2);
                    } else {
                        $finalResult .= "\r\n" . 'No other countries speaks ' . $countryName . '\'s language.';
                    }
                    
                    return $this->output( $finalResult );
                }
                
            } else {
                return $this->output('Not a country');
            }            

        } catch (Exception $e) {
            return "\r\n" . $e->getMessage() . "\r\n";
        }        
    }

    /**
     * this method will process whether two countries speak in same language
     */
    public function getSimilarity( $countryNameFirst, $countryNameSecond ): string
    {
        try {
            // input validation
            if (preg_match('/^[a-zA-Z]{2,}/', $countryNameFirst) && preg_match('/^[a-zA-Z]{2,}/', $countryNameSecond)) {
                // restcountries API
                $url = "https://restcountries.eu/rest/v2/name/" . $countryNameFirst . "?fullText=true";
                $result = $this->curl->get( $url );

                // curl output validation
                if ($this->curl->error) {
                    return $this->output( $this->curl->error_code );

                } else {
                    $response = json_decode($result->response);

                    // some countries speak in more than one language
                    foreach($response[0]->languages as $language)
                    {
                        // check which other countries speak same language
                        $url = "https://restcountries.eu/rest/v2/lang/" . $language->iso639_1;
                        $result = $this->curl->get( $url );

                        // curl output validation
                        if ($this->curl->error) {
                            return $this->output( $this->curl->error_code );
        
                        } else {
                            $responseCountries = json_decode($result->response);
                            $matched = false;
                            // checking if the second country speak same language
                            foreach($responseCountries as $country)
                            {
                                if($country->name == $countryNameSecond) {
                                    $matched = true;
                                    break;
                                }                                
                            }
                        }                                                
                    }

                    if($matched) {
                        $finalResult = $countryNameFirst . ' and ' . $countryNameSecond . ' speak the same language';
                    } else {
                        $finalResult = $countryNameFirst . ' and ' . $countryNameSecond . ' do not speak the same language';
                    }                 
                    
                    return $this->output( $finalResult );
                }
                
            } else {
                return $this->output('Only country names accepted');
            }            

        } catch (Exception $e) {
            return "\r\n" . $e->getMessage() . "\r\n";
        }
    }

    /**
     * This will print the output
     */
    private function output( $result ): string
    {
        try {
            $finalResult = "\r\n";
            $finalResult .= $result;
            $finalResult .= "\r\n";

            return $finalResult;

        } catch ( Exception $e ) {
            return "\r\n" . $e->getMessage() . "\r\n";
        }
        
    }
}