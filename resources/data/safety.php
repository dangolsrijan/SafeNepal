<?php

/**
 * SafeNepal Frontend Demo Data — Safety Advisories & Emergency Contacts
 *
 * Clearly labeled simulated/reference safety data for frontend demonstration.
 */

return [
    'alerts' => [
        [
            'id' => 1,
            'destination_slug' => 'everest-region',
            'title' => 'High-Altitude Night Frost Advisory above 4,200m (DEMO)',
            'severity' => 'warning',
            'message' => 'Simulated seasonal advisory: Temperatures above Dingboche and Lobuche drop below -10°C overnight. Carry rated -15°C sleeping bags and verify daily acclimatization.',
            'is_demo_data' => true,
        ],
        [
            'id' => 2,
            'destination_slug' => 'mustang',
            'title' => 'Afternoon Kali Gandaki Valley Wind Caution (DEMO)',
            'severity' => 'advisory',
            'message' => 'Simulated advisory: High winds typically pick up after 11:30 AM between Jomsom and Kagbeni. Plan morning departures for smoother trekking and flights.',
            'is_demo_data' => true,
        ],
        [
            'id' => 3,
            'destination_slug' => null,
            'title' => 'Carry Offline Emergency Contacts & TIMS Registration (DEMO)',
            'severity' => 'info',
            'message' => 'Before departing for remote trails, register your trekking permits, share your SafeNepal Check-In schedule, and keep Tourist Police (1144) saved offline.',
            'is_demo_data' => true,
        ],
    ],
    'emergency_contacts' => [
        [
            'id' => 1,
            'name' => 'Nepal Police Emergency',
            'category' => 'police',
            'phone' => '100',
            'region' => 'Nepal Nationwide',
            'description' => '24/7 national police emergency hotline (reference number).',
            'is_demo_data' => true,
        ],
        [
            'id' => 2,
            'name' => 'Tourist Police Nepal (Bhrikutimandap)',
            'category' => 'tourist_police',
            'phone' => '1144',
            'region' => 'Nepal Nationwide',
            'description' => 'Dedicated tourist assistance, lost documents, and travel safety support.',
            'is_demo_data' => true,
        ],
        [
            'id' => 3,
            'name' => 'Ambulance Service Nepal',
            'category' => 'ambulance',
            'phone' => '102',
            'region' => 'Nepal Nationwide',
            'description' => 'Emergency medical ambulance dispatch (reference number).',
            'is_demo_data' => true,
        ],
        [
            'id' => 4,
            'name' => 'Himalayan Rescue Association (HRA)',
            'category' => 'rescue',
            'phone' => '+977-1-4440292',
            'region' => 'Kathmandu / Everest / Annapurna',
            'description' => 'High-altitude medical advice and seasonal mountain aid posts.',
            'is_demo_data' => true,
        ],
        [
            'id' => 5,
            'name' => 'CIWEC Hospital Travel Medicine',
            'category' => 'hospital',
            'phone' => '+977-1-4524111',
            'region' => 'Kathmandu & Pokhara',
            'description' => '24/7 international travel medicine and altitude emergency clinic.',
            'is_demo_data' => true,
        ],
    ],
];
