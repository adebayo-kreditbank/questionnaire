<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionnaireResources;
use App\Repositories\QuestionRepository;
use App\Traits\CacheTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionnaireController extends Controller
{
    use ResponseTrait, CacheTrait;

    public function __construct(private QuestionRepository $questionRepository)
    {
    }

    public function index()
    {
        $data = $this->cacheToRemember('questionnaire', fn () => $this->questionRepository->getAllWithAnswers());

        return $this->onSuccess(
            statusCode: Response::HTTP_OK, 
            data: QuestionnaireResources::collection($data)
        );
    }
}
