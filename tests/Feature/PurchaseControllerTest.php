<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PurchaseControllerTest extends TestCase
{
    use RefreshDatabase;

    private $product;
    private $user;


    public function __construnct($product, $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testGetPuchasesForUser()
    {
        $this->prepareData();

        Sanctum::actingAs($this->user);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('api/user/products');

         $this->assertEquals(1, count($response['data']));
         $this->assertEquals($this->product->sku, $response['data'][0]['SKU']);
         $this->assertEquals($this->product->name, $response['data'][0]['name']);

         $response->assertStatus(200);
    }

    public function testAddPuchaseForUser()
    {
        Sanctum::actingAs($this->user);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/user/products', ['product_sku' => $this->product->sku]);

        $response->assertStatus(201);
        $data = $response->decodeResponseJson();
        $this->assertEquals($this->product->sku, $data['SKU']);
        $this->assertEquals($this->product->name, $data['name']);
    }

    public function testDeletePuchaseForUser()
    {
        $this->prepareData();

        Sanctum::actingAs($this->user);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->delete("/api/user/products/{$this->product->sku}");

        $response->assertStatus(200);

        $data = $response->decodeResponseJson();
        
        $this->assertEquals("Product removed from user purchases", $data['message']);
    }

    private function prepareData()
    {
        Purchase::factory(5)->create();

        $purchase = Purchase::factory()->create([
            'user_id' => $this->user->id,
            'product_sku' => $this->product->sku
        ]);

        return $purchase;
    }
}
