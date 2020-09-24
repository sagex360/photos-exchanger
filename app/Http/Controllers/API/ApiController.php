<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Files Exchanger API",
 * )
 * @OA\Parameter(
 *     parameter="header-accept-type",
 *     name="Accept",
 *     description="Accept type",
 *     required=true,
 *     in="header",
 *     @OA\Schema(
 *         type="string",
 *         example="application/json",
 *     ),
 * ),
 * @OA\Parameter(
 *     parameter="header-authorization-token",
 *     name="Authorization",
 *     description="Api authorization user token",
 *     required=true,
 *     in="header",
 *     @OA\Schema(
 *         type="string",
 *         example="Bearer 9194773b-3f24-42bb-93ca-654557dd303c",
 *     ),
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="bearer_auth",
 *     name="bearer_auth",
 *     type="http",
 *     scheme="bearer",
 *     in="header",
 * ),
 */
abstract class ApiController extends Controller
{
}
