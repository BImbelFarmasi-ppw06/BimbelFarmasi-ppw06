<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DriveController extends Controller
{
    /**
     * Upload file ke Google Drive via API
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200', // Max 50MB
            'folder_id' => 'nullable|string',
        ]);

        try {
            $file = $request->file('file');
            $accessToken = $this->getAccessToken();
            
            if (!$accessToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Google Drive belum dikonfigurasi'
                ], 400);
            }

            // Upload file ke Google Drive
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'multipart/form-data',
            ])->attach(
                'file', 
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart', [
                'name' => $file->getClientOriginalName(),
                'parents' => $request->folder_id ? [$request->folder_id] : [],
            ]);

            if ($response->successful()) {
                $fileData = $response->json();
                
                return response()->json([
                    'success' => true,
                    'file_id' => $fileData['id'],
                    'file_name' => $fileData['name'],
                    'web_view_link' => "https://drive.google.com/file/d/{$fileData['id']}/view",
                    'message' => '✅ File berhasil diupload ke Google Drive'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal upload ke Google Drive: ' . $response->body()
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * List files dari Google Drive folder tertentu
     */
    public function listFiles(Request $request)
    {
        try {
            $folderId = $request->get('folder_id');
            $accessToken = $this->getAccessToken();
            
            if (!$accessToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Google Drive belum dikonfigurasi'
                ], 400);
            }

            $query = $folderId 
                ? "'{$folderId}' in parents and trashed=false"
                : "trashed=false";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get('https://www.googleapis.com/drive/v3/files', [
                'q' => $query,
                'fields' => 'files(id,name,mimeType,size,createdTime,webViewLink)',
                'orderBy' => 'createdTime desc',
                'pageSize' => 50,
            ]);

            if ($response->successful()) {
                $files = collect($response->json('files'))->map(function ($file) {
                    return [
                        'id' => $file['id'],
                        'name' => $file['name'],
                        'type' => $file['mimeType'],
                        'size' => $file['size'] ?? 0,
                        'created_at' => $file['createdTime'],
                        'link' => $file['webViewLink'] ?? "https://drive.google.com/file/d/{$file['id']}/view",
                    ];
                });

                return response()->json([
                    'success' => true,
                    'files' => $files
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil file dari Google Drive'
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get access token (simplified - seharusnya pakai OAuth flow)
     * Untuk implementasi lengkap, gunakan Service Account atau OAuth 2.0
     */
    private function getAccessToken()
    {
        // Opsi 1: Menggunakan API Key (read-only untuk public files)
        // Opsi 2: Menggunakan Service Account credentials
        // Opsi 3: OAuth 2.0 flow dengan refresh token
        
        // Sementara return null - perlu konfigurasi Service Account
        $serviceAccountPath = storage_path('app/google-drive/service-account.json');
        
        if (!file_exists($serviceAccountPath)) {
            return null;
        }

        // TODO: Implement proper OAuth flow atau Service Account authentication
        return null;
    }

    /**
     * Embed Google Drive file viewer
     */
    public function view($fileId)
    {
        return view('pages.drive-viewer', compact('fileId'));
    }
}
