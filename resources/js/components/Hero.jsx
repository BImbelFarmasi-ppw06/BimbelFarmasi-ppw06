import React from 'react';

const Hero = () => {
    return (
        <section className="relative bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20">
            <div className="container mx-auto px-4">
                <div className="max-w-4xl mx-auto text-center">
                    <h1 className="text-5xl md:text-6xl font-bold mb-6 animate-fade-in">
                        Bimbel Farmasi Terpercaya
                    </h1>
                    <p className="text-xl md:text-2xl mb-8 opacity-90">
                        Persiapan UKOM, CPNS, dan P3K untuk Apoteker & Tenaga Teknis Kefarmasian
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                        <a 
                            href="#program" 
                            className="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-blue-50 transition-all transform hover:scale-105"
                        >
                            Lihat Program
                        </a>
                        <a 
                            href="/register" 
                            className="bg-transparent border-2 border-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-all"
                        >
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default Hero;
