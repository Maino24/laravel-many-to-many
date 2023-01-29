<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Antipasti',
            'Primi',
            'Secondi',
            'Dolci'
        ];

        foreach($categories as $category){
            $newcategory = new Category();
            $newcategory->name = $category;
            $newcategory->save();
        }

    }
}
