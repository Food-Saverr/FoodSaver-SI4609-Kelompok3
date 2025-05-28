<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use App\Models\ForumComment;
use App\Models\ForumAttachment;
use App\Models\ForumReport;
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
        $postId = $attachment->ID_ForumPost;

        Storage::disk('public')->delete($attachment->path);
        $attachment->delete();

        // Jika request minta JSON (AJAX), baru balas JSON
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }

        // Kalau form biasa (tidak AJAX), redirect balik ke show
        return redirect()
            ->route('admin.forum.show', $postId)
            ->with('success', 'Lampiran berhasil dihapus!');
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
    public function reportIndex(Request $request)
    {
        $query = ForumReport::with(['post', 'reporter', 'admin']);

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->whereHas('post', function($q) use ($searchTerm) {
                $q->where('judul', 'like', "%{$searchTerm}%");
            })->orWhereHas('reporter', function($q) use ($searchTerm) {
                $q->where('Nama_Pengguna', 'like', "%{$searchTerm}%");
            });
        }

        // Handle status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Handle reason filter
        if ($request->has('reason') && !empty($request->reason)) {
            $query->where('alasan_laporan', $request->reason);
        }

        // Handle sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
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

        $reports = $query->paginate(15);

        // Get statistics for the dashboard
        $totalReports = ForumReport::count();
        $pendingReports = ForumReport::where('status', 'pending')->count();
        $actionedReports = ForumReport::where('status', 'actioned')->count();
        $rejectedReports = ForumReport::where('status', 'rejected')->count();
        
        // Get counts by reason
        $reportsByReason = ForumReport::selectRaw('alasan_laporan, count(*) as count')
            ->groupBy('alasan_laporan')
            ->get()
            ->pluck('count', 'alasan_laporan')
            ->toArray();

        // Preserve query parameters in pagination links
        if ($request->has(['search', 'sort', 'status', 'reason'])) {
            $reports->appends($request->only(['search', 'sort', 'status', 'reason']));
        }

        return view('admin.forum.reports.index', compact(
            'reports', 
            'totalReports', 
            'pendingReports', 
            'actionedReports', 
            'rejectedReports',
            'reportsByReason'
        ));
    }

    /**
     * Display the specified report details.
     */
    public function reportShow($id)
    {
        $report = ForumReport::with([
            'post', 
            'post.pengguna',
            'post.comments', 
            'post.attachments',
            'reporter',
            'admin'
        ])->findOrFail($id);
        
        // Get other reports for this post
        $otherReports = ForumReport::where('ID_ForumPost', $report->ID_ForumPost)
            ->where('ID_Report', '!=', $id)
            ->with('reporter')
            ->get();

        return view('admin.forum.reports.show', compact('report', 'otherReports'));
    }

    /**
     * Update the status of a report.
     */
    public function reportUpdate(Request $request, $id)
    {
        $report = ForumReport::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,reviewed,rejected,actioned',
            'admin_notes' => 'nullable|string|max:1000',
            'action' => 'nullable|in:none,hide_post,delete_post,warn_user,ban_user',
        ]);
        
        // Update report
        $report->status = $request->status;
        $report->admin_notes = $request->admin_notes;
        $report->ID_Admin = Auth::id();
        $report->handled_at = now();
        $report->save();
        
        // Perform action based on admin's decision if status is actioned
        if ($request->status === 'actioned' && $request->has('action')) {
            $post = $report->post;
            
            switch ($request->action) {
                case 'hide_post':
                    // Mark post as hidden/reported
                    $post->is_reported = true;
                    $post->save();
                    break;
                    
                case 'delete_post':
                    // Soft delete the post
                    $post->delete();
                    
                    // Update other reports about this post
                    ForumReport::where('ID_ForumPost', $post->ID_ForumPost)
                        ->where('status', 'pending')
                        ->update([
                            'status' => 'actioned',
                            'admin_notes' => 'Post deleted due to violations',
                            'ID_Admin' => Auth::id(),
                            'handled_at' => now()
                        ]);
                    break;
                    
                case 'warn_user':
                    // TODO: Implement warning system for users
                    // This would typically create a warning record and possibly send an email/notification
                    
                    // For now, we'll just make a note
                    $report->admin_notes .= "\n(User warning has been issued)";
                    $report->save();
                    break;
                    
                case 'ban_user':
                    // TODO: Implement ban functionality
                    // This would typically update user status and possibly send an email/notification
                    
                    // For now, we'll just make a note
                    $report->admin_notes .= "\n(User ban has been initiated)";
                    $report->save();
                    break;
            }
        }
        
        Alert::success('Berhasil', 'Status laporan berhasil diperbarui');
        return redirect()->back();
    }

    /**
     * Remove a report from system.
     */
    public function reportDestroy($id)
    {
        $report = ForumReport::findOrFail($id);
        $report->delete();
        
        Alert::success('Berhasil', 'Laporan berhasil dihapus dari sistem');
        return redirect()->route('admin.forum.reports');
    }
}