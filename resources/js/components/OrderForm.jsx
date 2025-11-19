import React, { useState } from 'react';

const OrderForm = ({ program }) => {
    const [formData, setFormData] = useState({
        program_id: program?.id || '',
        notes: ''
    });
    const [loading, setLoading] = useState(false);

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        
        try {
            const form = e.target;
            form.submit();
        } catch (error) {
            console.error('Error submitting form:', error);
            setLoading(false);
        }
    };

    return (
        <div className="bg-white rounded-2xl shadow-xl p-6 sticky top-24">
            <h3 className="text-xl font-bold text-gray-900 mb-4">Form Pemesanan</h3>
            
            {program && (
                <div className="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-4 mb-6">
                    <p className="text-white text-sm mb-1">Total Pembayaran</p>
                    <p className="text-white text-3xl font-bold">
                        Rp {program.price?.toLocaleString('id-ID') || '0'}
                    </p>
                </div>
            )}
            
            <form onSubmit={handleSubmit} method="POST" action="/order">
                <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                <input type="hidden" name="program_id" value={formData.program_id} />
                
                <div className="mb-6">
                    <label htmlFor="notes" className="block text-sm font-semibold text-gray-700 mb-2">
                        Catatan (Opsional)
                    </label>
                    <textarea
                        id="notes"
                        name="notes"
                        value={formData.notes}
                        onChange={handleChange}
                        rows="4"
                        className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                        placeholder="Tambahkan catatan khusus untuk pesanan Anda..."
                    />
                </div>
                
                <div className="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div className="flex gap-3">
                        <svg className="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div className="text-sm">
                            <p className="font-semibold text-gray-900 mb-1">Informasi Pesanan</p>
                            <p className="text-gray-600">
                                Pesanan akan dikirim ke email: <span className="font-semibold">{window.userEmail || 'Anda'}</span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <button
                    type="submit"
                    disabled={loading}
                    className="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-4 rounded-xl hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    {loading ? (
                        <span className="flex items-center justify-center gap-2">
                            <svg className="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" fill="none"/>
                                <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                            </svg>
                            Memproses...
                        </span>
                    ) : (
                        <>
                            Lanjut ke Pembayaran
                            <svg className="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </>
                    )}
                </button>
                
                <div className="mt-6 pt-6 border-t">
                    <div className="flex items-center gap-3 text-sm text-gray-600">
                        <svg className="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Pembayaran Aman & Terpercaya</span>
                    </div>
                </div>
            </form>
        </div>
    );
};

export default OrderForm;
