<?php
namespace App\Containers\AppSection\Checkin\Tasks;
use App\Containers\AppSection\Checkin\Models\Country;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Apiato\Core\Traits\HashIdTrait;
use Illuminate\Support\Facades\Cache;

class getCityCountryStateTask extends ParentTask
{
    use HashIdTrait;

    // public function run($request)
    // {
    //     $keyword = strtolower($request->get('keyword'));

    //     if($keyword == null){
    //         return [
    //             'result' => false,
    //             'message' => "KeyWord is required",
    //             'object' => "Checkin",
    //             'data' => [
    //                 'country' => ''
    //             ]
    //         ];
    //     }

    //     $data = $this->fetchAllData(); // Always get raw structured data

    //     if (!$keyword) {
    //         // Use cache if no keyword
    //         $data = Cache::remember('checkin_location_tree', 86400, function () {
    //             return $this->fetchAllData();
    //         });

    //         return [
    //             'result' => true,
    //             'message' => "All Data Found Successfully",
    //             'object' => "Checkin",
    //             'data' => [
    //                 'country' => $data
    //             ]
    //         ];
    //     }

    //     $result = [];

    //     foreach ($data as $country) {
    //         // 1. Match COUNTRY
    //         if (stripos($country['name'], $keyword) !== false) {
    //             $result[] = $country;
    //             continue;
    //         }

    //         foreach ($country['state'] as $state) {
    //             // 2. Match STATE
    //             if (stripos($state['name'], $keyword) !== false) {
    //                 $result[] = [
    //                     'id' => $country['id'],
    //                     'name' => $country['name'],
    //                     'currency' => $country['currency'],
    //                     'state' => [
    //                         [
    //                             'name' => $state['name'],
    //                             'city' => $state['city']
    //                         ]
    //                     ]
    //                 ];
    //                 continue 2; // go to next country
    //             }

    //             foreach ($state['city'] as $city) {
    //                 // 3. Match CITY
    //                 if (stripos($city['name'], $keyword) !== false) {
    //                     $result[] = [
    //                         'id' => $country['id'],
    //                         'name' => $country['name'],
    //                         'currency' => $country['currency'],
    //                         'state' => [
    //                             [
    //                                 'name' => $state['name'],
    //                                 'city' => [
    //                                     [
    //                                         'id' => $city['id'],
    //                                         'name' => $city['name']
    //                                     ]
    //                                 ]
    //                             ]
    //                         ]
    //                     ];
    //                     continue 3; // go to next state
    //                 }
    //             }
    //         }
    //     }

    //     return [
    //         'result' => true,
    //         'message' => "Filtered Data Found Successfully",
    //         'object' => "Checkin",
    //         'data' => [
    //             'country' => $result
    //         ]
    //     ];
    // }

    // private function fetchAllData()
    // {
    //     return Country::select('id', 'name', 'currency')
    //         ->with([
    //             'states' => function ($query) {
    //                 $query->select('id', 'country_id', 'name')
    //                     ->with(['cities' => function ($q) {
    //                         $q->select('id', 'state_id', 'name');
    //                     }]);
    //             }
    //         ])
    //         ->get()
    //         ->map(function ($country) {
    //             return [
    //                 'id' => $country->id, 
    //                 'name' => $country->name,
    //                 'currency' => $country->currency,
    //                 'state' => $country->states->map(function ($state) {
    //                     return [
    //                         'name' => $state->name,
    //                         'city' => $state->cities->map(function ($city) {
    //                             return [
    //                                 'id' => $city->id,
    //                                 'name' => $city->name
    //                             ];
    //                         })->toArray()
    //                     ];
    //                 })->toArray()
    //             ];
    //         })->toArray();
    // }

    public function run($request)
    {
        $keyword = $request->input('keyword');

        
        if (empty($keyword)) {
            $countries = Country::select('id', 'name')->orderBy('name')->get();

            return [
                'result' => true,
                'message' => "All countries loaded successfully",
                'object' => "Checkin",
                'data' => $countries
            ];
        }

        
        $countries = Country::where('name', 'like', '%' . $keyword . '%')
            ->with([
                'states' => function ($q) {
                    $q->select('id', 'name', 'country_id');
                },
                'states.cities' => function ($q) {
                    $q->select('id', 'name', 'state_id');
                }
            ])
            ->select('id', 'name') // only needed fields
            ->get();

        $result = [];

        foreach ($countries as $country) {
            $statesArr = [];

            foreach ($country->states as $state) {
                $citiesArr = $state->cities->map(function ($city) {
                    return [
                        'city_id' => $city->id,
                        'city' => $city->name,
                    ];
                })->toArray();

                $statesArr[] = [
                    'state' => $state->name,
                    'state_id' => $state->id,
                    'cities' => $citiesArr,
                ];
            }

            $result[] = [
                'country' => $country->name,
                'country_id' => $country->id,
                'states' => $statesArr,
            ];
        }

        return [
            'result' => true,
            'message' => "Filtered country/state/city data loaded successfully",
            'object' => "Checkin",
            'data' => $result
        ];
    }
}
       
