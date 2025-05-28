<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use App\Models\ForumComment;
use App\Models\ForumAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class AdminForumController extends Controller
{
    /**
     * Display a listing of all forum posts.
     */
    public function index(Request $request)
    {
        $query = ForumPost::with(['pengguna:ID_Pengguna,Nama_Pengguna,Email_Pengguna,Role_Pengguna', 'attachments'])
            ->withCount(['comments', 'likes']);

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul', 'like', "%{$searchTerm}%")
                  ->orWhere('konten', 'like', "%{$searchTerm}%");
            });
        }

        // Handle role filter
        if ($request->has('role') && !empty($request->role)) {
            $query->whereHas('pengguna', function($q) use ($request) {
                $q->where('Role_Pengguna', $request->role);
            });
        }

        // Handle status filter (deleted or not)
        if ($request->has('status')) {
            if ($request->status == 'deleted') {
                $query->onlyTrashed();
            } elseif ($request->status == 'active') {
                $query->withoutTrashed();
            }
        }

        // Handle sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popular':
                    $query->orderBy('likes_count', 'desc');
                    break;
                case 'most_comments':
                    $query->orderBy('comments_count', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
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

        $posts = $query->paginate(15);

        // Get statistics for the dashboard
        $totalPosts = ForumPost::count();
        $totalComments = ForumComment::count();
        $totalAttachments = ForumAttachment::count();
        $deletedPosts = ForumPost::onlyTrashed()->count();

        // Top posters
        $topPosters = \App\Models\Pengguna::withCount('forumPosts')
            ->having('forum_posts_count', '>', 0)
            ->orderBy('forum_posts_count', 'desc')
            ->limit(5)
            ->get(['ID_Pengguna', 'Nama_Pengguna', 'Role_Pengguna', 'forum_posts_count']);

        // Preserve query parameters in pagination links
        if ($request->has(['search', 'sort', 'role', 'status'])) {
            $posts->appends($request->only(['search', 'sort', 'role', 'status']));
        }

        return view('admin.forum.index', compact(
            'posts', 
            'totalPosts', 
            'totalComments', 
            'totalAttachments', 
            'deletedPosts',
            'topPosters'
        ));
    }

    /**
     * Display the specified forum post details.
     */
    public function show($id)
    {
        $post = ForumPost::with([
            'pengguna',
            'attachments',
            'comments' => function($query) {
                $query->orderBy('created_at', 'asc');
            },
            'comments.pengguna',
            'likes.pengguna'
        ])->withTrashed()->findOrFail($id);

        // Get previous and next post for navigation
        $previousPost = ForumPost::where('ID_ForumPost', '<', $id)->orderBy('ID_ForumPost', 'desc')->first();
        $nextPost = ForumPost::where('ID_ForumPost', '>', $id)->orderBy('ID_ForumPost', 'asc')->first();

        return view('admin.forum.show', compact('post', 'previousPost', 'nextPost'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit($id)
    {
        $post = ForumPost::with('attachments')->withTrashed()->findOrFail($id);
        return view('admin.forum.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, $id)
    {
        $post = ForumPost::withTrashed()->findOrFail($id);

        // Log the request data for debugging purposes
        Log::info('Forum update request data:', [
            'all' => $request->all(),
            'judul' => $request->judul,
            'konten_length' => strlen($request->konten ?? ''),
            'has_konten' => $request->has('konten')
        ]);

        // Memvalidasi request
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'attachments.*' => 'nullable|file|max:10240', // Max 10MB per file
        ]);

        // Directly update the post with validated data
        $post->judul = $validated['judul'];
        $post->konten = $validated['konten'];
        $post->save();
        
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

        // Handle post restoration if it was deleted
        if ($post->trashed() && $request->has('restore') && $request->restore) {
            $post->restore();
            Alert::success('Berhasil', 'Postingan forum berhasil dipulihkan dan diperbarui!');
        } else {
            Alert::success('Berhasil', 'Postingan forum berhasil diperbarui!');
        }

        return redirect()->route('admin.forum.show', $post->ID_ForumPost);
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy($id)
    {
        $post = ForumPost::withTrashed()->findOrFail($id);

        // Check if post is already deleted and permanent delete is requested
        if ($post->trashed() && request()->has('permanent')) {
            // Permanently delete attachments from storage
            foreach ($post->attachments as $attachment) {
                Storage::disk('public')->delete($attachment->path);
                $attachment->delete();
            }
            
            // Delete comments
            $post->comments()->forceDelete();
            
            // Delete likes
            $post->likes()->delete();
            
            // Permanently delete post
            $post->forceDelete();
            
            Alert::success('Berhasil', 'Postingan forum berhasil dihapus secara permanen!');
        } 
        // Soft delete if not already deleted
        elseif (!$post->trashed()) {
            $post->delete();
            Alert::warning('Berhasil', 'Postingan forum berhasil dihapus! Anda dapat memulihkannya nanti.');
        }

        return redirect()->route('admin.forum.index');
    }

    /**
     * Restore a soft deleted post
     */
    public function restore($id)
    {
        $post = ForumPost::withTrashed()->findOrFail($id);
        
        if ($post->trashed()) {
            $post->restore();
            Alert::success('Berhasil', 'Postingan forum berhasil dipulihkan!');
        } else {
            Alert::info('Info', 'Postingan ini tidak dalam status terhapus.');
        }
        
        return redirect()->route('admin.forum.show', $post->ID_ForumPost);
    }

    /**
     * Delete a comment
     */
    public function deleteComment($commentId)
    {
        $comment = ForumComment::withTrashed()->findOrFail($commentId);
        $postId = $comment->ID_ForumPost;

        if ($comment->trashed() && request()->has('permanent')) {
            $comment->forceDelete();
            Alert::success('Berhasil', 'Komentar berhasil dihapus permanen!');
        } else {
            $comment->delete();
            Alert::warning('Berhasil', 'Komentar berhasil dihapus!');
        }

        return redirect()->back();
    }

    /**
     * Delete an attachment
     */
    public function deleteAttachment($attachmentId)
    {
        $attachment = ForumAttachment::findOrFail($attachmentId);
        
        Storage::disk('public')->delete($attachment->path);
        $attachment->delete();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Download an attachment
     */
    public function downloadAttachment($attachmentId)
    {
        $attachment = ForumAttachment::findOrFail($attachmentId);
        $path = storage_path('app/public/' . $attachment->path);
        
        if (file_exists($path)) {
            return response()->download($path, $attachment->nama_file);
        }
        
        Alert::error('Error', 'File tidak ditemukan');
        return redirect()->back();
    }
}