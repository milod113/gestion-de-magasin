<?php


namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class MessageController extends Controller
{
    /**
     * (Optionnel) Liste des messages.
     */
public function index()
{
    $userId = auth()->id();

    $sent = Message::with(['sender', 'recipient', 'attachments'])
        ->where('user_id', $userId)
        ->latest()
        ->paginate(15, ['*'], 'sent_page');

    $received = Message::with(['sender', 'recipient', 'attachments'])
        ->where('recipient_id', $userId)
        ->latest()
        ->paginate(15, ['*'], 'received_page');

    return view('messages.index', compact('sent', 'received'));
}
public function inbox()
{
    $messages = Message::with(['sender','attachments'])
        ->where('recipient_id', auth()->id())
        ->latest()
        ->paginate(15);

    return view('messages.inbox', compact('messages'));
}

public function sent()
{
    $messages = Message::with(['recipient','attachments'])
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(15);

    return view('messages.sent', compact('messages'));
}


    /**
     * (Optionnel) Formulaire de création.
     */
 public function create()
{
    $users = User::with('roles')
        ->orderBy('name')
        ->get();

    return view('messages.create', compact('users'));
}

    /**
     * Enregistrer un message avec pièces jointes (multiple).
     */
    public function store(Request $request)
    {
$validated = $request->validate([
    'sujet' => ['required', 'string', 'max:255'],
    'contenu' => ['required', 'string'],
    'recipient_id' => ['required', 'exists:users,id'],
    'attachments' => ['nullable', 'array'],
    'attachments.*' => ['file', 'max:10240'],
]);


        DB::transaction(function () use ($request, $validated) {
$message = Message::create([
    'user_id'       => auth()->id(),
    'recipient_id'  => $validated['recipient_id'],
    'sujet'         => $validated['sujet'],
    'contenu'       => $validated['contenu'],
]);


            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('attachments', 'public');

                    $message->attachments()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'path'          => $path,
                        'mime_type'     => $file->getClientMimeType(),
                        'size'          => $file->getSize(),
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Message envoyé.');
    }

    /**
     * Afficher un message.
     */
    public function show(Message $message)
    {
        $message->load(['user', 'attachments']);

        return view('messages.show', compact('message'));
    }

    /**
     * (Optionnel) Formulaire d’édition.
     */
    public function edit(Message $message)
    {
        $message->load('attachments');

        return view('messages.edit', compact('message'));
    }

    /**
     * Mettre à jour sujet/contenu + (optionnel) ajouter de nouvelles pièces jointes.
     */
    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'sujet' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:10240'], // 10 MB
        ]);

        DB::transaction(function () use ($request, $validated, $message) {
            $message->update([
                'sujet'   => $validated['sujet'],
                'contenu' => $validated['contenu'],
            ]);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('attachments', 'public');

                    $message->attachments()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'path'          => $path,
                        'mime_type'     => $file->getClientMimeType(),
                        'size'          => $file->getSize(),
                    ]);
                }
            }
        });

        return redirect()->route('messages.show', $message)->with('success', 'Message mis à jour.');
    }

    /**
     * Supprimer un message (les attachments DB seront supprimés via cascade).
     * Note: si tu veux aussi supprimer les fichiers du disque, dis-moi et je te l’ajoute.
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('messages.index')->with('success', 'Message supprimé.');
    }
}
