<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Service\InvestService;
use App\Service\Statement\Asset\FuturesService;
use App\Service\Statement\AssetService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Ben',
            'account' => 'plosinben',
            'password' => password_hash('12345', PASSWORD_DEFAULT)
        ]);

        $this->createInvestAccount();
        $this->createFutures();
    }

    protected function createInvestAccount()
    {
        collect([
            'B',
            'A',
            'Wu',
            '熊',
            'Emma',
            'Allie',
            '金'
        ])->each(fn($alias) => InvestService::make()->createAccount($alias));
    }

    protected function createFutures()
    {
        /**
         * @var FuturesService $futuresService
         */
        $futuresService = app()->make(FuturesService::class);

        collect([
            //[日期, 結餘, 未平倉, 沖銷, 入金, 出金]
            ['2018-09', 161506, 12550, null],
            ['2018-10', 241029, 11450, null, 100000],
            ['2018-11', 239339, 12000, null],
            ['2018-12', 276552, 7800, null, 10000],
            ['2019-01', 333144, 0, null, 3000],
            ['2019-02', 403849, 5000, null, 50000],
            ['2019-03', 400437, 3300, null, 3000],
            ['2019-04', 412727, -9150, null],
            ['2019-05', 533288, 19580, null, 3000],
            ['2019-06', 498742, -8850, null, 3000],
            ['2019-07', 267297, -9520, null, 3000],
            ['2019-08', 346254, 16910, null, 3000],
            ['2019-09', 409290, 4900, null, 3000],
            ['2019-10', 448812, 26820, null, 3000],
            ['2019-11', 408469, 7920, null, 15000],
            ['2019-12', 565513, 1780, null, 22000],
            ['2020-01', 1110184, 74510, -131920, 602000],
            ['2020-02', 1249247, 147750, 71090, 5000],
            ['2020-03', 1481732, 0, 377000, 10000],
            ['2020-04', 1891941, 40800, 198790, 105000],
            ['2020-05', 1800657, 6250, -90527, 10000],
            ['2020-06', 1901887, -4300, 96004, 39605],
            ['2020-07', 2081876, -10850, 184509, 12639],
            ['2020-08', 1647065, -51350, -3002, 13000, 350000],
            ['2020-09', 1689311, 200, -212750, 203000],
            ['2020-10', 1665002, 117550, -111173, 23000],
            ['2020-11', 2069267, -19550, 540150, 8000],
            ['2020-12', 2027190, 41800, -103427, 32216],
            ['2021-01', 2071980, 96650, -9794, 5000],
            ['2021-02', 2041993, 63350, -3760, 7000],
            ['2021-03', 1593499, 64200, -473751, 7000],
            ['2021-04', 1658541, 0, 148342, 9000],
            ['2021-05', 2304896, 43650, 609393, 7000],
            ['2021-06', 2243681, 28550, -46319, 7000],
            ['2021-07', 2188571, -8000, -17638, 2000],
            ['2021-08', 2798167, 206700, 344217, 52000],
            ['2021-09', 2419291, 750, -223094, 52000],
            ['2021-10', 2297759, -36800, -83847, 2000],
            ['2021-11', 2591873, -7550, 264452, 2000],
            ['2021-12', 2624673, 108000, -82501, 2000],
            ['2022-01', 2704690, 80150, 107824, 2000],
            ['2022-02', 2610063, 80500, -88812, 2000],
            ['2022-03', 2657171, -19900, 141439, 2000],
            ['2022-04', 2792552, 550, 114650, 5000],
            ['2022-05', 2913539, 208150, -86272, 5000],
        ])
            ->each(fn($data) => $futuresService->create(
                group: '群益',
                period: Carbon::parse($data[0]),
                commitment: $data[1],
                openProfit: $data[2],
                closeProfit: $data[3] ?? null,
                deposit: $data[4] ?? 0,
                withdraw: $data[5] ?? 0
            ));
    }
}
