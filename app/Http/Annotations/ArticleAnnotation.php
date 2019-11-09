<?php 


/**
 * @OA\Get(
 *      path="/articles/drafts",
 *      operationId="getDraftedArticlesList",
 *      tags={"Articles"},
 *      summary="Get list of drafted articles",
 *      description="Returns list of drafted articles",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"passport": {}}
 *       }
 *     )
 *
 */
/**
 * @OA\Get(
 *      path="/articles/published",
 *      operationId="getPublishedArticlesList",
 *      tags={"Articles"},
 *      summary="Get list of published articles",
 *      description="Returns list of published articles",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"passport": {}}
 *       }
 *     )
 *
 */
/**
 * @OA\Get(
 *      path="/articles/series/{series}",
 *      operationId="getArticleListBySeries",
 *      tags={"Articles", "Series"},
 *      summary="Get list of articles by series",
 *      description="Returns list of articles by series id",
 *      @OA\Parameter(
 *          name="series",
 *          description="Series id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       @OA\Response(response=404, description="Resource Not Found"),
 *       security={
 *           {"passport": {}}
 *       }
 *     )
 *
 */
/**
 * @OA\Get(
 *      path="/articles/{id}",
 *      operationId="getArticleById",
 *      tags={"Articles"},
 *      summary="Get article information",
 *      description="Returns article data",
 *      @OA\Parameter(
 *          name="id",
 *          description="Article id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "passport": {"write:articles", "read:articles"}
 *         }
 *     },
 * )
 */
/**
 * @OA\Post(
 *      path="/articles",
 *      operationId="storeArticle",
 *      tags={"Articles"},
 *      summary="Store new article",
 *      description="Stores new article",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "passport": {"write:articles", "read:articles"}
 *         }
 *     },
 * )
 */