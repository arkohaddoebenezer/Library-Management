<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksFunctionality extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    /**@test**/
    public function a_book_can_be_added_to_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' =>  'The Rules of Work',
            'author'    =>   'Richard Templar',
        ]);
        $response->assertOk();
        $this->assertCount(1,Book::all());

    }
}
