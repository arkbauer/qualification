<?php

namespace Service;

use Entity\Address;

class AddressBuilder
{
    public function createAddress(array $data): Address
    {
        if ($data['type'] == 'legal') {
            $type = Address::TYPE_LEGAL;
        } elseif ($data['type'] == 'physical') {
            $type = Address::TYPE_PHYSICAL;
        }

        $address = new Address(
            $data['id'],
            $data['creator'] ?? '',
            $data['country'] ?? '',
            $data['street'] ?? '',
            $data['house'] ?? 0,
            $data['city'] ?? '',
            $data['state'] ?? '',
            $data['zip'] ?? '',
            $type,
            $data['is_valid'] === '1',
        );

        return $address;
    }
}
