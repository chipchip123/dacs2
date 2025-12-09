<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $users = User::withCount('orders')
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%$keyword%")
                      ->orWhere('email', 'LIKE', "%$keyword%")
                      ->orWhere('phone', 'LIKE', "%$keyword%");
                });
            })
            ->orderBy('user_id', 'DESC')
            ->paginate(10)
            ->appends($request->all());

        return view('admin.users.index', compact('users', 'keyword'));
    }

    // Gửi email tất cả khách hàng
    public function sendMailAll(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
        ]);

        $users = User::whereNotNull('email')->get();

        foreach ($users as $user) {
            Mail::raw($request->message, function ($mail) use ($user, $request) {
                $mail->to($user->email)
                     ->subject($request->subject);
            });
        }

        return back()->with('success', 'Đã gửi email đến tất cả khách hàng!');
    }

    // Gửi mail 1 người
    public function sendMailOne($id, Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
        ]);

        $user = User::findOrFail($id);

        if (!$user->email) {
            return back()->with('error', 'Khách hàng không có email!');
        }

        Mail::raw($request->message, function ($mail) use ($user, $request) {
            $mail->to($user->email)
                 ->subject($request->subject);
        });

        return back()->with('success', "Đã gửi email cho {$user->email}!");
    }
}
