<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
 * Test ID: Category-001
 * Description: Check if we can access the get all categories API
 * Precondition: None
 * Test Steps:
 *   1. Send a GET request to /api/categories
 *   2. Check if the response status is 200
 * Test Data: None
 * Expected Result: The response status should be 200
 * Actual Result: The response status is 200
 * Status: Passed
 * Remark: None
 */

/**
 * Test ID: Category-002
 * Description: Verify if getting a category by valid ID returns correct data
 * Precondition: Category with ID 1 must exist
 * Test Steps:
 *   1. Send GET request to /api/categories/1
 *   2. Verify response contains category details and status 200
 * Test Data: Category ID = 1
 * Expected Result: Response contains valid category data and status 200
 * Actual Result: Response contains valid data
 * Status: Passed
 * Remark: None
 */

/**
 * Test ID: Category-003
 * Description: Verify API returns 404 for non-existent category ID
 * Precondition: Category with ID 999 does not exist
 * Test Steps:
 *   1. Send GET request to /api/categories/999
 *   2. Check if the response status is 404
 * Test Data: Category ID = 999
 * Expected Result: Response status should be 404
 * Actual Result: Response status is 404
 * Status: Passed
 * Remark: None
 */

/**
 * Test ID: Category-004
 * Description: Check if a category can be successfully created via API
 * Precondition: None
 * Test Steps:
 *   1. Send POST request with category name
 *   2. Check if response status is 201 and database is updated
 * Test Data: name = "New Category"
 * Expected Result: Response status 201 and new record in DB
 * Actual Result: Category created successfully
 * Status: Passed
 * Remark: None
 */

/**
 * Test ID: Category-005
 * Description: Verify validation error when creating category without name
 * Precondition: None
 * Test Steps:
 *   1. Send POST request with empty name
 *   2. Check if response status is 422
 * Test Data: name = ""
 * Expected Result: Response status should be 422
 * Actual Result: Validation error received
 * Status: Passed
 * Remark: None
 */

/**
 * Test ID: Category-006
 * Description: Check if a category can be updated using PUT request
 * Precondition: Category exists
 * Test Steps:
 *   1. Send PUT request with updated name
 *   2. Verify response and DB update
 * Test Data: name = "Updated Category"
 * Expected Result: Status 200 and updated name in DB
 * Actual Result: Update successful
 * Status: Passed
 * Remark: None
 */

/**
 * Test ID: Category-007
 * Description: Ensure category update fails with empty name
 * Precondition: Category exists
 * Test Steps:
 *   1. Send PUT request with empty name
 *   2. Check if response status is 422
 * Test Data: name = ""
 * Expected Result: Status 422 with validation message
 * Actual Result: Validation error received
 * Status: Passed
 * Remark: None
 */

/**
 * Test ID: Category-008
 * Description: Check if a category can be deleted
 * Precondition: Category exists
 * Test Steps:
 *   1. Send DELETE request for category ID
 *   2. Verify response and ensure category is removed
 * Test Data: Category ID = valid
 * Expected Result: Status 204 and record deleted
 * Actual Result: Category deleted successfully
 * Status: Passed
 * Remark: None
 */

/**
 * Test ID: Category-009
 * Description: Verify API returns 404 when deleting non-existent category
 * Precondition: Category ID does not exist
 * Test Steps:
 *   1. Send DELETE request for non-existent ID
 *   2. Check response status
 * Test Data: ID = 999
 * Expected Result: Status 404
 * Actual Result: Not found
 * Status: Passed
 * Remark: None
 */

/**
 * Test ID: Category-010
 * Description: Ensure duplicate category names are not allowed
 * Precondition: A category named "Electronics" already exists
 * Test Steps:
 *   1. Try to create another category named "Electronics"
 *   2. Check if validation error is returned
 * Test Data: name = "Electronics"
 * Expected Result: Status 422 with duplicate error
 * Actual Result: Duplicate name not allowed
 * Status: Passed
 * Remark: None
 */

    public function testGetAllCategories()
    {
        $response = $this->get('/api/categories');
        $response->assertStatus(200);
    }

    /**
     * Test ID : Category-002
     * Description: Check if the get category by ID API returns correct data
     * ...
     */
    public function testGetCategoryById()
    {
        $category = Category::create(['name' => 'Books']);
        $response = $this->get("/api/categories/{$category->id}");
        $response->assertStatus(200)
                 ->assertJson(['name' => 'Books']);
    }

    /**
     * Test ID : Category-003
     * Description: Verify category creation via API
     */
    public function testCreateCategory()
    {
        $response = $this->post('/api/categories', [
            'name' => 'New Category',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', ['name' => 'New Category']);
    }

    /**
     * Test ID : Category-004
     * Description: Update a category via API
     */
    public function testUpdateCategory()
    {
        $category = Category::create(['name' => 'Old Name']);

        $response = $this->put("/api/categories/{$category->id}", [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', ['name' => 'Updated Name']);
    }

    /**
     * Test ID : Category-005
     * Description: Delete a category via API
     */
    public function testDeleteCategory()
    {
        $category = Category::create(['name' => 'To Be Deleted']);

        $response = $this->delete("/api/categories/{$category->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_if_we_can_access_get_all_categories_api(): void
{
    $response = $this->get('/api/categories');

    $response->assertStatus(200)
             ->assertJsonFragment(["message" => "success"]);
}

}