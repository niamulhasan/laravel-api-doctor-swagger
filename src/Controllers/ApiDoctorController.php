<?php

namespace NiamulHasan\ApiDoctorSwagger\Controllers;

use NiamulHasan\ApiDoctorSwagger\ApiDoctorSwagger;

class ApiDoctorController
{
    public function index()
    {
        return view('api-doctor-swagger::index');
    }

    public function yamlGenerated(ApiDoctorSwagger $apiDoctorSwagger): string
    {
        return $apiDoctorSwagger->getYaml();
    }

}
