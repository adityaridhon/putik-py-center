const fs = require('fs');
const path = require('path');

const filePath = path.join('c:', 'Users', 'acerr', 'putik-py-center', 'resources', 'js', 'components', 'UserDashboard.vue');
let code = fs.readFileSync(filePath, 'utf8');

const regex = /<div class="flex flex-col divide-y divide-gray-100">[\s\S]*?<\/div>\s*<\/section>/;
const replacement = `<div class="flex flex-col divide-y divide-gray-100">
                <div v-if="!riwayat || riwayat.length === 0" class="py-10 text-center text-gray-500">
                    Belum ada riwayat tes.
                </div>

                <div v-for="item in riwayat" :key="item.id" class="flex items-center justify-between gap-4 py-4">      
                    <div class="min-w-0">
                        <p
                            class="truncate text-base font-semibold text-gray-900"
                        >
                            {{ item.test_type }}
                        </p>
                        <p class="mt-0.5 text-sm text-gray-400">
                            {{ item.date }}
                        </p>
                    </div>
                    <div class="flex shrink-0 flex-col items-end gap-2">        
                        <span
                            :class="[
                                'rounded-full px-3 py-0.5 text-xs font-semibold',
                                item.raw_status === 'completed' || item.raw_status === 'reported' 
                                    ? 'bg-green-100 text-green-700' 
                                    : 'bg-yellow-100 text-yellow-700'
                            ]"
                        >{{ item.status }}</span>
                        <!-- Kalau report sudah ada, mungkin download link bisa diaktifkan -->
                        <Button v-if="item.has_pdf" size="sm" class="gap-1.5 text-xs">
                            <FileDown class="size-4" />
                            Unduh Hasil (PDF)
                        </Button>
                        <Button v-else-if="item.raw_status !== 'completed' && item.raw_status !== 'reported'" size="sm" variant="outline" class="text-xs">    
                            Proses
                        </Button>
                    </div>
                </div>
            </div>
        </section>`;

code = code.replace(regex, replacement);

fs.writeFileSync(filePath, code);
console.log('PATCHED HISTORY');
