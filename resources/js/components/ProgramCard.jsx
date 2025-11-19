import React, { useState, useEffect } from 'react';

const ProgramCard = () => {
    const [programs, setPrograms] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchPrograms();
    }, []);

    const fetchPrograms = async () => {
        try {
            // Mock data - replace with actual API call
            const mockPrograms = [
                {
                    id: 1,
                    name: 'Bimbel UKOM D3 Farmasi',
                    slug: 'bimbel-ukom-d3-farmasi',
                    type: 'bimbel',
                    description: 'Program persiapan UKOM dengan materi lengkap dan try out berkala',
                    price: 1250000,
                    duration_months: 3,
                    features: [
                        'Materi lengkap sesuai kisi-kisi',
                        'Try out mingguan',
                        'Konsultasi mentor',
                        'Bank soal 1000+'
                    ]
                },
                {
                    id: 2,
                    name: 'CPNS & P3K Farmasi',
                    slug: 'cpns-p3k-farmasi',
                    type: 'cpns',
                    description: 'Persiapan lengkap CPNS dan P3K bidang farmasi',
                    price: 2050000,
                    duration_months: 4,
                    features: [
                        'Materi TWK, TIU, TKP',
                        'Try out CAT system',
                        'Pembahasan interaktif',
                        'Update info terbaru'
                    ]
                },
                {
                    id: 3,
                    name: 'Joki Tugas Farmasi',
                    slug: 'joki-tugas-farmasi',
                    type: 'joki',
                    description: 'Bantuan pengerjaan tugas farmasi oleh ahli',
                    price: 150000,
                    duration_months: 0,
                    features: [
                        'Dikerjakan ahli farmasi',
                        'Revisi gratis',
                        'Pengerjaan cepat',
                        'Konsultasi gratis'
                    ]
                }
            ];
            
            setPrograms(mockPrograms);
            setLoading(false);
        } catch (error) {
            console.error('Error fetching programs:', error);
            setLoading(false);
        }
    };

    if (loading) {
        return (
            <div className="text-center py-12">
                <div className="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent"></div>
            </div>
        );
    }

    return (
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {programs.map((program) => (
                <div 
                    key={program.id}
                    className="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all transform hover:-translate-y-2"
                >
                    <div className="p-6">
                        <div className="flex items-center justify-between mb-4">
                            <span className="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                {program.type.toUpperCase()}
                            </span>
                            {program.duration_months > 0 && (
                                <span className="text-sm text-gray-600">
                                    {program.duration_months} Bulan
                                </span>
                            )}
                        </div>
                        
                        <h3 className="text-xl font-bold text-gray-900 mb-2">
                            {program.name}
                        </h3>
                        
                        <p className="text-gray-600 mb-4">
                            {program.description}
                        </p>
                        
                        <ul className="space-y-2 mb-6">
                            {program.features.map((feature, index) => (
                                <li key={index} className="flex items-start gap-2 text-sm text-gray-700">
                                    <svg className="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {feature}
                                </li>
                            ))}
                        </ul>
                        
                        <div className="border-t pt-4">
                            <div className="flex items-center justify-between mb-4">
                                <span className="text-2xl font-bold text-blue-600">
                                    Rp {program.price.toLocaleString('id-ID')}
                                </span>
                            </div>
                            
                            <a 
                                href={`/order/${program.slug}`}
                                className="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors"
                            >
                                Beli Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            ))}
        </div>
    );
};

export default ProgramCard;
