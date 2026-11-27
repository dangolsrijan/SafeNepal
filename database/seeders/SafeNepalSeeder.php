<?php

namespace Database\Seeders;

use App\Models\AgencyProfile;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\DestinationActivity;
use App\Models\EmergencyContact;
use App\Models\GuideProfile;
use App\Models\Inquiry;
use App\Models\InquiryMessage;
use App\Models\NearbyService;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Review;
use App\Models\SafetyAlert;
use App\Models\SafetyInformation;
use App\Models\Trip;
use App\Models\TripActivity;
use App\Models\TripDay;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SafeNepalSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@safenepal.test'],
            [
                'name' => 'Aarav Shrestha',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+977-9801000001',
                'location' => 'Kathmandu, Nepal',
                'bio' => 'SafeNepal Platform Administrator overseeing destination safety and partner verification.',
                'is_active' => true,
            ]
        );

        $traveler = User::updateOrCreate(
            ['email' => 'traveler@safenepal.test'],
            [
                'name' => 'Maya Gurung',
                'password' => Hash::make('password'),
                'role' => 'traveler',
                'phone' => '+977-9841000002',
                'location' => 'Pokhara, Nepal',
                'bio' => 'Mountain photographer and responsible traveler exploring Himalayan heritage trails.',
                'is_active' => true,
            ]
        );

        $traveler2 = User::updateOrCreate(
            ['email' => 'rohan@safenepal.test'],
            [
                'name' => 'Rohan Tamang',
                'password' => Hash::make('password'),
                'role' => 'traveler',
                'phone' => '+977-9841000009',
                'location' => 'Lalitpur, Nepal',
                'bio' => 'Weekend trekker and cultural explorer.',
                'is_active' => true,
            ]
        );

        $agencyUsers = [
            User::updateOrCreate(
                ['email' => 'agency@safenepal.test'],
                [
                    'name' => 'Pemba Sherpa',
                    'password' => Hash::make('password'),
                    'role' => 'agency',
                    'phone' => '+977-9851000101',
                    'location' => 'Thamel, Kathmandu',
                    'is_active' => true,
                ]
            ),
            User::updateOrCreate(
                ['email' => 'annapurna.agency@safenepal.test'],
                [
                    'name' => 'Bikash Pun',
                    'password' => Hash::make('password'),
                    'role' => 'agency',
                    'phone' => '+977-9856000202',
                    'location' => 'Lakeside, Pokhara',
                    'is_active' => true,
                ]
            ),
            User::updateOrCreate(
                ['email' => 'terai.agency@safenepal.test'],
                [
                    'name' => 'Sita Chaudhary',
                    'password' => Hash::make('password'),
                    'role' => 'agency',
                    'phone' => '+977-9855000303',
                    'location' => 'Sauraha, Chitwan',
                    'is_active' => true,
                ]
            ),
            User::updateOrCreate(
                ['email' => 'pending.agency@safenepal.test'],
                [
                    'name' => 'Kiran Lama',
                    'password' => Hash::make('password'),
                    'role' => 'agency',
                    'phone' => '+977-9851000404',
                    'location' => 'Boudha, Kathmandu',
                    'is_active' => true,
                ]
            ),
        ];

        $agenciesData = [
            [
                'user_id' => $agencyUsers[0]->id,
                'name' => 'Himalayan Horizon Expeditions',
                'slug' => 'himalayan-horizon-expeditions',
                'logo' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=300&q=80',
                'description' => 'Government-licensed trekking and high-altitude expedition operator based in Thamel with 18 years of safety-first Himalayan guiding.',
                'location' => 'Thamel, Kathmandu',
                'phone' => '+977-1-4412345',
                'email' => 'agency@safenepal.test',
                'website' => 'https://himalayanhorizon.demo.np',
                'license_number' => 'NTB-2048-KTM',
                'verification_status' => 'verified',
                'verified_at' => now()->subMonths(8),
                'rating_avg' => 4.9,
                'reviews_count' => 3,
            ],
            [
                'user_id' => $agencyUsers[1]->id,
                'name' => 'Annapurna Trailcraft Tours',
                'slug' => 'annapurna-trailcraft-tours',
                'logo' => 'https://images.unsplash.com/photo-1585016495481-91613a3ab1bc?auto=format&fit=crop&w=300&q=80',
                'description' => 'Pokhara-based boutique agency specializing in Annapurna, Mustang, and lake-to-peak eco-trekking experiences.',
                'location' => 'Lakeside, Pokhara',
                'phone' => '+977-61-462890',
                'email' => 'annapurna.agency@safenepal.test',
                'website' => 'https://trailcraft.demo.np',
                'license_number' => 'NTB-3109-PKR',
                'verification_status' => 'verified',
                'verified_at' => now()->subMonths(5),
                'rating_avg' => 4.8,
                'reviews_count' => 2,
            ],
            [
                'user_id' => $agencyUsers[2]->id,
                'name' => 'Terai Wildlife & Heritage Journeys',
                'slug' => 'terai-wildlife-heritage-journeys',
                'logo' => 'https://images.unsplash.com/photo-1547970810-dc1eac37d174?auto=format&fit=crop&w=300&q=80',
                'description' => 'Community-led wildlife safaris in Chitwan and spiritual heritage tours across Lumbini and Kathmandu Valley.',
                'location' => 'Sauraha, Chitwan',
                'phone' => '+977-56-580211',
                'email' => 'terai.agency@safenepal.test',
                'website' => 'https://teraijourneys.demo.np',
                'license_number' => 'NTB-4210-CHT',
                'verification_status' => 'verified',
                'verified_at' => now()->subMonths(3),
                'rating_avg' => 4.7,
                'reviews_count' => 2,
            ],
            [
                'user_id' => $agencyUsers[3]->id,
                'name' => 'Langtang Valley Eco Treks',
                'slug' => 'langtang-valley-eco-treks',
                'logo' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=300&q=80',
                'description' => 'Newly registered eco-friendly trekking collective focused on Langtang and Tamang Heritage trails.',
                'location' => 'Boudha, Kathmandu',
                'phone' => '+977-1-4911223',
                'email' => 'pending.agency@safenepal.test',
                'website' => 'https://langtangeco.demo.np',
                'license_number' => 'NTB-PENDING-882',
                'verification_status' => 'pending',
                'verified_at' => null,
                'rating_avg' => 0,
                'reviews_count' => 0,
            ],
        ];

        $agencies = [];
        foreach ($agenciesData as $data) {
            $agencies[$data['slug']] = AgencyProfile::updateOrCreate(['slug' => $data['slug']], $data);
        }

        $guidesData = [
            [
                'agency_id' => $agencies['himalayan-horizon-expeditions']->id,
                'name' => 'Tenzing Norbu Sherpa',
                'slug' => 'tenzing-norbu-sherpa',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
                'bio' => 'Certified high-altitude trekking guide from Namche Bazaar with over 14 years leading safe Everest Base Camp and Gokyo expeditions.',
                'location' => 'Solukhumbu / Kathmandu',
                'experience_years' => 14,
                'specializations' => ['Trekking', 'High Altitude', 'Adventure', 'Photography'],
                'languages' => ['English', 'Nepali', 'Sherpa', 'Hindi'],
                'certifications' => ['NMA Trekking Guide License', 'Wilderness First Responder (WFR)', 'Altitude Sickness Rescue Training'],
                'services' => ['Private Trek Guiding', 'Permit & Logistics Support', 'Acclimatization Planning', 'Emergency Satellite Comms'],
                'daily_rate_npr' => 7500,
                'verification_status' => 'verified',
                'rating_avg' => 4.95,
                'reviews_count' => 2,
            ],
            [
                'agency_id' => $agencies['annapurna-trailcraft-tours']->id,
                'name' => 'Anjali Gurung',
                'slug' => 'anjali-gurung',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&q=80',
                'bio' => 'Pioneering female trekking leader in the Annapurna and Mustang regions, passionate about solo-female travel safety and Gurung culture.',
                'location' => 'Pokhara',
                'experience_years' => 9,
                'specializations' => ['Trekking', 'Culture', 'Nature', 'Photography'],
                'languages' => ['English', 'Nepali', 'Gurung', 'Japanese'],
                'certifications' => ['NTB Licensed Trekking Guide', 'Female Trekking Safety Specialist', 'Basic First Aid'],
                'services' => ['Women-Friendly Treks', 'Cultural Homestay Guiding', 'Annapurna & Mustang Routes'],
                'daily_rate_npr' => 6500,
                'verification_status' => 'verified',
                'rating_avg' => 4.9,
                'reviews_count' => 2,
            ],
            [
                'agency_id' => $agencies['terai-wildlife-heritage-journeys']->id,
                'name' => 'Dipendra Tharu',
                'slug' => 'dipendra-tharu',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
                'bio' => 'Naturalist and birding specialist born in Sauraha with deep knowledge of Chitwan National Park flora, fauna, and ethical wildlife tracking.',
                'location' => 'Chitwan',
                'experience_years' => 11,
                'specializations' => ['Wildlife', 'Nature', 'Photography', 'Culture'],
                'languages' => ['English', 'Nepali', 'Tharu', 'Hindi'],
                'certifications' => ['Chitwan National Park Licensed Naturalist', 'Wildlife Safety & First Aid'],
                'services' => ['Jeep & Walking Safaris', 'Birdwatching Tours', 'Tharu Village Walks'],
                'daily_rate_npr' => 5200,
                'verification_status' => 'verified',
                'rating_avg' => 4.85,
                'reviews_count' => 1,
            ],
            [
                'agency_id' => $agencies['himalayan-horizon-expeditions']->id,
                'name' => 'Prakash Maharjan',
                'slug' => 'prakash-maharjan',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=400&q=80',
                'bio' => 'Kathmandu Valley historian, architectural storyteller, and Newari culinary guide licensed by the Department of Tourism.',
                'location' => 'Kathmandu',
                'experience_years' => 12,
                'specializations' => ['Culture', 'History', 'Food', 'Spirituality'],
                'languages' => ['English', 'Nepali', 'Newari', 'French'],
                'certifications' => ['Department of Tourism City Guide', 'UNESCO Heritage Interpreter'],
                'services' => ['Heritage Walking Tours', 'Newari Food Trails', 'Monastery & Temple Immersion'],
                'daily_rate_npr' => 4800,
                'verification_status' => 'verified',
                'rating_avg' => 4.8,
                'reviews_count' => 1,
            ],
            [
                'agency_id' => $agencies['annapurna-trailcraft-tours']->id,
                'name' => 'Sonam Lama',
                'slug' => 'sonam-lama',
                'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=400&q=80',
                'bio' => 'Remote region specialist guiding restricted-area treks in Manaslu, Upper Mustang, and Far-West Rara Lake.',
                'location' => 'Kathmandu / Manaslu',
                'experience_years' => 10,
                'specializations' => ['Trekking', 'Adventure', 'Spirituality', 'History'],
                'languages' => ['English', 'Nepali', 'Tibetan'],
                'certifications' => ['Restricted Area Trekking Guide', 'Mountain Rescue First Aid'],
                'services' => ['Manaslu Circuit Guiding', 'Upper Mustang Cultural Expeditions', 'Rara Overland & Trek'],
                'daily_rate_npr' => 7000,
                'verification_status' => 'verified',
                'rating_avg' => 4.9,
                'reviews_count' => 1,
            ],
            [
                'agency_id' => $agencies['terai-wildlife-heritage-journeys']->id,
                'name' => 'Bimala Shakya',
                'slug' => 'bimala-shakya',
                'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80',
                'bio' => 'Buddhist heritage scholar and mindfulness guide leading peaceful retreats in Lumbini and Kathmandu monasteries.',
                'location' => 'Lumbini',
                'experience_years' => 8,
                'specializations' => ['Spirituality', 'History', 'Culture', 'Relaxation'],
                'languages' => ['English', 'Nepali', 'Hindi', 'Mandarin'],
                'certifications' => ['Lumbini Development Trust Certified Guide', 'Meditation & Heritage Facilitator'],
                'services' => ['Sacred Garden Tours', 'Monastic Zone Cycling', 'Mindfulness Retreats'],
                'daily_rate_npr' => 4500,
                'verification_status' => 'verified',
                'rating_avg' => 4.85,
                'reviews_count' => 1,
            ],
        ];

        $guides = [];
        foreach ($guidesData as $data) {
            $guides[$data['slug']] = GuideProfile::updateOrCreate(['slug' => $data['slug']], $data);
        }

        $destinationsData = [
            [
                'name' => 'Kathmandu',
                'slug' => 'kathmandu',
                'region' => 'Bagmati',
                'location' => 'Kathmandu Valley, Bagmati Province',
                'short_description' => 'A living museum of UNESCO World Heritage stupas, medieval Newari courtyards, Himalayan viewpoints, and vibrant culinary streets.',
                'description' => 'Kathmandu Valley blends centuries-old Hindu and Buddhist sacred architecture with bustling artisan bazaars and serene hillside monasteries. Explore Patan and Bhaktapur Durbar Squares, spin prayer wheels at Boudhanath Stupa, and sample authentic Newari cuisine while preparing for mountain journeys.',
                'hero_image' => 'https://images.unsplash.com/photo-1558799401-1dcba79834c2?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1558799401-1dcba79834c2?auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1582650625119-3a31f8fa2699?auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1605640840605-14ac1855827b?auto=format&fit=crop&w=1000&q=80',
                ],
                'difficulty' => 'easy',
                'estimated_duration_days' => 3,
                'estimated_budget_npr' => 18000,
                'best_time_to_visit' => 'September – November, March – May',
                'altitude_max_m' => 1400,
                'interests' => ['Culture', 'History', 'Spirituality', 'Food', 'Photography'],
                'attractions' => ['Swayambhunath Stupa', 'Boudhanath Stupa', 'Patan Durbar Square', 'Bhaktapur Pottery Square', 'Pashupatinath Temple'],
                'travel_info' => 'Accessible via Tribhuvan International Airport (KTM). Ride-hailing apps, taxis, and guided walking tours make valley exploration easy.',
                'latitude' => 27.7172,
                'longitude' => 85.3240,
                'is_featured' => true,
                'rating_avg' => 4.8,
                'reviews_count' => 2,
                'safety' => [
                    'risk_level' => 'low',
                    'safety_description' => 'Kathmandu is generally safe for travelers. Main considerations are urban traffic, air quality during dry winter months, and petty pickpocketing in crowded markets.',
                    'risk_factors' => ['Heavy urban traffic at crossings', 'Seasonal dust and air quality', 'Crowded market pickpocketing'],
                    'recommended_preparation' => ['Carry a lightweight N95 mask for dry roads', 'Use registered taxis or ride-hailing apps', 'Drink filtered or bottled water'],
                    'seasonal_warnings' => 'Monsoon (June–August) brings sudden heavy showers and occasional waterlogging.',
                    'altitude_awareness' => 'At 1,400m, altitude sickness is not a risk.',
                    'emergency_info' => 'Tourist Police Bhrikutimandap (1144) and CIWEC Hospital Lazimpat are within 15 minutes of Thamel.',
                    'weather_demo_data' => ['temp_c' => 21, 'condition' => 'Partly Cloudy', 'wind_kph' => 9, 'precipitation_pct' => 15, 'warning' => null],
                ],
                'activities' => [
                    ['name' => 'Swayambhunath Sunrise Stupa Walk', 'description' => 'Climb the stone steps to the Monkey Temple for panoramic morning views over Kathmandu Valley.', 'category' => 'Heritage', 'interests' => ['Spirituality', 'Photography', 'Culture'], 'duration_hours' => 2.5, 'estimated_cost_npr' => 800, 'difficulty' => 'easy', 'best_time_of_day' => 'morning', 'location' => 'Swayambhu Hill', 'transportation_info' => '15 min taxi from Thamel'],
                    ['name' => 'Patan Durbar Square & Golden Temple', 'description' => 'Explore masterfully carved Newari bronze and wood architecture with a local historian.', 'category' => 'Culture', 'interests' => ['History', 'Culture', 'Photography'], 'duration_hours' => 3.0, 'estimated_cost_npr' => 1800, 'difficulty' => 'easy', 'best_time_of_day' => 'afternoon', 'location' => 'Lalitpur', 'transportation_info' => '25 min drive from Thamel'],
                    ['name' => 'Boudhanath Evening Kora & Rooftop Tea', 'description' => 'Join locals circling one of the world’s largest spherical stupas lit by butter lamps.', 'category' => 'Spirituality', 'interests' => ['Spirituality', 'Culture', 'Relaxation'], 'duration_hours' => 2.0, 'estimated_cost_npr' => 1000, 'difficulty' => 'easy', 'best_time_of_day' => 'evening', 'location' => 'Boudha', 'transportation_info' => '25 min taxi'],
                    ['name' => 'Old Town Newari Culinary Walk', 'description' => 'Taste bara, yomari, chatamari, and spiced masala tea through Asan and Indra Chowk alleys.', 'category' => 'Food', 'interests' => ['Food', 'Culture'], 'duration_hours' => 2.5, 'estimated_cost_npr' => 2200, 'difficulty' => 'easy', 'best_time_of_day' => 'evening', 'location' => 'Asan Bazaar', 'transportation_info' => 'Walking distance from Thamel'],
                    ['name' => 'Bhaktapur Ancient City & Pottery Workshop', 'description' => 'Discover medieval brick squares and try traditional clay wheel pottery with local artisans.', 'category' => 'Heritage', 'interests' => ['History', 'Culture', 'Photography'], 'duration_hours' => 4.0, 'estimated_cost_npr' => 2800, 'difficulty' => 'easy', 'best_time_of_day' => 'morning', 'location' => 'Bhaktapur', 'transportation_info' => '45 min private vehicle'],
                ],
            ],
            [
                'name' => 'Pokhara',
                'slug' => 'pokhara',
                'region' => 'Gandaki',
                'location' => 'Kaski District, Gandaki Province',
                'short_description' => 'Nepal’s tranquil lakeside gateway to the Annapurna massif, famed for Phewa Lake reflections, Sarangkot sunrises, and soft adventure.',
                'description' => 'Nestled beneath the dramatic silhouette of Machhapuchhre (Fishtail), Pokhara balances serene lakeside relaxation with world-class outdoor adventure. Paddle across Phewa Lake, watch sunrise light up Annapurna South from Sarangkot, or embark on gentle ridge hikes.',
                'hero_image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1589308078059-be1415eab4c3?auto=format&fit=crop&w=1000&q=80',
                ],
                'difficulty' => 'easy',
                'estimated_duration_days' => 4,
                'estimated_budget_npr' => 24000,
                'best_time_to_visit' => 'October – April',
                'altitude_max_m' => 1600,
                'interests' => ['Nature', 'Relaxation', 'Adventure', 'Photography', 'Food'],
                'attractions' => ['Phewa Lake', 'Sarangkot Viewpoint', 'World Peace Pagoda', 'Begnas Lake', 'International Mountain Museum'],
                'travel_info' => '25-minute domestic flight or 6–7 hour tourist bus from Kathmandu.',
                'latitude' => 28.2096,
                'longitude' => 83.9856,
                'is_featured' => true,
                'rating_avg' => 4.9,
                'reviews_count' => 2,
                'safety' => [
                    'risk_level' => 'low',
                    'safety_description' => 'Pokhara is one of Nepal’s calmest and safest tourist hubs. Follow life-jacket rules on lakes and choose certified adventure operators.',
                    'risk_factors' => ['Sudden afternoon gusts on Phewa Lake', 'Slippery hillside trails during monsoon'],
                    'recommended_preparation' => ['Always wear life jackets while boating', 'Verify operator licenses for paragliding or zip-lining'],
                    'seasonal_warnings' => 'Heavy rainfall in July–August can obscure mountain views and make ridge trails muddy.',
                    'altitude_awareness' => 'Low elevation (820m–1,600m); no altitude risk.',
                    'emergency_info' => 'Tourist Police Lakeside and Manipal Teaching Hospital provide 24/7 response.',
                    'weather_demo_data' => ['temp_c' => 23, 'condition' => 'Clear & Sunny', 'wind_kph' => 11, 'precipitation_pct' => 10, 'warning' => null],
                ],
                'activities' => [
                    ['name' => 'Sarangkot Himalayan Sunrise View', 'description' => 'Witness golden alpenglow across Dhaulagiri, Annapurna, and Machhapuchhre peaks.', 'category' => 'Nature', 'interests' => ['Photography', 'Nature', 'Relaxation'], 'duration_hours' => 2.5, 'estimated_cost_npr' => 1500, 'difficulty' => 'easy', 'best_time_of_day' => 'morning', 'location' => 'Sarangkot Hill', 'transportation_info' => '30 min sunrise drive from Lakeside'],
                    ['name' => 'Phewa Lake Rowing & Peace Pagoda Hike', 'description' => 'Row across emerald waters and hike through forest shade to the hilltop Shanti Stupa.', 'category' => 'Nature', 'interests' => ['Nature', 'Spirituality', 'Photography'], 'duration_hours' => 3.5, 'estimated_cost_npr' => 1400, 'difficulty' => 'easy', 'best_time_of_day' => 'afternoon', 'location' => 'Phewa Lake / Anadu Hill', 'transportation_info' => 'Wooden boat from Lakeside Ghat'],
                    ['name' => 'Certified Tandem Paragliding Flight', 'description' => 'Soar above Pokhara valley alongside Himalayan thermal currents with a licensed pilot.', 'category' => 'Adventure', 'interests' => ['Adventure', 'Photography'], 'duration_hours' => 2.0, 'estimated_cost_npr' => 9500, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Sarangkot Launch', 'transportation_info' => 'Operator 4x4 shuttle included'],
                    ['name' => 'Begnas Lake Quiet Canoe & Local Fish Lunch', 'description' => 'Escape crowds at tranquil Begnas Lake surrounded by terraced hillsides.', 'category' => 'Relaxation', 'interests' => ['Relaxation', 'Food', 'Nature'], 'duration_hours' => 4.0, 'estimated_cost_npr' => 2600, 'difficulty' => 'easy', 'best_time_of_day' => 'afternoon', 'location' => 'Begnas Lake', 'transportation_info' => '40 min drive east of Pokhara'],
                    ['name' => 'International Mountain Museum Visit', 'description' => 'Learn Himalayan mountaineering history, Sherpa heritage, and alpine ecology.', 'category' => 'Culture', 'interests' => ['History', 'Culture'], 'duration_hours' => 2.0, 'estimated_cost_npr' => 900, 'difficulty' => 'easy', 'best_time_of_day' => 'afternoon', 'location' => 'Rato Pairo, Pokhara', 'transportation_info' => '15 min taxi'],
                ],
            ],
            [
                'name' => 'Chitwan',
                'slug' => 'chitwan',
                'region' => 'Bagmati / Terai',
                'location' => 'Chitwan District, Southern Terai',
                'short_description' => 'Lush subtropical UNESCO wildlife sanctuary home to greater one-horned rhinos, gharials, Bengal tigers, and Tharu heritage.',
                'description' => 'Chitwan National Park protects floodplains, sal forests, and oxbow lakes along the Rapti River. Experience ethical jeep safaris, dugout canoe rides at dawn, and warm cultural hospitality in Tharu villages.',
                'hero_image' => 'https://images.unsplash.com/photo-1547970810-dc1eac37d174?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1547970810-dc1eac37d174?auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1000&q=80',
                ],
                'difficulty' => 'easy',
                'estimated_duration_days' => 3,
                'estimated_budget_npr' => 22000,
                'best_time_to_visit' => 'October – March',
                'altitude_max_m' => 250,
                'interests' => ['Wildlife', 'Nature', 'Photography', 'Culture', 'Relaxation'],
                'attractions' => ['Chitwan National Park', 'Rapti River Canoeing', 'Gharial Breeding Center', 'Tharu Cultural Village', 'Bis Hajar Tal'],
                'travel_info' => '20-minute flight to Bharatpur or 5-hour scenic highway drive from Kathmandu/Pokhara.',
                'latitude' => 27.5291,
                'longitude' => 84.3542,
                'is_featured' => true,
                'rating_avg' => 4.75,
                'reviews_count' => 1,
                'safety' => [
                    'risk_level' => 'moderate',
                    'safety_description' => 'Wildlife encounters require strict adherence to licensed naturalist instructions. Never enter buffer-zone forest trails alone.',
                    'risk_factors' => ['Wild rhinoceros and sloth bear proximity', 'Summer heat and humidity', 'Mosquito-borne illness during monsoon'],
                    'recommended_preparation' => ['Wear neutral-colored breathable clothing', 'Carry insect repellent and sun protection', 'Always stay with a licensed park naturalist'],
                    'seasonal_warnings' => 'Park jeep tracks may close July–September during peak monsoon river flooding.',
                    'altitude_awareness' => 'Subtropical lowlands (200m); stay hydrated in warm weather.',
                    'emergency_info' => 'Chitwan Medical College (Bharatpur) and Sauraha Police Post are accessible within 30 minutes.',
                    'weather_demo_data' => ['temp_c' => 28, 'condition' => 'Warm & Humid', 'wind_kph' => 7, 'precipitation_pct' => 20, 'warning' => null],
                ],
                'activities' => [
                    ['name' => 'Rapti River Dawn Dugout Canoe & Birding', 'description' => 'Glide silently past marsh mugger crocodiles, gharials, and kingfishers at sunrise.', 'category' => 'Wildlife', 'interests' => ['Wildlife', 'Nature', 'Photography'], 'duration_hours' => 2.5, 'estimated_cost_npr' => 2500, 'difficulty' => 'easy', 'best_time_of_day' => 'morning', 'location' => 'Rapti River', 'transportation_info' => '10 min walk from Sauraha'],
                    ['name' => 'Guided National Park Jeep Safari', 'description' => 'Venture deep into grassland corridors to responsibly spot one-horned rhinos and deer.', 'category' => 'Wildlife', 'interests' => ['Wildlife', 'Adventure', 'Photography'], 'duration_hours' => 4.0, 'estimated_cost_npr' => 5500, 'difficulty' => 'easy', 'best_time_of_day' => 'afternoon', 'location' => 'Chitwan Core Zone', 'transportation_info' => 'Open-top 4x4 safari jeep'],
                    ['name' => 'Tharu Village Walk & Cultural Evening', 'description' => 'Visit traditional mud-plastered homes and enjoy indigenous stick dance performances.', 'category' => 'Culture', 'interests' => ['Culture', 'History', 'Food'], 'duration_hours' => 2.5, 'estimated_cost_npr' => 1200, 'difficulty' => 'easy', 'best_time_of_day' => 'evening', 'location' => 'Bachhauli Village', 'transportation_info' => 'Bicycle or short walk'],
                    ['name' => 'Bis Hajar Tal Wetlands Cycling', 'description' => 'Cycle along quiet countryside lanes to the Ramsar-listed Twenty Thousand Lakes wetland.', 'category' => 'Nature', 'interests' => ['Nature', 'Wildlife', 'Relaxation'], 'duration_hours' => 3.0, 'estimated_cost_npr' => 1600, 'difficulty' => 'easy', 'best_time_of_day' => 'morning', 'location' => 'Tikauli Buffer Zone', 'transportation_info' => 'Rental mountain bike'],
                ],
            ],
            [
                'name' => 'Annapurna',
                'slug' => 'annapurna',
                'region' => 'Gandaki',
                'location' => 'Annapurna Conservation Area, Gandaki',
                'short_description' => 'Iconic Himalayan trekking sanctuary spanning rhododendron forests, Gurung stone villages, and glacial amphitheaters.',
                'description' => 'The Annapurna region offers Nepal’s greatest diversity of mountain trails—from the accessible Ghorepani Poon Hill ridge to the dramatic Annapurna Base Camp sanctuary at 4,130m.',
                'hero_image' => 'https://images.unsplash.com/photo-1585016495481-91613a3ab1bc?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1585016495481-91613a3ab1bc?auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1000&q=80',
                ],
                'difficulty' => 'moderate',
                'estimated_duration_days' => 7,
                'estimated_budget_npr' => 45000,
                'best_time_to_visit' => 'March – May, October – November',
                'altitude_max_m' => 4130,
                'interests' => ['Trekking', 'Adventure', 'Nature', 'Photography', 'Culture'],
                'attractions' => ['Annapurna Base Camp', 'Poon Hill Viewpoint', 'Ghandruk Village', 'Jhinu Danda Hot Springs', 'Mardi Himal Ridge'],
                'travel_info' => 'Requires ACAP permit and TIMS card; trailheads start 1.5–3 hours by jeep from Pokhara.',
                'latitude' => 28.5304,
                'longitude' => 83.8780,
                'is_featured' => true,
                'rating_avg' => 4.9,
                'reviews_count' => 2,
                'safety' => [
                    'risk_level' => 'moderate',
                    'safety_description' => 'Well-established teahouse trails, but rapid elevation gain above 3,000m and winter avalanche zones between Deurali and MBC require a licensed guide and weather checks.',
                    'risk_factors' => ['Acute Mountain Sickness (AMS) above 3,000m', 'Winter avalanche corridors near Deurali', 'Steep stone staircases'],
                    'recommended_preparation' => ['Ascend gradually and hydrate well', 'Pack layered thermal clothing and rain shell', 'Register ACAP permit and carry travel insurance covering 4,500m+'],
                    'seasonal_warnings' => 'Heavy snowfall January–February can temporarily close the Annapurna Sanctuary trail.',
                    'altitude_awareness' => 'Monitor headache, nausea, or dizziness above 3,200m; descend immediately if symptoms worsen.',
                    'emergency_info' => 'HRA Clinic at Manang/Chhomrong and helicopter evacuation pads available in Chhomrong and ABC.',
                    'weather_demo_data' => ['temp_c' => 8, 'condition' => 'Crisp Mountain Breeze', 'wind_kph' => 18, 'precipitation_pct' => 25, 'warning' => 'Sub-zero nights above 3,500m'],
                ],
                'activities' => [
                    ['name' => 'Ghandruk Heritage Stone Village Trek', 'description' => 'Walk through terraced fields to the iconic Gurung village with Annapurna South views.', 'category' => 'Trekking', 'interests' => ['Trekking', 'Culture', 'Photography'], 'duration_hours' => 4.5, 'estimated_cost_npr' => 3200, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Ghandruk', 'transportation_info' => 'Jeep from Pokhara to Nayapul + trek'],
                    ['name' => 'Poon Hill 3,210m Golden Sunrise', 'description' => 'Early morning ascent to a 360-degree panorama of Dhaulagiri and Annapurna ranges.', 'category' => 'Trekking', 'interests' => ['Trekking', 'Photography', 'Nature'], 'duration_hours' => 3.0, 'estimated_cost_npr' => 2000, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Ghorepani', 'transportation_info' => 'On foot from Ghorepani lodge'],
                    ['name' => 'Jhinu Danda Natural Hot Springs Soak', 'description' => 'Relax tired trekking muscles in riverside geothermal pools beside the Modi Khola.', 'category' => 'Relaxation', 'interests' => ['Relaxation', 'Nature'], 'duration_hours' => 2.5, 'estimated_cost_npr' => 1200, 'difficulty' => 'easy', 'best_time_of_day' => 'afternoon', 'location' => 'Jhinu Danda', 'transportation_info' => '20 min downhill walk from village'],
                    ['name' => 'Rhododendron Forest Ridge Walk to Tadapani', 'description' => 'Trek beneath mossy oak and blooming rhododendron canopies with langur sightings.', 'category' => 'Nature', 'interests' => ['Nature', 'Trekking', 'Wildlife'], 'duration_hours' => 5.0, 'estimated_cost_npr' => 2800, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Tadapani Trail', 'transportation_info' => 'Foot trail'],
                ],
            ],
            [
                'name' => 'Everest Region',
                'slug' => 'everest-region',
                'region' => 'Koshi / Khumbu',
                'location' => 'Sagarmatha National Park, Solukhumbu',
                'short_description' => 'The roof of the world—suspension bridges, Sherpa monasteries, turquoise Gokyo lakes, and the trail to Everest Base Camp.',
                'description' => 'Home to Mount Everest (Sagarmatha, 8,848.86m), the Khumbu valley pairs awe-inspiring glaciated peaks with deeply rooted Sherpa Buddhist culture in Namche Bazaar and Tengboche Monastery.',
                'hero_image' => 'https://images.unsplash.com/photo-1516302752625-fcc3c50ae61f?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1516302752625-fcc3c50ae61f?auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1486911278844-a81c5267e227?auto=format&fit=crop&w=1000&q=80',
                ],
                'difficulty' => 'challenging',
                'estimated_duration_days' => 12,
                'estimated_budget_npr' => 95000,
                'best_time_to_visit' => 'March – May, October – November',
                'altitude_max_m' => 5545,
                'interests' => ['Trekking', 'Adventure', 'Photography', 'Spirituality', 'Nature'],
                'attractions' => ['Namche Bazaar', 'Tengboche Monastery', 'Kala Patthar', 'Everest Base Camp', 'Gokyo Lakes'],
                'travel_info' => 'Fly into Lukla (Tenzing-Hillary Airport) from Ramechhap/Kathmandu or trek via Salleri/Phaplu.',
                'latitude' => 27.8069,
                'longitude' => 86.7140,
                'is_featured' => true,
                'rating_avg' => 4.95,
                'reviews_count' => 2,
                'safety' => [
                    'risk_level' => 'high',
                    'safety_description' => 'High-altitude Himalayan environment exceeding 5,300m. Strict acclimatization schedules, experienced guides, and comprehensive evacuation insurance are essential.',
                    'risk_factors' => ['Severe altitude sickness (AMS/HAPE/HACE)', 'Lukla mountain weather flight delays', 'Extreme cold temperatures and UV exposure'],
                    'recommended_preparation' => ['Schedule mandatory rest days at Namche (3,440m) and Dingboche (4,410m)', 'Verify helicopter rescue insurance up to 6,000m', 'Carry pulse oximeter, down jacket, and water purification'],
                    'seasonal_warnings' => 'Winter temperatures drop below -20°C at Gorakshep; monsoon causes frequent Lukla flight cancellations.',
                    'altitude_awareness' => 'Never ascend with worsening headache, ataxia, or shortness of breath at rest. Descend promptly.',
                    'emergency_info' => 'Himalayan Rescue Association (HRA) Aid Post in Pheriche and Khunde Hospital serve the Khumbu valley.',
                    'weather_demo_data' => ['temp_c' => -2, 'condition' => 'Clear High-Altitude Sky', 'wind_kph' => 26, 'precipitation_pct' => 10, 'warning' => 'High-altitude frost & windchill advisory'],
                ],
                'activities' => [
                    ['name' => 'Namche Bazaar Acclimatization Hike to Everest View', 'description' => 'Climb gently to 3,880m for first sweeping views of Everest, Lhotse, and Ama Dablam.', 'category' => 'Trekking', 'interests' => ['Trekking', 'Photography', 'Adventure'], 'duration_hours' => 4.0, 'estimated_cost_npr' => 3500, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Syangboche / Khumjung', 'transportation_info' => 'Foot trail from Namche'],
                    ['name' => 'Tengboche Monastery Blessing & Ridge Walk', 'description' => 'Visit the spiritual heart of Khumbu surrounded by towering snow walls.', 'category' => 'Spirituality', 'interests' => ['Spirituality', 'Culture', 'Trekking'], 'duration_hours' => 5.0, 'estimated_cost_npr' => 4200, 'difficulty' => 'challenging', 'best_time_of_day' => 'morning', 'location' => 'Tengboche (3,867m)', 'transportation_info' => 'Trekking trail'],
                    ['name' => 'Kala Patthar Sunrise Panorama', 'description' => 'Ascend to 5,545m for the closest unobstructed view of Mount Everest’s summit pyramid.', 'category' => 'Adventure', 'interests' => ['Adventure', 'Photography', 'Trekking'], 'duration_hours' => 4.5, 'estimated_cost_npr' => 4800, 'difficulty' => 'challenging', 'best_time_of_day' => 'morning', 'location' => 'Gorakshep', 'transportation_info' => 'Guided foot ascent'],
                    ['name' => 'Sherpa Culture Museum & Khumjung Bakery', 'description' => 'Explore mountaineering heritage exhibits and visit the historic Hillary School.', 'category' => 'Culture', 'interests' => ['Culture', 'History', 'Food'], 'duration_hours' => 2.5, 'estimated_cost_npr' => 1800, 'difficulty' => 'easy', 'best_time_of_day' => 'afternoon', 'location' => 'Namche / Khumjung', 'transportation_info' => 'Walking trail'],
                ],
            ],
            [
                'name' => 'Mustang',
                'slug' => 'mustang',
                'region' => 'Gandaki',
                'location' => 'Mustang District, Trans-Himalaya',
                'short_description' => 'Dramatic rain-shadow desert canyons, ancient Tibetan sky caves, apple orchards, and the walled kingdom of Lo Manthang.',
                'description' => 'Lying north of the Annapurna and Dhaulagiri giants, Mustang reveals an arid trans-Himalayan landscape of ochre cliffs, medieval gompas, and enduring Tibetan Buddhist traditions.',
                'hero_image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1589308078059-be1415eab4c3?auto=format&fit=crop&w=1000&q=80',
                ],
                'difficulty' => 'moderate',
                'estimated_duration_days' => 6,
                'estimated_budget_npr' => 58000,
                'best_time_to_visit' => 'April – November (great even in monsoon)',
                'altitude_max_m' => 3840,
                'interests' => ['Culture', 'History', 'Adventure', 'Photography', 'Spirituality'],
                'attractions' => ['Lo Manthang Walled City', 'Muktinath Temple', 'Marpha Apple Village', 'Chhoser Sky Caves', 'Kagbeni'],
                'travel_info' => 'Accessible by 4x4 jeep or Pokhara–Jomsom flight. Upper Mustang requires a Restricted Area Permit.',
                'latitude' => 28.9985,
                'longitude' => 83.8473,
                'is_featured' => true,
                'rating_avg' => 4.85,
                'reviews_count' => 1,
                'safety' => [
                    'risk_level' => 'moderate',
                    'safety_description' => 'High desert winds start after midday, and road sections along the Kali Gandaki gorge can experience rockfalls during heavy rain.',
                    'risk_factors' => ['Strong afternoon valley winds', 'High-altitude dryness and dehydration', 'Mountain road landslides in Lower Mustang'],
                    'recommended_preparation' => ['Travel early in the morning before winds peak', 'Carry windproof shell, sunglasses, and lip/skin hydration', 'Ensure Upper Mustang Restricted Permit if going north of Kagbeni'],
                    'seasonal_warnings' => 'Heavy winter snow closes high passes December–February.',
                    'altitude_awareness' => 'Jomsom (2,743m) to Muktinath/Lo Manthang (3,800m+): pace ascent over 2 days.',
                    'emergency_info' => 'Mustang District Hospital in Jomsom and police checkposts at Kagbeni and Lo Manthang.',
                    'weather_demo_data' => ['temp_c' => 12, 'condition' => 'Sunny & Breezy', 'wind_kph' => 29, 'precipitation_pct' => 5, 'warning' => 'Strong afternoon gusts expected'],
                ],
                'activities' => [
                    ['name' => 'Marpha Whitewashed Village & Apple Orchard Tasting', 'description' => 'Stroll stone-flagged alleys and taste locally pressed apple cider and dried fruit.', 'category' => 'Culture', 'interests' => ['Culture', 'Food', 'Photography'], 'duration_hours' => 2.5, 'estimated_cost_npr' => 1800, 'difficulty' => 'easy', 'best_time_of_day' => 'morning', 'location' => 'Marpha', 'transportation_info' => '20 min drive from Jomsom'],
                    ['name' => 'Kagbeni Medieval Monastery & Kali Gandaki Walk', 'description' => 'Explore the gateway fortress village to Upper Mustang and fossil-rich riverbeds.', 'category' => 'History', 'interests' => ['History', 'Spirituality', 'Photography'], 'duration_hours' => 3.0, 'estimated_cost_npr' => 2200, 'difficulty' => 'easy', 'best_time_of_day' => 'morning', 'location' => 'Kagbeni', 'transportation_info' => '45 min 4x4 drive from Jomsom'],
                    ['name' => 'Muktinath Sacred 108 Spouts Pilgrimage', 'description' => 'Visit the revered Hindu and Buddhist shrine framed by snow-dusted Nilgiri peaks.', 'category' => 'Spirituality', 'interests' => ['Spirituality', 'Culture'], 'duration_hours' => 3.5, 'estimated_cost_npr' => 2600, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Muktinath (3,710m)', 'transportation_info' => '1 hr jeep climb from Kagbeni'],
                    ['name' => 'Dhumba Lake & Thini Village Hike', 'description' => 'A peaceful half-day hike to a turquoise emerald lake sacred to local Thakali communities.', 'category' => 'Nature', 'interests' => ['Nature', 'Relaxation', 'Trekking'], 'duration_hours' => 3.5, 'estimated_cost_npr' => 1500, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Thini, Jomsom', 'transportation_info' => 'Foot trail from Jomsom'],
                ],
            ],
            [
                'name' => 'Langtang',
                'slug' => 'langtang',
                'region' => 'Bagmati',
                'location' => 'Rasuwa District, Langtang National Park',
                'short_description' => 'The closest Himalayan glacial valley to Kathmandu, combining Tamang mountain heritage, yak pastures, and sacred Gosaikunda lakes.',
                'description' => 'Just north of Kathmandu, Langtang National Park offers uncrowded alpine trekking through bamboo forests, red panda habitats, and the rebuilt stone lodges of Kyanjin Gompa.',
                'hero_image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1000&q=80',
                ],
                'difficulty' => 'moderate',
                'estimated_duration_days' => 7,
                'estimated_budget_npr' => 38000,
                'best_time_to_visit' => 'March – May, October – December',
                'altitude_max_m' => 4984,
                'interests' => ['Trekking', 'Nature', 'Wildlife', 'Culture', 'Spirituality'],
                'attractions' => ['Kyanjin Gompa', 'Kyanjin Ri Viewpoint', 'Gosaikunda Alpine Lakes', 'Langtang Cheese Factory', 'Tamang Heritage Trail'],
                'travel_info' => '6–7 hour jeep or bus drive north from Kathmandu to Syabrubesi trailhead.',
                'latitude' => 28.2139,
                'longitude' => 85.5500,
                'is_featured' => false,
                'rating_avg' => 4.8,
                'reviews_count' => 1,
                'safety' => [
                    'risk_level' => 'moderate',
                    'safety_description' => 'Moderate trekking difficulty with high viewpoints above 4,700m. The Pasang Lhamu highway to Syabrubesi can be narrow during monsoon.',
                    'risk_factors' => ['Rapid climb from Lama Hotel to Kyanjin Gompa', 'Monsoon road mudslides near Dhunche'],
                    'recommended_preparation' => ['Hire a licensed local Tamang guide', 'Check highway status during rainy season', 'Acclimatize overnight at Langtang Village before Kyanjin Ri'],
                    'seasonal_warnings' => 'Gosaikunda pass freezes over during peak winter months.',
                    'altitude_awareness' => 'Kyanjin Gompa sits at 3,870m; hydrate and pace climbs to Kyanjin Ri (4,773m).',
                    'emergency_info' => 'Nepal Army park checkpoints along trail and Rasuwa District Hospital in Dhunche.',
                    'weather_demo_data' => ['temp_c' => 6, 'condition' => 'Partly Cloudy', 'wind_kph' => 15, 'precipitation_pct' => 20, 'warning' => null],
                ],
                'activities' => [
                    ['name' => 'Kyanjin Gompa & Yak Cheese Factory Visit', 'description' => 'Tour the historic monastery and sample artisanal Himalayan yak cheese.', 'category' => 'Culture', 'interests' => ['Culture', 'Food', 'Spirituality'], 'duration_hours' => 2.5, 'estimated_cost_npr' => 1400, 'difficulty' => 'easy', 'best_time_of_day' => 'afternoon', 'location' => 'Kyanjin Gompa', 'transportation_info' => 'On foot'],
                    ['name' => 'Kyanjin Ri Glacier Viewpoint Climb', 'description' => 'Hike to 4,773m for dramatic close-ups of Langtang Lirung icefalls.', 'category' => 'Trekking', 'interests' => ['Trekking', 'Adventure', 'Photography'], 'duration_hours' => 5.0, 'estimated_cost_npr' => 2500, 'difficulty' => 'challenging', 'best_time_of_day' => 'morning', 'location' => 'Kyanjin Ri', 'transportation_info' => 'Foot ascent'],
                    ['name' => 'Tamang Heritage Village Homestay Walk', 'description' => 'Experience warm Tamang hospitality, hot springs at Tatopani, and woven crafts.', 'category' => 'Culture', 'interests' => ['Culture', 'Relaxation', 'Nature'], 'duration_hours' => 4.0, 'estimated_cost_npr' => 2200, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Gatlang / Briddim', 'transportation_info' => 'Foot trail'],
                    ['name' => 'Bamboo Forest Red Panda Habitat Walk', 'description' => 'Quiet guided nature walk through mossy oak and bamboo zones.', 'category' => 'Wildlife', 'interests' => ['Wildlife', 'Nature'], 'duration_hours' => 3.5, 'estimated_cost_npr' => 2000, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Lama Hotel Trail', 'transportation_info' => 'Foot trail'],
                ],
            ],
            [
                'name' => 'Lumbini',
                'slug' => 'lumbini',
                'region' => 'Lumbini',
                'location' => 'Rupandehi District, Lumbini Province',
                'short_description' => 'The serene UNESCO World Heritage birthplace of Siddhartha Gautama (Lord Buddha), surrounded by international monasteries and gardens.',
                'description' => 'Lumbini invites quiet reflection amid the Sacred Garden, Maya Devi Temple, the Ashoka Pillar, and dozens of architectural monasteries built by Buddhist nations worldwide.',
                'hero_image' => 'https://images.unsplash.com/photo-1582650625119-3a31f8fa2699?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1582650625119-3a31f8fa2699?auto=format&fit=crop&w=1000&q=80',
                ],
                'difficulty' => 'easy',
                'estimated_duration_days' => 2,
                'estimated_budget_npr' => 14000,
                'best_time_to_visit' => 'October – March',
                'altitude_max_m' => 150,
                'interests' => ['Spirituality', 'History', 'Culture', 'Relaxation', 'Photography'],
                'attractions' => ['Maya Devi Temple', 'Ashoka Pillar', 'World Peace Pagoda', 'Monastic Zone Canal', 'Lumbini Crane Sanctuary'],
                'travel_info' => '35-minute flight to Gautam Buddha International Airport (Bhairahawa), 25 minutes from Sacred Garden.',
                'latitude' => 27.4833,
                'longitude' => 83.2767,
                'is_featured' => false,
                'rating_avg' => 4.8,
                'reviews_count' => 1,
                'safety' => [
                    'risk_level' => 'low',
                    'safety_description' => 'Peaceful, flat pilgrimage zone ideal for all ages. Main consideration is intense summer heat between April and June.',
                    'risk_factors' => ['High summer temperatures (38°C+)', 'Winter morning fog affecting domestic flights'],
                    'recommended_preparation' => ['Visit temples early morning or late afternoon', 'Carry water, hat, and respectful modest attire'],
                    'seasonal_warnings' => 'December–January morning fog can delay Bhairahawa flights.',
                    'altitude_awareness' => 'Flat Terai plains (150m); no altitude risk.',
                    'emergency_info' => 'Lumbini Tourist Police inside the Master Plan area and Universal Medical College in Bhairahawa.',
                    'weather_demo_data' => ['temp_c' => 27, 'condition' => 'Warm & Clear', 'wind_kph' => 6, 'precipitation_pct' => 5, 'warning' => null],
                ],
                'activities' => [
                    ['name' => 'Maya Devi Temple & Sacred Garden Dawn Walk', 'description' => 'Explore the archaeological birthplace marker, Puskarini pond, and 249 BCE Ashoka Pillar.', 'category' => 'Spirituality', 'interests' => ['Spirituality', 'History', 'Culture'], 'duration_hours' => 2.5, 'estimated_cost_npr' => 1000, 'difficulty' => 'easy', 'best_time_of_day' => 'morning', 'location' => 'Sacred Garden', 'transportation_info' => 'Electric rickshaw or walk'],
                    ['name' => 'International Monastic Zone Bicycle Tour', 'description' => 'Cycle past serene Thai, Myanmar, German, and Tibetan monasteries along the central canal.', 'category' => 'Culture', 'interests' => ['Culture', 'Photography', 'Relaxation'], 'duration_hours' => 3.5, 'estimated_cost_npr' => 1200, 'difficulty' => 'easy', 'best_time_of_day' => 'afternoon', 'location' => 'East & West Monastic Zones', 'transportation_info' => 'Bicycle rental'],
                    ['name' => 'Guided Mindfulness Session & Crane Sanctuary', 'description' => 'Combine quiet meditation with spotting rare Sarus cranes in the restored wetlands.', 'category' => 'Relaxation', 'interests' => ['Spirituality', 'Wildlife', 'Relaxation'], 'duration_hours' => 2.5, 'estimated_cost_npr' => 1500, 'difficulty' => 'easy', 'best_time_of_day' => 'morning', 'location' => 'Lumbini Crane Sanctuary', 'transportation_info' => 'Short tuk-tuk ride'],
                ],
            ],
            [
                'name' => 'Rara Lake',
                'slug' => 'rara-lake',
                'region' => 'Karnali',
                'location' => 'Mugu District, Karnali Province',
                'short_description' => 'Nepal’s largest alpine lake—an untouched sapphire jewel mirrored by pine forests and snow-dusted western peaks.',
                'description' => 'Hidden in remote northwestern Nepal, Rara National Park rewards adventurous travelers with crystal-clear water that shifts color with the sky, tranquil wooden trails, and starry mountain nights.',
                'hero_image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1000&q=80',
                ],
                'difficulty' => 'moderate',
                'estimated_duration_days' => 6,
                'estimated_budget_npr' => 52000,
                'best_time_to_visit' => 'April – May, September – October',
                'altitude_max_m' => 3635,
                'interests' => ['Nature', 'Photography', 'Relaxation', 'Adventure', 'Wildlife'],
                'attractions' => ['Rara Lake Shoreline', 'Murma Top Viewpoint', 'Chuchemara Ridge', 'Rara National Park'],
                'travel_info' => 'Fly Kathmandu–Nepalgunj–Talcha (weather-dependent) or take an overland 4x4 journey along the Karnali Highway.',
                'latitude' => 29.5290,
                'longitude' => 82.0890,
                'is_featured' => false,
                'rating_avg' => 4.9,
                'reviews_count' => 1,
                'safety' => [
                    'risk_level' => 'moderate',
                    'safety_description' => 'Remote region with limited medical clinics and variable mountain flight schedules. Build buffer days into your itinerary.',
                    'risk_factors' => ['Remote healthcare access', 'Weather-dependent Talcha flights', 'Limited ATM and cellular coverage'],
                    'recommended_preparation' => ['Carry sufficient cash in NPR and basic personal medication', 'Keep 1–2 buffer days for flight delays', 'Pack warm fleece even in spring/autumn'],
                    'seasonal_warnings' => 'Heavy snow can block trails and road access December–February.',
                    'altitude_awareness' => 'Lake sits at 2,990m; mild breathlessness possible when climbing Murma Top (3,635m).',
                    'emergency_info' => 'Nepal Army park headquarters at Hutu and Mugu District Hospital in Gamgadhi.',
                    'weather_demo_data' => ['temp_c' => 11, 'condition' => 'Crisp & Clear', 'wind_kph' => 14, 'precipitation_pct' => 10, 'warning' => 'Remote region — check flight status daily'],
                ],
                'activities' => [
                    ['name' => 'Rara Lake Full Shoreline Nature Circuit', 'description' => 'Walk the peaceful 14km forest trail encircling Nepal’s deepest alpine lake.', 'category' => 'Nature', 'interests' => ['Nature', 'Photography', 'Trekking'], 'duration_hours' => 4.5, 'estimated_cost_npr' => 1800, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Rara Rim Trail', 'transportation_info' => 'Foot trail'],
                    ['name' => 'Murma Top 3,635m Panorama Hike', 'description' => 'Climb above the lake for an unforgettable aerial view of Rara and Saipal peaks.', 'category' => 'Trekking', 'interests' => ['Trekking', 'Photography', 'Adventure'], 'duration_hours' => 4.0, 'estimated_cost_npr' => 2200, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Murma Village', 'transportation_info' => 'Foot trail from lakeside'],
                    ['name' => 'Lakeside Wooden Boating & Sunset Reflection', 'description' => 'Glide across mirror-still waters accompanied by park boatmen.', 'category' => 'Relaxation', 'interests' => ['Relaxation', 'Nature', 'Photography'], 'duration_hours' => 2.0, 'estimated_cost_npr' => 1500, 'difficulty' => 'easy', 'best_time_of_day' => 'afternoon', 'location' => 'Rara Lake', 'transportation_info' => 'Park boat station'],
                ],
            ],
            [
                'name' => 'Manaslu',
                'slug' => 'manaslu',
                'region' => 'Gandaki',
                'location' => 'Gorkha District, Manaslu Conservation Area',
                'short_description' => 'A raw, authentic Himalayan circuit around the world’s eighth-highest peak, crossing dramatic Larkya La Pass at 5,106m.',
                'description' => 'The Manaslu Circuit preserves old-world Himalayan trekking—suspension bridges over roaring Budhi Gandaki gorges, Tibetan-influenced Nubri villages, and glaciated high passes.',
                'hero_image' => 'https://images.unsplash.com/photo-1486911278844-a81c5267e227?auto=format&fit=crop&w=1400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1486911278844-a81c5267e227?auto=format&fit=crop&w=1000&q=80',
                ],
                'difficulty' => 'challenging',
                'estimated_duration_days' => 14,
                'estimated_budget_npr' => 98000,
                'best_time_to_visit' => 'March – May, September – November',
                'altitude_max_m' => 5106,
                'interests' => ['Trekking', 'Adventure', 'Nature', 'Culture', 'Spirituality'],
                'attractions' => ['Larkya La Pass (5,106m)', 'Samagaun Village', 'Birendra Lake', 'Pungyen Gompa', 'Manaslu Base Camp'],
                'travel_info' => 'Restricted Area Permit required (minimum 2 trekkers with a licensed guide). 7–8 hour jeep from Kathmandu to Machha Khola.',
                'latitude' => 28.5497,
                'longitude' => 84.5597,
                'is_featured' => false,
                'rating_avg' => 4.9,
                'reviews_count' => 1,
                'safety' => [
                    'risk_level' => 'high',
                    'safety_description' => 'Remote high-altitude restricted circuit crossing Larkya La (5,106m). Requires mandatory licensed guide, acclimatization days, and microspikes in shoulder seasons.',
                    'risk_factors' => ['High altitude crossing at 5,106m', 'Icy pass descents and cold winds', 'Limited mobile signal in upper gorges'],
                    'recommended_preparation' => ['Acclimatize 2 nights at Samagaun (3,530m)', 'Carry crampons/microspikes and thermal layers', 'Use a registered agency for Restricted Area Permits'],
                    'seasonal_warnings' => 'Larkya La can be impassable during heavy winter snow (Dec–Feb).',
                    'altitude_awareness' => 'High AMS risk above 3,800m; monitor oxygen saturation and never rush the pass.',
                    'emergency_info' => 'Samagaun health post and helicopter evacuation pad available for weather-permitting rescue.',
                    'weather_demo_data' => ['temp_c' => 1, 'condition' => 'Cold Alpine Wind', 'wind_kph' => 24, 'precipitation_pct' => 15, 'warning' => 'High pass snow/ice caution'],
                ],
                'activities' => [
                    ['name' => 'Birendra Glacial Lake & Manaslu Base Camp Acclimatization', 'description' => 'Hike from Samagaun past turquoise glacial waters beneath Manaslu’s ice walls.', 'category' => 'Trekking', 'interests' => ['Trekking', 'Nature', 'Photography'], 'duration_hours' => 5.5, 'estimated_cost_npr' => 3000, 'difficulty' => 'challenging', 'best_time_of_day' => 'morning', 'location' => 'Samagaun', 'transportation_info' => 'Foot trail'],
                    ['name' => 'Pungyen Gompa Monastery Valley Walk', 'description' => 'Visit a secluded century-old gompa set in a serene alpine meadow.', 'category' => 'Spirituality', 'interests' => ['Spirituality', 'Culture', 'Trekking'], 'duration_hours' => 4.0, 'estimated_cost_npr' => 2200, 'difficulty' => 'moderate', 'best_time_of_day' => 'morning', 'location' => 'Shyala / Samagaun', 'transportation_info' => 'Foot trail'],
                    ['name' => 'Larkya La Pass (5,106m) Dawn Crossing', 'description' => 'Cross the iconic prayer-flag pass framed by Himlung and Cheo Himal.', 'category' => 'Adventure', 'interests' => ['Adventure', 'Trekking'], 'duration_hours' => 7.5, 'estimated_cost_npr' => 4500, 'difficulty' => 'challenging', 'best_time_of_day' => 'morning', 'location' => 'Dharamsala to Bimthang', 'transportation_info' => 'Guided high-pass trek'],
                ],
            ],
        ];

        $destinations = [];
        foreach ($destinationsData as $d) {
            $safety = $d['safety'];
            $activities = $d['activities'];
            unset($d['safety'], $d['activities']);

            $destination = Destination::updateOrCreate(['slug' => $d['slug']], $d);
            $destinations[$d['slug']] = $destination;

            SafetyInformation::updateOrCreate(
                ['destination_id' => $destination->id],
                array_merge($safety, [
                    'is_demo_data' => true,
                    'last_updated_at' => now()->subDays(2),
                ])
            );

            foreach ($activities as $act) {
                DestinationActivity::updateOrCreate(
                    ['destination_id' => $destination->id, 'name' => $act['name']],
                    $act
                );
            }
        }

        $packagesData = [
            [
                'agency_id' => $agencies['himalayan-horizon-expeditions']->id,
                'destination_id' => $destinations['everest-region']->id,
                'guide_id' => $guides['tenzing-norbu-sherpa']->id,
                'title' => 'Everest Base Camp & Kala Patthar Safety-First Trek',
                'slug' => 'everest-base-camp-safety-first-trek',
                'short_description' => '12-day guided Khumbu expedition with gradual acclimatization, pulse-oximeter checks, and experienced Sherpa leadership.',
                'description' => 'Experience the iconic journey to Everest Base Camp (5,364m) and Kala Patthar (5,545m) designed around responsible acclimatization. Includes Lukla flights, Sagarmatha permits, cozy teahouses, and daily health monitoring.',
                'hero_image' => 'https://images.unsplash.com/photo-1516302752625-fcc3c50ae61f?auto=format&fit=crop&w=1200&q=80',
                'gallery' => ['https://images.unsplash.com/photo-1516302752625-fcc3c50ae61f?auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1486911278844-a81c5267e227?auto=format&fit=crop&w=1000&q=80'],
                'duration_days' => 12,
                'price_npr' => 115000,
                'difficulty' => 'challenging',
                'package_type' => 'trekking',
                'group_size_max' => 10,
                'availability_status' => 'available',
                'interests' => ['Trekking', 'Adventure', 'Photography', 'Spirituality'],
                'included_services' => ['Domestic Lukla round-trip flights', 'Sagarmatha National Park & Khumbu permits', 'Licensed Sherpa guide & porter support', 'Full-board teahouse meals & accommodation', 'Daily oxygen saturation & safety check-ins'],
                'excluded_services' => ['International flights', 'High-altitude travel insurance', 'Personal trekking gear & hot showers', 'Tips for mountain crew'],
                'accommodation_info' => 'Selected clean mountain teahouses with twin-sharing rooms',
                'transportation_info' => 'Kathmandu/Ramechhap–Lukla flights + airport transfers',
                'itinerary' => [
                    ['day' => 1, 'title' => 'Fly to Lukla & Trek to Phakding', 'details' => 'Scenic mountain flight and gentle river valley walk (2,610m).'],
                    ['day' => 2, 'title' => 'Trek to Namche Bazaar', 'details' => 'Cross Hillary Suspension Bridge and climb to the Sherpa capital (3,440m).'],
                    ['day' => 3, 'title' => 'Acclimatization Day at Namche', 'details' => 'Hike to Hotel Everest View and Khumjung village.'],
                    ['day' => 4, 'title' => 'Namche to Tengboche Monastery', 'details' => 'Ridge walk with Ama Dablam panoramas (3,867m).'],
                    ['day' => 5, 'title' => 'Trek to Dingboche', 'details' => 'Enter the Imja Valley alpine zone (4,410m).'],
                    ['day' => 6, 'title' => 'Acclimatization Hike to Nangkartshang', 'details' => 'Active acclimatization and health check.'],
                    ['day' => 7, 'title' => 'Dingboche to Lobuche', 'details' => 'Pass Thukla Memorial and Khumbu Glacier moraine (4,940m).'],
                    ['day' => 8, 'title' => 'Everest Base Camp (5,364m)', 'details' => 'Reach Base Camp via Gorakshep and return for overnight rest.'],
                    ['day' => 9, 'title' => 'Kala Patthar Sunrise & Descend to Pheriche', 'details' => 'Unmatched Everest sunrise views from 5,545m.'],
                    ['day' => 10, 'title' => 'Descend to Namche Bazaar', 'details' => 'Return through pine forests to Namche.'],
                    ['day' => 11, 'title' => 'Trek to Lukla', 'details' => 'Celebratory final dinner with trekking team.'],
                    ['day' => 12, 'title' => 'Morning Flight back to Kathmandu', 'details' => 'Transfer to hotel and trip debrief.'],
                ],
                'is_published' => true,
                'approval_status' => 'approved',
                'is_featured' => true,
                'rating_avg' => 4.95,
                'reviews_count' => 2,
            ],
            [
                'agency_id' => $agencies['annapurna-trailcraft-tours']->id,
                'destination_id' => $destinations['annapurna']->id,
                'guide_id' => $guides['anjali-gurung']->id,
                'title' => 'Annapurna Sanctuary & Poon Hill Scenic Trek',
                'slug' => 'annapurna-sanctuary-poon-hill-trek',
                'short_description' => '8-day boutique trek from Pokhara combining Poon Hill sunrise, Gurung villages, and Jhinu hot springs.',
                'description' => 'Walk through blooming rhododendron forests and stone-paved mountain villages before entering the amphitheater of Annapurna Base Camp with a certified female-friendly guide team.',
                'hero_image' => 'https://images.unsplash.com/photo-1585016495481-91613a3ab1bc?auto=format&fit=crop&w=1200&q=80',
                'gallery' => ['https://images.unsplash.com/photo-1585016495481-91613a3ab1bc?auto=format&fit=crop&w=1000&q=80'],
                'duration_days' => 8,
                'price_npr' => 54000,
                'difficulty' => 'moderate',
                'package_type' => 'trekking',
                'group_size_max' => 8,
                'availability_status' => 'available',
                'interests' => ['Trekking', 'Nature', 'Photography', 'Culture'],
                'included_services' => ['ACAP & TIMS permits', 'Private jeep transfers from Pokhara', 'Licensed guide & meals on trek', 'Teahouse accommodation'],
                'excluded_services' => ['Pokhara hotel nights', 'Travel insurance', 'Personal drinks & snacks'],
                'accommodation_info' => 'Handpicked family-run mountain lodges',
                'transportation_info' => 'Private 4x4 jeep from Pokhara to trailhead',
                'itinerary' => [
                    ['day' => 1, 'title' => 'Pokhara to Ulleri', 'details' => 'Drive to Nayapul and ascend to Ulleri village.'],
                    ['day' => 2, 'title' => 'Ulleri to Ghorepani', 'details' => 'Walk through oak and rhododendron woods.'],
                    ['day' => 3, 'title' => 'Poon Hill Sunrise & Tadapani', 'details' => 'Golden dawn over Dhaulagiri followed by ridge trek.'],
                    ['day' => 4, 'title' => 'Tadapani to Chhomrong', 'details' => 'Descend to Kimrong Khola and climb to Gurung gateway village.'],
                    ['day' => 5, 'title' => 'Chhomrong to Himalaya', 'details' => 'Enter Modi Khola bamboo valley.'],
                    ['day' => 6, 'title' => 'Annapurna Base Camp (4,130m)', 'details' => 'Reach Machhapuchhre Base Camp and Annapurna Sanctuary.'],
                    ['day' => 7, 'title' => 'Descend to Jhinu Danda Hot Springs', 'details' => 'Soak in natural geothermal pools by the river.'],
                    ['day' => 8, 'title' => 'Return to Pokhara', 'details' => 'Short walk to Siwai and jeep back to Lakeside.'],
                ],
                'is_published' => true,
                'approval_status' => 'approved',
                'is_featured' => true,
                'rating_avg' => 4.9,
                'reviews_count' => 1,
            ],
            [
                'agency_id' => $agencies['annapurna-trailcraft-tours']->id,
                'destination_id' => $destinations['pokhara']->id,
                'guide_id' => $guides['anjali-gurung']->id,
                'title' => 'Pokhara Lakes, Sunrise & Soft Adventure Retreat',
                'slug' => 'pokhara-lakes-sunrise-retreat',
                'short_description' => '4-day restorative escape pairing Sarangkot sunrise, Phewa & Begnas lake boating, and optional paragliding.',
                'description' => 'Ideal for families, couples, and solo travelers seeking mountain beauty without strenuous high-altitude trekking.',
                'hero_image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1200&q=80',
                'gallery' => ['https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1000&q=80'],
                'duration_days' => 4,
                'price_npr' => 26500,
                'difficulty' => 'easy',
                'package_type' => 'leisure',
                'group_size_max' => 12,
                'availability_status' => 'available',
                'interests' => ['Relaxation', 'Nature', 'Photography', 'Food', 'Adventure'],
                'included_services' => ['3 nights boutique Lakeside hotel with breakfast', 'Sarangkot sunrise transfer', 'Phewa Lake boat & Peace Pagoda guided walk', 'Begnas Lake day excursion'],
                'excluded_services' => ['Optional paragliding add-on', 'Lunches & dinners', 'Flights to Pokhara'],
                'accommodation_info' => '4-star eco-boutique Lakeside hotel',
                'transportation_info' => 'Private AC car for all local transfers',
                'itinerary' => [
                    ['day' => 1, 'title' => 'Arrival & Lakeside Sunset Boat', 'details' => 'Check in and enjoy tranquil Phewa Lake rowing.'],
                    ['day' => 2, 'title' => 'Sarangkot Sunrise & Mountain Museum', 'details' => 'Early morning ridge sunrise and cultural exploration.'],
                    ['day' => 3, 'title' => 'Peace Pagoda & Begnas Lake', 'details' => 'Gentle ridge hike and quiet lakeside afternoon.'],
                    ['day' => 4, 'title' => 'Leisure Morning & Departure', 'details' => 'Lakeside coffee and airport/bus transfer.'],
                ],
                'is_published' => true,
                'approval_status' => 'approved',
                'is_featured' => true,
                'rating_avg' => 4.85,
                'reviews_count' => 1,
            ],
            [
                'agency_id' => $agencies['terai-wildlife-heritage-journeys']->id,
                'destination_id' => $destinations['chitwan']->id,
                'guide_id' => $guides['dipendra-tharu']->id,
                'title' => 'Chitwan Ethical Wildlife Safari & Tharu Immersion',
                'slug' => 'chitwan-ethical-wildlife-safari',
                'short_description' => '3-day elephant-free, conservation-first safari with licensed park naturalists, canoeing, and Tharu village dining.',
                'description' => 'Discover Chitwan National Park responsibly through open-jeep safaris, sunrise dugout canoeing on the Rapti River, and authentic community hospitality.',
                'hero_image' => 'https://images.unsplash.com/photo-1547970810-dc1eac37d174?auto=format&fit=crop&w=1200&q=80',
                'gallery' => ['https://images.unsplash.com/photo-1547970810-dc1eac37d174?auto=format&fit=crop&w=1000&q=80'],
                'duration_days' => 3,
                'price_npr' => 24500,
                'difficulty' => 'easy',
                'package_type' => 'wildlife',
                'group_size_max' => 8,
                'availability_status' => 'available',
                'interests' => ['Wildlife', 'Nature', 'Photography', 'Culture'],
                'included_services' => ['2 nights eco-jungle lodge (full board)', 'National park conservation permits', 'Jeep safari & Rapti River canoe', 'Licensed Tharu naturalist guide'],
                'excluded_services' => ['Flights to Bharatpur', 'Bar beverages', 'Personal tips'],
                'accommodation_info' => 'Riverside eco-lodge in Sauraha',
                'transportation_info' => 'Bharatpur airport pickup included',
                'itinerary' => [
                    ['day' => 1, 'title' => 'Arrival & Tharu Cultural Walk', 'details' => 'Riverside sunset and indigenous village visit.'],
                    ['day' => 2, 'title' => 'Dawn Canoe & Core Park Jeep Safari', 'details' => 'Full wildlife tracking day with park naturalist.'],
                    ['day' => 3, 'title' => 'Morning Birding & Departure', 'details' => 'Guided wetland walk before transfer.'],
                ],
                'is_published' => true,
                'approval_status' => 'approved',
                'is_featured' => true,
                'rating_avg' => 4.8,
                'reviews_count' => 1,
            ],
            [
                'agency_id' => $agencies['himalayan-horizon-expeditions']->id,
                'destination_id' => $destinations['kathmandu']->id,
                'guide_id' => $guides['prakash-maharjan']->id,
                'title' => 'Kathmandu Valley Heritage, Artisans & Culinary Trail',
                'slug' => 'kathmandu-valley-heritage-culinary-trail',
                'short_description' => '3-day curated cultural journey through UNESCO squares, Bhaktapur pottery studios, and authentic Newari kitchens.',
                'description' => 'Go beyond surface sightseeing with local historian Prakash Maharjan. Experience living craft traditions, sunrise stupas, and carefully vetted neighborhood kitchens.',
                'hero_image' => 'https://images.unsplash.com/photo-1558799401-1dcba79834c2?auto=format&fit=crop&w=1200&q=80',
                'gallery' => ['https://images.unsplash.com/photo-1558799401-1dcba79834c2?auto=format&fit=crop&w=1000&q=80'],
                'duration_days' => 3,
                'price_npr' => 19500,
                'difficulty' => 'easy',
                'package_type' => 'cultural',
                'group_size_max' => 10,
                'availability_status' => 'available',
                'interests' => ['Culture', 'History', 'Food', 'Spirituality', 'Photography'],
                'included_services' => ['Heritage site entrance fees', 'Licensed historian guide', 'Newari tasting dinner', 'Private valley transport'],
                'excluded_services' => ['Hotel stay (available on request)', 'Personal shopping'],
                'accommodation_info' => 'Optional heritage boutique stay in Patan or Thamel',
                'transportation_info' => 'Private vehicle throughout Kathmandu Valley',
                'itinerary' => [
                    ['day' => 1, 'title' => 'Swayambhunath & Asan Food Walk', 'details' => 'Morning stupa views and evening culinary exploration.'],
                    ['day' => 2, 'title' => 'Patan & Boudhanath Stupa', 'details' => 'Newari bronze workshops and evening monastery kora.'],
                    ['day' => 3, 'title' => 'Bhaktapur Ancient City', 'details' => 'Pottery square hands-on session and farewell lunch.'],
                ],
                'is_published' => true,
                'approval_status' => 'approved',
                'is_featured' => false,
                'rating_avg' => 4.8,
                'reviews_count' => 1,
            ],
            [
                'agency_id' => $agencies['annapurna-trailcraft-tours']->id,
                'destination_id' => $destinations['mustang']->id,
                'guide_id' => $guides['sonam-lama']->id,
                'title' => 'Lower & Upper Mustang Trans-Himalayan Overland',
                'slug' => 'mustang-trans-himalayan-overland',
                'short_description' => '6-day 4x4 and day-hike journey through Marpha, Kagbeni, Muktinath, and ancient red-cliff monasteries.',
                'description' => 'Explore the rain-shadow canyons of Mustang comfortably by private 4x4 Scorpio paired with scenic cultural walks through apple orchards and medieval fortresses.',
                'hero_image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?auto=format&fit=crop&w=1200&q=80',
                'gallery' => ['https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?auto=format&fit=crop&w=1000&q=80'],
                'duration_days' => 6,
                'price_npr' => 64000,
                'difficulty' => 'moderate',
                'package_type' => 'overland',
                'group_size_max' => 6,
                'availability_status' => 'limited',
                'interests' => ['Culture', 'History', 'Adventure', 'Photography', 'Spirituality'],
                'included_services' => ['Private 4x4 jeep from Pokhara', 'ACAP permit & local guide', '5 nights boutique Mustang lodges with breakfast & dinner'],
                'excluded_services' => ['Upper Mustang $500 RAP fee (if extending north of Kagbeni)', 'Lunches & personal expenses'],
                'accommodation_info' => 'Warm stone-built Mustang heritage lodges',
                'transportation_info' => '4x4 mountain SUV with experienced mountain driver',
                'itinerary' => [
                    ['day' => 1, 'title' => 'Pokhara to Tatopani', 'details' => 'Scenic drive along Kali Gandaki gorge and hot springs.'],
                    ['day' => 2, 'title' => 'Tatopani to Marpha & Jomsom', 'details' => 'Apple orchards and Thakali stone architecture.'],
                    ['day' => 3, 'title' => 'Kagbeni & Muktinath', 'details' => 'Medieval fortress village and sacred 108 spouts.'],
                    ['day' => 4, 'title' => 'Dhumba Lake & Thini Hike', 'details' => 'Half-day hike to emerald lake beneath Nilgiri.'],
                    ['day' => 5, 'title' => 'Drive to Kalopani', 'details' => 'Pine forests and close-up Dhaulagiri views.'],
                    ['day' => 6, 'title' => 'Return to Pokhara', 'details' => 'Arrival in Pokhara by late afternoon.'],
                ],
                'is_published' => true,
                'approval_status' => 'approved',
                'is_featured' => false,
                'rating_avg' => 4.85,
                'reviews_count' => 1,
            ],
            [
                'agency_id' => $agencies['terai-wildlife-heritage-journeys']->id,
                'destination_id' => $destinations['lumbini']->id,
                'guide_id' => $guides['bimala-shakya']->id,
                'title' => 'Lumbini Sacred Heritage & Mindfulness Retreat',
                'slug' => 'lumbini-sacred-heritage-retreat',
                'short_description' => '3-day peaceful journey through Maya Devi Temple, international monasteries, and Sarus crane wetlands.',
                'description' => 'Unwind in the tranquil birthplace of Lord Buddha with guided heritage interpretation, morning meditation, and slow bicycle exploration.',
                'hero_image' => 'https://images.unsplash.com/photo-1582650625119-3a31f8fa2699?auto=format&fit=crop&w=1200&q=80',
                'gallery' => ['https://images.unsplash.com/photo-1582650625119-3a31f8fa2699?auto=format&fit=crop&w=1000&q=80'],
                'duration_days' => 3,
                'price_npr' => 18500,
                'difficulty' => 'easy',
                'package_type' => 'spiritual',
                'group_size_max' => 12,
                'availability_status' => 'available',
                'interests' => ['Spirituality', 'History', 'Relaxation', 'Culture'],
                'included_services' => ['2 nights peaceful garden resort', 'Certified Buddhist heritage guide', 'Monastic zone bicycle & electric rickshaw', 'Guided meditation session'],
                'excluded_services' => ['Domestic flights to Bhairahawa', 'Personal donations'],
                'accommodation_info' => 'Quiet retreat hotel near Lumbini Sacred Garden',
                'transportation_info' => 'Bhairahawa airport transfers included',
                'itinerary' => [
                    ['day' => 1, 'title' => 'Arrival & World Peace Pagoda Sunset', 'details' => 'Gentle welcome walk and evening reflection.'],
                    ['day' => 2, 'title' => 'Maya Devi Temple & Monastic Zone', 'details' => 'Full heritage tour and canal cycling.'],
                    ['day' => 3, 'title' => 'Crane Sanctuary & Departure', 'details' => 'Morning meditation and transfer.'],
                ],
                'is_published' => true,
                'approval_status' => 'approved',
                'is_featured' => false,
                'rating_avg' => 4.85,
                'reviews_count' => 1,
            ],
        ];

        $packages = [];
        foreach ($packagesData as $p) {
            $packages[$p['slug']] = Package::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // Safety Alerts (Clearly marked DEMO DATA)
        $alerts = [
            [
                'destination_id' => $destinations['everest-region']->id,
                'title' => 'High-Altitude Night Frost Advisory above 4,200m (DEMO)',
                'severity' => 'warning',
                'message' => 'Simulated seasonal advisory: Temperatures above Dingboche and Lobuche drop below -10°C overnight. Carry rated -15°C sleeping bags and verify daily acclimatization.',
                'is_active' => true,
                'is_demo_data' => true,
            ],
            [
                'destination_id' => $destinations['mustang']->id,
                'title' => 'Afternoon Kali Gandaki Valley Wind Caution (DEMO)',
                'severity' => 'advisory',
                'message' => 'Simulated advisory: High winds typically pick up after 11:30 AM between Jomsom and Kagbeni. Plan morning departures for smoother trekking and flights.',
                'is_active' => true,
                'is_demo_data' => true,
            ],
            [
                'destination_id' => null,
                'title' => 'Carry Offline Emergency Contacts & TIMS Registration (DEMO)',
                'severity' => 'info',
                'message' => 'Before departing for remote trails, register your trekking permits, share your SafeNepal Check-In schedule, and keep Tourist Police (1144) saved offline.',
                'is_active' => true,
                'is_demo_data' => true,
            ],
        ];
        foreach ($alerts as $alert) {
            SafetyAlert::updateOrCreate(['title' => $alert['title']], $alert);
        }

        // Platform-wide Emergency Contacts
        $contacts = [
            ['name' => 'Nepal Police Emergency', 'category' => 'police', 'phone' => '100', 'region' => 'Nepal Nationwide', 'description' => '24/7 national police emergency hotline (reference number).', 'is_demo_data' => true],
            ['name' => 'Tourist Police Nepal (Bhrikutimandap)', 'category' => 'tourist_police', 'phone' => '1144', 'region' => 'Nepal Nationwide', 'description' => 'Dedicated tourist assistance, lost documents, and travel safety support.', 'is_demo_data' => true],
            ['name' => 'Ambulance Service Nepal', 'category' => 'ambulance', 'phone' => '102', 'region' => 'Nepal Nationwide', 'description' => 'Emergency medical ambulance dispatch (reference number).', 'is_demo_data' => true],
            ['name' => 'Himalayan Rescue Association (HRA)', 'category' => 'rescue', 'phone' => '+977-1-4440292', 'region' => 'Kathmandu / Everest / Annapurna', 'description' => 'High-altitude medical advice and seasonal mountain aid posts.', 'is_demo_data' => true],
            ['name' => 'CIWEC Hospital Travel Medicine', 'category' => 'hospital', 'phone' => '+977-1-4524111', 'region' => 'Kathmandu & Pokhara', 'description' => '24/7 international travel medicine and altitude emergency clinic.', 'is_demo_data' => true],
        ];
        foreach ($contacts as $contact) {
            EmergencyContact::updateOrCreate(
                ['user_id' => null, 'name' => $contact['name']],
                $contact
            );
        }

        // Personal emergency contact for demo traveler
        EmergencyContact::updateOrCreate(
            ['user_id' => $traveler->id, 'name' => 'Suman Gurung (Brother)'],
            [
                'category' => 'personal',
                'phone' => '+977-9846001122',
                'region' => 'Pokhara',
                'description' => 'Primary family emergency contact for trip check-ins.',
                'is_demo_data' => true,
            ]
        );

        // Nearby Emergency Services (Clearly labeled DEMO DATA)
        $services = [
            ['destination_id' => $destinations['kathmandu']->id, 'name' => 'CIWEC Hospital & Travel Medicine Center (Demo)', 'category' => 'hospital', 'address' => 'Kapurdhara Marg, Lazimpat, Kathmandu', 'region' => 'Kathmandu', 'phone' => '+977-1-4524111', 'latitude' => 27.7215, 'longitude' => 85.3206, 'operating_hours' => '24 Hours', 'is_demo_data' => true],
            ['destination_id' => $destinations['kathmandu']->id, 'name' => 'Tourist Police Unit Thamel (Demo)', 'category' => 'police', 'address' => 'Thamel Marg, Kathmandu', 'region' => 'Kathmandu', 'phone' => '1144', 'latitude' => 27.7154, 'longitude' => 85.3123, 'operating_hours' => '24 Hours', 'is_demo_data' => true],
            ['destination_id' => $destinations['kathmandu']->id, 'name' => 'Himalayan Care Pharmacy Thamel (Demo)', 'category' => 'pharmacy', 'address' => 'Chaksibari Marg, Thamel', 'region' => 'Kathmandu', 'phone' => '+977-1-4700112', 'latitude' => 27.7141, 'longitude' => 85.3115, 'operating_hours' => '07:00 – 22:00', 'is_demo_data' => true],
            ['destination_id' => $destinations['pokhara']->id, 'name' => 'CIWEC Clinic Lakeside Pokhara (Demo)', 'category' => 'clinic', 'address' => 'Street 16, Lakeside, Pokhara', 'region' => 'Pokhara', 'phone' => '+977-61-453082', 'latitude' => 28.2090, 'longitude' => 83.9595, 'operating_hours' => '24 Hours', 'is_demo_data' => true],
            ['destination_id' => $destinations['pokhara']->id, 'name' => 'Tourist Police Office Lakeside (Demo)', 'category' => 'police', 'address' => 'Baidam Road, Lakeside, Pokhara', 'region' => 'Pokhara', 'phone' => '+977-61-462761', 'latitude' => 28.2112, 'longitude' => 83.9588, 'operating_hours' => '24 Hours', 'is_demo_data' => true],
            ['destination_id' => $destinations['pokhara']->id, 'name' => 'Fewa City Hospital & Pharmacy (Demo)', 'category' => 'hospital', 'address' => 'Nagdhunga, Pokhara', 'region' => 'Pokhara', 'phone' => '+977-61-532685', 'latitude' => 28.2044, 'longitude' => 83.9835, 'operating_hours' => '24 Hours', 'is_demo_data' => true],
            ['destination_id' => $destinations['chitwan']->id, 'name' => 'Sauraha Community Health Clinic (Demo)', 'category' => 'clinic', 'address' => 'Sauraha Main Road, Chitwan', 'region' => 'Chitwan', 'phone' => '+977-56-580105', 'latitude' => 27.5754, 'longitude' => 84.4940, 'operating_hours' => '07:00 – 21:00', 'is_demo_data' => true],
            ['destination_id' => $destinations['chitwan']->id, 'name' => 'Chitwan Tourist Police Post (Demo)', 'category' => 'police', 'address' => 'Sauraha Chowk, Chitwan', 'region' => 'Chitwan', 'phone' => '+977-56-580100', 'latitude' => 27.5761, 'longitude' => 84.4922, 'operating_hours' => '24 Hours', 'is_demo_data' => true],
            ['destination_id' => $destinations['everest-region']->id, 'name' => 'HRA Altitude Aid Post Pheriche (Demo)', 'category' => 'rescue', 'address' => 'Pheriche Valley, Khumbu (4,371m)', 'region' => 'Everest Region', 'phone' => '+977-1-4440292', 'latitude' => 27.8936, 'longitude' => 86.8194, 'operating_hours' => 'Seasonal Trekking Months', 'is_demo_data' => true],
            ['destination_id' => $destinations['everest-region']->id, 'name' => 'Khunde Himalayan Hospital (Demo)', 'category' => 'hospital', 'address' => 'Khunde Village, Namche', 'region' => 'Everest Region', 'phone' => '+977-38-540050', 'latitude' => 27.8172, 'longitude' => 86.7108, 'operating_hours' => '24 Hours Emergency', 'is_demo_data' => true],
            ['destination_id' => $destinations['annapurna']->id, 'name' => 'Chhomrong Mountain First-Aid Station (Demo)', 'category' => 'rescue', 'address' => 'Chhomrong, Annapurna Sanctuary Trail', 'region' => 'Annapurna', 'phone' => '+977-61-462761', 'latitude' => 28.4191, 'longitude' => 83.8205, 'operating_hours' => '08:00 – 19:00', 'is_demo_data' => true],
            ['destination_id' => $destinations['mustang']->id, 'name' => 'Mustang District Hospital Jomsom (Demo)', 'category' => 'hospital', 'address' => 'Jomsom Bazaar, Mustang', 'region' => 'Mustang', 'phone' => '+977-69-440111', 'latitude' => 28.7806, 'longitude' => 83.7231, 'operating_hours' => '24 Hours', 'is_demo_data' => true],
        ];
        foreach ($services as $svc) {
            NearbyService::updateOrCreate(['name' => $svc['name']], $svc);
        }

        // Sample Booking + Demo Payment for Demo Traveler
        $booking = Booking::updateOrCreate(
            ['booking_code' => 'SN-2026-1001'],
            [
                'user_id' => $traveler->id,
                'package_id' => $packages['everest-base-camp-safety-first-trek']->id,
                'agency_id' => $agencies['himalayan-horizon-expeditions']->id,
                'travel_date' => now()->addDays(24)->toDateString(),
                'travelers_count' => 2,
                'total_price_npr' => 230000,
                'contact_name' => $traveler->name,
                'contact_email' => $traveler->email,
                'contact_phone' => $traveler->phone,
                'special_requests' => 'Vegetarian meal preference and extra acclimatization briefing.',
                'traveler_details' => [
                    ['name' => 'Maya Gurung', 'age' => 29, 'nationality' => 'Nepali'],
                    ['name' => 'Nisha Thapa', 'age' => 28, 'nationality' => 'Nepali'],
                ],
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
            ]
        );

        Payment::updateOrCreate(
            ['transaction_reference' => 'DEMO-TXN-20261001'],
            [
                'booking_id' => $booking->id,
                'user_id' => $traveler->id,
                'amount_npr' => 230000,
                'payment_method' => 'demo_esewa',
                'payment_status' => 'completed',
                'is_demo' => true,
                'paid_at' => now()->subDays(2),
            ]
        );

        // Sample Saved Trip for Demo Traveler
        $trip = Trip::updateOrCreate(
            ['user_id' => $traveler->id, 'title' => 'Pokhara Lakeside & Sunrise Escape'],
            [
                'destination_id' => $destinations['pokhara']->id,
                'start_date' => now()->addDays(10)->toDateString(),
                'end_date' => now()->addDays(12)->toDateString(),
                'duration_days' => 3,
                'budget_npr' => 25000,
                'estimated_total_npr' => 11400,
                'travelers_count' => 2,
                'interests' => ['Nature', 'Photography', 'Relaxation', 'Food'],
                'travel_style' => 'balanced',
                'difficulty_preference' => 'easy',
                'accommodation_preference' => 'boutique',
                'transportation_preference' => 'private_car',
                'match_score' => 80.0,
                'status' => 'planned',
            ]
        );

        if ($trip->days()->count() === 0) {
            $day1 = TripDay::create([
                'trip_id' => $trip->id,
                'day_number' => 1,
                'date' => now()->addDays(10)->toDateString(),
                'title' => 'Sunrise & Phewa Lake Discovery',
                'daily_budget_npr' => 5800,
            ]);
            TripActivity::create([
                'trip_day_id' => $day1->id,
                'title' => 'Sarangkot Himalayan Sunrise View',
                'description' => 'Golden alpenglow across Annapurna and Machhapuchhre peaks.',
                'start_time' => '05:30',
                'duration_hours' => 2.5,
                'estimated_cost_npr' => 1500,
                'location' => 'Sarangkot Hill',
                'transportation_info' => '30 min drive from Lakeside',
                'sort_order' => 1,
            ]);
            TripActivity::create([
                'trip_day_id' => $day1->id,
                'title' => 'Phewa Lake Rowing & Peace Pagoda Hike',
                'description' => 'Row across emerald waters and walk up to Shanti Stupa.',
                'start_time' => '13:30',
                'duration_hours' => 3.5,
                'estimated_cost_npr' => 1400,
                'location' => 'Phewa Lake',
                'transportation_info' => 'Wooden boat',
                'sort_order' => 2,
            ]);

            $day2 = TripDay::create([
                'trip_id' => $trip->id,
                'day_number' => 2,
                'date' => now()->addDays(11)->toDateString(),
                'title' => 'Begnas Lake Tranquility',
                'daily_budget_npr' => 5200,
            ]);
            TripActivity::create([
                'trip_day_id' => $day2->id,
                'title' => 'Begnas Lake Quiet Canoe & Local Fish Lunch',
                'description' => 'Unwind at quiet Begnas Lake surrounded by forested hills.',
                'start_time' => '09:30',
                'duration_hours' => 4.0,
                'estimated_cost_npr' => 2600,
                'location' => 'Begnas Lake',
                'transportation_info' => '40 min drive',
                'sort_order' => 1,
            ]);
        }

        // Sample Reviews
        $reviews = [
            ['user_id' => $traveler->id, 'reviewable_type' => Destination::class, 'reviewable_id' => $destinations['pokhara']->id, 'rating' => 5, 'title' => 'Peaceful mornings and unforgettable mountain views', 'comment' => 'Rowing on Phewa Lake at sunrise with Machhapuchhre reflected in the water was magical. Having SafeNepal safety contacts handy gave extra peace of mind.'],
            ['user_id' => $traveler2->id, 'reviewable_type' => Destination::class, 'reviewable_id' => $destinations['annapurna']->id, 'rating' => 5, 'title' => 'Well-paced trails and warm Gurung hospitality', 'comment' => 'The stone villages and rhododendron forests are breathtaking. Checking altitude notes ahead of time helped our group plan rest stops properly.'],
            ['user_id' => $traveler->id, 'reviewable_type' => Package::class, 'reviewable_id' => $packages['everest-base-camp-safety-first-trek']->id, 'rating' => 5, 'title' => 'Safety-first leadership from day one', 'comment' => 'Tenzing and Himalayan Horizon checked our oxygen levels every evening and kept the pace calm and encouraging. Truly professional.'],
            ['user_id' => $traveler2->id, 'reviewable_type' => GuideProfile::class, 'reviewable_id' => $guides['tenzing-norbu-sherpa']->id, 'rating' => 5, 'title' => 'Calm, knowledgeable, and deeply respectful of the mountains', 'comment' => 'Tenzing knows every ridge and monastery in Khumbu. Best trekking guide we have ever traveled with.'],
            ['user_id' => $traveler->id, 'reviewable_type' => AgencyProfile::class, 'reviewable_id' => $agencies['himalayan-horizon-expeditions']->id, 'rating' => 5, 'title' => 'Transparent pricing and responsive communication', 'comment' => 'Everything from permits to teahouse bookings ran smoothly with zero hidden fees.'],
        ];
        foreach ($reviews as $rev) {
            Review::updateOrCreate(
                [
                    'user_id' => $rev['user_id'],
                    'reviewable_type' => $rev['reviewable_type'],
                    'reviewable_id' => $rev['reviewable_id'],
                ],
                $rev
            );
        }

        // Sample Inquiry Conversation
        $inquiry = Inquiry::updateOrCreate(
            ['user_id' => $traveler->id, 'subject' => 'Custom acclimatization day for Everest Base Camp'],
            [
                'agency_id' => $agencies['himalayan-horizon-expeditions']->id,
                'destination_id' => $destinations['everest-region']->id,
                'travel_date' => now()->addDays(24)->toDateString(),
                'travelers_count' => 2,
                'status' => 'responded',
            ]
        );

        if ($inquiry->messages()->count() === 0) {
            InquiryMessage::create([
                'inquiry_id' => $inquiry->id,
                'sender_id' => $traveler->id,
                'message' => 'Namaste! Can we include an extra half-day acclimatization walk near Dingboche for two travelers?',
            ]);
            InquiryMessage::create([
                'inquiry_id' => $inquiry->id,
                'sender_id' => $agencyUsers[0]->id,
                'message' => 'Namaste Maya! Yes, we include a guided acclimatization hike to Nangkartshang ridge above Dingboche at no extra charge. We will also brief you in Kathmandu.',
            ]);
        }
    }
}
