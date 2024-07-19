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
            $chats = Chat::with(['messages', 'product', 'agent'])
            ->where('tenant_id', $userId)
                ->get();
        } elseif ($userRole === Roles::LANDLORD) {
            $chats = Chat::with(['messages', 'product', 'tenant'])
            ->where('agent_id', $userId)
                ->get();
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_FORBIDDEN);
        }

        $chats->each(function ($chat) use ($userId) {
            $chat->unread_count = $chat->messages->where('sender_id', '!=', $userId)->whereNull('read_at')->count();
        });

        return response()->json([
            'message' => $request->user()->name . ' chats retrieved successfully',
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

    public function getChatById($chatId, Request $request)
    {
        $userId = $request->user()->id;
        $userRole = $request->user()->role;

        $chat = Chat::with(['messages', 'product', 'tenant', 'agent'])
            ->where(function ($query) use ($userId, $userRole) {
                if ($userRole === Roles::TENANT) {
                    $query->where('tenant_id', $userId);
                } elseif ($userRole === Roles::LANDLORD) {
                    $query->where('agent_id', $userId);
                }
            })
            ->findOrFail($chatId);

        $chat->messages->where('sender_id', '!=', $userId)->each(function ($message) {
            $message->read_at = now();
            $message->save();
        });

        return response()->json([
            'message' => 'Chat retrieved successfully',
            'data' => $chat
        ], Response::HTTP_OK);
    }
}
