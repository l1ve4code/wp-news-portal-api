<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API - Новостного портала",
 *      description="Участники: Веденин Иван, Тишкина Алина, Федор Пережогин, Александр Сергеев",
 *      @OA\License(
 *          name="MIT",
 *          url="https://opensource.org/licenses/MIT"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API"
 * )
 *
 * @OA\Tag(
 *     name="Auth",
 *     description="Auth endpoints"
 * )
 *
 * @OA\Tag(
 *     name="Категории",
 *     description="Ссылки для работы с категориями"
 * )
 * @OA\Tag(
 *     name="Комментарии",
 *     description="Ссылки для работы с комментариями"
 * )
 * @OA\Tag(
 *     name="Группы",
 *     description="Ссылки для работы с группами"
 * )
 * @OA\Tag(
 *     name="Лайки",
 *     description="Ссылки для работы с лайками"
 * )
 * @OA\Tag(
 *     name="Изображение [ПОЗЖЕ]",
 *     description="Ссылки для работы с изображениями"
 * )
 * @OA\Tag(
 *     name="Посты",
 *     description="Ссылки для работы с постами"
 * )
 * @OA\Tag(
 *     name="Сохраненные группы",
 *     description="Ссылки для работы с сохраненными группами"
 * )
 * @OA\Tag(
 *     name="Подписки",
 *     description="Ссылки для работы с подписками"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
