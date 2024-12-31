<?php
	namespace App\Http\Controllers;

	use App\Helpers\MyHelper;
	use App\Models\Image;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Log;
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\Str;

	use Epigra\TrGeoZones\Models\City;
	use Epigra\TrGeoZones\Models\Country;
	use Epigra\TrGeoZones\Models\County;
	use Epigra\TrGeoZones\Models\District;
	use Epigra\TrGeoZones\Models\Neighbourhood;

	class CountryStateCityController extends Controller
	{
		public function getCountries()
		{
			return Country::all();
		}

		public function getCities($countryId)
		{
			return City::where('country_id', $countryId)->get();
		}

		public function getCounties($cityId)
		{
			return County::where('city_id', $cityId)->get();
		}

		public function getDistricts($countyId)
		{
			return District::where('county_id', $countyId)->get();
		}

		public function getNeighborhoods($districtId)
		{
			return Neighbourhood::where('district_id', $districtId)->get();
		}
	}
