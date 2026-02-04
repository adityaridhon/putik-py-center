// Warna untuk setiap kategori berdasarkan ID
export const getCategoryColor = (categoryId: number) => {
    const colors = {
        1: {
            badge: 'bg-blue-100 text-blue-700 hover:bg-blue-100/80',
            chart: '#3b82f6', // blue-500
        },
        2: {
            badge: 'bg-green-100 text-green-700 hover:bg-green-100/80',
            chart: '#22c55e', // green-500
        },
        3: {
            badge: 'bg-purple-100 text-purple-700 hover:bg-purple-100/80',
            chart: '#a855f7', // purple-500
        },
        4: {
            badge: 'bg-orange-100 text-orange-700 hover:bg-orange-100/80',
            chart: '#f97316', // orange-500
        },
        5: {
            badge: 'bg-pink-100 text-pink-700 hover:bg-pink-100/80',
            chart: '#ec4899', // pink-500
        },
    };

    return (
        colors[categoryId as keyof typeof colors] || {
            badge: 'bg-gray-100 text-gray-700 hover:bg-gray-100/80',
            chart: '#6b7280', // gray-500
        }
    );
};
