<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ImageUploadService
{
    /**
     * Envía una imagen recibida a la API externa de almacenamiento
     * y retorna la URL pública HTTPS devuelta por la API para guardarse en la BD.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string|null
     */
    public static function uploadImage($file)
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        $apiKey = config('services.imgbb.api_key') ?? env('IMGBB_API_KEY');

        // 1. Intento con ImgBB API si se proveyó clave válida en .env
        if (!empty($apiKey) && $apiKey !== 'tu_imgbb_api_key_aqui') {
            try {
                $base64Image = base64_encode(file_get_contents($file->getRealPath()));
                $response = Http::timeout(25)->asForm()->post("https://api.imgbb.com/1/upload?key={$apiKey}", [
                    'image' => $base64Image,
                ]);

                if ($response->successful() && $response->json('data.url')) {
                    return $response->json('data.url');
                }
            } catch (Exception $e) {
                Log::warning('Fallo en ImgBB, usando servidor de respaldo: ' . $e->getMessage());
            }
        }

        // 2. Servidor de API Externa de Almacenamiento Directo (TmpFiles API)
        try {
            $response = Http::timeout(25)->attach(
                'file',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->post('https://tmpfiles.org/api/v1/upload');

            if ($response->successful() && $response->json('data.url')) {
                $rawUrl = $response->json('data.url');
                // Convierte la URL a enlace de descarga/visualización pública directa
                return str_replace('tmpfiles.org/', 'tmpfiles.org/dl/', $rawUrl);
            }

            Log::error('Error en API Externa de imágenes: ' . $response->body());
            return null;
        } catch (Exception $e) {
            Log::error('Excepción al conectar con la API de imágenes: ' . $e->getMessage());
            return null;
        }
    }
}
