<?php

namespace App\Enum;


enum CacheKeyEnum: string
{
    case QUESTIONNAIRE = 'questionnaire';
    case QUESTIONS = 'questions';
    case ANSWERS = 'answers';
    case BEHAVIOURS = 'behaviours';
    case PRODUCTS = 'products';
}
