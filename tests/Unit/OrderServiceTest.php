<?php

namespace Tests\Unit;

use App\Http\Domains\Order\Service\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    /** @test */
    public function it_generates_unique_order_numbers()
    {
        $numbers = [];
        for ($i = 0; $i < 10; $i++) {
            $numbers[] = $this->orderService->generateOrderNumber();
        }

        $this->assertEquals(count($numbers), count(array_unique($numbers)));

        // format (ORD-YYYYMMDD-XXXXX)
        foreach ($numbers as $number) {
            $this->assertMatchesRegularExpression('/^ORD-\d{8}-\d{5}$/', $number);
        }
    }

    /** @test */
    public function it_creates_an_order_with_items()
    {
        $orderData = [
            'user_id' => [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'address' => '123 Main St'
            ],
            'notes' => 'Test order'
        ];

        $items = [
            [
                'product_name' => 'Test Product 1',
                'product_sku' => 'TP1',
                'quantity' => 2,
                'unit_price' => 100
            ],
            [
                'product_name' => 'Test Product 2',
                'product_sku' => 'TP2',
                'quantity' => 1,
                'unit_price' => 50
            ]
        ];

        $order = $this->orderService->createOrder($orderData, $items);

        // Check if order was created
        $this->assertInstanceOf(Order::class, $order);
        $this->assertNotNull($order->order_number);

        // Check if items were added
        $this->assertEquals(2, $order->items->count());

        // Check total calculation
        $this->assertEquals(250, $order->total_amount);

        // Check if order status is properly set
        $this->assertEquals('draft', $order->status);

        // Check if history was recorded
        $this->assertEquals(1, $order->history->count());
    }
}
