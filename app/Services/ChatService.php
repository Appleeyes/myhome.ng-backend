<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Product;
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
        $chats = Chat::with(['messages', 'product'])->where('tenant_id', $request->user()->id)->get();
        return response()->json([
            'message' => 'Chats retrieved successfully',
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
}
