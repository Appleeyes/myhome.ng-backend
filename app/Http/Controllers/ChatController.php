<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatService;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/contact-agent/{productId}",
     *     summary="Start a chat with an agent",
     *     tags={"Chats"},
     *     description="Start a chat with an agent about a product",
     *     operationId="startChat",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         description="ID of the product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chat started successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chat started successfully"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Chat"))
     *         )
     *     )
     * )
     */
    public function startChat(Request $request, $productId)
    {
        return $this->chatService->startChat($request, $productId);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/chats",
     *     summary="Get all chats for the authenticated user",
     *     tags={"Chats"},
     *     description="Get all chats for the authenticated user (tenant or landlord)",
     *     operationId="getChats",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Chats retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chats retrieved successfully"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Chat"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized access",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function getChats(Request $request)
    {
        return $this->chatService->getChats($request);
    }


    /**
     * @OA\Post(
     *     path="/api/v1/chats/{chatId}/messages",
     *     summary="Send a message in a chat",
     *     tags={"Chats"},
     *     description="Send a message to an agent in a chat",
     *     operationId="sendMessage",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="chatId",
     *         in="path",
     *         description="ID of the chat",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Hello, I am interested in this property......")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message sent successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="object", example="Message sent successfully"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Message"))
     *         )
     *     )
     * )
     */
    public function sendMessage(Request $request, $chatId)
    {
        return $this->chatService->sendMessage($request, $chatId);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/chats/product/{productId}/agent/{agentId}",
     *     summary="Get specific chat for the authenticated tenant related to a specific product and agent",
     *     tags={"Chats"},
     *     description="Get specific chat for the authenticated tenant related to a specific product and agent",
     *     operationId="getSpecificChat",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the product"
     *     ),
     *     @OA\Parameter(
     *         name="agentId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the agent"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chat retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chat retrieved successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Chat")
     *         )
     *     )
     * )
     */
    public function getSpecificChat(Request $request, $productId, $agentId)
    {
        return $this->chatService->getSpecificChat($request, $productId, $agentId);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/chats/{chatId}",
     *     summary="Get a specific chat by ID for the authenticated user",
     *     tags={"Chats"},
     *     description="Retrieve a specific chat by ID. Only accessible to the tenant or landlord involved in the chat.",
     *     operationId="getChatById",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="chatId",
     *         in="path",
     *         description="ID of the chat to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chat retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chat retrieved successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Chat")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized access",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chat not found")
     *         )
     *     )
     * )
     */
    public function getChatById(Request $request, $chatId)
    {
        return $this->chatService->getChatById($chatId, $request);
    }

}
