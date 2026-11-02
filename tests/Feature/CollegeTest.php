<?php

namespace Tests\Feature;

use App\Models\College;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// Can create valid data
// Cannot create invalid data
// Can access building (Direct relatioship)
// Can access floor and room (indirect relationship)

class CollegeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_a_new_college(): void
    {

        $response = $this->post(route('admin.colleges.store'), [
            'name' => 'College of Computing Studies',
            'code' => 'CCS',
        ]);

        $response->assertRedirect(route('admin.colleges.index'));
        $response->assertSessionHas('success', 'College created successfully!');

        // 3. Assert the record actually exists in the database table
        $this->assertDatabaseHas('colleges', [
            'name' => 'College of Computing Studies',
            'code' => 'CCS',
        ]);
    }

    /**
     * Test validation rules for required fields.
     */
    public function test_college_requires_name_and_code(): void
    {
        $response = $this->post(route('admin.colleges.store'), [
            'name' => '',
            'code' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'code']);

        // Assert nothing was inserted into the database
        $this->assertDatabaseCount('colleges', 0);
    }

    /**
     * Test that duplicate college codes are rejected by StoreCollegeRequest.
     */
    public function test_college_code_must_be_unique(): void
    {
        College::create([
            'name' => 'College of Education',
            'code' => 'CED',
        ]);

        $response = $this->post(route('admin.colleges.store'), [
            'name' => 'Duplicate College',
            'code' => 'CED',
        ]);

        // Assert unique rule validation fails
        $response->assertSessionHasErrors(['code']);
    }
}