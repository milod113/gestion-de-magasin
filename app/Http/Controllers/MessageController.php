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


public function inbox(Request $request)
{
    $query = Message::with(['sender.roles','attachments'])
        ->where('recipient_id', auth()->id());

    // 🔎 Search (subject + content + sender name)
    if ($request->filled('search')) {
        $s = $request->input('search');

        $query->where(function ($q) use ($s) {
            $q->where('sujet', 'like', "%{$s}%")
              ->orWhere('contenu', 'like', "%{$s}%")
              ->orWhereHas('sender', function ($qq) use ($s) {
                  $qq->where('name', 'like', "%{$s}%")
                     ->orWhere('email', 'like', "%{$s}%");
              });
        });
    }

    // ✅ Status filter: unread / read
    if ($request->filled('status')) {
        if ($request->status === 'unread') {
            $query->where('is_read', false);
        } elseif ($request->status === 'read') {
            $query->where('is_read', true);
        }
    }

    // 📅 Date filter: today / week / month
    if ($request->filled('date')) {
        if ($request->date === 'today') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($request->date === 'week') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($request->date === 'month') {
            $query->where('created_at', '>=', now()->subDays(30));
        }
    }

    // Order: unread first, then newest
    $messages = $query
        ->orderBy('is_read')   // false (0) first
        ->latest()
        ->paginate(15)
        ->withQueryString();   // keep filters on pagination links

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

return redirect()->route('messages.sent')
    ->with('success', 'Message envoyé.');    }

    /**
     * Afficher un message.
     */


public function show(Message $message)
{
    $message->load([
        'sender', 'recipient',
        'attachments',              // if you have message attachments
        'replies.user',
        'replies.attachments',
    ]);

    if ($message->recipient_id === auth()->id() && !$message->is_read) {
        $message->update(['is_read' => true, 'read_at' => now()]);
    }

    return view('messages.show', compact('message'));
}




public function reply(Request $request, Message $message)
{
    // allow only sender or recipient to reply (optional but recommended)
    abort_if(!in_array(auth()->id(), [$message->user_id, $message->recipient_id]), 403);

    $validated = $request->validate([
        'contenu' => ['required', 'string'],
        'attachments' => ['nullable', 'array'],
        'attachments.*' => ['file', 'max:10240'],
    ]);

    DB::transaction(function () use ($request, $message, $validated) {

        $reply = $message->replies()->create([
            'user_id' => auth()->id(),
            'contenu' => $validated['contenu'],
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('reply_attachments', 'public');

                $reply->attachments()->create([
                    'user_id' => auth()->id(),
                    'disk' => 'public',
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }
    });

    return back()->with('success', 'Réponse envoyée.');
}


public function bulkMarkAsRead(Request $request)
{
    $data = $request->validate([
        'ids' => ['required', 'array'],
        'ids.*' => ['integer', 'exists:messages,id'],
    ]);

    Message::whereIn('id', $data['ids'])
        ->where('recipient_id', auth()->id()) // security: only your inbox
        ->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

    return response()->json(['success' => true]);
}

public function bulkDelete(Request $request)
{
    $data = $request->validate([
        'ids' => ['required', 'array'],
        'ids.*' => ['integer', 'exists:messages,id'],
    ]);

    // You can decide the rule: delete only if recipient OR sender.
    Message::whereIn('id', $data['ids'])
        ->where(function ($q) {
            $q->where('recipient_id', auth()->id())
              ->orWhere('user_id', auth()->id());
        })
        ->delete();

    return response()->json(['success' => true]);
}

public function markAsRead(Message $message)
{
    abort_if($message->recipient_id !== auth()->id(), 403);

    $message->update([
        'is_read' => true,
        'read_at' => now(),
    ]);

    // For your JS click handler you want JSON:
    return response()->json(['success' => true]);
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
