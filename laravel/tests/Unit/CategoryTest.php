<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\Category;

class CategoryTest extends TestCase
{
  
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
         'name' => 'New Categoryp',
     ]);

     $response->assertStatus(201);
     $this->assertDatabaseHas('categories', ['name' => 'New Categoryp']);
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
