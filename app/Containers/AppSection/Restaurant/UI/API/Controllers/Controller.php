<?php

namespace App\Containers\AppSection\Restaurant\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Restaurant\Actions\CreateOrUpdateRestaurantMasterAction;
use App\Containers\AppSection\Restaurant\Actions\DeleteRestaurantmasterAction;
use App\Containers\AppSection\Restaurant\Actions\FindRestaurantmasterByIdAction;
use App\Containers\AppSection\Restaurant\Actions\CreateOrUpdateRestaurantCategoryMenuAction;
use App\Containers\AppSection\Restaurant\Actions\GetRestaurantByIdAction;
use App\Containers\AppSection\Restaurant\Actions\DeleteRestaurantByIdAction;
use App\Containers\AppSection\Restaurant\Actions\GetAllRestaurantMasterAction;
use App\Containers\AppSection\Restaurant\Actions\GetAllRestaurantCategoryMenuMasterAction;
use App\Containers\AppSection\Restaurant\Actions\getRestaurantByIdCategoryMenuMasterAction;
use App\Containers\AppSection\Restaurant\Actions\DeleteRestaurantByIdCategoryMenuMasterAction;
use App\Containers\AppSection\Restaurant\Actions\CreateORUpdateRestaurantMenuMasterAction;
use App\Containers\AppSection\Restaurant\Actions\GetAllRestaurantMenuMasterAction;
use App\Containers\AppSection\Restaurant\Actions\GetRestaurantMenuMasterByIdAction;
use App\Containers\AppSection\Restaurant\Actions\DeleteRestaurantMenuMasterByIdAction;
use App\Containers\AppSection\Restaurant\Actions\CreateORUpdateRestaurantTableMasterAction;
use App\Containers\AppSection\Restaurant\Actions\GetAllRestaurantTableMasterAction;
use App\Containers\AppSection\Restaurant\Actions\GetRestaurantTableMasterByIdAction;
use App\Containers\AppSection\Restaurant\Actions\DeleteRestaurantTableMasterByIdAction;
use App\Containers\AppSection\Restaurant\Actions\CreateOrUpdateKotMasterAction; 
use App\Containers\AppSection\Restaurant\Actions\GetAllKotMasterAction;
use App\Containers\AppSection\Restaurant\Actions\GetKotMasterByIdAction;
use App\Containers\AppSection\Restaurant\Actions\DeleteKotMasterByIdAction;
use App\Containers\AppSection\Restaurant\Actions\GetCategoryWiseAllItemsByIdAction;
use App\Containers\AppSection\Restaurant\Actions\GetRoomAndTableNoAction;
use App\Containers\AppSection\Restaurant\Actions\CreateOrUpdateKotBillAction;
use App\Containers\AppSection\Restaurant\Actions\GetAllKotBillAction;
use App\Containers\AppSection\Restaurant\Actions\GetKotBillByIdAction;
use App\Containers\AppSection\Restaurant\Actions\DeleteKotBillByIdAction;
use App\Containers\AppSection\Restaurant\Actions\GetAllItemsByRestaurantIdAction;
use App\Containers\AppSection\Restaurant\Actions\ReturnKotByKotBillIdAction;









use App\Containers\AppSection\Restaurant\UI\API\Requests\ReturnKotByKotBillIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetAllRestaurantCategoryMenuMasterRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetAllItemsByRestaurantIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\DeleteKotBillByIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetKotBillByIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetAllKotBillRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\CreateOrUpdateKotBillRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetRoomAndTableNoRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetCategoryWiseAllItemsByIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\DeleteKotMasterByIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetKotMasterByIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetAllKotMasterRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\CreateOrUpdateKotMasterRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\DeleteRestaurantTableMasterByIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetRestaurantTableMasterByIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetAllRestaurantTableMasterRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\CreateORUpdateRestaurantTableMasterRequest;

use App\Containers\AppSection\Restaurant\UI\API\Requests\DeleteRestaurantMenuMasterByIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetAllRestaurantMenuMasterRequest;

use App\Containers\AppSection\Restaurant\UI\API\Requests\CreateORUpdateRestaurantMenuMasterRequest;

use App\Containers\AppSection\Restaurant\UI\API\Requests\GetRestaurantByIdCategoryMenuMasterRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\DeleteRestaurantByIdCategoryMenuMasterRequest;

use App\Containers\AppSection\Restaurant\UI\API\Requests\CreateOrUpdateRestaurantMasterRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetRestaurantMenuMasterByIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetAllRestaurantMasterRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetRestaurantByIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\DeleteRestaurantByIdRequest;
use App\Containers\AppSection\Restaurant\UI\API\Requests\CreateOrUpdateRestaurantCategoryMenuRequest;
use App\Containers\AppSection\Restaurant\UI\API\Transformers\RestaurantsTransformer;

use App\Containers\AppSection\Restaurant\Entities\Restaurant;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException; 
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createORUpdateRestaurantMaster(CreateOrUpdateRestaurantMasterRequest $request)
    {   
        // return "hiiii";
        $restaurant = app(CreateOrUpdateRestaurantMasterAction::class)->run($request);
        return $restaurant;
    }

    public function GetAllRestaurantMaster(GetAllRestaurantMasterRequest $request){
        
        $restaurant = app(GetAllRestaurantMasterAction::class)->run($request);
        return $restaurant;
    }

    public function GetRestaurantById(GetRestaurantByIdRequest $request){
        $restaurant = app(GetRestaurantByIdAction::class)->run($request);
        return $restaurant;
    }

    public function DeleteRestaurantById(DeleteRestaurantByIdRequest $request){
        $restaurant = app(DeleteRestaurantByIdAction::class)->run($request);
        return $restaurant;
    }

    public function createORUpdateRestaurantCategoryMenu(CreateOrUpdateRestaurantCategoryMenuRequest $request){
        $restaurant = app(CreateOrUpdateRestaurantCategoryMenuAction::class)->run($request);
        return $restaurant;

    }

    public function GetAllRestaurantCategoryMenuMaster(GetAllRestaurantCategoryMenuMasterRequest $request){
        // return "ggggggggggggggg";
        $restaurant = app(GetAllRestaurantCategoryMenuMasterAction::class)->run($request);
        return $restaurant;
    }
    public function getRestaurantByIdCategoryMenuMaster(GetRestaurantByIdCategoryMenuMasterRequest $request){
        // return "ggggggggggggggg";
        $restaurant = app(GetRestaurantByIdCategoryMenuMasterAction::class)->run($request);
        return $restaurant;
    }
    public function DeleteRestaurantByIdCategoryMenuMaster(DeleteRestaurantByIdCategoryMenuMasterRequest $request){
        // return "ggggggggggggggg";
        $restaurant = app(DeleteRestaurantByIdCategoryMenuMasterAction::class)->run($request);
        return $restaurant;
    }

    public function CreateORUpdateRestaurantMenuMaster(CreateORUpdateRestaurantMenuMasterRequest $request){
        $restaurant = app(CreateORUpdateRestaurantMenuMasterAction::class)->run($request);
        return $restaurant;
    }

    public function GetAllRestaurantMenuMaster(GetAllRestaurantMenuMasterRequest $request){
        $restaurant = app(GetAllRestaurantMenuMasterAction::class)->run($request);
        return $restaurant;
    }
    public function GetRestaurantMenuMasterById(GetRestaurantMenuMasterByIdRequest $request){
        $restaurant = app(GetRestaurantMenuMasterByIdAction::class)->run($request);
        return $restaurant;
    }
    
    public function DeleteRestaurantMenuMasterById(DeleteRestaurantMenuMasterByIdRequest $request){
        $restaurant = app(DeleteRestaurantMenuMasterByIdAction::class)->run($request);
        return $restaurant;
    }

    public function CreateORUpdateRestaurantTableMaster(CreateORUpdateRestaurantTableMasterRequest $request){
        $restaurant = app(CreateORUpdateRestaurantTableMasterAction::class)->run($request);
        return $restaurant;
    }

    public function GetAllRestaurantTableMaster(GetAllRestaurantTableMasterRequest $request){
        $restaurant = app(GetAllRestaurantTableMasterAction::class)->run($request);
        return $restaurant;
    }

    public function GetRestaurantTableMasterById(GetRestaurantTableMasterByIdRequest $request){
        $restaurant = app(GetRestaurantTableMasterByIdAction::class)->run($request);
        return $restaurant;
    }   

    public function DeleteRestaurantTableMasterById(DeleteRestaurantTableMasterByIdRequest $request){
        $restaurant = app(DeleteRestaurantTableMasterByIdAction::class)->run($request);
        return $restaurant;
    }

    public function CreateORUpdateKotMaster(CreateOrUpdateKotMasterRequest $request){
        $kot = app(CreateOrUpdateKotMasterAction::class)->run($request);
        return $kot;
    }  
    
    public function GetAllKotMaster(GetAllKotMasterRequest $request){
        $kot = app(GetAllKotMasterAction::class)->run($request);
        return $kot;
    }

    public function GetKotMasterById(GetKotMasterByIdRequest $request){
        $kot = app(GetKotMasterByIdAction::class)->run($request);    
        return $kot;
    }

    public function DeleteKotMasterById(DeleteKotMasterByIdRequest $request){
        $kot = app(DeleteKotMasterByIdAction::class)->run($request);
        return $kot;
    }

    public function GetCategoryWiseAllItemsById(GetCategoryWiseAllItemsByIdRequest $request){
        $kot = app(GetCategoryWiseAllItemsByIdAction::class)->run($request);
        return $kot;
    }

    public function GetRoomAndTableNo(GetRoomAndTableNoRequest $request){
        $kot = app(GetRoomAndTableNoAction::class)->run($request);
        return $kot;
    }

    public function CreateOrUpdateKotBill(CreateOrUpdateKotBillRequest $request){
        $kot = app(CreateOrUpdateKotBillAction::class)->run($request);
        return $kot;
    }

    public function GetAllKotBill(GetAllKotBillRequest $request){
        $kot = app(GetAllKotBillAction::class)->run($request);
        return $kot;
    }

    public function GetKotBillById(GetKotBillByIdRequest $request){
        $kot = app(GetKotBillByIdAction::class)->run($request);
        return $kot;    
    }

    public function DeleteKotBillById(DeleteKotBillByIdRequest $request){
        $kot = app(DeleteKotBillByIdAction::class)->run($request);
        return $kot;
    }

    public function GetAllItemsByRestaurantId(GetAllItemsByRestaurantIdRequest $request){
        $kot = app(GetAllItemsByRestaurantIdAction::class)->run($request);
        return $kot;
    }

    public function ReturnKotByKotBillId(ReturnKotByKotBillIdRequest $request){
        $kot = app(ReturnKotByKotBillIdAction::class)->run($request);
        return $kot;
    }
}
