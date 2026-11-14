<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_page_is_not_matched_as_a_building_id(): void
    {
        $this->get('/admin/buildings/create')->assertOk();
    }
}
