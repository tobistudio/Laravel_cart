<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PagesProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $product_categories = [
            [
                'lv' => 'Universālās daļas',
                'en' => 'Universālās daļas',
                'ru' => 'Universālās daļas',
                'children' => [
                    [
                        'lv' => 'Akumulatori',
                        'en' => 'Akumulatori',
                        'ru' => 'Akumulatori',
                        'children' => [
                            [
                                'lv' => 'Auto akumulatori',
                                'en' => 'Auto akumulatori',
                                'ru' => 'Auto akumulatori',
                            ],
                            [
                                'lv' => 'Akumulatoru lādētāji',
                                'en' => 'Akumulatoru lādētāji',
                                'ru' => 'Akumulatoru lādētāji',
                            ],
                            [
                                'lv' => 'Akumulatoru testeri',
                                'en' => 'Akumulatoru testeri',
                                'ru' => 'Akumulatoru testeri',
                            ],
                            [
                                'lv' => 'Piederumi akumulatoriem',
                                'en' => 'Piederumi akumulatoriem',
                                'ru' => 'Piederumi akumulatoriem',
                            ]
                        ]
                    ],
                    [
                        'lv' => 'Auto ķīmija',
                        'en' => 'Auto ķīmija',
                        'ru' => 'Auto ķīmija',
                        'children' => [
                            [
                                'lv' => 'Motoreļļas',
                                'en' => 'Motoreļļas',
                                'ru' => 'Motoreļļas',
                            ],
                            [
                                'lv' => 'Transmisijas eļļas',
                                'en' => 'Transmisijas eļļas',
                                'ru' => 'Transmisijas eļļas',
                            ],
                            [
                                'lv' => 'Bremžu šķidrumi',
                                'en' => 'Bremžu šķidrumi',
                                'ru' => 'Bremžu šķidrumi',
                            ],
                            [
                                'lv' => 'Dzesēšanas šķidrumi',
                                'en' => 'Dzesēšanas šķidrumi',
                                'ru' => 'Dzesēšanas šķidrumi',
                            ],
                            [
                                'lv' => 'Degvielas piedevas',
                                'en' => 'Degvielas piedevas',
                                'ru' => 'Degvielas piedevas',
                            ],
                            [
                                'lv' => 'Logu mazgāšanas šķidrumi',
                                'en' => 'Logu mazgāšanas šķidrumi',
                                'ru' => 'Logu mazgāšanas šķidrumi',
                            ],
                            [
                                'lv' => 'Ķīmija auto remontam',
                                'en' => 'Ķīmija auto remontam',
                                'ru' => 'Ķīmija auto remontam',
                            ],
                            [
                                'lv' => 'Cits',
                                'en' => 'Cits',
                                'ru' => 'Cits',
                            ]
                        ]
                    ],
                    [
                        'lv' => 'Iekārtas un instrumenti',
                        'en' => 'Iekārtas un instrumenti',
                        'ru' => 'Iekārtas un instrumenti',
                        'children' => [
                            [
                                'lv' => 'Specializētie instrumenti',
                                'en' => 'Specializētie instrumenti',
                                'ru' => 'Specializētie instrumenti',
                                'children' => [
                                    [
                                        'lv' => 'Motoram',
                                        'en' => 'Motoram',
                                        'ru' => 'Motoram',
                                    ],
                                    [
                                        'lv' => 'Bremžu sistēmai',
                                        'en' => 'Bremžu sistēmai',
                                        'ru' => 'Bremžu sistēmai',
                                    ],
                                    [
                                        'lv' => 'Degvielas sistēmai',
                                        'en' => 'Degvielas sistēmai',
                                        'ru' => 'Degvielas sistēmai',
                                    ],
                                    [
                                        'lv' => 'Dzesēšanas sistēmai',
                                        'en' => 'Dzesēšanas sistēmai',
                                        'ru' => 'Dzesēšanas sistēmai',
                                    ],
                                    [
                                        'lv' => 'Stūres sistēmai',
                                        'en' => 'Stūres sistēmai',
                                        'ru' => 'Stūres sistēmai',
                                    ],
                                    [
                                        'lv' => 'Piedziņas sistēmai',
                                        'en' => 'Piedziņas sistēmai',
                                        'ru' => 'Piedziņas sistēmai',
                                    ],
                                    [
                                        'lv' => 'Piekarei',
                                        'en' => 'Piekarei',
                                        'ru' => 'Piekarei',
                                    ],
                                    [
                                        'lv' => 'Riteņu ģemometrijai / kalibrēšanai',
                                        'en' => 'Riteņu ģemometrijai / kalibrēšanai',
                                        'ru' => 'Riteņu ģemometrijai / kalibrēšanai',
                                    ],
                                    [
                                        'lv' => 'Izpūtējam un DPF filtram',
                                        'en' => 'Izpūtējam un DPF filtram',
                                        'ru' => 'Izpūtējam un DPF filtram',
                                    ],
                                    [
                                        'lv' => 'Hibrīdautomašīnām',
                                        'en' => 'Hibrīdautomašīnām',
                                        'ru' => 'Hibrīdautomašīnām',
                                    ],
                                ]
                            ],
                            [
                                'lv' => 'Darba vietas labiekārtošana',
                                'en' => 'Darba vietas labiekārtošana',
                                'ru' => 'Darba vietas labiekārtošana',
                                'children' => [
                                    [
                                        'lv' => 'Plaukti stendi pakaramie',
                                        'en' => 'Plaukti stendi pakaramie',
                                        'ru' => 'Plaukti stendi pakaramie',
                                    ],
                                    [
                                        'lv' => 'Dažādi',
                                        'en' => 'Dažādi',
                                        'ru' => 'Dažādi',
                                    ],
                                ]
                            ],
                            [
                                'lv' => 'Diagnostika',
                                'en' => 'Diagnostika',
                                'ru' => 'Diagnostika',
                                'children' => [
                                    [
                                        'lv' => 'Endoskopi',
                                        'en' => 'Endoskopi',
                                        'ru' => 'Endoskopi',
                                    ],
                                    [
                                        'lv' => 'Diagnostikas datu bāzes',
                                        'en' => 'Diagnostikas datu bāzes',
                                        'ru' => 'Diagnostikas datu bāzes',
                                    ],
                                    [
                                        'lv' => 'Diagnostikas testeri',
                                        'en' => 'Diagnostikas testeri',
                                        'ru' => 'Diagnostikas testeri',
                                    ],
                                    [
                                        'lv' => 'Gāzu analizētāji',
                                        'en' => 'Gāzu analizētāji',
                                        'ru' => 'Gāzu analizētāji',
                                    ],
                                    [
                                        'lv' => 'Riepu spiediena kontrole',
                                        'en' => 'Riepu spiediena kontrole',
                                        'ru' => 'Riepu spiediena kontrole',
                                    ],
                                ]
                            ],
                            [
                                'lv' => 'Eļļu un smērvielu instrumenti',
                                'en' => 'Eļļu un smērvielu instrumenti',
                                'ru' => 'Eļļu un smērvielu instrumenti',
                                'children' => [
                                    [
                                        'lv' => 'Eļļas filtra atslēga',
                                        'en' => 'Eļļas filtra atslēga',
                                        'ru' => 'Eļļas filtra atslēga',
                                    ],
                                    [
                                        'lv' => 'Eļļas kanniņas',
                                        'en' => 'Eļļas kanniņas',
                                        'ru' => 'Eļļas kanniņas',
                                    ],
                                    [
                                        'lv' => 'Eļļas savākšanas tvertnes',
                                        'en' => 'Eļļas savākšanas tvertnes',
                                        'ru' => 'Eļļas savākšanas tvertnes',
                                    ],
                                    [
                                        'lv' => 'Instrumenti eļļas korķu izskrūvēšanai',
                                        'en' => 'Instrumenti eļļas korķu izskrūvēšanai',
                                        'ru' => 'Instrumenti eļļas korķu izskrūvēšanai',
                                    ],
                                    [
                                        'lv' => 'Piltuvers',
                                        'en' => 'Piltuvers',
                                        'ru' => 'Piltuvers',
                                    ],
                                    [
                                        'lv' => 'Vanniņas eļļas maiņai',
                                        'en' => 'Vanniņas eļļas maiņai',
                                        'ru' => 'Vanniņas eļļas maiņai',
                                    ],
                                ]
                            ],
                            [
                                'lv' => 'Kondicionēšanas sistēma',
                                'en' => 'Kondicionēšanas sistēma',
                                'ru' => 'Kondicionēšanas sistēma',
                                'children' => [
                                    [
                                        'lv' => 'Apkope',
                                        'en' => 'Apkope',
                                        'ru' => 'Apkope',
                                    ],
                                    [
                                        'lv' => 'Dezinfekcija',
                                        'en' => 'Dezinfekcija',
                                        'ru' => 'Dezinfekcija',
                                    ],
                                    [
                                        'lv' => 'Instrumenti',
                                        'en' => 'Instrumenti',
                                        'ru' => 'Instrumenti',
                                    ],
                                    [
                                        'lv' => 'Noplūdes atklāšna',
                                        'en' => 'Noplūdes atklāšna',
                                        'ru' => 'Noplūdes atklāšna',
                                    ],
                                    [
                                        'lv' => 'Skalošana',
                                        'en' => 'Skalošana',
                                        'ru' => 'Skalošana',
                                    ],
                                ]
                            ],
                            [
                                'lv' => 'Pacēlāji, domkroti, atbalsti, preses',
                                'en' => 'Pacēlāji, domkroti, atbalsti, preses',
                                'ru' => 'Pacēlāji, domkroti, atbalsti, preses',
                                'children' => [
                                    [
                                        'lv' => 'Donkrati',
                                        'en' => 'Donkrati',
                                        'ru' => 'Donkrati',
                                    ],
                                    [
                                        'lv' => 'Atbalsti',
                                        'en' => 'Atbalsti',
                                        'ru' => 'Atbalsti',
                                    ],
                                    [
                                        'lv' => 'Motora/transmisijas turētāji',
                                        'en' => 'Motora/transmisijas turētāji',
                                        'ru' => 'Motora/transmisijas turētāji',
                                    ],
                                    [
                                        'lv' => 'Preses',
                                        'en' => 'Preses',
                                        'ru' => 'Preses',
                                    ],
                                ]
                            ],
                            [
                                'lv' => 'Riepu remonts, vulkanizācija',
                                'en' => 'Riepu remonts, vulkanizācija',
                                'ru' => 'Riepu remonts, vulkanizācija',
                                'children' => [
                                    [
                                        'lv' => 'Riepu balansētāji',
                                        'en' => 'Riepu balansētāji',
                                        'ru' => 'Riepu balansētāji',
                                    ],
                                    [
                                        'lv' => 'Riepu montāžas iekārtas',
                                        'en' => 'Riepu montāžas iekārtas',
                                        'ru' => 'Riepu montāžas iekārtas',
                                    ],
                                    [
                                        'lv' => 'Riepu pumpēšana',
                                        'en' => 'Riepu pumpēšana',
                                        'ru' => 'Riepu pumpēšana',
                                    ],
                                    [
                                        'lv' => 'Riepu spiediena kontrole',
                                        'en' => 'Riepu spiediena kontrole',
                                        'ru' => 'Riepu spiediena kontrole',
                                    ],
                                    [
                                        'lv' => 'Vulkanizācijas instrumenti',
                                        'en' => 'Vulkanizācijas instrumenti',
                                        'ru' => 'Vulkanizācijas instrumenti',
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'lv' => 'Rokas instrumenti',
                        'en' => 'Rokas instrumenti',
                        'ru' => 'Rokas instrumenti',
                        'children' => [
                            [
                                'lv' => 'Instrumentu komplekti',
                                'en' => 'Instrumentu komplekti',
                                'ru' => 'Instrumentu komplekti',
                            ],
                            [
                                'lv' => 'Muciņatslēgas un piederumi',
                                'en' => 'Muciņatslēgas un piederumi',
                                'ru' => 'Muciņatslēgas un piederumi',
                            ],
                            [
                                'lv' => 'Pneimatiskie insrumenti',
                                'en' => 'Pneimatiskie insrumenti',
                                'ru' => 'Pneimatiskie insrumenti',
                            ],
                            [
                                'lv' => 'Ugriežņu atslēgas',
                                'en' => 'Ugriežņu atslēgas',
                                'ru' => 'Ugriežņu atslēgas',
                            ],
                            [
                                'lv' => 'Skrūvgrieži',
                                'en' => 'Skrūvgrieži',
                                'ru' => 'Skrūvgrieži',
                            ],
                            [
                                'lv' => 'Apgaismojums',
                                'en' => 'Apgaismojums',
                                'ru' => 'Apgaismojums',
                            ],
                            [
                                'lv' => 'Āmuri un piedrumi',
                                'en' => 'Āmuri un piedrumi',
                                'ru' => 'Āmuri un piedrumi',
                            ],
                            [
                                'lv' => 'Stangas, knaibles',
                                'en' => 'Stangas, knaibles',
                                'ru' => 'Stangas, knaibles',
                            ],
                            [
                                'lv' => 'Kniedēšana',
                                'en' => 'Kniedēšana',
                                'ru' => 'Kniedēšana',
                            ],
                            [
                                'lv' => 'Vīles',
                                'en' => 'Vīles',
                                'ru' => 'Vīles',
                            ],
                            [
                                'lv' => 'Griešanai un zāģēšanai',
                                'en' => 'Griešanai un zāģēšanai',
                                'ru' => 'Griešanai un zāģēšanai',
                            ],
                            [
                                'lv' => 'Darba aizsardzība',
                                'en' => 'Darba aizsardzība',
                                'ru' => 'Darba aizsardzība',
                            ],
                            [
                                'lv' => 'Skrūvspīles un laktas',
                                'en' => 'Skrūvspīles un laktas',
                                'ru' => 'Skrūvspīles un laktas',
                            ],
                            [
                                'lv' => 'Drāšu birstes',
                                'en' => 'Drāšu birstes',
                                'ru' => 'Drāšu birstes',
                            ],
                            [
                                'lv' => 'Spoguļi un magnēti',
                                'en' => 'Spoguļi un magnēti',
                                'ru' => 'Spoguļi un magnēti',
                            ],
                            [
                                'lv' => 'Sviras',
                                'en' => 'Sviras',
                                'ru' => 'Sviras',
                            ],
                            [
                                'lv' => 'Urbšana un vītņošana',
                                'en' => 'Urbšana un vītņošana',
                                'ru' => 'Urbšana un vītņošana',
                            ],
                            [
                                'lv' => 'Uzgaļi',
                                'en' => 'Uzgaļi',
                                'ru' => 'Uzgaļi',
                            ],
                        ]
                    ],
                    [
                        'lv' => 'Auto kopšana',
                        'en' => 'Auto kopšana',
                        'ru' => 'Auto kopšana',
                        'children' => [
                            [
                                'lv' => 'Virsbūves tīrīšana',
                                'en' => 'Virsbūves tīrīšana',
                                'ru' => 'Virsbūves tīrīšana',
                                'children' => [
                                    [
                                        'lv' => 'Stikla tīrīšana',
                                        'en' => 'Stikla tīrīšana',
                                        'ru' => 'Stikla tīrīšana',
                                    ],
                                    [
                                        'lv' => 'Kukaiņu/darvas noņemšana',
                                        'en' => 'Kukaiņu/darvas noņemšana',
                                        'ru' => 'Kukaiņu/darvas noņemšana',
                                    ],
                                    [
                                        'lv' => 'Plastmasas kopšana',
                                        'en' => 'Plastmasas kopšana',
                                        'ru' => 'Plastmasas kopšana',
                                    ],
                                    [
                                        'lv' => 'Disku tīrīšana',
                                        'en' => 'Disku tīrīšana',
                                        'ru' => 'Disku tīrīšana',
                                    ],
                                    [
                                        'lv' => 'Riepu tīrīšana',
                                        'en' => 'Riepu tīrīšana',
                                        'ru' => 'Riepu tīrīšana',
                                    ],
                                    [
                                        'lv' => 'Šampūni, putas',
                                        'en' => 'Šampūni, putas',
                                        'ru' => 'Šampūni, putas',
                                    ],
                                    [
                                        'lv' => 'Izplūdes sistēma, DPF',
                                        'en' => 'Izplūdes sistēma, DPF',
                                        'ru' => 'Izplūdes sistēma, DPF',
                                    ]
                                ]
                            ],
                            [
                                'lv' => 'Virsbūves aizsardzība',
                                'en' => 'Virsbūves aizsardzība',
                                'ru' => 'Virsbūves aizsardzība',
                            ],
                            [
                                'lv' => 'Salona tīrīšana',
                                'en' => 'Salona tīrīšana',
                                'ru' => 'Salona tīrīšana',
                            ],
                            [
                                'lv' => 'Atkausēšanas līdzekļi',
                                'en' => 'Atkausēšanas līdzekļi',
                                'ru' => 'Atkausēšanas līdzekļi',
                            ],
                            [
                                'lv' => 'Gaisa kondicionēšanas tīrīšanai',
                                'en' => 'Gaisa kondicionēšanas tīrīšanai',
                                'ru' => 'Gaisa kondicionēšanas tīrīšanai',
                            ],
                            [
                                'lv' => 'Ķīļsiksnas apkope',
                                'en' => 'Ķīļsiksnas apkope',
                                'ru' => 'Ķīļsiksnas apkope',
                            ],
                            [
                                'lv' => 'Motora tīrīšana',
                                'en' => 'Motora tīrīšana',
                                'ru' => 'Motora tīrīšana',
                            ],
                        ]
                    ],
                    [
                        'lv' => 'Motocikliem',
                        'en' => 'Motocikliem',
                        'ru' => 'Motocikliem',
                        'children' => [
                            [
                                'lv' => 'Akumulatori',
                                'en' => 'Akumulatori',
                                'ru' => 'Akumulatori',
                            ],
                            [
                                'lv' => 'Eļļas, šķidrumi',
                                'en' => 'Eļļas, šķidrumi',
                                'ru' => 'Eļļas, šķidrumi',
                                'children' => [
                                    [
                                        'lv' => 'Motoreļļa',
                                        'en' => 'Motoreļļa',
                                        'ru' => 'Motoreļļa',
                                    ],
                                    [
                                        'lv' => 'Ķēdes eļļa',
                                        'en' => 'Ķēdes eļļa',
                                        'ru' => 'Ķēdes eļļa',
                                    ],
                                    [
                                        'lv' => 'Bremžu šķidrums',
                                        'en' => 'Bremžu šķidrums',
                                        'ru' => 'Bremžu šķidrums',
                                    ]
                                ]
                            ],
                            [
                                'lv' => 'Apkope',
                                'en' => 'Apkope',
                                'ru' => 'Apkope',
                            ],
                            [
                                'lv' => 'Cits',
                                'en' => 'Cits',
                                'ru' => 'Cits',
                            ],
                        ]
                    ],
                    [
                        'lv' => 'Piederumi un aprīkojums',
                        'en' => 'Piederumi un aprīkojums',
                        'ru' => 'Piederumi un aprīkojums',
                        'children' => [
                            [
                                'lv' => 'Baterijas',
                                'en' => 'Baterijas',
                                'ru' => 'Baterijas',
                            ],
                            [
                                'lv' => 'Drošība',
                                'en' => 'Drošība',
                                'ru' => 'Drošība',
                            ],
                            [
                                'lv' => 'Logu slotiņas',
                                'en' => 'Logu slotiņas',
                                'ru' => 'Logu slotiņas',
                            ],
                            [
                                'lv' => 'Paklāji',
                                'en' => 'Paklāji',
                                'ru' => 'Paklāji',
                            ],
                            [
                                'lv' => 'Līme',
                                'en' => 'Līme',
                                'ru' => 'Līme',
                            ],
                            [
                                'lv' => 'Materiāli riepu maiņai',
                                'en' => 'Materiāli riepu maiņai',
                                'ru' => 'Materiāli riepu maiņai',
                            ],
                            [
                                'lv' => 'Papildus apgaismojums',
                                'en' => 'Papildus apgaismojums',
                                'ru' => 'Papildus apgaismojums',
                            ],
                            [
                                'lv' => 'Plastmasas stiprinājumi',
                                'en' => 'Plastmasas stiprinājumi',
                                'ru' => 'Plastmasas stiprinājumi',
                            ],
                            [
                                'lv' => 'Piekabes piederumi',
                                'en' => 'Piekabes piederumi',
                                'ru' => 'Piekabes piederumi',
                            ],
                            [
                                'lv' => 'Savilcēji un žņaugi',
                                'en' => 'Savilcēji un žņaugi',
                                'ru' => 'Savilcēji un žņaugi',
                            ],
                            [
                                'lv' => 'Ziemas preces',
                                'en' => 'Ziemas preces',
                                'ru' => 'Ziemas preces',
                            ],
                        ]
                    ],
                    [
                        'lv' => 'Smērvielas',
                        'en' => 'Smērvielas',
                        'ru' => 'Smērvielas',
                        'children' => [
                            [
                                'lv' => 'Baltā smēre',
                                'en' => 'Baltā smēre',
                                'ru' => 'Baltā smēre',
                            ],
                            [
                                'lv' => 'Grafīta smēre',
                                'en' => 'Grafīta smēre',
                                'ru' => 'Grafīta smēre',
                            ],
                            [
                                'lv' => 'Gultņiem',
                                'en' => 'Gultņiem',
                                'ru' => 'Gultņiem',
                            ],
                            [
                                'lv' => 'Industriālā smēre',
                                'en' => 'Industriālā smēre',
                                'ru' => 'Industriālā smēre',
                            ],
                            [
                                'lv' => 'Keramiskā smēre',
                                'en' => 'Keramiskā smēre',
                                'ru' => 'Keramiskā smēre',

                            ],
                            [
                                'lv' => 'Litija smēre',
                                'en' => 'Litija smēre',
                                'ru' => 'Litija smēre',
                            ],
                            [
                                'lv' => 'Molibdēna smēre',
                                'en' => 'Molibdēna smēre',
                                'ru' => 'Molibdēna smēre',
                            ],
                            [
                                'lv' => 'Multifunkcionāla smēre',
                                'en' => 'Multifunkcionāla smēre',
                                'ru' => 'Multifunkcionāla smēre',
                            ],
                            [
                                'lv' => 'Pretrūsas līdzekļi',
                                'en' => 'Pretrūsas līdzekļi',
                                'ru' => 'Pretrūsas līdzekļi',
                            ],
                            [
                                'lv' => 'Silikona smēre',
                                'en' => 'Silikona smēre',
                                'ru' => 'Silikona smēre',
                            ],
                            [
                                'lv' => 'Teflona smēre',
                                'en' => 'Teflona smēre',
                                'ru' => 'Teflona smēre',
                            ],
                            [
                                'lv' => 'Vara smēre',
                                'en' => 'Vara smēre',
                                'ru' => 'Vara smēre',
                            ],
                        ]
                    ],
                    [
                        'lv' => 'Eļļa dārza tehnikai',
                        'en' => 'Eļļa dārza tehnikai',
                        'ru' => 'Eļļa dārza tehnikai',
                    ],
                    [
                        'lv' => 'Eļļa gaisa kompresoriem',
                        'en' => 'Eļļa gaisa kompresoriem',
                        'ru' => 'Eļļa gaisa kompresoriem',
                    ],
                    [
                        'lv' => 'Hidrauliskā eļļa',
                        'en' => 'Hidrauliskā eļļa',
                        'ru' => 'Hidrauliskā eļļa',
                    ]
                ]
            ],
            [
                'lv' =>  'Rezerves daļas',
                'en' =>  'Rezerves daļas',
                'ru' =>  'Rezerves daļas',
                'children' => [
                    [
                        'lv' => 'Dzinējs',
                        'en' => 'Dzinējs',
                        'ru' => 'Dzinējs',
                    ],
                    [
                        'lv' => 'Transmisija',
                        'en' => 'Transmisija',
                        'ru' => 'Transmisija',
                    ],
                    [
                        'lv' => 'Izplūde',
                        'en' => 'Izplūde',
                        'ru' => 'Izplūde',
                    ],
                    [
                        'lv' => 'Filtri',
                        'en' => 'Filtri',
                        'ru' => 'Filtri',
                    ],
                    [
                        'lv' => 'Ritošā daļa',
                        'en' => 'Ritošā daļa',
                        'ru' => 'Ritošā daļa',
                    ],
                    [
                        'lv' => 'Bremžu sistēma',
                        'en' => 'Bremžu sistēma',
                        'ru' => 'Bremžu sistēma',
                    ],
                    [
                        'lv' => 'Dzesēšana',
                        'en' => 'Dzesēšana',
                        'ru' => 'Dzesēšana',
                    ],
                    [
                        'lv' => 'Virsbūve un salons',
                        'en' => 'Virsbūve un salons',
                        'ru' => 'Virsbūve un salons',
                    ],
                    [
                        'lv' => 'Degvielas sistēam',
                        'en' => 'Degvielas sistēam',
                        'ru' => 'Degvielas sistēam',
                    ],
                    [
                        'lv' => 'Apgaismojums',
                        'en' => 'Apgaismojums',
                        'ru' => 'Apgaismojums',
                    ],
                    [
                        'lv' => 'Elektroiekārta',
                        'en' => 'Elektroiekārta',
                        'ru' => 'Elektroiekārta',
                    ]
                ]
            ]
        ];

        $languages = Language::all();
        foreach($product_categories as $product_category){
            $page = new Page();
            $page->parent_id = null;
            $page->type = 'product_category';
            $page->show_in_pages = 1;
            $page->save();

            foreach($languages as $language){
                $language_page = new LanguagePage();

                $language_page->page_id = $page->id;
                $language_page->language_id = $language->id;
                $language_page->type = $page->type;
                $language_page->name = $product_category[$language->locale];
                $language_page->slug = Str::slug($product_category[$language->locale], "-");
                $language_page->save();
            }

            if(isset($product_category['children'])) {
                foreach ($product_category['children'] as $second_level_category) {
                    $second_level_page = new Page();
                    $second_level_page->parent_id = $page->id;
                    $second_level_page->type = 'product_category';
                    $second_level_page->show_in_pages = 1;
                    $second_level_page->save();

                    foreach ($languages as $language) {
                        $language_page = new LanguagePage();

                        $language_page->page_id = $second_level_page->id;
                        $language_page->language_id = $language->id;
                        $language_page->type = $second_level_page->type;
                        $language_page->name = $second_level_category[$language->locale];
                        $language_page->slug = Str::slug($second_level_category[$language->locale], "-");
                        $language_page->save();
                    }

                    if(isset($second_level_category['children'])) {
                        foreach ($second_level_category['children'] as $third_level_category) {
                            $third_level_page = new Page();
                            $third_level_page->parent_id = $second_level_page->id;
                            $third_level_page->type = 'product_category';
                            $third_level_page->show_in_pages = 1;
                            $third_level_page->save();

                            foreach ($languages as $language) {
                                $language_page = new LanguagePage();

                                $language_page->page_id = $third_level_page->id;
                                $language_page->language_id = $language->id;
                                $language_page->type = $third_level_page->type;
                                $language_page->name = $third_level_category[$language->locale];
                                $language_page->slug = Str::slug($third_level_category[$language->locale], "-");
                                $language_page->save();
                            }

                            if(isset($third_level_category['children'])) {
                                foreach ($third_level_category['children'] as $fourth_level_category) {
                                    $fourth_level_page = new Page();
                                    $fourth_level_page->parent_id = $third_level_page->id;
                                    $fourth_level_page->type = 'product_category';
                                    $fourth_level_page->show_in_pages = 1;
                                    $fourth_level_page->save();

                                    foreach ($languages as $language) {
                                        $language_page = new LanguagePage();

                                        $language_page->page_id = $fourth_level_page->id;
                                        $language_page->language_id = $language->id;
                                        $language_page->type = $fourth_level_page->type;
                                        $language_page->name = $fourth_level_category[$language->locale];
                                        $language_page->slug = Str::slug($fourth_level_category[$language->locale], "-");
                                        $language_page->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
