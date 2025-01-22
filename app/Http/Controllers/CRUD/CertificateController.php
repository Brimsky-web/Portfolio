<?php

namespace App\Http\Controllers\CRUD;

use App\Models\Certificates;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CertificateController
{
    public function create()
    {
        return Inertia::render('Admin/Certificates');
    }

    public function store(Request $request)
    {
        $certificate = new Certificates();
        $certificate->certificate_name = $request->certificate_name;
        $certificate->provider = $request->provider;
        $certificate->url = $request->url;
        $certificate->date = $request->date;
        $certificate->save();

        return redirect('/admin');
    }

    public function edit($id)
    {
        $certificate = Certificates::find($id);
        return Inertia::render('Admin/Certificates', [
            'certificate' => [
                'id' => $certificate->id,
                'certificate_name' => $certificate->certificate_name,
                'provider' => $certificate->provider,
                'url' => $certificate->url,
                'date' => $certificate->date,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $certificate = Certificates::find($id);
        $certificate->certificate_name = $request->certificate_name;
        $certificate->save();

        return redirect('/admin');
    }

    public function destroy($id)
    {
        $certificate = Certificates::find($id);
        $certificate->delete();

        return redirect('/admin');
    }
}
