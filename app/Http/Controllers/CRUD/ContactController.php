<?php

namespace App\Http\Controllers\CRUD;

use App\Models\Contacts;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController
{
    public function create()
    {
        return Inertia::render('Admin/Contacts');
    }

    public function store(Request $request)
    {
        $contact = new Contacts();
        $contact->platform = $request->platform;
        $contact->url = $request->url;
        $contact->icon = $request->icon;
        $contact->save();

        return redirect('/admin');
    }

    public function edit($id)
    {
        $contact = Contacts::find($id);
        return Inertia::render('Admin/Contacts', [
            'contact' => [
                'id' => $contact->id,
                'platform' => $contact->platform,
                'url' => $contact->url,
                'icon' => $contact->icon,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $contact = Contacts::find($id);
        $contact->platform = $request->platform;
        $contact->url = $request->url;
        $contact->icon = $request->icon;
        $contact->save();

        return redirect('/admin');
    }

    public function destroy($id)
    {
        $contact = Contacts::find($id);
        $contact->delete();

        return redirect('/admin');
    }
}
