<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RankInfoControllerTest extends TestCase
{
    // TODO: 以下の@return voidコメントは必須？？？
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_non_number_is_invalid()
    {
        $response = $this->get('/api/ranking-post/a');
        // $data = $response->json();
        // dump('testing perry', $data);
        $response->assertStatus(400);
    }
    // TODO: やり方を調べてから以下のテストを書こう
    // public function test_get_rank_info_that_exist()
    // {
    //     // 
    // }
    // public function test_get_rank_info_that_does_not_exist()
    // {
    //     // 
    // }
}
