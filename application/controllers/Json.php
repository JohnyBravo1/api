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

        "Eastern Cape",
        "Free State",
        "Gauteng",
        "Kwazulu-Natal",
        "Limpopo",
        "Mpumalanga",
        "Northern Cape",
        "North West",
        "Polokwane",
        "Western Cape",
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

        $this->_normalize($output);

        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($output));
    }

    private function _normalize(&$cities) {

        $result = [];

        foreach ($cities as $city) {

            $result[]['name'] = $city;
        }

        // $cities = $result;
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