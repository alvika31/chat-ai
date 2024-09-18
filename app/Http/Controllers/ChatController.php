<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\SessionCustom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessionId = Session::get('session_id');
        $conversation = [];
        if ($sessionId) {
            $conversation = Conversation::with('messages')
                ->where('session_custom_id', $sessionId)
                ->first();
        }
        return Inertia::render('Chat/Index', [
            'conversation' => $conversation ?? null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sessionId = $request->session()->get('session_id');
        $message = $request->input('message');
        // Simpan pesan pengguna
        $conversation = Conversation::firstOrCreate(
            ['session_custom_id' => $sessionId],
            ['title' => 'Untitled Conversation']
        );

        $userMessage = $conversation->messages()->create([
            'role' => 'user',
            'content' => $message
        ]);

        // Kirim ke AI dan simpan respons
        // $aiResponse = $this->sendToAI($message);
        // $aiMessage = $conversation->messages()->create([
        //     'role' => 'ai',
        //     'content' => $aiResponse
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createSession()
    {
        $sessionId = \Str::uuid();
        Session::put('session_id', $sessionId);

        // Simpan sesi ke database
        DB::table('session_customs')->insert([
            'id' => $sessionId,
            'created_at' => now(),
            'last_activity' => now()
        ]);

        return $sessionId;
    }
}
