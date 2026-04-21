<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client; // Sesuaikan dengan namespace model kamu

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => 'PT. Angkasa Pura Logistics',
                'location' => 'Balikpapan',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/c/ca/Logo_Angkasa_Pura_Logistik.png',
            ],
            [
                'name' => 'PT. Antanmitra Sempada',
                'location' => 'Jakarta & Balikpapan',
                'logo' => 'https://ams.co.id/com/images/ams/logo.png',
            ],
            [
                'name' => 'PT. Asuransi Bringin Sejahtera Artamakmur',
                'location' => 'Balikpapan',
                'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnykNkDMI1C2Qsd3f2FYki1-HGrnc6XFSZ9g&s',
            ],
            [
                'name' => 'PT. Asuransi Tit Pakarta',
                'location' => 'Jakarta & Balikpapan',
                'logo' => 'https://tripakarta.co.id/img/logo2.png',
            ],
            [
                'name' => 'PT. Arkananta',
                'location' => 'Balikpapan',
                'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRyf4ZmrUFRNlyv_n2SAbc-MVF8W7yscssUpA&s',
            ],
            [
                'name' => 'PT. Bank Danamon Indonesia, Tbk',
                'location' => 'Balikpapan',
                'logo' => 'https://travellin.co.id/Files/Agents/4e2838f3-be3b-40ea-b242-85e423c83da1.png',
            ],
            [
                'name' => 'PT. Bank PANIN, Tbk',
                'location' => 'Balikpapan',
                'logo' => 'https://commons.wikimedia.org/wiki/File:Logo_Panin_Bank.svg',
            ],
            [
                'name' => 'PT. Bank Syariah Indonesia Tbk',
                    'location' => 'Balikpapan',
                    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Bank_Syariah_Indonesia.svg/960px-Bank_Syariah_Indonesia.svg.png',
            ],
            [
                'name' => 'PT. Cahaya Fajar Kaltim',
                'location' => 'Balikpapan',
                'logo' => 'https://media.licdn.com/dms/image/v2/C560BAQFtd7oO_FN_fg/company-logo_200_200/company-logo_200_200/0/1637821015099?e=2147483647&v=beta&t=aD3IGeEW9eP3JLNiwXnM6OoTG8jeTRse9rZ-GMNPTJk',
            ],
            [
                'name' => 'Bank BTPN',
                'location' => 'Balikpapan',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Logo_of_Bank_BTPN.svg/1280px-Logo_of_Bank_BTPN.svg.png',
            ],
            [
                'name' => 'PT. BUMA',
                'location' => 'Jakarta',
                'logo' => 'https://lokerbumn.com/wp-content/uploads/2024/06/PT-Bukit-Makmur-Mandiri-Utama-BUMA-02.jpg',
            ],
            [
                'name' => 'PT. Cakra Jawara',
                'location' => 'Balikpapan',
                'logo' => 'rengrypted-tbnam.com/images/carton AΝΙΩΣ TOPOBFPV NAVEEDIONIKAMPONG283XBA',
            ],
            [
                'name' => 'PT. Cipta Krida Bahari',
                'location' => 'Jakarta & Balikpapan',
                'logo' => 'https://www.ckb.co.id/site/uploads/newspage/5a6806e4c9aa0-news-img-none.jpg',
            ],
            [
                'name' => 'COMBIPHAR',
                'location' => 'Balikpapan',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Combiphar.svg/1280px-Combiphar.svg.png',
            ],
            [
                'name' => 'Dinas Komunikasi & Informatika',
                'location' => 'Prov. Kaltim',
                'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT1notMiIIsOZyozm_1N0Y8S63BQVWnk9al_Q&s',
            ],
            [
                'name' => 'ERHA Klinik',
                'location' => 'Balikpapan',
                'logo' => 'https://erha.co.id/assets/frontend/assets/logo.png',
            ],
            [
                'name' => 'PT. Persada Palembang Ratya',
                'location' => 'Jakarta',
                'logo' => 'https://media.licdn.com/dms/image/v2/C560BAQExzQ3QeyFYig/company-logo_200_200/company-logo_200_200/0/1631358482227?e=2147483647&v=beta&t=9nLqBkguj9yar11wDRmREwPWai_IFP5d41_e-XP92m0',
            ],
            [
                'name' => 'PT. Hiliconjaya Sakti',
                'location' => 'Jakarta',
                'logo' => 'https://www.hillcon.co.id/images/logo-hc.png',
            ],
            [
                'name' => 'PT. Haneagle',
                'location' => 'Balikpapan',
                'logo' => 'https://haneagle.co.id/wp-content/uploads/2023/05/HHI-LOGO.png',
            ],
            [
                'name' => 'PT. Harapan Utama',
                'location' => 'Jakarta',
                'logo' => 'https://harapanutama.co.id/assets/images/logo.png',
            ],
            [
                'name' => 'PT. Asuransi Jasa Tania',
                'location' => 'Balikpapan',
                'logo' => 'https://awsimages.detik.net.id/visual/2023/09/25/logo-asuransi-jastan_169.png?w=480&q=90',
            ],
            [
                'name' => 'PT. Karsa Mulia Sejahtera',
                'location' => 'Balikpapan',
                'logo' => 'https://www.karsamulia.co.id/wp-content/uploads/2020/02/kms-150px.png',
            ],
            [
                'name' => 'PT. Hariff Daya Tunggal Engineering',
                'location' => 'Bandung',
                'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTh-3gJg9ciEw75rrOIfAWLnrKc8EKViP_JTA&s',
            ],
            [
                'name' => 'PT. INDONESIA EXIMBANK',
                'location' => 'Jakarta & Balikpapan',
                'logo' => 'https://www.indonesiaeximbank.go.id/lib/images/logo/logo-eximbank-indonesia1.png',
            ],
            [
                'name' => 'PT. INTERBAT Tbk',
                'location' => 'Jakarta',
                'logo' => 'https://karirindustri.com/wp-content/uploads/2025/04/Interbat-New-Thumbnail.png',
            ],
            [
                'name' => 'PT. Sapta Indra Sejati',
                'location' => 'Jakarta & Balikpapan',
                'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTLws_RjOmHw9O7_7dn2o7Ul8SFkDk6O4sHg&s',
            ],
            [
                'name' => 'PT. Sanggar Sarana Baja',
                'location' => 'Jakarta & Balikpapan',
                'logo' => 'https://i.ytimg.com/vi/I0Mp9vkWb4M/maxresdefault.jpg',
            ],
            [
                'name' => 'PT. Supraco Indonesia',
                'location' => 'Jakarta & Balikpapan',
                'logo' => 'https://suyanto.id/wp-content/uploads/2024/10/supraco.jpg',
            ],
            [
                'name' => 'PT. Radiant Tbk',
                'location' => 'Balikpapan',
                'logo' => 'https://lokerbumn.com/wp-content/uploads/2024/05/PT-Radiant-Utama-Interinsco-Tbk.jpg',
            ],
            [
                'name' => 'PT. Samudera Indonesia',
                'location' => 'Jakarta & Balikpapan',
                'logo' => 'https://bucket.soedarpo.id:7443/websamudera-dev/logo-samudera.png',
            ],
            [
                'name' => 'PT. Timenndo Perkasa International',
                'location' => 'Jakarta',
                'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSO8JsOPxE4Bw_q4Dwsz7qdE7ttLa3BcVZ18A&s',
            ],
            [
                'name' => 'PT. Tri Swardana Utama',
                'location' => 'Balikpapan',
                'logo' => 'https://media.licdn.com/dms/image/v2/C510BAQF-xHE55WerEw/company-logo_200_200/company-logo_200_200/0/1630587434997?e=2147483647&v=beta&t=RyrrEVw8V6WCo6nRhTc7ofsV1qVfIaANEbZKN1jpAkc',
            ],
            [
                'name' => 'PT. Tunas Dwipa Matra',
                'location' => 'Balikpapan & Tanah Grogot',
                'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnlAByvKkNtYNiJ_K13CmzcQvf3MFyxMHQtg&s',
            ],
            [
                'name' => 'PT. Federal Karyatama',
                'location' => 'Jakarta',
                'logo' => 'https://media.licdn.com/dms/image/v2/C510BAQHhbWRHYX82aQ/company-logo_200_200/company-logo_200_200/0/1630578972308/federal_karyatama_logo?e=2147483647&v=beta&t=D0hEbYpAXNCe95NanC1yqmQgDdeTWF9mg6o8K4_oEf0',
            ],
            [
                'name' => 'PT. ASTRA INTERNATIONAL, Tbk Honda',
                'location' => 'Balikpapan',
                'logo' => 'https://webmedias.motorkux.id/_ui/responsive/theme-astramotor/images/white-logo.png',
            ],
            [
                'name' => 'PT. FEDERAL INTERNATIONAL FINANCE',
                'location' => 'Balikpapan',
                'logo' => 'https://smkjambimedan.sch.id/web/media_library/posts/post-image-1639121456341.jpg',
            ],
            [
                'name' => 'PT SERASI AUTORAYA',
                'location' => 'Jakarta & Balikpapan',
                'logo' => 'https://www.sera.astra.co.id/uploads/contents/1500017831_U846WX1nRM.png',
            ],
            [
                'name' => 'PT. ASTRA INTERNATIONAL Tbk',
                'location' => 'Balikpapan',
                'logo' => 'https://images.glints.com/unsafe/glints-dashboard.oss-ap-southeast-1-internal.aliyuncs.com/company-logo/00a9ee2e94fb2ecd69b4f4cc00614373.jpg',
            ],
            [
                'name' => 'PT. HARMONI MITRA UTAMA',
                'location' => 'Balikpapan',
                'logo' => 'https://media.licdn.com/dms/image/v2/D560BAQEV8HI3i2fpsg/company-logo_200_200/company-logo_200_200/0/1698640694376?e=2147483647&v=beta&t=PX_ixJMjIuBqGxVpbFW_nt0fP3hMw2MnvIaxRm1NeGY',
            ],
            [
                'name' => 'YAYASAN DHARMA BHAKTI ASTRA',
                'location' => 'Jakarta & Balikpapan',
                'logo' => 'https://ydba.astra.co.id/cfind/source/thumb/images/cover_w246_h81_cover_w246_h81_footer-ydba-rz.png',
            ],
            [
                'name' => 'PT. ASURANSI ASTRA BUANA',
                'location' => 'Jakarta & Balikpapan',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/1/11/Asuransi_astra.png',
            ],
            [
                'name' => 'PT. AUTO 2000',
                'location' => 'Balikpapan & Jakarta',
                'logo' => 'https://e7.pngegg.com/pngimages/161/898/png-clipart-toyota-auto2000-serang-car-pt-toyota-astra-motor-toyota-auto-2000-new-member-text-logo.png',
            ],
            [
                'name' => 'SDIT Istiqamah',
                'location' => 'Balikpapan',
                'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRcHmLxHLJIejdRphrG1E9ZJc9d1L9Klor3Rg&s',
            ],
            [
                'name' => 'SDIT Lukman Hakim',
                'location' => 'Balikpapan',
                'logo' => 'https://play-lh.googleusercontent.com/yVyRuh2CnWfA1OCleuHHFZGsuajbx1ZAoU7IUg54Wk8iITmpQlAH3XKFkCXlfTnDxA=w600-h300-pc0xffffff-pd',
            ],
            [
                'name' => 'SD INTIS School',
                'location' => 'Balikpapan',
                'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRYn_DiEL2lwQ6lXtHngLkEltMmRzNiHqYZGQ&s',
            ],
            [
                'name' => 'SD Kristen Trimulia',
                'location' => 'Bandung',
                'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQSgscm7NRn3YtpKTXrYJ1hsfJFzmtrvOmB4A&s',
            ],
            [
                'name' => 'SMP Negeri 1',
                'location' => 'Balikpapan',
                'logo' => 'https://smpn1bpn.sch.id/images/logo-smp1.png',
            ],
            [
                'name' => 'SMA Negeri 1',
                'location' => 'Balikpapan',
                'logo' => 'https://play-lh.googleusercontent.com/39b6IfKC60mOgzHa_BPcda4Lak988y0g1c4eYKBQxrV_B-DaxbmxiO9iVL6rl2ykcDI=w600-h300-pc0xffffff-pd',
            ],
            [
                'name' => 'SMP Negeri 15',
                'location' => 'Balikpapan',
                'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbTAw1M4n6kZAzij2QJVGr-CLkeGTF29hQkg&s',
            ],
            [
                'name' => 'SMA Negeri 3',
                'location' => 'Balikpapan',
                'logo' => 'https://play-lh.googleusercontent.com/CHoV5CpKH_Hodmc4CxHlse-_zvwnnWN3EKSE382JgScE9_pOEcje-le-omlMOCqPrq-I=w240-h480-rw',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}