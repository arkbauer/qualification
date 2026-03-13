<?php

require 'vendor/autoload.php';

use Entity\Address;
use Entity\Company;
use Service\AddressBuilder;
use Service\CompanyBuilder;

$entries = [
    [
        'id' => 123,
        'creator' => 'demo1@test.com',
        'name' => 'Nexus Corp',
        'addresses' => [
            [
                'id' => 10001,
                'creator' => 'demo2@test.com',
                'country' => 'GB',
                'street' => 'Baker Street',
                'house' => 317,
                'city' => 'London',
                'state' => 'Greater London',
                'zip' => 'SW1A 1AA',
                'type' => Address::TYPE_LEGAL,
                'is_valid' => '1',
            ],
            [
                'id' => 10002,
                'creator' => 'demo3@test.com',
                'country' => 'JP',
                'street' => 'Jingumae',
                'house' => 263,
                'city' => 'Shibuya',
                'state' => 'Tokyo',
                'zip' => '150-0001',
                'type' => Address::TYPE_PHYSICAL,
                'is_valid' => '0',
            ],
        ],
    ],
];

$companyBuilder = new CompanyBuilder();
$addressBuilder = new AddressBuilder();

foreach ($entries as $entry) {
    $company = $companyBuilder->createCompany($entry);

    foreach ($entry['addresses'] as $address) {
        $addressObj = $addressBuilder->createAddress($address);
        $company->addAddress($addressObj);
    }

    print_r($company->render(Enum\Format::US));
    print_r($company->render(Enum\Format::UK));
    print_r($company->render(Enum\Format::JP));
}
