<?php

class Api 
{
    private $url = '192.168.100.9';
    private $port = ':80';

    static public function index(string $table){
        $self = new self();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $self->url.$self->port."/aspel/api/v3/".$table,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic dTJhdTA3dUIyQmFmZDM0Nnl0aHBvbG10cnNBYi5BN0F5bC5XZ1J0c2ljbjd5a0tmZ0hXQ2xtS3ZlNXUuOmsyYWswN2tCMkJhZmQzNDZ5dGhwb2xtdHJzQWIuV21pci5UMC9UaC5SYlV6TTlMbHE0MEVLOFFZbTlLVw=="
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    static public function show(string $table, string $id){
        $self = new self();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $self->url.$self->port."/aspel/api/v3/".$table."/".$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic dTJhdTA3dUIyQmFmZDM0Nnl0aHBvbG10cnNBYi5BN0F5bC5XZ1J0c2ljbjd5a0tmZ0hXQ2xtS3ZlNXUuOmsyYWswN2tCMkJhZmQzNDZ5dGhwb2xtdHJzQWIuV21pci5UMC9UaC5SYlV6TTlMbHE0MEVLOFFZbTlLVw=="
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    static public function create(string $table, array $data){
        $self = new self();
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $self->url.$self->port."/aspel/api/v3/".$table,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic dTJhdTA3dUIyQmFmZDM0Nnl0aHBvbG10cnNBYi5BN0F5bC5XZ1J0c2ljbjd5a0tmZ0hXQ2xtS3ZlNXUuOmsyYWswN2tCMkJhZmQzNDZ5dGhwb2xtdHJzQWIuV21pci5UMC9UaC5SYlV6TTlMbHE0MEVLOFFZbTlLVw=="
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

}
