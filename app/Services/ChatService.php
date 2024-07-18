<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Product;
use App\Constants\Roles;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatService
{
    public function startChat(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $chat = Chat::create([
            'product_id' => $productId,
            'tenant_id' => $request->user()->id,
            'agent_id' => $product->user_id,
        ]);

        return response()->json([
            'message' => 'Chat started successfully',
            'data' => $chat
        ], Response::HTTP_OK);
    }

    public function getChats(Request $request)
    {
        $userId = $request->user()->id;
        $userRole = $request->user()->role; 

        if ($userRole === Roles::TENANT) {
            $chats = Chat::with(['messages', 'product'])
            ->where('tenant_id', $userId)
                ->get();
        } elseif ($userRole === Roles::LANDLORD) {
            $chats = Chat::with(['messages', 'product'])
            ->where('agent_id', $userId)
                ->get();
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_FORBIDDEN);
        }

        return response()->json([
            'message' => $request->user()->name . ' ' . 'chats retrieved successfully',
            'data' => $chats
        ], Response::HTTP_OK);
    }


    public function sendMessage(Request $request, $chatId)
    {
        $chat = Chat::findOrFail($chatId);

        $message = $chat->messages()->create([
            'sender_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message
        ], Response::HTTP_OK);
    }

    public function getSpecificChat(Request $request, $productId, $agentId)
    {
        $chat = Chat::where('tenant_id', $request->user()->id)
            ->where('product_id', $productId)
            ->where('agent_id', $agentId)
            ->with(['messages', 'product'])
            ->firstOrFail();

        return response()->json([
            'message' => 'Chat retrieved successfully',
            'data' => $chat
        ], Response::HTTP_OK);
    }

}
