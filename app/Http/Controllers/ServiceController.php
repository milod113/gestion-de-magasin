<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{


public function index(Request $request)
{
    // per_page (10/25/50/100)
    $perPage = (int) $request->input('per_page', 10);
    $perPage = in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 10;

    $search       = trim((string) $request->input('search', ''));       // quick search
    $code         = trim((string) $request->input('code', ''));         // code filter
    $serviceFr    = trim((string) $request->input('service_fr', ''));   // FR filter
    $serviceArab  = trim((string) $request->input('service_arab', '')); // AR filter
    $sort         = (string) $request->input('sort', 'created_at_desc');

    $query = Service::query();

    // Quick search: applies to code + fr + arab (matches your quick search box)
    if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where('code_service', 'like', "%{$search}%")
              ->orWhere('service_fr', 'like', "%{$search}%")
              ->orWhere('service_arab', 'like', "%{$search}%");
        });
    }

    // Dedicated filters (matches filter section)
    if ($code !== '') {
        $query->where('code_service', 'like', "%{$code}%");
    }
    if ($serviceFr !== '') {
        $query->where('service_fr', 'like', "%{$serviceFr}%");
    }
    if ($serviceArab !== '') {
        $query->where('service_arab', 'like', "%{$serviceArab}%");
    }

    // Sorting (matches <select name="sort"> in blade)
    switch ($sort) {
        case 'code_asc':
            $query->orderBy('code_service', 'asc');
            break;
        case 'code_desc':
            $query->orderBy('code_service', 'desc');
            break;

        case 'service_fr_asc':
            $query->orderBy('service_fr', 'asc');
            break;
        case 'service_fr_desc':
            $query->orderBy('service_fr', 'desc');
            break;

        case 'service_arab_asc':
            $query->orderBy('service_arab', 'asc');
            break;
        case 'service_arab_desc':
            $query->orderBy('service_arab', 'desc');
            break;

        case 'created_at_asc':
            $query->orderBy('created_at', 'asc');
            break;

        case 'created_at_desc':
        default:
            $query->orderBy('created_at', 'desc');
            break;
    }

    // Secondary stable sort (optional, helps when created_at is same)
    $query->orderBy('id_service', 'desc');

    $services = $query
        ->paginate($perPage)
        ->appends($request->query()); // keep filters for pagination links

    return view('admin.service.index', compact('services'));
}


    public function create()
    {
        return view('admin.service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_arab' => 'required|string|max:255',
            'service_fr' => 'required|string|max:255',
            'code_service' => 'required|string|max:20|unique:services,code_service',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service ajouté avec succès.');
    }

    public function edit(Service $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service_arab' => 'required|string|max:255',
            'service_fr' => 'required|string|max:255',
            'code_service' => 'required|string|max:20|unique:services,code_service,' . $service->id_service,
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service mis à jour avec succès.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service supprimé avec succès.');
    }
}
