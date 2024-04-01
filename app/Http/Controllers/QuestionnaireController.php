<?php

namespace App\Http\Controllers;

use App\Enum\CacheKeyEnum;
use App\Helper\ArrayHelper;
use App\Http\Requests\QuestionnaireRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\QuestionnaireResources;
use App\Models\Behaviour;
use App\Repositories\ProductRepository;
use App\Repositories\QuestionRepository;
use App\Traits\CacheTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class QuestionnaireController extends Controller
{
    use ResponseTrait, CacheTrait;

    /**
     * Inject relevant repository dependencies
     * use repository in case data layer needs to change
     */
    public function __construct(
        private QuestionRepository $questionRepository,
        private ProductRepository $productRepository
    ) {
    }

    /**
     * Fetch all questionnaire and answer options
     */
    public function index(): Response | JsonResponse
    {
        $data = $this->cacheToRemember(
            CacheKeyEnum::QUESTIONNAIRE->value,
            fn () => $this->questionRepository->getAllWithAnswers()
        );

        return $this->onSuccess(
            statusCode: Response::HTTP_OK,
            data: QuestionnaireResources::collection($data)
        );
    }

    /**
     * Compute answer and suggest products
     */
    public function store(QuestionnaireRequest $request)
    {
        $questionAnswers = $request->validated();
        $suggestedProducts = [];

        foreach ($questionAnswers['questionnaire'] as $questionAnswer) {

            # fetch the behaviours logic of the questions and answers submitted
            $behaviour = $this->questionRepository->getQuestionAnswerBehaviourById(
                $questionAnswer['questionId'],
                $questionAnswer['answerId']
            );

            # Extract related products from unrelated ones
            if ($behaviour && (optional($behaviour)->product_included || optional($behaviour)->product_excluded)) {
                $suggestedProducts[] = ArrayHelper::extractWantedFromUnwanted(
                    optional($behaviour)->product_included, 
                    optional($behaviour)->product_excluded
                );
            }
        }
        $suggestedProducts = ArrayHelper::flattenArray($suggestedProducts);

        return $this->onSuccess(
            statusCode: Response::HTTP_OK,
            data: $this->buildSuggestedProducts($suggestedProducts)
        );
    }

    private function buildSuggestedProducts(array $suggestedProducts): array
    {
        $products = [];

        if (count($suggestedProducts) > 0)

            foreach ($suggestedProducts as $product) {

                // if category ID array, then fetch all products in the category
                if (is_array($product) && optional($product)['category']) {
                    $productResource = $this->productRepository->getAllByCategoryId((int)$product['category'])->toArray();
                    $products = array_merge($productResource, $products);
                }

                // if integer, then fetch product with that ID
                if (is_int($product)) {
                    $productResource = $this->productRepository->getById($product)->toArray();
                    $products[] = $productResource;
                }
            }

        return ArrayHelper::removeDuplicate($products);
    }

}
