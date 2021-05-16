<?php

namespace App\Http\Controllers\Endpoints;

/*https://www.itsolutionstuff.com/post/laravel-form-validation-request-class-exampleexample.html*/
/*https://laravelproject.com/http-client-laravel-7*/
/*https://stackoverflow.com/questions/27064953/how-can-i-paginate-an-array-of-objects-in-laravel*/
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class StackOverflowController extends BaseController
{
    public function getResults(Request $request){
        $tag = $request->input('tag');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $currentPage = $request->input('currentPage');
        if(!is_null($tag)){
            $url = config('app.restURL');
            $url .=$tag;
            if(!is_null($startDate)){
                $url .= '&fromdate='.strtotime($startDate);
            }
            if(!is_null($endDate)){
                $url .= '&todate='.strtotime($endDate);
            }
            $url .= '&sort=creation';
            $response = Http::get($url);
            $data = $response->json();
            $total = count($data['items']);
            $perPage = 10; 
            $pagesNum = $total/$perPage;
            //ddd($pagesNum);
            if(is_null($currentPage))
            {
                $currentPage = 1;
            }   
            $paginatedResult = array_slice($data['items'], ($currentPage - 1) * $perPage, $perPage);
            $response = "{\"results\": ".json_encode($paginatedResult).", \"pages\":".$pagesNum.", \"pageAct\": ".$currentPage.", \"errors\":null }";   
           
        }else{
            $response = "{\"results\": null, \"pages\": null, \"pageAct\":1, \"errors\": \"".trans("search.tag is required")."\" }"; 
        }

        return $response;
    }
}
