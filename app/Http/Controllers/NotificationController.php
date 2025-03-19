<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();
        return view('notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user_request' => 'required|integer',
            'id_user_offer' => 'required|integer',
            'date_requested' => 'required|date',
            'read' => 'boolean',
            'type' => 'required|string',
            'id_type_request' => 'required|integer',
        ]);

        Notification::create($request->all());
        return redirect()->route('notifications.index')->with('success', 'Notification created successfully.');
    }

    public function show(Notification $notification)
    {
        return view('notifications.show', compact('notification'));
    }

    public function edit(Notification $notification)
    {
        return view('notifications.edit', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'id_user_request' => 'required|integer',
            'id_user_offer' => 'required|integer',
            'date_requested' => 'required|date',
            'read' => 'boolean',
            'type' => 'required|string',
            'id_type_request' => 'required|integer',
        ]);

        $notification->update($request->all());
        return redirect()->route('notifications.index')->with('success', 'Notification updated successfully.');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('notifications.index')->with('success', 'Notification deleted successfully.');
    }
}
