<?php

namespace Tests\Feature;

use App\Models\Categories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class CateogryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_categories(): void
    {
        Artisan::call('migrate');
        Categories::create(['cat_name'=>'cat_1']);
        //ADD CATAEGORY
        $addCategory = $this->postJson('/api/category',['cat_name'=>'cat_2']);
        $addCategory->assertStatus(200)
        ->assertJsonFragment(['cat_name'=>'cat_2'])
        ->assertJsonStructure([
            'data'=>['id','created_at','updated_at','cat_name']
        ]);

        $addCategorybad = $this->postJson('/api/category',[]);
        $addCategorybad->assertStatus(422);

        $this->assertDatabaseHas('categories',['id'=>2]);
        //EDIT CATEGORY
        $editCategory = $this->putJson('/api/category?id=2&cat_name=cat_editada_2');
        $editCategory->assertStatus(200)
        ->assertJsonFragment(['cat_name'=>'cat_editada_2'])
        ->assertJsonStructure([
            'data'=>['id','created_at','updated_at','cat_name']
        ]);

        $editCategorybad = $this->putJson('/api/category',['id'=>2,'cat_name'=>'cat_editada_2']);
        $editCategorybad->assertStatus(422);

        //GET ALL CATEOGRIES
        $allCategories = $this->getJson('/api/categories');
        $allCategories->assertStatus(200);

        //DELETE CATEGORIES
        $deleteCategory = $this->deleteJson('/api/category?id=2');
        $deleteCategory->assertStatus(200)
        ->assertJsonStructure([
            'data'=>['id','created_at','updated_at','cat_name']
        ]);
        
        $deleteCategorybad = $this->deleteJson('/api/category?id=2');
        $deleteCategorybad->assertStatus(422);
    }
}
