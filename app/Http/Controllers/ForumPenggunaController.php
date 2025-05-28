<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumComment;
use App\Models\ForumLike;
use App\Models\ForumAttachment;
use App\Models\ForumReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ForumPenggunaController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index(Request $request)
    {
        $query = ForumPost::with(['pengguna:ID_Pengguna,Nama_Pengguna,Email_Pengguna', 'attachments'])
            ->withCount(['comments', 'likes']);

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul', 'like', "%{$searchTerm}%")
                  ->orWhere('konten', 'like', "%{$searchTerm}%");
            });
        }

        // Handle sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popular':
                    $query->withCount('likes')->orderBy('likes_count', 'desc');
                    break;
                case 'most_comments':
                    $query->withCount('comments')->orderBy('comments_count', 'desc');
                    break;
                case 'latest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default sorting
            $query->orderBy('created_at', 'desc');
        }

        $posts = $query->paginate(10);

        // Preserve query parameters in pagination links
        if ($request->has(['search', 'sort'])) {
            $posts->appends($request->only(['search', 'sort']));
        }

        return view('pengguna.forum.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('pengguna.forum.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'attachments.*' => 'nullable|file|max:10240', // Max 10MB per file
        ]);

        $post = ForumPost::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'ID_Pengguna' => Auth::id(),
        ]);

        // Handle attachments if any
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('forum_attachments', $filename, 'public');

                ForumAttachment::create([
                    'ID_ForumPost' => $post->ID_ForumPost,
                    'nama_file' => $file->getClientOriginalName(),
                    'path' => $path,
                    'tipe_file' => $file->getMimeType(),
                    'ukuran' => $file->getSize(),
                ]);
            }
        }

        Alert::success('Berhasil', 'Postingan forum berhasil dibuat!');
        return redirect()->route('pengguna.forum.show', $post->ID_ForumPost);
    }

    /**
     * Display the specified post.
     */
    public function show($id)
    {
        $post = ForumPost::with([
            'pengguna',
            'attachments',
            'comments' => function($query) {
                $query->orderBy('created_at', 'asc');
            },
            'comments.pengguna'
        ])->findOrFail($id);

        $isLiked = false;
        if (Auth::check()) {
            $isLiked = $post->isLikedByUser(Auth::id());
        }

        return view('pengguna.forum.show', compact('post', 'isLiked'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit($id)
    {
        $post = ForumPost::with('attachments')->findOrFail($id);

        // Check if user is authorized to edit this post
        if ($post->ID_Pengguna != Auth::id()) {
            Alert::error('Error', 'Anda tidak berhak mengedit postingan ini!');
            return redirect()->back();
        }

        return view('pengguna.forum.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, $id)
    {
        $post = ForumPost::findOrFail($id);

        // Check if user is authorized to update this post
        if ($post->ID_Pengguna != Auth::id()) {
            Alert::error('Error', 'Anda tidak berhak mengupdate postingan ini!');
            return redirect()->back();
        }

        $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'attachments.*' => 'nullable|file|max:10240', // Max 10MB per file
        ]);

        $post->update([
            'judul' => $request->judul,
            'konten' => $request->konten,
        ]);

        // Handle attachments if any
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('forum_attachments', $filename, 'public');

                ForumAttachment::create([
                    'ID_ForumPost' => $post->ID_ForumPost,
                    'nama_file' => $file->getClientOriginalName(),
                    'path' => $path,
                    'tipe_file' => $file->getMimeType(),
                    'ukuran' => $file->getSize(),
                ]);
            }
        }

        // Handle deleted attachments
        if ($request->has('deleted_attachments')) {
            $attachmentsToDelete = ForumAttachment::whereIn('ID_Attachment', $request->deleted_attachments)
                ->where('ID_ForumPost', $post->ID_ForumPost)
                ->get();

            foreach ($attachmentsToDelete as $attachment) {
                Storage::disk('public')->delete($attachment->path);
                $attachment->delete();
            }
        }

        Alert::success('Berhasil', 'Postingan forum berhasil diperbarui!');
        return redirect()->route('pengguna.forum.show', $post->ID_ForumPost);
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy($id)
    {
        $post = ForumPost::findOrFail($id);

        // Check if user is authorized to delete this post
        if ($post->ID_Pengguna != Auth::id()) {
            Alert::error('Error', 'Anda tidak berhak menghapus postingan ini!');
            return redirect()->back();
        }

        // Delete attachments from storage
        foreach ($post->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->path);
        }

        $post->delete();

        Alert::success('Berhasil', 'Postingan forum berhasil dihapus!');
        return redirect()->route('pengguna.forum.index');
    }

    /**
     * Add comment to a post
     */
    public function addComment(Request $request, $postId)
    {
        $request->validate([
            'konten' => 'required',
        ]);

        ForumComment::create([
            'ID_ForumPost' => $postId,
            'ID_Pengguna' => Auth::id(),
            'konten' => $request->konten,
        ]);

        Alert::success('Berhasil', 'Komentar berhasil ditambahkan!');
        return redirect()->back();
    }

    /**
     * Toggle like/unlike for a post
     */
    public function toggleLike(Request $request, $postId)
    {
        if (!Auth::check()) {
            // Jika user tidak login, return error (AJAX atau redirect)
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'isLiked' => false,
                    'likeCount' => ForumPost::find($postId)->likeCount(),
                ], 401);
            }
            Alert::error('Error', 'Anda harus login untuk melakukan aksi ini!');
            return redirect()->route('login');
        }

        $post = ForumPost::findOrFail($postId);
        $userId = Auth::id();

        // Cek apakah sudah pernah like
        $existingLike = ForumLike::where('ID_ForumPost', $postId)
            ->where('ID_Pengguna', $userId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $message = 'Post unliked';
            $isLiked = false;
        } else {
            ForumLike::create([
                'ID_ForumPost' => $postId,
                'ID_Pengguna' => $userId,
            ]);
            $message = 'Post liked';
            $isLiked = true;
        }

        // Pastikan return response JSON jika request AJAX
        if ($request->ajax()) {
            return response()->json([
                'message' => $message,
                'isLiked' => $isLiked,
                'likeCount' => $post->fresh()->likeCount(),
            ]);
        }

        return redirect()->back();
    }

    /**
     * Delete a comment
     */
    public function deleteComment($commentId)
    {
        $comment = ForumComment::findOrFail($commentId);

        // Check if user is authorized to delete this comment
        if ($comment->ID_Pengguna != Auth::id()) {
            Alert::error('Error', 'Anda tidak berhak menghapus komentar ini!');
            return redirect()->back();
        }

        $comment->delete();

        Alert::success('Berhasil', 'Komentar berhasil dihapus!');
        return redirect()->back();
    }

    /**
     * Delete an attachment
     */
    public function deleteAttachment($attachmentId)
    {
        $attachment = ForumAttachment::findOrFail($attachmentId);
        $post = $attachment->post;

        // Check if user is authorized to delete this attachment
        if ($post->ID_Pengguna != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($attachment->path);
        $attachment->delete();

        return response()->json(['success' => true]);
    }

    public function reportPost(Request $request, $postId)
    {
        // Validate request
        $request->validate([
            'alasan_laporan' => 'required|string',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $post = ForumPost::findOrFail($postId);
        $userId = Auth::id();

        // Check if user has already reported this post
        if ($post->isReportedByUser($userId)) {
            Alert::warning('Peringatan', 'Anda sudah melaporkan postingan ini sebelumnya.');
            return redirect()->back();
        }

        // Create a new report
        ForumReport::create([
            'ID_ForumPost' => $postId,
            'ID_Pengguna' => $userId,
            'alasan_laporan' => $request->alasan_laporan,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
        ]);

        Alert::success('Berhasil', 'Laporan Anda telah dikirim dan akan ditinjau oleh moderator.');
        return redirect()->back();
    }
}