<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {

    private static $_CITIES = [

        "Bisho",
        "Bloemfontein",
        "Cape Town",
        "Durban",
        "Kimberley",
        "Johannesburg",
        "Nelspruit",
        "Pretoria",
    ];

    private static $_PROVINCES = [

        "Eastern Cape" => [

            "Grahamstown",
            "Aliwal",
            "Rhodes",
            "Bisho",
            "Port Elizabeth"
        ],
        "Free State" => [

            "Bloemfontein",
            "Parys",
            "Welkom"
        ],
        "Gauteng" => [

            "Pretoria",
            "Johannesburg",
            "Cullinan"
        ],
        "Kwazulu-Natal" => [

            "Durban",
            "Umhlanga",
            "Richards Bay",
            "Scottburgh"
        ],
        "Limpopo" => [

            "Louis Trichardt",
            "Polokwane"
        ],
        "Mpumalanga" => [

            "Waterval Boven",
            "Nelspruit",
            "Badplaas",
            "Sabie",
            "Waterberg"
        ],
        "Northern Cape" => [

            "Augrabies",
            "Port nolloth",
            "Kimberley"
        ],
        "North West" => [

            "Rustenburg",
            "Hartbeespoort",
            "Britz",
            "Pilansberg"
        ],
        "Western Cape" => [

            "Stellenbosch",
            "Gordons Bay",
            "Cape town",
            "Langebaan"
        ],
    ];

    public function __construct() {

        parent::__construct();
    }

    public function index() {

        if ($this->input->post() != NULL) {

            $output = [ "post_received" ];
        }
        else {

            $output = $this->_shuffled();
        }

        $this->_normalizeCities($output);

        $output = json_encode($output);

        $this->output->set_content_type("application/json");
        $this->output->set_output($output);
    }

    public function regions() {

        $result = NULL;

        if ($this->input->post() != NULL) {

            $province = $this->input->post("province");

            foreach (Json::$_PROVINCES as $provinceName => $cities) {

                if (stristr($province, $provinceName) != NULL) {

                    $result[$provinceName] = $cities;
                    break;
                }
            }
        }
        else {
            
            $result = JSON::$_PROVINCES;
        }

        $this->_normalizeRegions($result);
        $output = json_encode($result);

        $this->output->set_content_type("application/json");
        $this->output->set_output($output);
    }

    private function _normalizeCities(&$cities)
    {
        $result = [];

        foreach ($cities as $city) {

            $result[]['name'] = $city;
        }
        $cities = $result;
    }

    private function _normalizeRegions(&$regions) {

        $result = [];
        $regionIndex = 0;
        foreach($regions as $regionName => $cities) {

            $this->_normalizeCities($cities);
            
            $result['province'][$regionIndex]['city'] = $cities;
            $result['province'][$regionIndex]['name'] = $regionName;

            $regionIndex++;
        }
        $regions = $result;
    }

    private function _shuffled() {

        $result = [];
        $len = sizeof(Json::$_CITIES) - 1;
        $numItems = 0;

        while ($numItems < 5) {

            $currentIndex = rand(0, $len);
            $currentCity = Json::$_CITIES[$currentIndex];

            if (array_search($currentCity, $result) === FALSE) {

                $result[] = $currentCity;
                $numItems++;
            }
        }

        return ($result);
    }
}

?>