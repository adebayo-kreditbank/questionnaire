<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BehaviourRepository;
use App\Enum\CacheKeyEnum;
use App\Http\Requests\Admin\BehaviourRequest;
use App\Http\Resources\Admin\BehaviourResource;
use App\Http\Resources\Admin\QuestionResource;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use App\Traits\CacheTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BehaviourController extends Controller
{
    use ResponseTrait, CacheTrait;

    /**
     * Inject relevant repository dependencies
     * use repository in case data layer needs to change
     */
    public function __construct(
        private BehaviourRepository $behaviourRepository,
        private ProductRepository $productRepository
    ) {
    }


    /**
     * Get all Behaviours
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        # retrieve from cache if available, else from DB
        $data = $this->cacheToRemember(
            CacheKeyEnum::BEHAVIOURS->value,
            fn () => $this->behaviourRepository->getAllWithPivot()
        );

        $productData = $this->cacheToRemember(
            CacheKeyEnum::PRODUCTS->value,
            fn () => $this->productRepository->getAll()
        );

        $responseData = $request->query('withProduct') ? [
            "behaviours" => BehaviourResource::collection($data),
            "products" => ProductResource::collection($productData)
        ] : BehaviourResource::collection($data);

        return $this->onSuccess(
            statusCode: Response::HTTP_OK, data: $responseData
        );
    }


    /**
     * create new answer
     * @param BehaviourRequest $request
     * @param int $id
     * @return Response|JsonResponse
     */
    public function update(BehaviourRequest $request, $id): JsonResponse
    {
        if ($this->behaviourRepository->update($id, $request->validated())) {
            
            $this->forgetAllCached();
            
            return $this->onSuccess(statusCode: Response::HTTP_OK);
        }
    }


    /**
     * delete all cached data at once
     * @return void
     */
    private function forgetAllCached(): void
    {
        # delete from cache
        $this->forgetCache(CacheKeyEnum::BEHAVIOURS->value);
        $this->forgetCache(CacheKeyEnum::PRODUCTS->value);
    }
}
