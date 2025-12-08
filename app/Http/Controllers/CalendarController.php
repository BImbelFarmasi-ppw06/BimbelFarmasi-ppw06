<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Tampilkan halaman jadwal bimbel dengan Google Calendar Embed
     */
    public function index()
    {
        // Untuk saat ini, gunakan Google Calendar Embed (iframe)
        // Nanti admin bisa tambah event langsung di Google Calendar
        
        $calendarId = env('GOOGLE_CALENDAR_ID');
        $apiKey = env('GOOGLE_CALENDAR_API_KEY');
        
        return view('pages.jadwal', compact('calendarId', 'apiKey'));
    }

    /**
     * API: Ambil events dari Google Calendar (public calendar)
     */
    public function getEvents()
    {
        try {
            $calendarId = env('GOOGLE_CALENDAR_ID');
            $apiKey = env('GOOGLE_CALENDAR_API_KEY');
            
            if (!$calendarId || !$apiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Calendar ID atau API Key belum dikonfigurasi'
                ], 400);
            }

            // Call Google Calendar API
            $response = Http::get("https://www.googleapis.com/calendar/v3/calendars/{$calendarId}/events", [
                'key' => $apiKey,
                'timeMin' => Carbon::now()->toRfc3339String(),
                'timeMax' => Carbon::now()->addDays(30)->toRfc3339String(),
                'singleEvents' => true,
                'orderBy' => 'startTime',
                'maxResults' => 50,
            ]);

            if ($response->successful()) {
                $events = collect($response->json('items'))->map(function ($event) {
                    return [
                        'id' => $event['id'] ?? '',
                        'title' => $event['summary'] ?? 'Tanpa Judul',
                        'description' => $event['description'] ?? '',
                        'start' => $event['start']['dateTime'] ?? $event['start']['date'] ?? '',
                        'end' => $event['end']['dateTime'] ?? $event['end']['date'] ?? '',
                        'location' => $event['location'] ?? '',
                        'link' => $event['htmlLink'] ?? '',
                    ];
                });

                return response()->json([
                    'success' => true,
                    'events' => $events
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari Google Calendar'
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
