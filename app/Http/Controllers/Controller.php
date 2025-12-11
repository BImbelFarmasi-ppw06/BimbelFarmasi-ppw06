<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="BimbelFarmasi API Documentation",
 *     version="1.0.0",
 *     description="API Documentation untuk platform Bimbel Farmasi. Platform bimbingan belajar online untuk persiapan UKOM, CPNS & P3K Kefarmasian.",
 *     @OA\Contact(
 *         email="bimbelfarmasi@gmail.com",
 *         name="BimbelFarmasi Support"
 *     ),
 *     @OA\License(
 *         name="MIT License",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Local Development Server"
 * )
 *
 * @OA\Server(
 *     url="https://api.bimbelfarmasi.com",
 *     description="Production Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter token in format: Bearer {token}"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="Endpoints untuk register, login, dan logout user"
 * )
 *
 * @OA\Tag(
 *     name="User",
 *     description="Endpoints untuk mengelola profil user"
 * )
 *
 * @OA\Tag(
 *     name="Programs",
 *     description="Endpoints untuk melihat dan mengakses program bimbingan"
 * )
 *
 * @OA\Tag(
 *     name="Orders",
 *     description="Endpoints untuk membuat dan melihat pesanan"
 * )
 *
 * @OA\Tag(
 *     name="Payments",
 *     description="Endpoints untuk upload bukti pembayaran"
 * )
 *
 * @OA\Tag(
 *     name="Testimonials",
 *     description="Endpoints untuk mengelola testimoni user"
 * )
 *
 * @OA\Tag(
 *     name="Contact",
 *     description="Endpoint untuk mengirim pesan kontak"
 * )
 */
abstract class Controller
{
    //
}

// buat fungsi untuk menghitung rata-rata nilai


