<?php

namespace Tests\Unit;

use App\Http\Domains\Order\Model\Order;
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
            'user_id' => 1,
            'notes' => 'Test order',
            'items' => [
            [
                'product_id' => 1,
                'quantity' => 2,
                'unit_price' => 100
            ],
            [
                'product_id' => 2,
                'quantity' => 1,
                'unit_price' => 50
            ]]
        ];

        $order = $this->orderService->createOrder($orderData);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertNotNull($order->order_number);
        $this->assertEquals(2, $order->items->count());
        $this->assertEquals(250, $order->total_amount);
        $this->assertEquals('draft', $order->status);
        $this->assertEquals(1, $order->history->count());
    }
}
