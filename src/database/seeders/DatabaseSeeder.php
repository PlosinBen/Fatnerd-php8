<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\InvestAccount;
use App\Models\StatementFutures;
use App\Service\InvestService;
use App\Service\MixedEvent\StatementDistribute;
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
        $this->createInvestHistory();
        $this->createFutures();
    }

    protected function createInvestAccount()
    {
        collect([
            [
                'alias' => 'B',
                'user_id' => 1,
                'start_period' => 201809,
            ],
            [
                'alias' => 'A',
                'start_period' => 201810,
            ],
            [
                'alias' => 'Wu',
                'contract' => 'specially',
                'start_period' => 201911,
            ],
            [
                'alias' => '熊',
                'contract' => 'friend',
                'start_period' => 201911,
            ],
            [
                'alias' => '金',
                'start_period' => 202003,
                'end_period' => 202007,
            ],
            [
                'alias' => 'Emma',
                'contract' => 'friend',
                'start_period' => 202006,
            ],
            [
                'alias' => 'Allie',
                'contract' => 'specially',
                'start_period' => 202012,
            ]
        ])->each(fn($alias) => InvestAccount::create($alias));
    }

    protected function createFutures()
    {
        /**
         * @var FuturesService $futuresService
         */
        $futuresService = app()->make(FuturesService::class);

        /**
         * @var StatementDistribute $statementDistribute
         */
        $statementDistribute = app()->make(StatementDistribute::class);

        StatementFutures::create([
            StatementFutures::GROUP => '群益',
            StatementFutures::PERIOD => '201809',
            StatementFutures::COMMITMENT => 161506,
            StatementFutures::OPEN_PROFIT => 12550,
            StatementFutures::REAL_COMMITMENT => 161506 - 12550
        ]);

        collect([
            //[日期, 結餘, 未平倉, 沖銷, 入金, 出金]
//            ['2018-09', 161506, 12550, null],
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
            ->each(function ($data) use ($futuresService, $statementDistribute) {
                $period = Carbon::createFromFormat('Y-m', $data[0])->lastOfMonth();

                $futuresService->create(
                    group: '群益',
                    period: $period,
                    commitment: $data[1],
                    openProfit: $data[2],
                    closeProfit: $data[3] ?? null,
                    deposit: $data[4] ?? 0,
                    withdraw: $data[5] ?? 0
                );

                $statementDistribute->execute($period);
            });
    }

    private function createInvestHistory()
    {
        $investService = InvestService::make();

        collect([
            [1, '2018-09-01', 'deposit', 148956],
            [1, '2018-12-29', 'deposit', 10000],
            [1, '2019-01-15', 'deposit', 3000],
            [1, '2019-02-11', 'deposit', 50000],
            [1, '2019-03-27', 'deposit', 3000],
            [1, '2019-05-14', 'deposit', 3000],
            [1, '2019-06-11', 'deposit', 3000],
            [1, '2019-07-09', 'deposit', 3000],
            [1, '2019-08-08', 'deposit', 3000],
            [1, '2019-09-05', 'deposit', 3000],
            [1, '2019-10-09', 'deposit', 3000],
            [1, '2019-11-11', 'deposit', 3000],
            [1, '2019-12-23	', 'deposit', 20000],
            [1, '2020-01-31', 'deposit', 600000],
            [1, '2020-02-19', 'deposit', 3000],
            [1, '2020-03-13', 'deposit', 3000],
            [1, '2020-04-08', 'deposit', 3000],
            [1, '2020-05-05', 'deposit', 5000],
            [1, '2020-06-11', 'deposit', 3000],
            [1, '2020-07-01', 'deposit', 3000],
            [1, '2020-07-13', 'deposit', 5000],
            [1, '2020-08-05', 'deposit', 5000],
            [1, '2020-08-12', 'deposit', 5000],
            [1, '2020-08-27', 'withdraw', 350000],
            [1, '2020-09-29', 'deposit', 200000],
            [1, '2020-10-28', 'deposit', 20000],
            [1, '2020-11-27', 'deposit', 5000],
            [1, '2020-12-29', 'deposit', 2000],

            [1, '2021-01-20', 'deposit', 2000],
            [1, '2021-02-21', 'deposit', 2000],
            [1, '2021-03-16', 'deposit', 2000],
            [1, '2021-04-13', 'deposit', 2000],
            [1, '2021-05-18', 'deposit', 2000],
            [1, '2021-06-20', 'deposit', 2000],
            [1, '2021-07-15', 'deposit', 2000],
            [1, '2021-08-12', 'deposit', 2000],
            [1, '2021-09-14', 'deposit', 2000],
            [1, '2021-10-19', 'deposit', 2000],
            [1, '2021-11-11', 'deposit', 2000],
            [1, '2021-12-15', 'deposit', 2000],
            [1, '2022-01-15', 'deposit', 2000],
            [1, '2022-02-18', 'deposit', 2000],
            [1, '2022-03-15', 'deposit', 2000],
            [1, '2022-04-15', 'deposit', 5000],
            [1, '2022-05-16', 'deposit', 5000],

            [2, '2018-10-20', 'deposit', 100000],
            [2, '2020-04-14', 'deposit', 100000],
            [2, '2021-08-24', 'deposit', 50000],
            [2, '2021-09-10', 'deposit', 50000],

            [3, '2019-11-13', 'deposit', 2000],
            [3, '2019-12-23', 'deposit', 2000],
            [3, '2020-01-31', 'deposit', 2000],
            [3, '2020-02-19', 'deposit', 2000],
            [3, '2020-03-13', 'deposit', 2000],
            [3, '2020-04-13', 'deposit', 2000],
            [3, '2020-05-15', 'deposit', 2000],
            [3, '2020-06-11', 'deposit', 3000],
            [3, '2020-07-13', 'deposit', 3000],
            [3, '2020-07-16', 'deposit', 1639],
            [3, '2020-08-11', 'deposit', 3000],
            [3, '2020-09-10', 'deposit', 3000],
            [3, '2020-10-10', 'deposit', 3000],
            [3, '2020-11-10', 'deposit', 3000],
            [3, '2020-12-10', 'deposit', 3000],
            [3, '2021-01-10', 'deposit', 3000],
            [3, '2021-02-21', 'deposit', 5000],
            [3, '2021-03-11', 'deposit', 5000],
            [3, '2021-04-10', 'deposit', 7000],
            [3, '2021-05-10', 'deposit', 5000],
            [3, '2021-06-10', 'deposit', 5000],

            [4, '2019-11-21', 'deposit', 10000],
            [4, '2020-06-30', 'deposit', 13605],

            [5, '2020-03-20', 'deposit', 5000],
            [5, '2020-05-27', 'deposit', 3000],

            [6, '2020-06-19', 'deposit', 20000],

            [7, '2020-12-30', 'deposit', 27216]
        ])
            ->each(fn($data) => $investService->addHistory(
                $data[0],
                Carbon::parse($data[1]),
                $data[2],
                $data[3],
                ''
            ));
    }
}
