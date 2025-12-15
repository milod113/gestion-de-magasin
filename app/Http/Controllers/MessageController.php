<?php


namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * (Optionnel) Liste des messages.
     */
    public function index()
    {
        $messages = Message::with(['user', 'attachments'])
            ->latest()
            ->paginate(15);

        return view('messages.index', compact('messages'));
    }

    /**
     * (Optionnel) Formulaire de création.
     */
    public function create()
    {
        return view('messages.create');
    }

    /**
     * Enregistrer un message avec pièces jointes (multiple).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sujet' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:10240'], // 10 MB par fichier
        ]);

        DB::transaction(function () use ($request, $validated) {
            $message = Message::create([
                'user_id' => auth()->id(),
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
