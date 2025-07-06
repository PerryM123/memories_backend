<?php
// TODO: テストの整理方法は検討中
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReceiptInfoTest extends TestCase
{
    use RefreshDatabase;
    
    private string $token;

    protected function setUp(): void 
    {
        parent::setUp();
        $this->token = env('BEARER_TOKEN');
    }

    /** @test */
    public function it_can_store_receipt_info()
    {
        Storage::fake('s3');
        $payload = [
            'title' => 'Test Receipt',
            'user_who_paid' => 'Perry',
            'person_1_amount' => 100,
            'person_2_amount' => 200,
            'bought_items' => [
                ["name" => "ハーゲンミニCロウチャクリキーウカ", "price_total" => 218, "who_paid" => "perry"],
                ["name" => "オリジナルスフラッドオレンジ", "price_total" => 204, "who_paid" => "perry"],
                ["name" => "オカメ スコイサットS-903", "price_total" => 264, "who_paid" => "perry"],
                ["name" => "アタックウオシEXヘヤカカ850g", "price_total" => 308, "who_paid" => "both"],
                ["name" => "コウサンウオトンジヤ玉150×3", "price_total" => 78, "who_paid" => "both"],
                ["name" => "セブンスターリサンゴールド", "price_total" => 499, "who_paid" => "both"],
                ["name" => "ワイドハイターEXパワー820ml", "price_total" => 328, "who_paid" => "both"],
                ["name" => "サラヤ テイユコット100ムコち56", "price_total" => 280, "who_paid" => "both"],
                ["name" => "バナナ", "price_total" => 256, "who_paid" => "both"],
                ["name" => "ハウスバイング35g", "price_total" => 100, "who_paid" => "both"],
                ["name" => "トマト コツコ", "price_total" => 398, "who_paid" => "hannah"],
                ["name" => "タンノンビオカセイタクブドウ", "price_total" => 326, "who_paid" => "hannah"],
                ["name" => "タンノンビオ シチリアレモン 4コ", "price_total" => 163, "who_paid" => "hannah"],
                ["name" => "コイワイヨーグルトホンボウ400g", "price_total" => 199, "who_paid" => "perry"],
                ["name" => "ミヤマ イチオシムキチ 200g", "price_total" => 153, "who_paid" => "perry"],
                ["name" => "コウサンウオカトリムネニク", "price_total" => 596, "who_paid" => "perry"],
            ],
            'total_amount' => 300,
            'image' => UploadedFile::fake()->image('receipt.jpg'),
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->postJson('/api/receipt-info', $payload);
        $response->baseResponse->getContent();
        $response->dump();
        echo $response->getContent() . "\n";
        echo $response->status() . "\n";
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'receipt_id',
            'title',
            'image_url',
            'user_who_paid',
            'total_amount',
            'person_1_amount',
            'person_2_amount',
            'person_1_bought_items'
        ]);
        $response->assertJson([
            "receipt_id" => 1,
            "title" => "Test Receipt",
            "user_who_paid" => "Perry",
            "total_amount" => 300,
            "person_1_amount" => 100,
            "person_2_amount" => 200,
            "person_1_bought_items" => [
                [
                    "bought_item_id" => 1,
                    "receipt_id" => 1,
                    "name" => "ハーゲンミニCロウチャクリキーウカ",
                    "price" => 218,
                    "payer_name" => "perry"
                ],
                [
                    "bought_item_id" => 2,
                    "receipt_id" => 1,
                    "name" => "オリジナルスフラッドオレンジ",
                    "price" => 204,
                    "payer_name" => "perry"
                ],
                [
                    "bought_item_id" => 3,
                    "receipt_id" => 1,
                    "name" => "オカメ スコイサットS-903",
                    "price" => 264,
                    "payer_name" => "perry"
                ],
                [
                    "bought_item_id" => 14,
                    "receipt_id" => 1,
                    "name" => "コイワイヨーグルトホンボウ400g",
                    "price" => 199,
                    "payer_name" => "perry"
                ],
                [
                    "bought_item_id" => 15,
                    "receipt_id" => 1,
                    "name" => "ミヤマ イチオシムキチ 200g",
                    "price" => 153,
                    "payer_name" => "perry"
                ],
                [
                    "bought_item_id" => 16,
                    "receipt_id" => 1,
                    "name" => "コウサンウオカトリムネニク",
                    "price" => 596,
                    "payer_name" => "perry"
                ]
            ],
            "person_2_bought_items" => [
                [
                    "bought_item_id" => 11,
                    "receipt_id" => 1,
                    "name" => "トマト コツコ",
                    "price" => 398,
                    "payer_name" => "hannah"
                ],
                [
                    "bought_item_id" => 12,
                    "receipt_id" => 1,
                    "name" => "タンノンビオカセイタクブドウ",
                    "price" => 326,
                    "payer_name" => "hannah"
                ],
                [
                    "bought_item_id" => 13,
                    "receipt_id" => 1,
                    "name" => "タンノンビオ シチリアレモン 4コ",
                    "price" => 163,
                    "payer_name" => "hannah"
                ]
            ],
            "both_bought_items" => [
                [
                    "bought_item_id" => 4,
                    "receipt_id" => 1,
                    "name" => "アタックウオシEXヘヤカカ850g",
                    "price" => 308,
                    "payer_name" => "both"
                ],
                [
                    "bought_item_id" => 5,
                    "receipt_id" => 1,
                    "name" => "コウサンウオトンジヤ玉150×3",
                    "price" => 78,
                    "payer_name" => "both"
                ],
                [
                    "bought_item_id" => 6,
                    "receipt_id" => 1,
                    "name" => "セブンスターリサンゴールド",
                    "price" => 499,
                    "payer_name" => "both"
                ],
                [
                    "bought_item_id" => 7,
                    "receipt_id" => 1,
                    "name" => "ワイドハイターEXパワー820ml",
                    "price" => 328,
                    "payer_name" => "both"
                ],
                [
                    "bought_item_id" => 8,
                    "receipt_id" => 1,
                    "name" => "サラヤ テイユコット100ムコち56",
                    "price" => 280,
                    "payer_name" => "both"
                ],
                [
                    "bought_item_id" => 9,
                    "receipt_id" => 1,
                    "name" => "バナナ",
                    "price" => 256,
                    "payer_name" => "both"
                ],
                [
                    "bought_item_id" => 10,
                    "receipt_id" => 1,
                    "name" => "ハウスバイング35g",
                    "price" => 100,
                    "payer_name" => "both"
                ]
            ]
        ]);
    }

    /** @test */
    public function receipt_id_does_not_exist()
    {
        $receipt_id = 2;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->getJson('/api/receipt-info/' . $receipt_id);
        $response->baseResponse->getContent();
        $response->dump();
        $response->assertStatus(404);
        $response->assertJson([
            'error_message' => 'receipt ID "'. $receipt_id . '" does not exist'
        ]);
    }

    /** @test */
    public function fails_authorization_on_missing_required_bearer_tokens()
    {
        $receipt_id = 2;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer this_is_a_bad_token'
        ])->getJson('/api/receipt-info/' . $receipt_id);
        $response->baseResponse->getContent();
        $response->dump();
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthorized'
        ]);
    }
}